<?php

header("content-type: application/json; charset=utf-8");
header("access-control-allow-origin: *");

require_once '../db.php';

session_start();

$_POST = json_decode(file_get_contents('php://input'), true);

switch ($_GET['r']) {
	
	case "startup":
	
	$con = new pdo_db();
	$judge = $con->getData("SELECT CONCAT(first_name, ' ', last_name) name FROM judges WHERE id = $_SESSION[judge_id]");
	
	$contestants = $con->getData("SELECT * FROM contestants WHERE is_active = 1 ORDER BY no");
	
	if (count($judge)) {
		echo json_encode(array("judge"=>$judge[0],"contestants"=>$contestants));
	} else {
		echo json_encode(array("judge"=>[],"contestants"=>[]));
	}
	
	break;

	case "standing":
	
	$con = new pdo_db();	

	$contestants = $con->getData("SELECT * FROM contestants WHERE is_active = 1 ORDER BY no");
	
	$standing = [];
	foreach ($contestants as $key => $value) {
		
		/*
		** score computation
		*/

		$score = 0;
		$judge_id = (isset($_SESSION['judge_id']))?$_SESSION['judge_id']:0;
		$sql = "SELECT *, (SELECT percentage FROM criteria WHERE id = criteria_id) percentage FROM scores WHERE contestant_id = $value[id] AND judge_id = $judge_id";
		$contestant_scores = $con->getData($sql);

 		foreach ($contestant_scores as $key1 => $value1) {

			// $score += ($value1['score']*$value1['percentage'])/100;			
			$score += $value1['score'];		
			
		}
		
		$standing[] = array("no"=>$value['no'],"name"=>$value['cluster_name'],"score"=>$score);
		
	}
	
	if (count($standing)) {
	
		foreach ($standing as $key2 => $value2) {
			
			$rank[] = $standing[$key2]['score'];
			
		}

		array_multisort($rank, SORT_DESC, $standing);
		
	}
	
	echo json_encode($standing);
	
	break;
	
	case "tabulate":

	$con1 = new pdo_db("criteria");
	$criteria = $con1->getData("SELECT * FROM criteria");
	
	$con2 = new pdo_db("scores");
	foreach ($criteria as $criterion) {
		$sql = "SELECT * FROM scores WHERE judge_id = $_SESSION[judge_id] AND contestant_id = $_POST[id] AND criteria_id = $criterion[id]";
 		$scores = $con2->getData($sql);
		if ($con2->rows == 0) {
			$insert_criteria = $con2->insertData(array("judge_id"=>$_SESSION['judge_id'],"contestant_id"=>$_POST['id'],"criteria_id"=>$criterion['id']));
		}
	}
	
	$contestant = $con2->getData("SELECT no, cluster_name FROM contestants WHERE id = $_POST[id]");
	
	$contestant_criteria = $con2->getData("SELECT id, contestant_id, criteria_id, (SELECT description FROM criteria WHERE id = criteria_id) description, (SELECT percentage FROM criteria WHERE id = criteria_id) percentage, score FROM scores WHERE judge_id = $_SESSION[judge_id] AND contestant_id = $_POST[id]");
	
	echo json_encode(array("no"=>$contestant[0]['no'],"contestant"=>$contestant[0]['cluster_name'],"criteria"=>$contestant_criteria));
	
	break;
	
	case "save":
	
	$con = new pdo_db("scores");

	if (!isset($_POST['score']) || ($_POST['score'] == "")) $_POST['score'] = 0;
	
	$score = $con->query("UPDATE scores SET score = $_POST[score] WHERE id = $_POST[id]");
	
	break;
	
	case "save_scores":
	
	$con = new pdo_db("scores");
	
	foreach ($_POST as $key => $score) {
		
		if ($_POST[$key]['score'] == "") $_POST[$key]['score'] = 0;
		$score = $con->query("UPDATE scores SET score = ".$_POST[$key]['score']." WHERE id = ".$_POST[$key]['id']);		
		
	}
	
	
	break;
	
}

?>