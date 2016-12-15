<?php

require_once '../../db.php';

session_start();

$_POST = json_decode(file_get_contents('php://input'), true);

switch ($_GET['r']) {
	
	case "startup":
	
	$con = new pdo_db();
	$judges = $con->getData("SELECT id, CONCAT(first_name, ' ', last_name) name FROM judges");
	
	echo json_encode(array("judges"=>$judges));
	
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
		
		$standing[] = array("no"=>$value['no'],"name"=>$value['cluster_name'],"score"=>$score_average);		
		
	}
	
	foreach ($standing as $key3 => $value3) {
		
		$rank[] = $standing[$key3]['score'];
		
	}

	array_multisort($rank, SORT_DESC, $standing);	
	
	echo json_encode($standing);
	
	break;	
	
}

?>