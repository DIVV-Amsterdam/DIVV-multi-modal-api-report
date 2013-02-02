<?php

ini_set("memory_limit","1024M");

error_reporting(-1);

require_once dirname(__FILE__).'/../../etc/config.php';
require_once dirname(__FILE__).'/../../plan/class-plan-utils.php';
require_once dirname(__FILE__).'/../../plan/class-mmhubs.php';


$pu = new PlanUtils();
$mmh = new mmhubs();

echo "<h1>Suggest</h1>";


$term = $_GET["term"];

if ($term) {
	$req = new obj();
	$req->term = $term;

	$response = $pu->suggest($req);
	echo "Results<pre>";
	var_dump($response);
	echo "</pre>";
}

echo sprintf("<form action='suggest.php'><input type='text' name='term' value='%s'><input type='submit' value='suggest'></form>",$term);


?>