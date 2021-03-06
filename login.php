﻿<?php

session_start();

if (isset($_SESSION['judge_id'])) header("location: index.php");

require_once 'db.php';

$con = new pdo_db();

$_SESSION['preferences'] = ($con->getData("SELECT * FROM preferences WHERE id = 1"))[0];

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <title><?php echo $_SESSION['preferences']['title']; ?> - Judge Registration | Tabulation System</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME ICONS  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
     <!-- HTML5 Shiv and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body ng-app="signup" ng-controller="signupCtrl">
    <!-- HEADER END-->
    <div class="navbar navbar-inverse set-radius-zero">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">
                    <img src="assets/img/pglu.png" />
                </a>
            </div>

            <div class="left-div">
                <div class="user-settings-wrapper">
                    <ul class="nav">
                        <li>

                        </li>
                        <li>

                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- LOGO HEADER END-->
   
    <section class="menu-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="navbar-collapse collapse ">
                        <ul id="menu-top" class="nav navbar-nav navbar-right">
                            <li><a class="menu-top-active" href="back/">Login</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>   
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">			
            <div class="row">
                <div class="col-md-12">
                    <h1 style="color: #575757;"><?php echo $_SESSION['preferences']['title']; ?></h1>
				</div>
			</div>
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line">Please Sign Up To Proceed </h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="alert alert-info">
                         <strong>You need an account to access the judges dashboard page</strong>
                        <ul>
                            <li>
                                Please sign up and provide the token to login
                            </li>
                            <li>
								The token will be provided by the official tabulator
                            </li>
                        </ul>
                    </div>
					<hr>					
                </div>
                <div class="col-md-6">
					<form name="views.frmSignup" novalidate autocomplete="off">				
							<div class="form-group" ng-class="{'has-error': views.frmSignup.last_name.$invalid && views.frmSignup.last_name.$touched}">
							<label>Last Name: </label>
							<input type="text" class="form-control" name="last_name" ng-model="judge.last_name" required>
							<div class="alert alert-danger" style="margin-top: 5px;" ng-show="views.frmSignup.last_name.$invalid && views.frmSignup.last_name.$touched">Please provide Last Name</div>
							</div>
							<div class="form-group" ng-class="{'has-error': views.frmSignup.first_name.$invalid && views.frmSignup.first_name.$touched}">					
							<label>First Name:  </label>
							<input type="text" class="form-control" name="first_name" ng-model="judge.first_name" required>
							<div class="alert alert-danger" style="margin-top: 5px;" ng-show="views.frmSignup.first_name.$invalid && views.frmSignup.first_name.$touched">Please provide First Name</div>					
							</div>					
							<div class="form-group" ng-class="{'has-error': views.frmSignup.token.$invalid && views.frmSignup.token.$touched}">					
							<label>Token:  </label>
							<input type="number" class="form-control" name="token" ng-model="judge.token" required>
							<div class="alert alert-danger" style="margin-top: 5px;" ng-show="views.frmSignup.token.$invalid && views.frmSignup.token.$touched">Please provide token</div>
							</div>
							<div class="alert alert-danger" style="margin-top: 5px;" ng-show="views.invalidToken">Invalid token</div>					
							<hr />					
							<a href="javascript:;" class="btn btn-info pull-right" ng-click="signUp()"><span class="glyphicon glyphicon-user"></span> &nbsp;Sign Up and Log In </a>&nbsp;
					</form>					
                </div>

            </div>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    &copy; <?php echo date("Y"); ?> PGLU | MISD
                </div>
            </div>
        </div>
    </footer>
    <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.11.1.js"></script>
    <script src="assets/js/jquery.blockUI.js"></script>
    <script src="assets/js/bootbox.min.js"></script>
	
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
    <script src="bootstrap-notify-3.1.3/bootstrap-notify.min.js"></script>	
	
    <script src="angularjs/angular.min.js"></script>
	<!-- modules -->
	<script src="modules/block-ui.js"></script>
	<script src="modules/bootstrap-modal.js"></script>
	<script src="modules/bootstrap-notify.js"></script>
	
	<!-- controller -->
	<script src="controllers/signup.js"></script>
</body>
</html>
