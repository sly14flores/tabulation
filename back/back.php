<?php

require_once '../db.php';

$con = new pdo_db();

$sql = "SELECT * FROM judges WHERE id = ".$_POST['judge_id'];

session_start();

$_SESSION['preferences'] = ($con->getData("SELECT * FROM preferences WHERE id = 1"))[0];

$judge = $con->getData($sql);

if (count($judge)) {
	
	if ($_POST['admin_token'] == $_SESSION['preferences']['admin_token']) {
	
		foreach ($judge as $value) {
			
			session_start();
			$_SESSION['judge_id'] = $value['id'];
			$_SESSION['judge_name'] = $value['name'];	
			header("location: ../index.php");
			
		}
	
	} else {
		
		header("location: index.php?status=invalid_token");
		
	}

} else {
	
	header("location: index.php");	
	
}

?>

