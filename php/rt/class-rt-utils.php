<?php

require_once '../classes/class-leg.php';
require_once '../etc/config.php';

class obj {
}


class RtRequestKv78 {
	public $type = "rtrequest_kv78";
	public $route_id = "";	// e.g. "CXX|N082" for Connexxion 82 Marnixstraat->IJmuiden
	public $from, $to;
	public $kv78_id;       // Fill with get_kv78_id_for_leg, needed for get_rt_details_for_kv78
	
	function __construct() {
		$this->from = new TransitLineStop();
		$this->to = new TransitLineStop();
	}
}


class rtrequest_ns {
	public $type = "rtrequest_ns";
	public $company = "ns";	// ns
	public $mode = "TRAIN";
	public $tripShortname = "";	// 5848
	public $from, $to;
	
	function __construct() {
		$this->from = new stop_name();
		$this->to = new stop_name();
	}
	
	
}

class RtResponse {
	public $status = 0;
	public $kv78_id = "";	//	Journey ID in KV78 turbo format
    public $departure_time;
    public $departure_delay;
    public $arrival_time;
    public $arrival_delay;
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
    		$rv = $rv . "tripShortname [".$request->tripShortname."]\n";
    		$rv = $rv . "    depart [".$request->from->toString()."\n    ]\n";
    		$rv = $rv . "    arrive [".$request->to->toString()."\n    ]";
    		return $rv;
    	}
    	return "Unknown request type";
    }
    
    public function get_kv78_id_for_leg($request) {
    	/*
		** Get the KV78 journey ID for a leg.
		** This is found using the route ID, destination name, and the arrival time at a given stop.
		** there is a moving window of oppertunity - it always goes all the way down but drops off data at the start **
		** Requires a fully filled in RtRequestKv78 - see that class for info on the required fields.
		*/
    	if ($request->type != "rtrequest_kv78") {
			$retval = new RtResponse();
			$retval->status = -1;
			$retval->kv78_id = "invalid request type, please use a class of rtrequest_kv78";
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
                        $retval->kv78_id = $journey_id;
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
			$retval->kv78_id = "invalid request type, please use a class of rtrequest_kv78";
			return $retval;
    	}
    	if ($request->kv78_id == "") {
			$retval = new RtResponse();
			$retval->status = -1;
			return $retval;
    	}
    	////////////////////////////////////////////////////////////////////
    	// Retrieve the real-time data of our journey
    	////////////////////////////////////////////////////////////////////
		$url = "http://v0.ovapi.nl/journey/".$request->kv78_id;
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
    
    
    
    
    public function get_rt_details_from_leg_ns($request) {
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
			$retval->kv78_id = "invalid request type, please use a class of rtrequest_ns";
			return $retval;
    	}
		
		
		
		// your stuff here
	

		$retval = new RtResponse();
		$retval->status = 0;
		$retval->kv78_id = "reference to realtime data in train format";
		return $retval;

    
    }
    
    

}
