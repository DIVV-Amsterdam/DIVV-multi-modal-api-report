<?php

require_once '../classes/class-leg.php';
require_once '../etc/config.php';

class obj {
}


class rtrequest_kv78 {
	public $type = "rtrequest_kv78";
	public $company = "";	// GVB, CXX, ARR, QBUZZ, HTM, RET, EBS, GVU
	public $mode = "";
	public $line_num = "";	// TODO: figure out whether this should be public or internal line number (82 vs N082)
	public $headsign = "";	// sloterdijk
	public $from, $to;
	
	function __construct() {
		$this->from = new stop_index();
		$this->to = new stop_index();
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

class rtresponse {
	public $status = 0;
	public $realtime_reference = "";	//	Journey ID in KV78 turbo format

}

class RtUtils {

    function __construct() {
    }

    public function request_as_string($request) {
    	if ($request->type == "rtrequest_kv78") {
    		$rv = "";
    		$rv = $rv . "company [".$request->company."]";
    		$rv = $rv . "mode [".$request->mode."]";
    		$rv = $rv . "line_num [".$request->line_num."]";
    		$rv = $rv . "headsign [".$request->headsign."]";
    		$rv = $rv . "depart [".$request->from->toString()."]";
    		$rv = $rv . "arrive [".$request->to->toString()."]";
    		return $rv;
    	}
    	if ($request->type == "rtrequest_ns") {
    		$rv = "";
    		$rv = $rv . "company [".$request->company."]";
    		$rv = $rv . "mode [".$request->mode."]";
    		$rv = $rv . "tripShortname [".$request->tripShortname."]";
    		$rv = $rv . "depart [".$request->from->toString()."]";
    		$rv = $rv . "arrive [".$request->to->toString()."]";
    		return $rv;
    	}
    	return "Unknown request type";
    }
    
    public function get_rt_details_from_leg_kv78($request) {
    	/*
		** Get GVB journey by stop and planned time
		** there is a moving window of oppertunity - it always goes all the way down but drops off data at the start **
		company
		line number
		direction / headsign
		from
			stop index
			scheduled time at stopindex
		to
			stop index
			scheduled time at stopindex
			
			
		GVB match - train, bus (stop on stopindex)
		Connexxion FFF - not in there!!!
		Connexxion bus e.g. CXX/N082, also matchable on the stopid e.g. CXX|57135182 (timingpointcode)
		EBS matchable on number and headsign, also match stopid e.g. EBS|37390021 (timingpointcode)
		
		
		*/
    	if ($request->type != "rtrequest_kv78") {
			$retval = new rtresponse();
			$retval->status = -1;
			$retval->realtime_reference = "invalid request type, please use a class of rtrequest_kv78";
			return $retval;
    	}
    	
    	///////////////////////////////////////////////////
    	// Retrieve the IDs of all currently known journeys
		$journey_ids = array();
        $url = "http://v0.ovapi.nl/line/GVB_17_1,GVB_17_2"; // TODO: generate URL dynamically
        $response = json_decode(file_get_contents($url), true);
        
        // Data structure: (relevant parts only)
        // { '$LINE_ID': 'Actuals': {'$JOURNEY_ID': { <journey data> }, <more journeys> }, <other lines>}
        foreach ($response as $line_id => $line_data) {
            foreach ($line_data['Actuals'] as $journey_id => $journey_data) {
                if ($journey_data['DestinationName50'] == $request->headsign and $journey_data['LinePublicNumber'] == $request->line_num) {
                    $journey_ids[] = $journey_id;
                }
            }
        }

    	///////////////////////////////////////////////
    	// Retrieve the real-time data of all journeys
		$url = "http://v0.ovapi.nl/journey/".implode(",", $journey_ids);
        $response = json_decode(file_get_contents($url), true);
        
        // Data structure:
        // {'$JOURNEY_ID': {'Stops': {'$STOP_INDEX': {'ExpectedArrivalTime': <ISO stamp>, ...}, <more stops>}}, <more journeys>}
		$retval = new rtresponse();

        $openov_date_format = 'Y-m-d*H:i+';
        foreach ($response as $journey_id => $journey_data) {
            foreach ($journey_data['Stops'] as $stop_index => $stop_data) {
                if ($stop_index == $request->to->stopindex) {
                    $tta = DateTime::createFromFormat($openov_date_format, $stop_data['TargetArrivalTime'], new DateTimeZone("UTC"));
                    print "found journey $journey_id tta ".$tta->format('Y-m-d H:i:s')." status ".$status = $stop_data['TripStopStatus']." to ".$stop_data['DestinationName50']."\n";
                    if ($tta == $request->to->scheduled_time_at_stop) {
                        print "MATCH\n";
                		$retval->realtime_reference = $journey_id;
                        return $retval;
                    }
                }
            }
        }
		
		$retval->status = -1;
		return $retval;
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
			$retval = new rtresponse();
			$retval->status = -1;
			$retval->realtime_reference = "invalid request type, please use a class of rtrequest_ns";
			return $retval;
    	}
		
		
		
		// your stuff here
	

		$retval = new rtresponse();
		$retval->status = 0;
		$retval->realtime_reference = "reference to realtime data in train format";
		return $retval;

    
    }
    
    

}
