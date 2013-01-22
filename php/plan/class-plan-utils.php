<?php

require_once '../classes/class-base.php';
require_once '../classes/class-leg.php';
require_once '../etc/config.php';

class obj {
}



class plan_options {
	public $mode = "TRANSIT,WALK";
	public $maxTransfers = 25;
	public $arriveBy = 'false';
	public $ui_date = "2013-01-14";
	public $optimize = "QUICK";
	public $maxWalkDistance = 1000;
	public $walkSpeed = 0.833;
	public $hst = true;
	public $_date = "2013-01-14";
	public $_time = "15:02";
	public $_datetime;
	function __construct() {
		$this->_datetime = new mm_datetime();
	}
	
}

class plan_request {
	public $type = "plan_request";
	public $from, $to, $options;
	
	function __construct() {
		$this->from = new place();
		$this->to = new place();
		$this->options = new plan_options();
	}
	
	
}

class plan_reponse {
	public $status = 0;
	public $realtime_reference = "";	//	Journey ID in KV78 turbo format

}

class PlanUtils {

    function __construct() {
    }
    public function plan_car($request) {
    
    	$origin = $request->from->lat ."," . $request->from->lon;
    	$destination = $request->to->lat ."," . $request->to->lon;
    	
		$url="http://maps.googleapis.com/maps/api/directions/json";
		$ch1 = curl_init();
//			curl_setopt($ch1, CURLOPT_POST, 1);
		curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch1, CURLOPT_URL, $url."?mode=driving&origin=".$origin."&destination=".$destination."&sensor=true");
		
		$result1 = curl_exec($ch1);
		$response = json_decode($result1);

//			echo "<h1>dump response</h1>";
//			var_dump($response);
		
		$lg = new Leg();
		$lg->from = new Place($request->from->lat, $request->from->lon, $request->from->name);
		$lg->to = new Place($request->to->lat, $request->to->lon, $request->to->name);
		$lg->mode = "DRIVING";
		

		$retval = new obj();
		$retval->distance = $response->routes[0]->legs[0]->distance->value;
		$retval->duration = $response->routes[0]->legs[0]->duration->value;
		$retval->distancetxt = $response->routes[0]->legs[0]->distance->text;
		$retval->durationtxt = $response->routes[0]->legs[0]->duration->text;
		$retval->startaddress = $response->routes[0]->legs[0]->start_address;
		$retval->endaddress = $response->routes[0]->legs[0]->end_address;
		$retval->src = "curl";
		$retval->url = $url;
		$retval->rawdata = $result1;
		$retval->data = json_decode($result1);
		$retval->legs = array($lg);
//		$retval->legs = $legs;
    	return $retval;


    }
    public function plan_otp($request) {
    
    	$h = "http://opentripplanner.nl/opentripplanner-api-webapp/ws/plan";
    	$h = $h . "?maxTransfers=".$request->options->maxTransfers;
    	$h = $h . "&_dc=1358423838102";
    	$h = $h . "&from=";
    	$h = $h . "&to=";
    	$h = $h . "&arriveBy=".$request->options->arriveBy;
//    	$h = $h . "&ui_date=".$request->options->ui_date;
    	$h = $h . "&mode=".$request->options->mode;
    	$h = $h . "&optimize=".$request->options->optimize;
    	$h = $h . "&maxWalkDistance=".$request->options->maxWalkDistance;
    	$h = $h . "&walkSpeed=".$request->options->walkSpeed;
    	$h = $h . "&hst=".$request->options->hst;
    	$h = $h . "&date=".$request->options->_date;
    	$h = $h . "&time=".$request->options->_time;
    	$h = $h . "&toPlace=".$request->to->toString();
    	$h = $h . "&fromPlace=".$request->from->toString();
//    	$h = $h . "&maxWalkDistance=".$request->options->maxWalkDistance;
//    	$h = $h . "&maxWalkDistance=".$request->options->maxWalkDistance;

		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch,CURLOPT_URL,$h);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		
		$legs = array();
				
		$trip = json_decode($data);
		if ($trip->plan) {
			$itinerary = $trip->plan->itineraries[0];
			
			for ($i=0; $i < count($itinerary->legs); $i++) {
				$leg = $itinerary->legs[$i];
//				echo "\n Leg : $i \n";
//				var_dump($leg);
				
				$lg = new Leg();
				$lg->from = new Place($leg->from->lat, $leg->from->lon, $leg->from->name);
				$lg->to = new Place($leg->to->lat, $leg->to->lon, $leg->to->name);
				$lg->mode = $leg->mode;
				$lg->startTime = mm_datetime::createFromDateTime(DateTime::createFromFormat('U',($leg->startTime/1000)+(60*60),new DateTimeZone('Europe/Amsterdam')));
				$lg->endTime = mm_datetime::createFromDateTime(DateTime::createFromFormat('U',($leg->endTime/1000)+(60*60),new DateTimeZone('Europe/Amsterdam')));
				if ($leg->mode == "BUS") {
					$lg->transitinfo = new TransitInfoBus();
					$lg->transitinfo->agency = $leg->agencyName;
					$lg->transitinfo->line = $leg->route;
					$lg->transitinfo->lineId = $leg->routeId;
					$lg->transitinfo->headsign = $leg->headsign;
					$lg->transitinfo->from->stopindex = $leg->from->stopIndex;
					$lg->transitinfo->from->stopid = $leg->from->stopId->id;
					$lg->transitinfo->from->name = $leg->from->name;
					$lg->transitinfo->from->lat = $leg->from->lat;
					$lg->transitinfo->from->lon = $leg->from->lon;
					$lg->transitinfo->from->scheduled_time_at_stop = $lg->startTime;
					$lg->transitinfo->to->stopindex = $leg->to->stopIndex;
					$lg->transitinfo->to->stopid = $leg->to->stopId->id;
					$lg->transitinfo->to->name = $leg->to->name;
					$lg->transitinfo->to->lat = $leg->to->lat;
					$lg->transitinfo->to->lon = $leg->to->lon;
					$lg->transitinfo->to->scheduled_time_at_stop = $lg->endTime;

					
				} else if ($leg->mode == "TRAM") {
					$lg->transitinfo = new TransitInfoTram();
					$lg->transitinfo->agency = $leg->agencyName;
					$lg->transitinfo->line = $leg->route;
					$lg->transitinfo->headsign = $leg->headsign;
					$lg->transitinfo->from->stopindex = $leg->from->stopIndex;
					$lg->transitinfo->from->stopid = $leg->from->stopId->id;
					$lg->transitinfo->from->name = $leg->from->name;
					$lg->transitinfo->from->lat = $leg->from->lat;
					$lg->transitinfo->from->lon = $leg->from->lon;
					$lg->transitinfo->from->scheduled_time_at_stop = $lg->startTime;
					$lg->transitinfo->to->stopindex = $leg->to->stopIndex;
					$lg->transitinfo->to->stopid = $leg->to->stopId->id;
					$lg->transitinfo->to->name = $leg->to->name;
					$lg->transitinfo->to->lat = $leg->to->lat;
					$lg->transitinfo->to->lon = $leg->to->lon;
					$lg->transitinfo->to->scheduled_time_at_stop = $lg->endTime;

				} else if ($leg->mode == "SUBWAY") {
					$lg->transitinfo = new TransitInfoSubway();
					$lg->transitinfo->agency = $leg->agencyName;
					$lg->transitinfo->line = $leg->route;
					$lg->transitinfo->headsign = $leg->headsign;
					$lg->transitinfo->from->stopindex = $leg->from->stopIndex;
					$lg->transitinfo->from->stopid = $leg->from->stopId->id;
					$lg->transitinfo->from->name = $leg->from->name;
					$lg->transitinfo->from->lat = $leg->from->lat;
					$lg->transitinfo->from->lon = $leg->from->lon;
					$lg->transitinfo->from->scheduled_time_at_stop = $lg->startTime;
					$lg->transitinfo->to->stopindex = $leg->to->stopIndex;
					$lg->transitinfo->to->stopid = $leg->to->stopId->id;
					$lg->transitinfo->to->name = $leg->to->name;
					$lg->transitinfo->to->lat = $leg->to->lat;
					$lg->transitinfo->to->lon = $leg->to->lon;
					$lg->transitinfo->to->scheduled_time_at_stop = $lg->endTime;
					
				} else {
					$lg->transitinfo = new TransitInfoBase();
				}
				
				array_push($legs , $lg);
				
			}	
		}

		$retval = new obj();
		$retval->url = $h;
		$retval->rawdata = $data;
		$retval->data = json_decode($data);
		$retval->legs = $legs;
	
//		$items = json_decode($data);
//		array_push($totalitems , $items->items);
//		$totalitems = array_merge($totalitems , $items->items);
//		$totalitems = $items->items;



    	
    	return $retval;

    }
    
    
    public function plan_from_out_of_town($request) {


    
    
    }
    
    
/*
// http://opentripplanner.nl/opentripplanner-api-webapp/ws/plan?maxTransfers=12
//&_dc=1358423838102
//&from=&to=&
//arriveBy=false
//&time=15%3A02
//&ui_date=14%2F01%2F13&
mode=TRANSIT%2CWALK
&optimize=QUICK
&maxWalkDistance=1000
&walkSpeed=0.833
&hst=true&date=2013-01-14&toPlace=52.359798%2C4.884206&fromPlace=52.339633%2C4.998495
*/

}



?>