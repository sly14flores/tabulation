<?php

session_start();

if (isset($_SESSION['judge_id'])) unset($_SESSION['judge_id']);
if (isset($_SESSION['judge_name'])) unset($_SESSION['judge_name']);
if (isset($_SESSION['preferences'])) unset($_SESSION['preferences']);

echo "Logout Successful";

header("location: back/index.php");

?>