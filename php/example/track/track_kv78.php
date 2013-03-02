<?php

 error_reporting(E_ALL);
 ini_set("display_errors", 1);

require_once '../../rt/realtime-interface.php';

$json = $_POST["json"];
$data = json_decode($json);

echo "<legend>Track options</legend>";


// Extract useful data from the transit info
$sched_time = $data->transitinfo->to->scheduled_time_at_stop;

$sched_time_string = sprintf("%s-%s-%s %s:%s:%s", $sched_time->year, $sched_time->month, $sched_time->day, $sched_time->hour, $sched_time->minute, $sched_time->day);
$sched_datetime = new DateTime($sched_time_string, new DateTimeZone("Europe/Amsterdam"));


$req = new RtRequestKv78();
$req->route_id = $data->transitinfo->lineId;
$req->from->name = $data->transitinfo->from->name;
$req->from->stopid = $data->transitinfo->from->stopid;
$req->to->name = $data->transitinfo->to->name;
$req->to->stopid = $data->transitinfo->to->stopid;
$req->to->target_arrival_time = $sched_datetime;


$rt_kv78 = new RealtimeDataKV78();
$response = $rt_kv78->get_kv78_id($req);

if ($response->realtime_journey_id) {
	$req->realtime_journey_id = $response->realtime_journey_id;
	$response = $rt_kv78->get_status($req);
	if ($response->departure_time) {
		echo "Expected departure from ".$req->from->name." at ".$response->departure_time->format(DateTime::ISO8601)." (".$response->departure_delay.")<br />";
	}
	if ($response->arrival_time) {
		echo "Expected arrival at ".$req->to->name." at ".$response->arrival_time->format(DateTime::ISO8601)." (".$response->arrival_delay.")";
	}
} else {
	echo "No tracking information available at this time.";
}

?>
