<?php
ini_set("memory_limit","1024M");

error_reporting(-1);

require_once '../etc/config.php';
require_once 'class-divv-parking-locations.php';

$divvlocations = new divvlocations();

var_dump($divvlocations);

for ($i=0; $i < count($divvlocations->locations->parkeerlocaties); $i++) {
	echo sprintf("\n %s (%s) \n\n", $i,$divvlocations->locations->parkeerlocaties[$i]->parkeerlocatie->type);

}


?>