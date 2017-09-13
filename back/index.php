<?php

include_once '../db.php';

$con = new pdo_db();

$judges = $con->getData("SELECT * FROM judges");

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
    <title>Judge Registration - Sayaw-Awit Competition | Tabulation System</title>
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
<body>
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
                    <img src="../assets/img/pglu.png" />
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
                            <li><a class="menu-top-active" href="index.php">Login Judge</a></li>
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
                    <h4 class="page-head-line">Login Judge</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
					<form action="back.php" method="post">
						<div class="form-group">
							<label>Judges</label>
							<select class="form-control" name="judge_id">
							<?php
								
								foreach ($judges as $judge) {
									
									echo '<option value="'.$judge['id'].'">'.$judge['first_name'].' '.$judge['last_name'].'</option>';
									
								}
								
							?>
							</select>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-user"></span>&nbsp;Login</button>						
						</div>
					</form>				
                </div>
				<div class="col-md-6"></div>
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
	
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="../assets/js/bootstrap.js"></script>	
</body>
</html>
