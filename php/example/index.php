<?php

session_start();


if ($_GET["action"] != "") $_POST = $_GET;
$action = $_POST["action"];
$cli = false;

if (count($argv) > 1) {
	$action = $argv[1];
	$cli = true;
}


/*
we will return the following

	{	
		status : (num)
		status_msg : (some text)
		data : [] (an array of data)
	}
	
*/

$dbhost = "localhost";
$username = "root";
$password = "glimworm";
$database = "cition";
$images_folder = "/srv/www/htdocs/cition/images/";



$htop = "";
$htop = $htop .'<!DOCTYPE html>';
$htop = $htop .'<html lang="en">';
$htop = $htop .'  <head>';
$htop = $htop .'    <meta charset="utf-8">';
$htop = $htop .'    <title>Bootstrap, from Twitter</title>';
$htop = $htop .'    <meta name="viewport" content="width=device-width, initial-scale=1.0">';
$htop = $htop .'    <meta name="description" content="">';
$htop = $htop .'    <meta name="author" content="">';

$htop = $htop .'    <!-- Le styles -->';
$htop = $htop .'    <link href="http://www.glimworm.com/_assets/moock/bootstrap/css/bootstrap.css" rel="stylesheet">';
$htop = $htop .'    <style type="text/css">';
$htop = $htop .'      body {';
$htop = $htop .'        padding-top: 60px;';
$htop = $htop .'        padding-bottom: 40px;';
$htop = $htop .'      }';
$htop = $htop .'    </style>';
$htop = $htop .'    <link href="http://www.glimworm.com/_assets/moock/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">';

$htop = $htop .'    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->';
$htop = $htop .'    <!--[if lt IE 9]>';
$htop = $htop .'      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>';
$htop = $htop .'    <![endif]-->';

$htop = $htop .'    <!-- Le fav and touch icons -->';
$htop = $htop .'    <link rel="shortcut icon" href="http://www.glimworm.com/_assets/moock/bootstrap/ico/favicon.ico">';
$htop = $htop .'    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="http://www.glimworm.com/_assets/moock/bootstrap/ico/apple-touch-icon-144-precomposed.png">';
$htop = $htop .'    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="http://www.glimworm.com/_assets/moock/bootstrap/ico/apple-touch-icon-114-precomposed.png">';
$htop = $htop .'    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="http://www.glimworm.com/_assets/moock/bootstrap/ico/apple-touch-icon-72-precomposed.png">';
$htop = $htop .'    <link rel="apple-touch-icon-precomposed" href="http://www.glimworm.com/_assets/moock/bootstrap/ico/apple-touch-icon-57-precomposed.png">';
$htop = $htop .'  </head>';
$htop = $htop .'  <body>';

$htop = $htop .'    <div class="navbar navbar-fixed-top">';
$htop = $htop .'      <div class="navbar-inner">';
$htop = $htop .'        <div class="container">';
$htop = $htop .'          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">';
$htop = $htop .'            <span class="icon-bar"></span>';
$htop = $htop .'            <span class="icon-bar"></span>';
$htop = $htop .'            <span class="icon-bar"></span>';
$htop = $htop .'          </a>';
$htop = $htop .'          <a class="brand" href="#">DIVV MM project examples</a>';
$htop = $htop .'          <div class="nav-collapse">';
$htop = $htop .'            <ul class="nav">';
$htop = $htop .'              <li class="active"><a href="index.php">Home</a></li>';
$htop = $htop .'              <li class="active"><a href="geocoding/suggest.php">Geocoding - suggest</a></li>';
$htop = $htop .'              <li class="active"><a href="index.php?action=push">Push Notifications</a></li>';
$htop = $htop .'              <li class="active"><a href="index.php?action=list-pages">Pages</a></li>';
$htop = $htop .'              <li class="active"><a href="index.php?action=map">Map</a></li>';
$htop = $htop .'              <li class="active"><a href="index.php?action=logout">Logout</a></li>';
$htop = $htop .'            </ul>';
$htop = $htop .'          </div><!--/.nav-collapse -->';
$htop = $htop .'        </div>';
$htop = $htop .'      </div>';
$htop = $htop .'    </div>';
$htop = $htop .'    <div class="container">';

$hbot = "";
$hbot = $hbot .'      <footer>';
$hbot = $hbot .'        <p>&copy; Company 2012</p>';
$hbot = $hbot .'      </footer>';
$hbot = $hbot .'    <!-- Le javascript';
$hbot = $hbot .'    ================================================== -->';
$hbot = $hbot .'    <!-- Placed at the end of the document so the pages load faster -->';
$hbot = $hbot .'    <script src="http://www.glimworm.com/_assets/moock/bootstrap/js/jquery.js"></script>';
$hbot = $hbot .'    <script src="http://www.glimworm.com/_assets/moock/bootstrap/js/bootstrap-transition.js"></script>';
$hbot = $hbot .'    <script src="http://www.glimworm.com/_assets/moock/bootstrap/js/bootstrap-alert.js"></script>';
$hbot = $hbot .'    <script src="http://www.glimworm.com/_assets/moock/bootstrap/js/bootstrap-modal.js"></script>';
$hbot = $hbot .'    <script src="http://www.glimworm.com/_assets/moock/bootstrap/js/bootstrap-dropdown.js"></script>';
$hbot = $hbot .'    <script src="http://www.glimworm.com/_assets/moock/bootstrap/js/bootstrap-scrollspy.js"></script>';
$hbot = $hbot .'    <script src="http://www.glimworm.com/_assets/moock/bootstrap/js/bootstrap-tab.js"></script>';
$hbot = $hbot .'    <script src="http://www.glimworm.com/_assets/moock/bootstrap/js/bootstrap-tooltip.js"></script>';
$hbot = $hbot .'    <script src="http://www.glimworm.com/_assets/moock/bootstrap/js/bootstrap-popover.js"></script>';
$hbot = $hbot .'    <script src="http://www.glimworm.com/_assets/moock/bootstrap/js/bootstrap-button.js"></script>';
$hbot = $hbot .'    <script src="http://www.glimworm.com/_assets/moock/bootstrap/js/bootstrap-collapse.js"></script>';
$hbot = $hbot .'    <script src="http://www.glimworm.com/_assets/moock/bootstrap/js/bootstrap-carousel.js"></script>';
$hbot = $hbot .'    <script src="http://www.glimworm.com/_assets/moock/bootstrap/js/bootstrap-typeahead.js"></script>';
$hbot = $hbot .'  </body>';
$hbot = $hbot .'</html>';




if ( $action == "cron" ) {


}


$h = "welcome";
echo $htop;
echo '<div class="hero-unit">';
echo $h;
echo "</div>";
echo $hbot;
exit;
