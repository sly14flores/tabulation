<?php

require_once '../db.php';

session_start();

$_POST = json_decode(file_get_contents('php://input'), true);

switch ($_GET['r']) {
	
	case "judge":
	
	$con = new pdo_db();
	$judge = $con->getData("SELECT CONCAT(first_name, ' ', last_name) name FROM judges WHERE id = $_SESSION[judge_id]");
	
	echo json_encode($judge[0]);
	
	break;

}

?>