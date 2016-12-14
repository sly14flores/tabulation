<?php

require_once '../db.php';

session_start();

$_POST = json_decode(file_get_contents('php://input'), true);

switch ($_GET['r']) {
	
	case "token":
	
	$con = new pdo_db();
	$token = $con->getData("SELECT * FROM preferences WHERE id = 1");
	
	echo json_encode($token[0]);
	
	break;
	
	case "signup":
	
	unset($_POST['token']);
	
	$con = new pdo_db("judges");
	$judge = $con->insertData($_POST);
	$insertId = $con->insertId;
	
	$judge = $con->getData("SELECT id, CONCAT(first_name, ' ', last_name) name FROM judges WHERE id = $insertId");

	foreach ($judge as $key => $value) {
		$_SESSION['judge_id'] = $value['id'];
		$_SESSION['judge_name'] = $value['name'];
	}
	
	echo "successfull";
	
	break;

}

?>