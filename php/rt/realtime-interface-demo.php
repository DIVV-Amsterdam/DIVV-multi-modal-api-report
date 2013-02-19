<?php

ini_set("memory_limit","1024M");

error_reporting(-1);

require_once '../etc/config.php';
require_once 'realtime-interface.php';


// Tram 17 GVB

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

$req = new RtRequestKv78();
$req->route_id = "CXX|M172";
$req->from->name = "Aalsmeer, Floraholland Hoofdingang";
$req->from->stopid = "CXX|57442970";
$req->to->name = "Amsterdam, Centraal Station";
$req->to->stopid = "CXX|57002340";
$req->to->target_arrival_time = new DateTime("2013-02-19 13:40", new DateTimeZone("Europe/Amsterdam"));
process_and_print_kv78_request($req);


// Train

// $req = new RtRequestNs();
// $req->ritNummer = "5747";
// $req->from->name = "Amsterdam Airport Spoor 3";
// $req->to->name = "Weesp Spoor 11a";
// process_and_print_ns_request($req);



function process_and_print_kv78_request($req) {
    $rt_kv78 = new RealtimeDataKV78();
    
    $response = $rt_kv78->get_kv78_id($req);
    echo "\n\n";
    echo "\nrequest " . $req;
    echo "\nresponse ";
    echo "\nstatus: " . $response->status;
    echo "\nrealtime_journey_id: " . $response->realtime_journey_id;

    if ($response->realtime_journey_id) {
        $req->realtime_journey_id = $response->realtime_journey_id;
        $response = $rt_kv78->get_status($req);
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
    $rt_ns = new RealTimeDataNS();
    
    if (!(isset($_ENV['OV_NS_USERNAME']) and isset($_ENV['OV_NS_KEY']))) {
        fwrite(STDERR, "Error: please set OV_NS_USERNAME and OV_NS_KEY in the environment. Instructions on https://www.ns.nl/ews-aanvraagformulier/");
        exit(1);
    }
    
    $response = $rt_ns->get_status($req, $_ENV['OV_NS_USERNAME'], $_ENV['OV_NS_KEY']);
    echo "\n\n";
    echo "\nrequest " . $req;
    echo "\nresponse ";
    echo "\nstatus: " . $response->status;

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