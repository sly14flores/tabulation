<?php

require_once '../db.php';

session_start();

$_POST = json_decode(file_get_contents('php://input'), true);

switch ($_GET['r']) {
	
	case "startup":
	
	$con = new pdo_db();
	$judge = $con->getData("SELECT CONCAT(first_name, ' ', last_name) name FROM judges WHERE id = $_SESSION[judge_id]");
	
	$contestants = $con->getData("SELECT * FROM contestants WHERE is_active = 1 ORDER BY no");
	
	echo json_encode(array("judge"=>$judge[0],"contestants"=>$contestants));
	
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
	
	$contestant = $con2->getData("SELECT cluster_name FROM contestants WHERE id = $_POST[id]");
	
	$contestant_criteria = $con2->getData("SELECT id, contestant_id, criteria_id, (SELECT description FROM criteria WHERE id = criteria_id) description, (SELECT percentage FROM criteria WHERE id = criteria_id) percentage, score FROM scores WHERE judge_id = $_SESSION[judge_id] AND contestant_id = $_POST[id]");
	
	echo json_encode(array("contestant"=>$contestant[0]['cluster_name'],"criteria"=>$contestant_criteria));
	
	break;
	
	case "save":
	
	$con = new pdo_db("scores");
	
	$score = $con->updateData($_POST,'id');
	
	break;
	
}

?>