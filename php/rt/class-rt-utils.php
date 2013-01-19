<?php

require_once '../classes/class-leg.php';
require_once '../etc/config.php';

class obj {
}

class rt_datetime {
	public $day = 0;
	public $month = 0;
	public $year = 0;
	public $hour = 0;
	public $minute = 0;
	public function toString() {
		return $this->year . "-" . $this->month ."-". $this->day ." ". $this->hour .":". $this->minute;
	}
}

class rtrequest_kv78 {
	public $type = "rtrequest_kv78";
	public $company = "";	// gvb, cxx etc..
	public $mode = "";
	public $line_num = "";	// 4
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
    
    public function newdate($Y, $M, $D, $H, $M) {
    	$rt_datetime = new rt_datetime();
    	$rt_datetime->day = $D;
    	$rt_datetime->month = $M;
    	$rt_datetime->year = $Y;
    	$rt_datetime->hour = $H;
    	$rt_datetime->minute = $M;
    	return $rt_datetime;
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
		
		// your stuff here


	

		$retval = new rtresponse();
		$retval->status = 0;
		$retval->realtime_reference = "Journey ID in KV78 turbo format";
		
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
