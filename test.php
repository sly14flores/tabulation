<?php

session_start();
// var_dump($_SESSION);

if (isset($_SESSION['judge_id'])) unset($_SESSION['judge_id']);
if (isset($_SESSION['judge_name'])) unset($_SESSION['judge_name']);

?>