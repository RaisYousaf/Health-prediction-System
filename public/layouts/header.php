<?php
require_once('../includes/session.php'); global $session; global $page_title?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" ng-app="cube"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" ng-app="cube"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" ng-app="cube"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" ng-app="icon"><!--<![endif]--><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Smart Health Prediction System</title>
        <meta name="description" content="">
    <meta name="viewport" content="width=device-width">
  
      
 <link rel="stylesheet" href="stylesheets/font-awesome.css">
  <link rel="stylesheet" href="stylesheets/default.css">
  <link rel="stylesheet" href="stylesheets/main.css">
  <link type="text/css" href="stylesheets/LuxiSans.css" rel="stylesheet">
          
	   </head>
	   
    <body>

<header class="header-user-dropdown">

	<div class="header-limiter">
		<h1><a href="#">Smart Health<span> Prediction System</span></a></h1>


    <ul class="ls">
    
		  <li><a class="loginbtn" href="index.php">Home</a></li>
		   <?php if ($session->is_logged_in()) { ?>
			<li><a class="loginbtn" href="editprof.php">Edit Profile</a></li>
			<li><a class="loginbtn" href="diagnose.php">Diagnose</a></li>
			<li><a class="loginbtn" href="logout.php">Log Out</a></li>
			<?php } else { ?>
		   <li><a class="loginbtn" href="register.php">Register</a></li>
		   <li><a class="loginbtn" href="login.php">Login</a></li>
		    <?php } ?>
      
    </ul>


	</div>

</header>
  