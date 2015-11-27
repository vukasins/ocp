<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>OCP3 Login</title>

    <link href="<?=SITE_ROOT_URI?>/layout/admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=SITE_ROOT_URI?>/layout/admin/css/ocp-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?=SITE_ROOT_URI?>/layout/admin/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic|Roboto+Condensed&subset=latin,cyrillic-ext,greek-ext,greek,vietnamese,latin-ext,cyrillic' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:300italic,400italic,700italic,400,300,700&subset=latin,cyrillic-ext,greek-ext,greek,vietnamese,latin-ext,cyrillic' rel='stylesheet' type='text/css'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    
    <!-- jQuery Version 1.11.0 -->
    <script src="<?=SITE_ROOT_URI?>/layout/admin/js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?=SITE_ROOT_URI?>/layout/admin/js/bootstrap.min.js"></script>

</head>
<body class="nomargin">
	<header>
		<div class="container-fluid">
			<div class="row text-center">
				<img src="<?=SITE_ROOT_URI?>/layout/admin/img/ocp-login.png" alt="OCP3">
			</div>
		</div>
	</header>
	<div class="container">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-3 hidden-xs">
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="form-box" id="login-box">
						<h1><?=__('Sign In')?></h1>
						<form action="" method="post">
							<div class="body bg-gray">
								<?php if(isset($_POST['username'])): ?>
									<div class="form-group">
										<div class="alert alert-danger alert-dismissable">
											<i class="fa fa-ban"></i>
											<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
											<b><?=__('Alert!')?></b> <?=__('Login error')?>
										</div>
									</div>
								<?php endif; ?>
							
								<div class="form-group">
									<input type="text" name="username" value="<?=(isset($_POST['username']) ? $_POST['username'] : '')?>" class="form-control" placeholder="<?=__('User ID')?>"/>
								</div>
								<div class="form-group">
									<input type="password" name="password" class="form-control" placeholder="<?=__('Password')?>"/>
								</div>
								<div class="form-group text-center">
									<button type="submit" class="btn btn-primary"><?=__('Sign me in')?></button>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 hidden-xs">
				</div>
			</div>
		</div>
	</div>
	<footer>
		<div class="container">
			<div class="row">
				<p class="text-center">&copy; 2000-2015 by Omnicom solutions. All rights reserved.</p>
			</div>
		</div>
	</footer>

        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="/layout/admin/js/bootstrap.min.js" type="text/javascript"></script>        

    </body>
</html>