<?php

ini_set("memory_limit","1024M");

error_reporting(-1);

require_once '../etc/config.php';
require_once 'class-rt-utils.php';


// Tram 17 from CS to Osdorp

// $req = new RtRequestKv78();
// $req->route_id = "GVB|17";
// $req->from->name = "Bilderdijkstraat";
// $req->from->stopid = "GVB|060231";
// $req->from->target_departure_time = new DateTime("2013-01-20 16:32", new DateTimeZone("Europe/Amsterdam"));
// $req->to->name = "Centraal Station";
// $req->to->stopid = "GVB|050111";
// $req->to->target_arrival_time = new DateTime("2013-01-22 13:07", new DateTimeZone("Europe/Amsterdam"));
// process_and_print_kv78_request($req);


// CXX bus 172 from Kudelstraat to Amsterdam CS

// $req = new RtRequestKv78();
// $req->route_id = "CXX|M172";
// $req->from->name = "Aalsmeer, Floraholland Hoofdingang";
// $req->from->stopid = "CXX|57442970";
// $req->from->target_departure_time = new DateTime("2013-01-20 16:32", new DateTimeZone("Europe/Amsterdam"));
// $req->to->name = "Amsterdam, Centraal Station";
// $req->to->stopid = "CXX|57002340";
// $req->to->target_arrival_time = new DateTime("2013-01-22 11:10", new DateTimeZone("Europe/Amsterdam"));
// process_and_print_kv78_request($req);


// Train

$req = new RtRequestNs();
$req->ritNummer = "5735";
$req->from->name = "Amsterdam Airport Spoor 3";
$req->to->name = "Weesp Spoor 11a";
process_and_print_ns_request($req);



function process_and_print_kv78_request($req) {
    $rtu = new RtUtils();
    
    $response = $rtu->get_realtime_journey_id_for_leg($req);
    echo "\n\n";
    echo "\nrequest " . $rtu->request_as_string($req);
    echo "\nresponse ";
    echo "\nstatus: " . $response->status;
    echo "\nrealtime_journey_id: " . $response->realtime_journey_id;

    if ($response->realtime_journey_id) {
        $req->realtime_journey_id = $response->realtime_journey_id;
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


function process_and_print_ns_request($req) {
    $rtu = new RtUtils();
    
    if (!(isset($_ENV['OV_NS_USERNAME']) and isset($_ENV['OV_NS_KEY']))) {
        fwrite(STDERR, "Error: please set OV_NS_USERNAME and OV_NS_KEY in the environment. Instructions on https://www.ns.nl/ews-aanvraagformulier/");
        exit(1);
    }
    
    $response = $rtu->get_rt_details_for_ns($req, $_ENV['OV_NS_USERNAME'], $_ENV['OV_NS_KEY']);
    echo "\n\n";
    echo "\nrequest " . $rtu->request_as_string($req);
    echo "\nresponse ";
    echo "\nstatus: " . $response->status;
    echo "\nrealtime_journey_id: " . $response->realtime_journey_id;

    if ($response->departure_time) {
        echo "\nexpect  D: " . $response->departure_time->format(DateTime::ISO8601);
        echo "\ndelay   D: " . $response->departure_delay;
        echo "\nnew track: " . $response->changed_departure_track;
        echo "\nremark  D: " . $response->departure_remarks;
        
    }
    if ($response->arrival_time) {
        echo "\nexpect  A: " . $response->arrival_time->format(DateTime::ISO8601);
        echo "\ndelay   A: " . $response->arrival_delay;
        echo "\nnew track: " . $response->changed_arrival_track;
        echo "\nremark  A: " . $response->arrival_remarks;
        
    }

    echo "\n\n";
}

echo "\n\n";


?>