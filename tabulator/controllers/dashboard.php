<?php

require_once '../../db.php';

session_start();

$_POST = json_decode(file_get_contents('php://input'), true);

switch ($_GET['r']) {
	
	case "startup":
	
	$con = new pdo_db();
	
	$judges = $con->getData("SELECT id, CONCAT(first_name, ' ', last_name) name FROM judges");
	$contestants = $con->getData("SELECT * FROM contestants WHERE is_active = 1 ORDER BY no");		
	
	$winners = $con->getData("SELECT (SELECT no FROM contestants WHERE id = contestant_id) no, (SELECT cluster_name FROM contestants WHERE id = contestant_id) name, overall_score, place FROM winners");
	$consolations = $con->getData("SELECT (SELECT no FROM contestants WHERE id = contestant_id) no, (SELECT cluster_name FROM contestants WHERE id = contestant_id) name, overall_score, place FROM consolation_prizes");

	$contestants_list = $con->getData("SELECT id, IF(no=0,'',no) cn, cluster_name, IF(is_active=1,'Yes','No') participated FROM contestants");	
	$judges_list = $con->getData("SELECT id, CONCAT(first_name, ' ', last_name) name, remarks FROM judges");	

	echo json_encode(array("judges"=>$judges,"contestants"=>$contestants,"winners"=>$winners,"consolations"=>$consolations,"contestants_list"=>$contestants_list,"judges_list"=>$judges_list));
	
	break;	
	
	case "standing":
	
	$filter = "";
	
	if ($_POST['id'] != 0) {
		$filter = " WHERE id = $_POST[id]";
	}
	
	$con = new pdo_db();	

	$contestants = $con->getData("SELECT * FROM contestants WHERE is_active = 1 ORDER BY no");
	
	$judges = $con->getData("SELECT * FROM judges".$filter);
	$no_of_judges = $con->rows;
	
	$standing = [];
		
	foreach ($contestants as $key => $value) {
		
		$overall_score = 0;
		$score_average = 0;
		
		foreach ($judges as $i => $judge) {
	
			$score = 0;
			$sql = "SELECT *, (SELECT percentage FROM criteria WHERE id = criteria_id) percentage FROM scores WHERE contestant_id = $value[id] AND judge_id = $judge[id]";
			$contestant_scores = $con->getData($sql);

			foreach ($contestant_scores as $key2 => $value2) {

				// $score += ($value2['score']*$value2['percentage'])/100;			
				$score += $value2['score'];		
				
			}
			
			$overall_score += $score;

		}
		
		$score_average = $overall_score/$no_of_judges;
		
		$standing[] = array("id"=>$value['id'],"no"=>$value['no'],"name"=>$value['cluster_name'],"score"=>$score_average);		
		
	}
	
	if (count($standing)) {	
	
		foreach ($standing as $key3 => $value3) {
			
			$rank[] = $standing[$key3]['score'];
			
		}
	
		array_multisort($rank, SORT_DESC, $standing);	
	
	}	
	
	echo json_encode($standing);
	
	break;
	
	case "tabulation":
	
	$con = new pdo_db();
	
	$contestant = $con->getData("SELECT no, cluster_name FROM contestants WHERE id = $_POST[id]");
	
	$judges = $con->getData("SELECT id, CONCAT(first_name, ' ', last_name) name FROM judges");
	
	foreach ($judges as $key => $judge) {
		
		$scores = $con->getData("SELECT (SELECT description FROM criteria WHERE id = criteria_id) description, (SELECT percentage FROM criteria WHERE id = criteria_id) percentage, score FROM scores WHERE judge_id = $judge[id] AND contestant_id = $_POST[id] ORDER BY criteria_id");
		$total_score = $con->getData("SELECT SUM(score) total_score FROM scores WHERE judge_id = $judge[id] AND contestant_id = $_POST[id] ORDER BY criteria_id");
		$judges[$key]['scores'] = $scores;
		$judges[$key]['total_score'] = $total_score[0]['total_score'];
		
	}
	
	echo json_encode(array("contestant"=>$contestant[0],"judges"=>$judges));
	
	break;
	
	case "winners":

	$con1 = new pdo_db("winners");
	$con2 = new pdo_db("consolation_prizes");

	$wds = $con1->getData("SELECT * FROM winners_descriptions ORDER BY id ASC");
	
	$winners = [];
	$consolations = [];

	foreach ($_POST as $key => $value) {
		
		if ($key > (count($wds)-1)) {
			$consolations[] = array("contestant_id"=>$value['id'],"overall_score"=>$value['score'],"place"=>"Consolation Prize");						
		} else {
			$winners[] = array("contestant_id"=>$value['id'],"overall_score"=>$value['score'],"place"=>$wds[$key]['description']);
		}

	}
	
	$con1->db->exec("DELETE FROM winners");
	sleep(1);
	$con1->insertDataMulti($winners);
	$con2->db->exec("DELETE FROM consolation_prizes");
	sleep(1);
	$con2->insertDataMulti($consolations);
	
	sleep(1);
	$winners = $con1->getData("SELECT (SELECT no FROM contestants WHERE id = contestant_id) no, (SELECT cluster_name FROM contestants WHERE id = contestant_id) name, overall_score, place FROM winners");
	$consolations = $con2->getData("SELECT (SELECT no FROM contestants WHERE id = contestant_id) no, (SELECT cluster_name FROM contestants WHERE id = contestant_id) name, overall_score, place FROM consolation_prizes");

	echo json_encode(array("winners"=>$winners,"consolations"=>$consolations));	
	
	break;
	
	case "contestant_status":

	$con = new pdo_db("contestants");

	$contestant_status = $con->getData("SELECT no, is_active participated FROM contestants WHERE id = $_POST[id]");
	
	echo json_encode($contestant_status[0]);
	
	break;
	
	case "contestant":
	
	$con = new pdo_db("contestants");
	
	$contestant = $con->updateData($_POST,'id');
	
	$contestants_list = $con->getData("SELECT id, IF(no=0,'',no) cn, cluster_name, IF(is_active=1,'Yes','No') participated FROM contestants");	

	echo json_encode(array("contestants_list"=>$contestants_list));	
	
	break;
	
	case "judge_status":
	
	$con = new pdo_db("judges");
	
	$judge_status = $con->getData("SELECT remarks FROM judges WHERE id = $_POST[id]");
	
	echo $judge_status[0]['remarks'];
	
	break;
	
	case "judge":
	
	$con = new pdo_db("judges");	
	
	$judge = $con->updateData($_POST,'id');	
	
	$judges_list = $con->getData("SELECT id, CONCAT(first_name, ' ', last_name) name, remarks FROM judges");	

	echo json_encode(array("judges_list"=>$judges_list));	
	
	break;
	
}

?>