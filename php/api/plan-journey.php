<?php
ini_set("memory_limit","1024M");
error_reporting(-1);

session_start();


require_once dirname(__FILE__).'/../etc/config.php';
require_once dirname(__FILE__).'/class-plan-utils.php';
require_once dirname(__FILE__).'/class-mmhubs.php';




if ($_GET["action"] != "") $_POST = $_GET;
$action = $_POST["action"];



$from = $_GET["from"];
$to = $_GET["to"];
$dd = $_GET["dd"];
$mm = $_GET["mm"];
$yy = $_GET["yy"];
$HH = $_GET["HH"];
$MM = $_GET["MM"];

$_datetime = new mm_datetime($yy,$mm,$dd,$HH,$MM);


$pu = new PlanUtils();



?>