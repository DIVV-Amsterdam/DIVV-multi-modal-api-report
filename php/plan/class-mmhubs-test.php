<?php
ini_set("memory_limit","1024M");

error_reporting(-1);

require_once dirname(__FILE__).'/../etc/config.php';
require_once dirname(__FILE__).'/class-mmhubs.php';

$mmh = new mmhubs();

var_dump($mmh);


?>