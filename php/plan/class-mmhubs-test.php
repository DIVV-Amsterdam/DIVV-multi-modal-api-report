<?php
ini_set("memory_limit","1024M");

error_reporting(-1);

require_once '../etc/config.php';
require_once 'class-mmhubs.php';

$mmh = new mmhubs();

var_dump($mmh);


?>