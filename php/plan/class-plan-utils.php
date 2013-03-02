<?php

require_once dirname(__FILE__).'/../classes/class-base.php';
require_once dirname(__FILE__).'/../classes/class-leg.php';
require_once dirname(__FILE__).'/../classes/class-journey.php';
require_once dirname(__FILE__).'/../etc/config.php';

function startsWith($haystack, $needle)
{
    return !strncmp($haystack, $needle, strlen($needle));
}



class obj {
}



class plan_options {
	public $mode = "TRANSIT,WALK";
	public $maxTransfers = 25;
	public $arriveBy = 'false';
	public $ui_date = "2013-01-14";
	public $optimize = "QUICK";
	public $maxWalkDistance = 3000;
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
	public $realtime_journey_id = "";	//	Journey ID in KV78 turbo format

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

		$dur = $response->routes[0]->legs[0]->duration->value;
		
		$lg = new Leg();
		$lg->from = new Place($request->from->lat, $request->from->lon, $request->from->name);
		$lg->to = new Place($request->to->lat, $request->to->lon, $request->to->name);
		$lg->duration = $dur;
		$lg->startTime = $request->options->_datetime;
		$lg->endTime = new mm_datetime();
		$lg->endTime->setMMDateTime($request->options->_datetime);
		$lg->endTime->addMinutes(floor($dur/60));
		
		$lg->mode = "DRIVING";
		

		$retval = new obj();
		$retval->distance = $response->routes[0]->legs[0]->distance->value;
		$retval->duration = $response->routes[0]->legs[0]->duration->value;
		$retval->distancetxt = $response->routes[0]->legs[0]->distance->text;
		$retval->durationtxt = $response->routes[0]->legs[0]->duration->text;
		$retval->startaddress = $response->routes[0]->legs[0]->start_address;
		$retval->endaddress = $response->routes[0]->legs[0]->end_address;
		$retval->src = "curl";
		$retval->url = $url."?mode=driving&origin=".$origin."&destination=".$destination."&sensor=true";
		$retval->rawdata = $result1;
		$retval->data = json_decode($result1);
		$retval->legs = array($lg);
		$retval->type = "car/gmaps";
		$retval->startTime = $lg->startTime;
		$retval->endTime = $lg->endTime;
//		$retval->legs = $legs;
    	return $retval;


    }
    public function plan_car_openrouteservice($request) {
	    // http://www.openrouteservice.org
	    
    }
    
    
    public function geolookup_mapquest($address) {
		//	http://open.mapquestapi.com/geocoding/v1/address?location=glimworm    
		// (see http://open.mapquestapi.com/geocoding/#locations )
		
		$url="http://open.mapquestapi.com/geocoding/v1/address?location=".$address;
		$ch1 = curl_init();
		curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch1, CURLOPT_URL, $url);
		$result1 = curl_exec($ch1);
		$response = json_decode($result1);
		$retval = array();
		
		foreach ($response->results[0]->locations as $loc) {
			$ad = new obj();
			$ad->name = "";
			$ad->lat = $loc->latLng->lat;
			$ad->lng = $loc->latLng->lng;
			$ad->street = $loc->street;
			$ad->postcode = $loc->postalCode;
			$ad->url = $loc->mapUrl;
			$ad->type = $loc->type;
			$ad->data = $loc;
			array_push($retval , $ad);
		}
		
		return $retval;
    }
    
    public function geolookup_gm($address) {
		// http://maps.googleapis.com/maps/api/geocode/json?address=amsterdam+cs&sensor=true
    
		$url="http://maps.googleapis.com/maps/api/geocode/json?address=".$address."&sensor=true";
		$ch1 = curl_init();
		curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch1, CURLOPT_URL, $url);
		$result1 = curl_exec($ch1);
		$response = json_decode($result1);
		$retval = array();
		
		foreach ($response->results as $loc) {
			$ad = new obj();
			$ad->name = $loc->formatted_address;
			$ad->lat = $loc->geometry->location->lat;
			$ad->lng = $loc->geometry->location->lng;
			$ad->street = "";
			$ad->postcode = "";
			$ad->url = "";
			$ad->type = $loc->types;
			$ad->data = $loc;
			array_push($retval , $ad);
		}
		
		return $retval;
    }



    public function geolookup_nominatim($address) {
		// http://nominatim.openstreetmap.org/search?q=glimworm&format=json&polygon=0&addressdetails=1    
    
		$url="http://nominatim.openstreetmap.org/search?q=".$address."&format=json&polygon=0&addressdetails=1";
		$ch1 = curl_init();
		curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch1, CURLOPT_URL, $url);
		$result1 = curl_exec($ch1);
		$response = json_decode($result1);
		$retval = array();
		
		foreach ($response->results[0]->locations as $loc) {
			$ad = new obj();
			$ad->name = "";
			$ad->lat = $loc->latLng->lat;
			$ad->lng = $loc->latLng->lng;
			$ad->street = $loc->street;
			$ad->postcode = $loc->postalCode;
			$ad->url = $loc->mapUrl;
			$ad->type = $loc->type;
			$ad->data = $loc;
			array_push($retval , $ad);
		}
		
		return $retval;
    }
    
    public function taxicosts($distance, $time) {
    	$cost = 283 + ((208*$distance)/1000) + (34 * $time);
    	return ($cost/100);
    }

    public function geolookup($request) {
    	$retval = new obj();
    	$retval->mapquestapi = $this->geolookup_mapquest($request->term);
    	$retval->suggestions = $this->suggest($request);
    	$retval->gm = $this->geolookup_gm($request->term);
    	
    	return $retval;
    }
    
    public function suggest($request) {
    	//	http://9292.nl/suggest?q=eerste+weteringp
		$url="http://9292.nl/suggest?q=".$request->term;
		
		$ch1 = curl_init();
		curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch1, CURLOPT_URL, $url);

		$result1 = curl_exec($ch1);
		$response = json_decode($result1);


		$retval = array();
		
		foreach ($response->locations as $loc) {
			$ad = new obj();
			$ad->name = $loc->name;
			$ad->type = $loc->type . "/" .$loc->subType;
			$ad->lat = 0;
			$ad->lng = 0;
			$ad->street = "";
			$ad->postcode = "";
			$ad->url = "http://9292.nl/".$loc->url;
			$ad->data = $loc;
			array_push($retval , $ad);
		}
		
		return $retval;
    }
    
    public function getnode($request) {
    }

    public function RD2WGS84($x, $y){
        /* Conversie van Rijksdriehoeksmeting naar latitude en longitude (WGS84)
        Voorbeeld: Station Utrecht    
        x = 136013;
        y = 455723;
        */

        $dX = ($x - 155000) * pow(10,-5);
        $dY = ($y - 463000) * pow(10,-5);

        $SomN = (3235.65389 * $dY) + (-32.58297 * pow($dX,2)) + (-0.2475 * pow($dY,2)) + (-0.84978 * pow($dX,2) * $dY) + (-0.0655 * pow($dY,3)) + (-0.01709 * pow($dX,2) * pow($dY,2)) + (-0.00738 * $dX) + (0.0053 * pow($dX,4)) + (-0.00039 * pow($dX,2) * pow($dY,3)) + (0.00033 * pow($dX,4) * $dY) + (-0.00012 * $dX * $dY);
        $SomE = (5260.52916 * $dX) + (105.94684 * $dX * $dY) + (2.45656 * $dX * pow($dY,2)) + (-0.81885 * pow($dX,3)) + (0.05594 * $dX * pow($dY,3)) + (-0.05607 * pow($dX,3) * $dY) + (0.01199 * $dY) + (-0.00256 * pow($dX,3) * pow($dY,2)) + (0.00128 * $dX * pow($dY,4)) + (0.00022 * pow($dY,2)) + (-0.00022 * pow($dX,2)) + (0.00026 * pow($dX,5));

        $lat = 52.15517 + ($SomN / 3600);
        $lon = 5.387206 + ($SomE / 3600);
        
        return(Array("lat" => $lat, "lon" => $lon));
    }

    public function is_driving_delays($request) {
		$count = 0;
		$jsontxt = file_get_contents("http://www.trafficlink-online.nl/trafficlinkdata/wegdata/TrajectSensorsNH.GeoJSON");
		$json = json_decode($jsontxt);
		foreach($json->features as $feature){
			$count++;
			$color = $feature->properties->COLOR;
			$points = $feature->geometry->coordinates;
			$info = "". $feature->properties->LOCATION . " ";
			$info .= "Lengte: ". $feature->properties->LENGTH ." meter ";
			$info .= "Snelheid: ". $feature->properties->VELOCITY ." km/u ";
			$info .= "Normale reistijd: ". floor($feature->properties->TRAVELTIME_FF / 60) .":". str_pad($feature->properties->TRAVELTIME_FF % 60,2,"0") ." ";
			$info .= "Huidige reistijd: ". floor($feature->properties->TRAVELTIME / 60) .":". str_pad($feature->properties->TRAVELTIME % 60,2,"0") ."";
			$split = "";
			print("var path". $count ." = [");
			foreach($points as $point){
				$latlon = $this->RD2WGS84($point[0], $point[1]);
				$lat = $latlon["lat"];
				$lon = $latlon["lon"];
				print($split . " new google.maps.LatLng(". $lat .", ". $lon .")");
				$split = ",";
			}
			print("];\n");
           
			print("var line". $count ." = new google.maps.Polyline({map: map, path: path". $count .", strokeColor: '". $color ."', strokeOpacity: 1.0,strokeWeight: 3, title: '". $title ."'});\n");
			print("google.maps.event.addListener(line". $count .", 'click', function() {alert('". $info ."'); });\n");
		}
    }
    
    public function plan_car_mapquest($request) {
    
    	$origin = $request->from->lat ."," . $request->from->lon;
    	$destination = $request->to->lat ."," . $request->to->lon;
    	
    	/*
    		reference : http://open.mapquestapi.com/directions/
    	*/
		
		$url="http://open.mapquestapi.com/directions/v1/route";
		
		$ch1 = curl_init();
//			curl_setopt($ch1, CURLOPT_POST, 1);
		curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch1, CURLOPT_URL, $url."?outFormat=json&from=".$origin."&to=".$destination."&unit=k&routeType=fastest&shapeFormat=raw&narrativeType=text&generalize=200");
		
		//mustAvoidLinkIds
		//tryAvoidLinkIds
		//dateType=2 (mon, 3=tue)
		//&timeType=2&dateType=0&date=04/14/2011&localTime=12:05
		
		$result1 = curl_exec($ch1);
		$response = json_decode($result1);

//			echo "<h1>dump response</h1>";
//			var_dump($response);
		
		$dur = $response->route->time;

		$lg = new Leg();
		$lg->from = new Place($request->from->lat, $request->from->lon, $request->from->name);
		$lg->to = new Place($request->to->lat, $request->to->lon, $request->to->name);
		$lg->mode = "DRIVING";
		$lg->duration = $dur;
		$lg->startTime = $request->options->_datetime;
		$lg->endTime = new mm_datetime();
		$lg->endTime->setMMDateTime($request->options->_datetime);
		$lg->endTime->addMinutes(floor($dur/60));


		$retval = new obj();
		$retval->distance = floor($response->route->distance*1000);
		$retval->duration = $response->route->time;
		$retval->distancetxt = floor($response->route->distance*1000);
		$retval->durationtxt = $response->route->time;
		$retval->startaddress = $response->route->locations[0]->street . $response->route->locations[0]->postalCode;
		$retval->endaddress = $response->route->locations[1]->street . $response->route->locations[1]->postalCode;
		$retval->src = "curl";
		$retval->url = $url."?outFormat=json&from=".$origin."&to=".$destination."&unit=k&routeType=fastest&shapeFormat=raw&narrativeType=text&generalize=200";
		$retval->rawdata = $result1;
		$retval->data = json_decode($result1);
		$retval->legs = array($lg);
		$retval->type = "car/mapquest";
		$retval->startTime = $lg->startTime;
		$retval->endTime = $lg->endTime;
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
		$last_endtime = null;
				
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
				$last_endtime = $lg->endTime;
				
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

				} else if ($leg->mode == "SUBWAY") {
					$lg->transitinfo = new TransitInfoSubway();
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
					
				} else {
					$lg->transitinfo = new TransitInfoBase();
				}
				
				array_push($legs , $lg);
				
			}	
			$retval = new obj();
			$retval->url = $h;
			$retval->rawdata = $data;
			$retval->data = json_decode($data);
			$retval->legs = $legs;
			$retval->type = "transit/OTP";
			$retval->endTime = $last_endtime;
			$retval->duration = 0;	// we don't use the duration here we instead send the endtime
			$retval->status = 0;	// ok
		} else {
			/* 

			error occurred, it is generally possible to get errors like:

			Trip is not possible.  Your start or end point might not be safely accessible (for instance, you might be starting on a residential street connected only to a highway).

			*/
			$retval = new obj();
			$retval->url = $h;
			$retval->rawdata = $data;
			$retval->data = json_decode($data);
			$retval->legs = array();
			$retval->type = "transit/OTP";
			$retval->endTime = $request->options->_datetime;
			$retval->duration = 0;
			$retval->status = -1;	// error
			
		}

	
//		$items = json_decode($data);
//		array_push($totalitems , $items->items);
//		$totalitems = array_merge($totalitems , $items->items);
//		$totalitems = $items->items;



    	
    	return $retval;

    }
    
    
    public function plan($from, $to, $__datetime, $mmh, $options) {
    
    	$routes = array();
    
//		for ($j=0; $j < 20; $j++) {
		for ($j=0; $j < count($mmh->hubs); $j++) {
		
			$journey = new Journey();

			if ($options->debug) echo sprintf("\n\nREQ3 / HUB %s (%S) (%s) \n\n", $j,$mmh->hubs[$j], $mmh->hubs[$j]->type);
	
			if (startsWith($mmh->hubs[$j]->type,"CAR-TO")) {
			
				$_datetime = new mm_datetime();
				$_datetime->setMMDateTime($__datetime);
	
				$req = new plan_request();
				$req->from = $from;
				$req->to = $mmh->hubs[$j]->asPlace();
				$req->options->_date = $_datetime->asDate();
				$req->options->_time = $_datetime->asTime();
				$req->options->_datetime->setMMDateTime($_datetime);

//				$response = $this->plan_car($req);
				$response = $this->plan_car_mapquest($req);
				
				$journey->addleg($response);
				
				

				if ($options->debug) echo "DRIVING :: " . $response->legs[0] . " dist : " .$response->distancetxt.", duration : " .$response->durationtxt."\n";
		
				if ($options->debug) echo sprintf(" duration in mons %s \n", floor($response->duration/60));
				if ($options->debug) echo sprintf(" old start date : %s \n",$_datetime->toString());
				$_datetime->addMinutes(floor($response->duration/60));
				if ($options->debug) echo sprintf(" new start date : %s \n",$_datetime->toString());


				$leg = new Leg();
				$leg->from = $mmh->hubs[$j]->asPlace();
				$leg->to = $mmh->hubs[$j]->asPlace();
				$leg->mode = "PARKING";
				$leg->type = "STATIC";
				$leg->startTime = $_datetime;
				$_datetime->addMinutes(5);
				$leg->endTime = $_datetime;
				$journey->addleg($leg);


				$req = new plan_request();
				$req->from = $mmh->hubs[$j]->asPlace();
				$req->to = $to;
				$req->options->_date = $_datetime->asDate();
				$req->options->_time = $_datetime->asTime();
				if($options->maxWalkDistance) $req->options->maxWalkDistance = $options->maxWalkDistance;

				$response = $this->plan_otp($req);

				if ($response->status == 0) {

					$journey->addleg($response);
				
					if ($options->debug) {
						echo sprintf("url : %s \n\n",$response->url);
						for ($i=0; $i < count($response->legs); $i++) {
							echo "Leg $i :: " . $response->legs[$i] . "\n";
						}
					}
				    array_push($routes , $journey);
				}
				
			}
			if (startsWith($mmh->hubs[$j]->type,"TRANSIT-TO-TAXI")) {
			
				// transit
				if ($options->debug) echo sprintf("\n\nREQ3 / TRANSIT FIRST \n\n");

				$_datetime = new mm_datetime();
				$_datetime->setMMDateTime($__datetime);
				$req = new plan_request();
				$req->from = $from;
				$req->to = $mmh->hubs[$j]->asPlace();
				$req->options->_date = $_datetime->asDate();
				$req->options->_time = $_datetime->asTime();
				$req->options->_datetime->setMMDateTime($_datetime);
				if($options->maxWalkDistance) $req->options->maxWalkDistance = $options->maxWalkDistance;

				$response = $this->plan_otp($req);
				
				if ($response->status == 0) {
					// only calculate the 2nd half of the journey if there was not an error from OTP
				
					$journey->addleg($response);
				
					// add duration
//					$_datetime->addMinutes(floor($response->duration/60));

//					echo "RESPONSE";
//					var_dump($response);
//					echo "END TIME";
//					var_dump($response->endTime);
//					echo "END END TIME";

					$_datetime = new mm_datetime();
					$_datetime->setMMDateTime($response->endTime);

					// swith to taxi
					$leg = new Leg();
					$leg->from = $mmh->hubs[$j]->asPlace();
					$leg->to = $mmh->hubs[$j]->asPlace();
					$leg->mode = "GET_TAXI";
					$leg->type = "STATIC";
					$leg->startTime = $_datetime;
					$_datetime->addMinutes(5);
					$leg->endTime = $_datetime;
					$journey->addleg($leg);
				
					// now driving to address				

					$req = new plan_request();
					$req->from = $mmh->hubs[$j]->asPlace();
					$req->to = $to;
					$req->options->_date = $_datetime->asDate();
					$req->options->_time = $_datetime->asTime();
					$req->options->_datetime->setMMDateTime($_datetime);

//					$response = $this->plan_car($req);
					$response = $this->plan_car_mapquest($req);
				
					$response->cost = $this->taxicosts($response->distance, ($response->duration/60));
				
				
				
					$journey->addleg($response);
					if ($options->debug) echo sprintf(" new start date : %s \n",$_datetime->toString());

				    array_push($routes , $journey);
				} else {
//					var_dump($response->data->error);
				
				}
				
			}
			if (startsWith($mmh->hubs[$j]->type,"TRANSIT-TO-CONNECTCAR")) {
			
				// transit
				$_datetime = new mm_datetime();
				$_datetime->setMMDateTime($__datetime);
				$req = new plan_request();
				$req->from = $from;
				$req->to = $mmh->hubs[$j]->asPlace();
				$req->options->_date = $_datetime->asDate();
				$req->options->_time = $_datetime->asTime();
				$req->options->_datetime->setMMDateTime($_datetime);
				if($options->maxWalkDistance) $req->options->maxWalkDistance = $options->maxWalkDistance;

				$response = $this->plan_otp($req);



				
				if ($response->status == 0) {
					// only calculate the 2nd half of the journey if there was not an error from OTP
				
					$journey->addleg($response);
				
					// add duration
//					$_datetime->addMinutes(floor($response->duration/60));

//					echo "RESPONSE";
//					var_dump($response);
//					echo "END TIME";
//					var_dump($response->endTime);
//					echo "END END TIME";

					$_datetime = $response->endTime;

					// swith to taxi
					$leg = new Leg();
					$leg->from = $mmh->hubs[$j]->asPlace();
					$leg->to = $mmh->hubs[$j]->asPlace();
					$leg->mode = "GET_CONNECTCAR";
					$leg->type = "STATIC";
					$leg->startTime = $_datetime;
					$_datetime->addMinutes(5);
					$leg->endTime = $_datetime;
					$journey->addleg($leg);
				
					// now driving to address				

					$req = new plan_request();
					$req->from = $mmh->hubs[$j]->asPlace();
					$req->to = $to;
					$req->options->_date = $_datetime->asDate();
					$req->options->_time = $_datetime->asTime();
					$req->options->_datetime->setMMDateTime($_datetime);

//					$response = $this->plan_car($req);
					$response = $this->plan_car_mapquest($req);
				
					$response->cost = 0;
					// $this->taxicosts($response->distance, ($response->duration/60));
				
				
				
					$journey->addleg($response);
					if ($options->debug) echo sprintf(" new start date : %s \n",$_datetime->toString());

				    array_push($routes , $journey);
				} else {
					/*
					echo "<pre>";
					var_dump($response->data->error);
					var_dump($from);
					var_dump($to);
					var_dump($__datetime);
					var_dump($mmh->hubs[$j]);
					var_dump($options);
					echo "</pre>";
					*/
				}
				
			}


			if (startsWith($mmh->hubs[$j]->type,"TRANSIT-TO-BIKERNETAL")) {
			
				// transit
				$_datetime = new mm_datetime();
				$_datetime->setMMDateTime($__datetime);
				$req = new plan_request();
				$req->from = $from;
				$req->to = $mmh->hubs[$j]->asPlace();
				$req->options->_date = $_datetime->asDate();
				$req->options->_time = $_datetime->asTime();
				$req->options->_datetime->setMMDateTime($_datetime);
				if($options->maxWalkDistance) $req->options->maxWalkDistance = $options->maxWalkDistance;

				$response = $this->plan_otp($req);



				
				if ($response->status == 0) {
					// only calculate the 2nd half of the journey if there was not an error from OTP
				
					$journey->addleg($response);
				
					// add duration
//					$_datetime->addMinutes(floor($response->duration/60));

//					echo "RESPONSE";
//					var_dump($response);
//					echo "END TIME";
//					var_dump($response->endTime);
//					echo "END END TIME";

					$_datetime = $response->endTime;

					// swith to taxi
					$leg = new Leg();
					$leg->from = $mmh->hubs[$j]->asPlace();
					$leg->to = $mmh->hubs[$j]->asPlace();
					$leg->mode = "RENT_BIKE";
					$leg->type = "STATIC";
					$leg->startTime = $_datetime;
					$_datetime->addMinutes(5);
					$leg->endTime = $_datetime;
					$journey->addleg($leg);
				
					// now driving to address				


					$req = new plan_request();
					$req->from = $mmh->hubs[$j]->asPlace();
					$req->to = $to;
					$req->options->_date = $_datetime->asDate();
					$req->options->_time = $_datetime->asTime();
					$req->options->_datetime->setMMDateTime($_datetime);
					$req->options->mode = "BICYCLE";

					$response1 = $this->plan_otp($req);
					if ($response1->status == 0) {
						$journey->addleg($response1);
						if ($options->debug) echo sprintf(" new start date : %s \n",$_datetime->toString());
					    array_push($routes , $journey);
					}

				} else {
					/*
					echo "<pre>";
					var_dump($response->data->error);
					var_dump($from);
					var_dump($to);
					var_dump($__datetime);
					var_dump($mmh->hubs[$j]);
					var_dump($options);
					echo "</pre>";
					*/
				}
				
			}
			if (startsWith($mmh->hubs[$j]->type,"BIKE-TO-TRANSIT")) {
			
				// transit
				if ($options->debug) echo sprintf("\n\nREQ3 / TRANSIT FIRST \n\n");
				$_datetime = new mm_datetime();
				$_datetime->setMMDateTime($__datetime);
				$req = new plan_request();
				$req->from = $from;
				$req->to = $mmh->hubs[$j]->asPlace();
				$req->options->_date = $_datetime->asDate();
				$req->options->_time = $_datetime->asTime();
				$req->options->_datetime->setMMDateTime($_datetime);
				$req->options->mode = "BICYCLE";
				if($options->maxWalkDistance) $req->options->maxWalkDistance = $options->maxWalkDistance;
				

				$response = $this->plan_otp($req);
				$journey->addleg($response);
				
				// add duration
//				$_datetime->addMinutes(floor($response->duration/60));
				$_datetime = $response->endTime;

				// swith to transit
				$leg = new Leg();
				$leg->from = $mmh->hubs[$j]->asPlace();
				$leg->to = $mmh->hubs[$j]->asPlace();
				$leg->mode = "PARK_BIKE";
				$leg->type = "STATIC";
				$leg->startTime = $_datetime;
				$_datetime->addMinutes(5);
				$leg->endTime = $_datetime;
				$journey->addleg($leg);
				
				// now driving to address				

				$req = new plan_request();
				$req->from = $mmh->hubs[$j]->asPlace();
				$req->to = $to;
				$req->options->_date = $_datetime->asDate();
				$req->options->_time = $_datetime->asTime();
				if($options->maxWalkDistance) $req->options->maxWalkDistance = $options->maxWalkDistance;

				$response = $this->plan_otp($req);
				
				$journey->addleg($response);
				if ($options->debug) echo sprintf(" new start date : %s \n",$_datetime->toString());

			    array_push($routes , $journey);
				
			}

		}
		
		// driving all the way
		$_datetime = new mm_datetime();
		$_datetime->setMMDateTime($__datetime);
		$req = new plan_request();
		$req->from = $from;
		$req->to = $to;
		$req->options->_date = $_datetime->asDate();
		$req->options->_time = $_datetime->asTime();
		$req->options->_datetime->setMMDateTime($_datetime);

//		$response = $this->plan_car($req);
		$response = $this->plan_car_mapquest($req);
	
		if ($options->debug) echo "DRIVING ALL THE WAY :: " . $response->legs[0] . " dist : " .$response->distancetxt.", duration : " .$response->durationtxt."\n";
		
		$journey = new Journey();
		$journey->addleg($response);
	    array_push($routes , $journey);


		// transit all the way
		if ($options->debug) echo sprintf("\n\nREQ3 / TRANSIT ALL THE WAY \n\n");
		$_datetime = new mm_datetime();
		$_datetime->setMMDateTime($__datetime);
		$req = new plan_request();
		$req->from = $from;
		$req->to = $to;
		$req->options->_date = $_datetime->asDate();
		$req->options->_time = $_datetime->asTime();
		$req->options->_datetime->setMMDateTime($_datetime);
		if($options->maxWalkDistance) $req->options->maxWalkDistance = $options->maxWalkDistance;

		$response = $this->plan_otp($req);
	
	
		if ($options->debug) {
			for ($i=0; $i < count($response->legs); $i++) {
				echo "Leg $i :: " . $response->legs[$i] . "\n";
			}
		}

		$journey = new Journey();
		$journey->addleg($response);
	    array_push($routes , $journey);

		
		$retval = new obj();
		$retval->routes = $routes;
		
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