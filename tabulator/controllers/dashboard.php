<?php

require_once '../../db.php';

session_start();

$_POST = json_decode(file_get_contents('php://input'), true);

switch ($_GET['r']) {
	
	case "startup":
	
	$con = new pdo_db();
	
	$judges = $con->getData("SELECT id, CONCAT(first_name, ' ', last_name) name FROM judges");
	$contestants = $con->getData("SELECT * FROM contestants WHERE is_active = 1 ORDER BY no");		
	
	$winners = $con->getData("SELECT (SELECT cluster_name FROM contestants WHERE id = contestant_id) name, overall_score, place FROM winners");
	$consolations = $con->getData("SELECT (SELECT cluster_name FROM contestants WHERE id = contestant_id) name, overall_score, place FROM consolation_prizes");

	echo json_encode(array("judges"=>$judges,"contestants"=>$contestants,"winners"=>$winners,"consolations"=>$consolations));
	
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
	
	foreach ($standing as $key3 => $value3) {
		
		$rank[] = $standing[$key3]['score'];
		
	}

	array_multisort($rank, SORT_DESC, $standing);	
	
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
	
	$winners = [];
	$consolations = [];
	
	foreach ($_POST as $key => $value) {
		
		if ($key == 0) {
			$winners = array("contestant_id"=>$value['id'],"overall_score"=>$value['score'],"place"=>"First");
		}
		
		if ($key == 1) {
			$winners = array("contestant_id"=>$value['id'],"overall_score"=>$value['score'],"place"=>"Second");
		}
		
		if ($key == 2) {
			$winners = array("contestant_id"=>$value['id'],"overall_score"=>$value['score'],"place"=>"Third");			
		}
		
		if ($key > 3) {
			$consolations = array("contestant_id"=>$value['id'],"overall_score"=>$value['score'],"place"=>"Consolation Prize");			
		}
		
	}
	var_dump($winners);
	var_dump($consolations);
	// $con1->insertDataMulti($winners);
	// $con2->insertDataMulti($consolations);
	
	echo "successful";
	
	break;
	
}

?>