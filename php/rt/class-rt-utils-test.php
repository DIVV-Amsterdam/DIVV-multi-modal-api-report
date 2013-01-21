<?php

ini_set("memory_limit","1024M");

error_reporting(-1);

require_once '../etc/config.php';
require_once 'class-rt-utils.php';

$rtu = new RtUtils();

echo "\n\ntest 1";

// 
// 
// // bus 44 diemen noord to Buimer arena
// $req = new RtRequestKv78();
// $req->company = "gvb";
// $req->line_num = "44";
// $req->mode = "BUS";
// $req->headsign = "Station Bijlmer ArenA";
// $req->from->stopindex = 0;
// $req->from->scheduled_time_at_stop = new DateTime("2013-01-20 15:45", new DateTimeZone("UTC"));
// $req->to->stopindex = 12;
// $req->to->scheduled_time_at_stop = new DateTime("2013-01-20 16:8", new DateTimeZone("UTC"));
// 
// $response = $rtu->get_rt_details_from_leg_kv78($req);
// echo "\n\n";
// echo "\nrequest" . $rtu->request_as_string($req);
// echo "\nresponse";
// echo "\nstatus : " . $response->status;
// echo "\nrealtime_reference : " . $response->realtime_reference;
// 
// 
// 
// // metro to Gaasperplas
// 
// 
// $req = new RtRequestKv78();
// $req->company = "gvb";
// $req->line_num = "53";
// $req->mode = "SUBWAY";
// $req->headsign = "Centraal Station";
// $req->from->stopid = "Station Diemen-Zuid";
// $req->from->scheduled_time_at_stop = new DateTime("2013-01-20 16:10", new DateTimeZone("UTC"));
// $req->to->stopid = "Weesperplein";
// $req->to->scheduled_time_at_stop = new DateTime("2013-01-20 16:21", new DateTimeZone("UTC"));
// 
// $response = $rtu->get_rt_details_from_leg_kv78($req);
// echo "\n\n";
// echo "\nrequest" . $rtu->request_as_string($req);
// echo "\nresponse";
// echo "\nstatus : " . $response->status;
// echo "\nrealtime_reference : " . $response->realtime_reference;
// 
// 



// Tram

$req = new RtRequestKv78();
$req->route_id = "GVB|17";
$req->headsign = "Osdorp Dijkgraafplein";
$req->from->name = "Centraal Station";
$req->from->stopid = "GVB|050111";
$req->from->target_departure_time = new DateTime("2013-01-20 16:32", new DateTimeZone("Europe/Amsterdam"));
$req->to->name = "Bilderdijkstraat";
$req->to->stopid = "GVB|060231";
$req->to->target_arrival_time = new DateTime("2013-01-20 10:43:22", new DateTimeZone("Europe/Amsterdam"));

$response = $rtu->get_rt_details_from_leg_kv78($req);
echo "\n\n";
echo "\nrequest " . $rtu->request_as_string($req);
echo "\nresponse ";
echo "\nstatus: " . $response->status;
echo "\nrealtime_reference: " . $response->realtime_reference;

// train

// 
// $req = new rtrequest_ns();
// $req->company = "ns";
// $req->tripShortname = "5848";
// $req->mode = "TRAIN";
// $req->from->stopname = "wp | 5";
// $req->from->scheduled_time_at_stop = new DateTime("2013-01-20 11:44", new DateTimeZone("UTC"));
// $req->to->stopname = "asd | 14a";
// $req->to->scheduled_time_at_stop = new DateTime("2013-01-20 12:8", new DateTimeZone("UTC"));
// 
// $response = $rtu->get_rt_details_from_leg_ns($req);
// echo "\n\n";
// echo "\nrequest" . $rtu->request_as_string($req);
// echo "\nresponse";
// echo "\nstatus : " . $response->status;
// echo "\nrealtime_reference : " . $response->realtime_reference;
// 
// 
// 
// $req = new RtRequestKv78();
// $req->company = "cxx";
// $req->line_num = "71";
// $req->headsign = "Slotermeerweg";
// $req->from->stopid = "CXX|57135182";
// $req->from->scheduled_time_at_stop = new DateTime("2013-01-20 11:44", new DateTimeZone("UTC"));
// $req->to->stopid = "CXX|57135182";
// $req->to->scheduled_time_at_stop = new DateTime("2013-01-20 12:8", new DateTimeZone("UTC"));
// 
// $response = $rtu->get_rt_details_from_leg_kv78($req);
// echo "\n\n";
// echo "\nrequest" . $rtu->request_as_string($req);
// echo "\nresponse";
// echo "\nstatus : " . $response->status;
// echo "\nrealtime_reference : " . $response->realtime_reference;
// 
// 

echo "\n\n";






echo "\n\n";


?>