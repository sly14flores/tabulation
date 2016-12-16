<?php

require_once '../db.php';

$con = new pdo_db();

$sql = "SELECT * FROM judges WHERE id = ".$_POST['judge_id'];

$judge = $con->getData($sql);

foreach ($judge as $value) {
	
	session_start();
	$_SESSION['judge_id'] = $value['id'];
	$_SESSION['judge_name'] = $value['name'];	
	header("location: ../index.php");
	exit();
	
}

header("location: index.php");

?>

