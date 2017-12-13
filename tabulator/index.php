<?php

require_once '../db.php';

$con = new pdo_db();

$preferences = ($con->getData("SELECT * FROM preferences WHERE id = 1"))[0];
	
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
    <title><?php echo $preferences['title'] ?> - Tabulator Dashboard | Tabulation System</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME ICONS  -->
    <link href="../assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="../assets/css/style.css" rel="stylesheet" />
     <!-- HTML5 Shiv and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body ng-app="dashboard" ng-controller="dashboardCtrl">
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
                    <img src="../assets/img/logo.png" />
                </a>
            </div>

            <div class="left-div">
                <div class="user-settings-wrapper">
                    <ul class="nav">
                        <li></li>
                        <li></li>
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
                            <li><a class="menu-top-active" href="index.php">Tabulator Dashboard</a></li>
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
                    <h1 style="color: #575757;"><?php echo $preferences['title']; ?></h1>
				</div>
			</div>		
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line">Tabulator Dashboard</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">				
					<div class="panel panel-default">
						<div class="panel-heading">
							<strong>Contestants</strong>							
						</div>
						<div class="panel-body">
							<table class="table table-striped table-bordered table-hover">
								<thead>
									<tr><th>No</th><th>Cluster Name</th><th>Participated</th><th>&nbsp;</th></tr>										
								</thead>
								<tbody>
									<tr ng-repeat="contestant in contestants_list">
										<td>{{contestant.cn}}</td>
										<td>{{contestant.cluster_name}}</td>
										<td>{{contestant.participated}}</td>
										<td>
											<button type="button" class="btn btn-default btn-sm" ng-click="editContestant(contestant)">
												<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
											</button>										
										</td>
									</tr>
								</tbody>									
							</table>
						</div>							
					</div>
                </div>		
                <div class="col-md-6">				
					<div class="panel panel-default">
						<div class="panel-heading">
							<strong>Judges</strong>							
						</div>
						<div class="panel-body">
							<table class="table table-striped table-bordered table-hover">
								<thead>
									<tr><th>Name</th><th>Remarks</th><th>&nbsp;</th></tr>										
								</thead>
								<tbody>
									<tr ng-repeat="judge in judges_list">
										<td>{{judge.name}}</td>
										<td>{{judge.remarks}}</td>
										<td>
											<button type="button" class="btn btn-default btn-sm" ng-click="editJudge(judge.id)">
												<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
											</button>										
										</td>
									</tr>
								</tbody>									
							</table>
						</div>							
					</div>
                </div>
            </div>
			<hr>
			<div class="row">
                <div class="col-md-12">
				  <ul class="nav nav-tabs" role="tablist">
					<li ng-repeat="portion in portions" role="presentation" ng-class="{'active': views.portionIndex == $index}"><a href="#portion{{portion.id}}" aria-controls="portion{{portion.id}}" role="tab" data-toggle="tab" ng-click="logIndex(this,$index,portion)">{{portion.description}}</a></li>
				  </ul>
				  <div class="tab-content">
					<div ng-repeat="portion in portions" role="tabpanel" class="tab-pane" ng-class="{'active': views.portionIndex == $index}" id="portion{{portion.id}}">
						<hr>
						<div>
							<h4>Overall</h4>
							<table class="table table-bordered">
								<thead>
									<tr>
										<th style="width: 50px;">#</th><th>Contestant</th><th>Score</th><th>Rank</th>
									</tr>								
								</thead>
								<tbody ng-repeat="o in portion.overall">
									<tr>
										<td>{{o.no}}</td><td>{{o.cluster_name}}</td><td>{{o.overall_total_scores}}</td><td><strong>{{o.overall_rank}}</strong></td>
									</tr>
								</tbody>
							</table>
							<hr>
						</div>
						<div ng-repeat="jud in portion.judges">
							<h4>{{jud.name}}</h4>
							<table class="table table-bordered">
								<thead>
									<tr>
										<th style="width: 50px;">#</th><th>Contestant</th><th>Score</th><th>Rank</th><th style="width: 500px;">Score Details</th>
									</tr>
								</thead>
								<tbody ng-repeat="con in jud.contestants">
									<tr>
										<td>{{con.no}}</td><td>{{con.cluster_name}}</td><td>{{con.total_scores}}</td><td><strong>{{con.rank}}</strong></td>
										<td>
											<table class="table table-bordered">
												<thead>
													<tr>
														<th>Criteria</th><th>Percentage</th><th>Score</th>
													</tr>
												</thead>
												<tbody>
													<tr ng-repeat="score in con.scores">
														<td>{{score.description}}</td><td>{{score.percentage}}</td><td>{{score.score}}</td>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>
								</tbody>
							</table>
							<hr>
						</div>
					</div>
				  </div>
				</div>
			</div>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    &copy; 2016 PGLU | MISD
                </div>
            </div>
        </div>
    </footer>
    <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY SCRIPTS -->
    <script src="../assets/js/jquery-1.11.1.js"></script>
    <script src="../assets/js/jquery.blockUI.js"></script>
    <script src="../assets/js/bootbox.min.js"></script>
	
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="../assets/js/bootstrap.js"></script>
    <script src="../bootstrap-notify-3.1.3/bootstrap-notify.min.js"></script>	
	
    <script src="../angularjs/angular.min.js"></script>
	<!-- modules -->
	<script src="../modules/block-ui.js"></script>
	<script src="../modules/bootstrap-modal.js"></script>
	<script src="../modules/bootstrap-notify.js"></script>
	
	<!-- controller -->
	<script src="controllers/dashboard.js"></script>
</body>
</html>
