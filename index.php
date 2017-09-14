 <?php

require_once 'authentication.php';

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
    <title><?php echo $_SESSION['preferences']['title']; ?> - Judge Dashboard | Tabulation System</title>
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
                    <img src="assets/img/pglu.png" />
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
                            <li><a class="menu-top-active" href="index.php">Judge Dashboard</a></li>
							<li><a class="menu-top" href="javascript:;" ng-click="logout()">Logout</a></li>
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
                    <h4 class="page-head-line">Judge Dashboard</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-success">
                        Welcome, <strong>{{views.judge}}</strong>
                    </div>
                </div>

            </div>
      
            <div class="row">
                <div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading">Tabulation: <span style="border: 0!important;" ng-show="views.contestant_no != 0?true:false">{{views.contestant_no}}:</span>&nbsp;&nbsp;<strong>{{views.contestant}}</strong>
							<div class="pull-right" >
								<div class="dropdown">
								  <button class="btn btn-success dropdown-toggle btn-xs" type="button" data-toggle="dropdown" aria-expanded="true">
									<span class="glyphicon glyphicon-user"></span>
									<span class="caret"></span>
								  </button>
								  <ul class="dropdown-menu" role="menu">
									<li ng-repeat="contestant in contestants" role="presentation"><a role="menuitem" tabindex="-1" href="javascript:;" ng-click="tabulate(contestant.id)"><span style="border: 0!important;" ng-show="contestant.no != 0?true:false">#{{contestant.no}}:</span>&nbsp;&nbsp;<strong>{{contestant.cluster_name}}</strong></a></li>
								  </ul>
								</div>
							</div>							
						</div>
						<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover">
								<thead>
									<tr><th>Criteria</th><th>Percentage</th><th>Score</th><th>&nbsp;</th></tr>										
								</thead>
								<tbody>
									<tr ng-repeat="criterion in criteria">
										<td>{{criterion.description}}</td>
										<td>{{criterion.percentage}}</td>
										<td>
											<input type="number" class="form-control" ng-disabled="views.criteria[criterion.criteria_id]" name="score" ng-model="criterion.score" min="1" max="{{criterion.percentage}}">
										</td>
										<td>
											<button type="button" class="btn btn-default btn-sm" ng-click="score(criterion)">
												<span ng-class="{'glyphicon': true, 'glyphicon-pencil': views.criteria[criterion.criteria_id], 'glyphicon-saved': !views.criteria[criterion.criteria_id]}" aria-hidden="true"></span>
											</button>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="panel-footer">
							<!--<a href="#" class="btn btn-default btn-block"> <i class="glyphicon glyphicon-repeat"></i> Just A Small Footer Button</a>-->
						</div>
						</div>
					</div>
                    <hr />
                </div>
                <div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading">Standing
							<div class="pull-right" >
								  <button class="btn btn-success btn-xs" type="button" data-toggle="dropdown" aria-expanded="true" ng-click="refreshStanding(this)">
									<span class="glyphicon glyphicon-refresh"></span>
								  </button>
							</div>							
						</div>
						<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover">
								<thead>
									<tr><th>#</th><th>Contestant</th><th>Score</th><th>Rank</th></tr>										
								</thead>
								<tbody>
									<tr ng-repeat="contestant in standing">
										<td>{{contestant.no}}</td>
										<td>{{contestant.name}}</td>
										<td>{{contestant.score}}</td>
										<td>{{$index+1}}</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="panel-footer">
							<!--<a href="#" class="btn btn-default btn-block"> <i class="glyphicon glyphicon-repeat"></i> Just A Small Footer Button</a>-->
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
	<script src="controllers/dashboard.js"></script>	
</body>
</html>
