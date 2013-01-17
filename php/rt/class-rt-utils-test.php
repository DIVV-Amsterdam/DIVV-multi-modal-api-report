<?php

ini_set("memory_limit","1024M");

error_reporting(-1);

require_once '../etc/config.php';
require_once 'class-rt-utils.php';

$rtu = new RtUtils();

echo "\n\ntest 1";



// bus 44 diemen noord to Buimer arena
$req = new rtrequest_kv78();
$req->company = "gvb";
$req->line_num = "44";
$req->mode = "BUS";
$req->headsign = "Station Bijlmer ArenA";
$req->from->stopindex = 0;
$req->from->scheduled_time_at_stop = $rtu->newdate(2013,01,20,15,45);
$req->to->stopindex = 12;
$req->to->scheduled_time_at_stop = $rtu->newdate(2013,01,20,16,8);

$response = $rtu->get_rt_details_from_leg_kv78($req);
echo "\n\n";
echo "\nrequest" . $rtu->request_as_string($req);
echo "\nresponse";
echo "\nstatus : " . $response->status;
echo "\nrealtime_reference : " . $response->realtime_reference;



// metro to Gaasperplas


$req = new rtrequest_kv78();
$req->company = "gvb";
$req->line_num = "53";
$req->mode = "SUBWAY";
$req->headsign = "Centraal Station";
$req->from->stopid = "Station Diemen-Zuid";
$req->from->scheduled_time_at_stop = $rtu->newdate(2013,01,20,16,10);
$req->to->stopid = "Weesperplein";
$req->to->scheduled_time_at_stop = $rtu->newdate(2013,01,20,16,21);

$response = $rtu->get_rt_details_from_leg_kv78($req);
echo "\n\n";
echo "\nrequest" . $rtu->request_as_string($req);
echo "\nresponse";
echo "\nstatus : " . $response->status;
echo "\nrealtime_reference : " . $response->realtime_reference;





// Tram

$req = new rtrequest_kv78();
$req->company = "gvb";
$req->line_num = "7";
$req->mode = "TRAM";
$req->headsign = "Slotermeer";
$req->from->stopid = "Weesperplein";
$req->from->scheduled_time_at_stop = $rtu->newdate(2013,01,20,16,32);
$req->to->stopindex = 13;
$req->to->scheduled_time_at_stop = $rtu->newdate(2013,01,20,16,37);

$response = $rtu->get_rt_details_from_leg_kv78($req);
echo "\n\n";
echo "\nrequest" . $rtu->request_as_string($req);
echo "\nresponse";
echo "\nstatus : " . $response->status;
echo "\nrealtime_reference : " . $response->realtime_reference;

// train


$req = new rtrequest_ns();
$req->company = "ns";
$req->tripShortname = "5848";
$req->mode = "TRAIN";
$req->from->stopname = "wp | 5";
$req->from->scheduled_time_at_stop = $rtu->newdate(2013,01,20,11,44);
$req->to->stopname = "asd | 14a";
$req->to->scheduled_time_at_stop = $rtu->newdate(2013,01,20,12,8);

$response = $rtu->get_rt_details_from_leg_ns($req);
echo "\n\n";
echo "\nrequest" . $rtu->request_as_string($req);
echo "\nresponse";
echo "\nstatus : " . $response->status;
echo "\nrealtime_reference : " . $response->realtime_reference;



$req = new rtrequest_kv78();
$req->company = "cxx";
$req->line_num = "71";
$req->headsign = "Slotermeerweg";
$req->from->stopid = "CXX|57135182";
$req->from->scheduled_time_at_stop = $rtu->newdate(2013,01,20,11,44);
$req->to->stopid = "CXX|57135182";
$req->to->scheduled_time_at_stop = $rtu->newdate(2013,01,20,12,8);

$response = $rtu->get_rt_details_from_leg_kv78($req);
echo "\n\n";
echo "\nrequest" . $rtu->request_as_string($req);
echo "\nresponse";
echo "\nstatus : " . $response->status;
echo "\nrealtime_reference : " . $response->realtime_reference;



echo "\n\n";






echo "\n\n";


?>