<?php

session_start();

if (isset($_SESSION['judge_id'])) unset($_SESSION['judge_id']);
if (isset($_SESSION['judge_name'])) unset($_SESSION['judge_name']);

echo "Logout Successful";

header("location: index.php");

?>