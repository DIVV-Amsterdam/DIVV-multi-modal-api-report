<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once '../../rt/realtime-interface.php';

$json = $_POST["json"];
$data = json_decode($json);

echo "<legend>Track options</legend>";

$rt_ns = new RealTimeDataNS();
    
if (!(isset($_ENV['OV_NS_USERNAME']) and isset($_ENV['OV_NS_KEY']))) {
	die("Error: please set OV_NS_USERNAME and OV_NS_KEY in the environment. Instructions on https://www.ns.nl/ews-aanvraagformulier/");
}

$req = new RtRequestNs();
$req->ritNummer = $data->transitinfo->tripShortName;
$req->from->name = $data->from->name;
$req->to->name = $data->to->name;

$response = $rt_ns->get_status($req, $_ENV['OV_NS_USERNAME'], $_ENV['OV_NS_KEY']);

echo "<h2>Departure information</h2>";
if ($response->departure_time) {
	echo "\nexpected : " . $response->departure_time->format(DateTime::ISO8601);
	echo "\ndelay    : " . $response->departure_delay;
	if ($response->changed_departure_track)
		echo "\nnew track : " . $response->changed_departure_track;
	if ($response->departure_remarks)
		echo "\nremarks  : " . $response->departure_remarks;
} else {
	echo "No information available.";
}

echo "<h2>Arrival information</h2>";
if ($response->arrival_time) {
	echo "\nexpected : " . $response->arrival_time->format(DateTime::ISO8601);
	echo "\ndelay    : " . $response->arrival_delay;
	if ($response->changed_arrival_track)
		echo "\nnew track: " . $response->changed_arrival_track;
	if ($response->departure_remarks)
		echo "\nremarks  : " . $response->arrival_remarks;
} else {
	echo "No information available.";
}

?>
