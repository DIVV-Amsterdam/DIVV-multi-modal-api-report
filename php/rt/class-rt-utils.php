<?php

require_once '../classes/class-leg.php';
require_once '../etc/config.php';

class obj {
}


class RtRequestKv78 {
	public $type = "rtrequest_kv78";
	public $route_id = "";	// e.g. "CXX|N082" for Connexxion 82 Marnixstraat->IJmuiden
	public $from, $to;
	public $realtime_journey_id; // Fill with get_realtime_journey_id_for_leg, needed for get_rt_details_for_kv78
	
	function __construct() {
		$this->from = new TransitLineStop();
		$this->to = new TransitLineStop();
	}
}


class RtRequestNS {
	public $type = "rtrequest_ns";
	public $company = "NS";	// ns
	public $mode = "TRAIN";
	public $ritNummer = ""; // e.g. 5883, maps to OTP tripShortName (not the routeId!)
	public $from, $to;
	
	function __construct() {
		$this->from = new TransitLineStop();
		$this->to = new TransitLineStop();
	}
	
}

class RtResponse {
	public $status = 0;
	public $realtime_journey_id = ""; // Journey ID (for example, KV78 ID or NS ritnr)
    public $departure_time;
    public $departure_delay; // Delay is always in seconds
    public $changed_departure_track; // Track, e.g. "10B", if it has changed from planning.
    public $departure_remarks; // Freeform remarks (in Dutch, probably)
    public $arrival_time;
    public $arrival_delay;
    public $changed_arrival_track;
    public $arrival_remarks;
}

class RtUtils {

    function __construct() {
    }

    public function request_as_string($request) {
    	if ($request->type == "rtrequest_kv78") {
    		$rv = "";
    		$rv = $rv . "route_id[".$request->route_id."]\n";
    		$rv = $rv . "    depart [".$request->from->toString()."\n    ]\n";
    		$rv = $rv . "    arrive [".$request->to->toString()."\n    ]";
    		return $rv;
    	}
    	if ($request->type == "rtrequest_ns") {
    		$rv = "";
    		$rv = $rv . "company [".$request->company."] ";
    		$rv = $rv . "mode [".$request->mode."] ";
    		$rv = $rv . "ritNummer [".$request->ritNummer."]\n";
    		$rv = $rv . "    depart [".$request->from->toString()."\n    ]\n";
    		$rv = $rv . "    arrive [".$request->to->toString()."\n    ]";
    		return $rv;
    	}
    	return "Unknown request type";
    }
    
    public function get_realtime_journey_id_for_leg($request) {
    	/*
		** Get the KV78 journey ID for a leg.
		** This is found using the route ID, destination name, and the arrival time at a given stop.
		** there is a moving window of oppertunity - it always goes all the way down but drops off data at the start **
		** Requires a fully filled in RtRequestKv78 - see that class for info on the required fields.
		*/
    	if ($request->type != "rtrequest_kv78") {
			$retval = new RtResponse();
			$retval->status = -1;
			$retval->realtime_journey_id = "invalid request type, please use a class of rtrequest_kv78";
			return $retval;
    	}
    	
    	///////////////////////////////////////////////////
    	// Retrieve the IDs of all currently known journeys
    	///////////////////////////////////////////////////
		$journey_ids = array();
		$route_id = strtoupper(str_replace("|", "_", $request->route_id));
		$url = "http://v0.ovapi.nl/line/".$route_id."_1,".$route_id."_2"; // Generate the URL like http://v0.ovapi.nl/line/GVB_17_1,GVB_17_2
        $response = json_decode(file_get_contents($url), true);
        
#        print "response: ".print_r($response)."\n\n----\n";
#        return;
        
        // Data structure: (relevant parts only)
        // { '$LINE_ID': 'Actuals': {'$JOURNEY_ID': { <journey data> }, <more journeys> }, <other lines>}
        foreach ($response as $line_id => $line_data) {
            foreach ($line_data['Actuals'] as $journey_id => $journey_data) {
                 $journey_ids[] = $journey_id;
             }
        }
        // print_r($response);
        // return;
        

    	////////////////////////////////////////////////////////////////////
    	// Retrieve the real-time data of all journeys to find a matching ID
    	////////////////////////////////////////////////////////////////////
		$url = "http://v0.ovapi.nl/journey/".implode(",", $journey_ids);
        $response = json_decode(file_get_contents($url), true);
        
        // Data structure:
        // {'$JOURNEY_ID': {'Stops': {'$STOP_INDEX': {'ExpectedArrivalTime': <ISO stamp>, ...}, <more stops>}}, <more journeys>}
		$retval = new RtResponse();
        
        foreach ($response as $journey_id => $journey_data) {
            foreach ($journey_data['Stops'] as $stop_index => $stop_data) {
                if ($stop_data['TimingPointCode'] == $request->to->timingPointCodeFromStopId()) {
                    $tta = $this->kv78_timestamp_to_datetime($stop_data['TargetArrivalTime']);
                    print "found journey $journey_id tta ".$tta->format('Y-m-d H:i:s')." status ".$status = $stop_data['TripStopStatus']." at ".$stop_data['TimingPointName']."\n";
                    if (abs($tta->getTimestamp() - $request->to->target_arrival_time->getTimestamp()) <= 120) {
                        print "MATCH\n";
                        $retval->realtime_journey_id = $journey_id;
                        return $retval;
                    }
                }
            }
        }
		
		$retval->status = -1;
		return $retval;
    }
    
    
    public function get_rt_details_for_kv78($request) {
    	/*
		** Get the KV78 journey details, given a KV78 ID
		*/
    	if ($request->type != "rtrequest_kv78") {
			$retval = new RtResponse();
			$retval->status = -1;
			$retval->realtime_journey_id = "invalid request type, please use a class of rtrequest_kv78";
			return $retval;
    	}
    	if ($request->realtime_journey_id == "") {
			$retval = new RtResponse();
			$retval->status = -1;
			return $retval;
    	}
    	////////////////////////////////////////////////////////////////////
    	// Retrieve the real-time data of our journey
    	////////////////////////////////////////////////////////////////////
		$url = "http://v0.ovapi.nl/journey/".$request->realtime_journey_id;
        $response = json_decode(file_get_contents($url), true);

        // Data structure:
        // {'$JOURNEY_ID': {'Stops': {'$STOP_INDEX': {'ExpectedArrivalTime': <ISO stamp>, ...}, <more stops>}}, <more journeys>}
		$retval = new RtResponse();
		$retval->status = 0;

        foreach ($response as $journey_id => $journey_data) {
            foreach ($journey_data['Stops'] as $stop_index => $stop_data) {
                $ttd = $this->kv78_timestamp_to_datetime($stop_data['TargetDepartureTime']);
                $etd = $this->kv78_timestamp_to_datetime($stop_data['ExpectedDepartureTime']);
                $tta = $this->kv78_timestamp_to_datetime($stop_data['TargetArrivalTime']);
                $eta = $this->kv78_timestamp_to_datetime($stop_data['ExpectedArrivalTime']);

                if ($stop_data['TimingPointCode'] == $request->from->timingPointCodeFromStopId()) {
                    $retval->departure_time = $etd;
                    $departure_interval = $ttd->diff($etd);
                    $retval->departure_delay = $departure_interval->invert ? -$departure_interval->s : $departure_interval->s;
                }
                if ($stop_data['TimingPointCode'] == $request->to->timingPointCodeFromStopId()) {
                    $retval->arrival_time = $eta;
                    $arrival_interval = $tta->diff($eta);
                    $retval->arrival_delay = $arrival_interval->invert ? -$arrival_interval->s : $arrival_interval->s;
                }
            }
        }

		return $retval;
    }
    
    private function kv78_timestamp_to_datetime($kv78_timestamp) {
        $openov_date_format = 'Y-m-d*H:i:s';
        return DateTime::createFromFormat($openov_date_format, $kv78_timestamp, new DateTimeZone("Europe/Amsterdam"));
    }
    
    
    
    
    public function get_rt_details_for_ns($request, $username, $key) {
    	/*
		Get train by company_shortcode_fromstation_timedepart
		== train is easier ==
		company				ns
		tripShortname		5848
		from
			id			wp | 5
			scheduled time at stopindex
		to
			id			asd | 14a
			scheduled time at stopindex
		*/
    	if ($request->type != "rtrequest_ns") {
			$retval = new RtResponse();
			$retval->status = -1;
			$retval->realtime_journey_id = "invalid request type, please use a class of rtrequest_ns";
			return $retval;
    	}
		
        // public $status = 0;
        //      public $realtime_journey_id = ""; // Journey ID (for example, KV78 ID or NS ritnr)
        //         public $departure_time;
        //         public $departure_delay;
        //         public $arrival_time;
        //         public $arrival_delay;
        //         public $changed_departure_track;
        //         public $changed_arrival_track;
		
		$retval = new RtResponse();
		$retval->status = 0;
		
		// For the from station, we may not have a proper stopId. Get a station name from the stop name.
		$from_name = urlencode(preg_replace('/\s+spoor.*/i', '', $request->from->name));
	    $url = "https://webservices.ns.nl/ns-api-avt?station=$from_name";
	    $response = simplexml_load_string($this->do_ns_api_call($url, $username, $key));
        
        
        $departure_data = $this->get_ns_departure_status($request->ritNummer, $request->from->name, $username, $key);
        $retval->departure_time = $departure_data['departure_time'];
        $retval->departure_delay = $departure_data['departure_delay'];
        $retval->changed_departure_track = $departure_data['changed_departure_track'];
        $retval->departure_remarks = $departure_data['remarks'];
        
        $arrival_data = $this->get_ns_departure_status($request->ritNummer, $request->to->name, $username, $key);
        $retval->arrival_time = $arrival_data['departure_time'];
        $retval->arrival_delay = $arrival_data['departure_delay'];
        $retval->changed_arrival_track = $arrival_data['changed_departure_track'];
        $retval->arrival_remarks = $arrival_data['remarks'];
        
		return $retval;
    }
    
    
    // Station name is either "asd", "Amsterdam Centraal", or "Amsterdam Centraal spoor 8"
    private function get_ns_departure_status($ritNummer, $stationName, $username, $key) {
        $clean_station_name = urlencode(preg_replace('/\s+spoor.*/i', '', $stationName));
	    $url = "https://webservices.ns.nl/ns-api-avt?station=$clean_station_name";
	    $response = simplexml_load_string($this->do_ns_api_call($url, $username, $key));
        
        $retval = array(
            "departure_time" => null,
            "departure_delay" => 0,
            "changed_departure_track" => null,
            "remarks" => null,
        );
        
        foreach($response->VertrekkendeTrein as $departing_train) {
            if($departing_train->RitNummer != $ritNummer) continue;
            $retval['departure_time'] = DateTime::createFromFormat(DateTime::ISO8601, $departing_train->VertrekTijd, new DateTimeZone("UTC"));
            $delay_found = preg_match('/PT(\d+)M/', $departing_train->VertrekVertraging, $matches);
            if ($delay_found) $retval['departure_delay'] = ($matches[1]*60);
            
            $retval['remarks'] = trim($departing_train->Opmerkingen->Opmerking);
            
            if($departing_train->VertrekSpoor['wijziging'] == 'true') {
                $retval['changed_departure_track'] = (string) $departing_train->VertrekSpoor;
            }
        }
        
        return $retval;
    }
    
    private function do_ns_api_call($url, $username, $key) {
        // http://stackoverflow.com/questions/896728/how-to-use-twitter-api-with-http-basic-auth
        $ch = curl_init();
        // Sets the URL cURL will open
        curl_setopt($ch, CURLOPT_URL, $url);
        // Here's the HTTP auth
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$key");
        // Makes curl_exec() return server response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Lately the Twitter API expects an Expect header. It's a mystery
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
        // And here's the result XML
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
    
    

}
