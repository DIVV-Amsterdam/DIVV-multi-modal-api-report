<?php

ini_set("memory_limit","1024M");

error_reporting(-1);

require_once '../etc/config.php';
require_once 'class-rt-utils.php';


// Tram 17 from CS to Osdorp

// $req = new RtRequestKv78();
// $req->route_id = "GVB|17";
// $req->from->name = "Centraal Station";
// $req->from->stopid = "GVB|050111";
// $req->from->target_departure_time = new DateTime("2013-01-20 16:32", new DateTimeZone("Europe/Amsterdam"));
// $req->to->name = "Bilderdijkstraat";
// $req->to->stopid = "GVB|060231";
// $req->to->target_arrival_time = new DateTime("2013-01-22 10:24", new DateTimeZone("Europe/Amsterdam"));
// process_and_print_request($req);




// CXX bus 172 from Kudelstraat to Amsterdam CS

$req = new RtRequestKv78();
$req->route_id = "CXX|M172";
$req->from->name = "Aalsmeer, Floraholland Hoofdingang";
$req->from->stopid = "CXX|57442970";
$req->from->target_departure_time = new DateTime("2013-01-20 16:32", new DateTimeZone("Europe/Amsterdam"));
$req->to->name = "Amsterdam, Centraal Station";
$req->to->stopid = "CXX|57002340";
$req->to->target_arrival_time = new DateTime("2013-01-22 11:10", new DateTimeZone("Europe/Amsterdam"));
process_and_print_request($req);





function process_and_print_request($req) {
    $rtu = new RtUtils();
    
    $response = $rtu->get_kv78_id_for_leg($req);
    echo "\n\n";
    echo "\nrequest " . $rtu->request_as_string($req);
    echo "\nresponse ";
    echo "\nstatus: " . $response->status;
    echo "\nkv78_id: " . $response->kv78_id;

    if ($response->kv78_id) {
        $req->kv78_id = $response->kv78_id;
        $response = $rtu->get_rt_details_for_kv78($req);
        if ($response->departure_time) {
            echo "\nexpect D: " . $response->departure_time->format(DateTime::ISO8601);
            echo "\ndelay  D: " . $response->departure_delay;
        }
        echo "\nexpect A: " . $response->arrival_time->format(DateTime::ISO8601);
        echo "\ndelay  A: " . $response->arrival_delay;
    }

    echo "\n\n";
}




echo "\n\n";


?>