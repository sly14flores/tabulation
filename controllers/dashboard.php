<?php

header("content-type: application/json; charset=utf-8");
header("access-control-allow-origin: *");

require_once '../db.php';
require_once '../classes.php';

session_start();

$_POST = json_decode(file_get_contents('php://input'), true);

switch ($_GET['r']) {
	
	case "startup":
	
	$con = new pdo_db();
	
	$portions = $con->getData("SELECT * FROM portions");
	$portion_id = (count($portions ))?$portions[0]['id']:0;
	
	$judge_q = $con->getData("SELECT CONCAT(first_name, ' ', last_name) name FROM judges WHERE id = $_SESSION[judge_id]");
	
	$_contestants = $con->getData("SELECT * FROM contestants WHERE is_active = 1 ORDER BY no");
	$contestants = portionContestants($_contestants,$portion_id);
	
	$judge = (count($judge_q))?$judge_q[0]:array("name"=>"");	
	
	$response = array("judge"=>$judge,"contestants"=>$contestants,"portions"=>$portions);
	
	echo json_encode($response);
	
	break;

	case "standing":
	
	$con = new pdo_db();

	$_contestants = $con->getData("SELECT * FROM contestants WHERE is_active = 1 ORDER BY no");
	$contestants = portionContestants($_contestants,$_POST['portion_id']);

	$standing = [];
	foreach ($contestants as $key => $value) {
		
		/*
		** score computation
		*/

		$score = 0;
		$judge_id = (isset($_SESSION['judge_id']))?$_SESSION['judge_id']:0;
		$sql = "SELECT *, (SELECT criteria.percentage FROM criteria WHERE criteria.id = scores.criteria_id) percentage FROM scores LEFT JOIN criteria ON scores.criteria_id = criteria.id WHERE scores.contestant_id = $value[id] AND scores.judge_id = $judge_id AND criteria.portion_id = $_POST[portion_id]";

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
	$criteria = $con1->getData("SELECT * FROM criteria WHERE portion_id = ".$_POST['portion_id']);
	
	$con2 = new pdo_db("scores");
	foreach ($criteria as $criterion) {
		$sql = "SELECT * FROM scores WHERE judge_id = $_SESSION[judge_id] AND contestant_id = $_POST[contestant_id] AND criteria_id = $criterion[id]";
 		$scores = $con2->getData($sql);
		if ($con2->rows == 0) {
			$insert_criteria = $con2->insertData(array("judge_id"=>$_SESSION['judge_id'],"contestant_id"=>$_POST['contestant_id'],"criteria_id"=>$criterion['id']));
		}
	}
	
	$contestant = $con2->getData("SELECT no, cluster_name FROM contestants WHERE id = $_POST[contestant_id]");
	
	$contestant_criteria = $con2->getData("SELECT scores.id, scores.contestant_id, scores.criteria_id, (SELECT criteria.description FROM criteria WHERE criteria.id = scores.criteria_id) description, (SELECT criteria.percentage FROM criteria WHERE criteria.id = scores.criteria_id) percentage, scores.score FROM scores LEFT JOIN criteria ON scores.criteria_id = criteria.id WHERE scores.judge_id = $_SESSION[judge_id] AND scores.contestant_id = $_POST[contestant_id] AND criteria.portion_id = $_POST[portion_id]");
	
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
		if (isset($_POST[$key]['score'])) {
			$score = $_POST[$key]['score'];			
			if ($_POST[$key]['score'] == "") $score = 0;
		} else {
			$score = 0;			
		}
		$score = $con->query("UPDATE scores SET score = $score WHERE id = ".$_POST[$key]['id']);
	}	
	
	break;
	
	case "portions_contestants":
	
		$con = new pdo_db();	
	
		$_contestants = $con->getData("SELECT * FROM contestants WHERE is_active = 1 ORDER BY no");
		$contestants = portionContestants($_contestants,$_POST['portion_id']);
		
		echo json_encode($contestants);
		
	break;
	
}

?>