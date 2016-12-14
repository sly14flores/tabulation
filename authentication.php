<?php

session_start();
if (!isset($_SESSION['judge_id'])) header("location: login.php");

?>