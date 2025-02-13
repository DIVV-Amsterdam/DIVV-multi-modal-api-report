<?php
class BaseClass {

    public function Q($S) {
		return "'" . $S . "'";
	}

}


class place {
	public $lat = 0;
	public $lon = 0;
	public $name = "";
	function __construct($LAT = 0,$LON = 0,$NAME = "") {
		$this->lat = $LAT;
		$this->lon = $LON;
		$this->name = $NAME;
	}
	
    public function __toString() {
		return $this->lat .",". $this->lon . "/" . $this->name; 
    }
	public function toString() {
		return $this->lat .",". $this->lon; 
	}
}

class mm_datetime {
	public $day = 0;
	public $month = 0;
	public $year = 0;
	public $hour = 0;
	public $minute = 0;

	function __construct($Y=0, $M=0, $D=0, $HH=0, $MM=0) {
		$this->day = $D;
		$this->month = $M;
		$this->year = $Y;
		$this->hour = $HH;
		$this->minute = $MM;
	}
	function setMMDateTime($mmdt) {
		$this->day = $mmdt->day;
		$this->month = $mmdt->month;
		$this->year = $mmdt->year;
		$this->hour = $mmdt->hour;
		$this->minute = $mmdt->minute;
	}
	
	public static function createFromDateTime($DT) {
		$dt = new mm_datetime();
		$dt->year = $DT->format('Y');
		$dt->month = $DT->format('m');
		$dt->day = $DT->format('d');
		$dt->hour = $DT->format('H');
		$dt->minute = $DT->format('i');
//		$date->format('Y-m-d H:i:s');
		return $dt;
	}


	public function toString() {
		return $this->asDate() ." ". $this->asTime();
	}
    public function __toString() {
    	return $this->toString();
    }
	
	public function setDate($d=0, $m=0, $y=0) {
		$this->day = $d;
		$this->month = $m;
		$this->year = $y;
	}
	public function setTime($h=0, $m=0) {
		$this->hour = $h;
		$this->minute = $m;
	}
	public function asDate() {	//[%010s]
		return  sprintf('%04u',$this->year) . "-" .  sprintf('%02u',$this->month) ."-".  sprintf('%02u',$this->day);
	}
	public function asTime() {
		return  sprintf('%02u',$this->hour) . ":" .  sprintf('%02u',$this->minute);
	}
	public function addMinutes($m) {
		$this->minute = $this->minute + ($m % 60);
		if ($this->minute > 59) {
			$this->minute = $this->minute - 60;
			$this->hour = $this->hour + 1;
		}
		$this->hour = $this->hour + floor($m/60);
		if ($this->hour > 23) {
			$this->hour = $this->hour - 24;
			$this->day = $this->day + 1;
		}
		// month
		if ($this->month == 1 && $this->day > 31) {
			$this->day = $this->day - 31;
			$this->month = $this->month + 1;
		}
		if ($this->month == 2 && $this->day > 28) {
			$this->day = $this->day - 28;
			$this->month = $this->month + 1;
		}
		if ($this->month == 3 && $this->day > 31) {
			$this->day = $this->day - 31;
			$this->month = $this->month + 1;
		}
		if ($this->month == 4 && $this->day > 30) {
			$this->day = $this->day - 30;
			$this->month = $this->month + 1;
		}
		if ($this->month == 5 && $this->day > 31) {
			$this->day = $this->day - 31;
			$this->month = $this->month + 1;
		}
		if ($this->month == 6 && $this->day > 30) {
			$this->day = $this->day - 30;
			$this->month = $this->month + 1;
		}
		if ($this->month == 7 && $this->day > 31) {
			$this->day = $this->day - 31;
			$this->month = $this->month + 1;
		}
		if ($this->month == 8 && $this->day > 31) {
			$this->day = $this->day - 31;
			$this->month = $this->month + 1;
		}
		if ($this->month == 9 && $this->day > 30) {
			$this->day = $this->day - 30;
			$this->month = $this->month + 1;
		}
		if ($this->month == 10 && $this->day > 31) {
			$this->day = $this->day - 31;
			$this->month = $this->month + 1;
		}
		if ($this->month == 11 && $this->day > 30) {
			$this->day = $this->day - 30;
			$this->month = $this->month + 1;
		}
		if ($this->month == 12 && $this->day > 31) {
			$this->day = $this->day - 31;
			$this->month = $this->month + 1;
		}
		// year
		if ($this->month > 12) {
			$this->month = $this->month - 12;
			$this->year = $this->year + 1;
		}
		
	}
}

class TransitLineStop {

	// The ID of the stop, taken from stopId->id, e.g. CXX|57225182 - this maps to a TimingPointCode
	public $stopid = "";
	// Canonical name of the stop, e.g. "Centraal Station"
	public $name;
	public $lat,$lon;

	public $target_arrival_time;
	public $target_departure_time;
		
	public function toString() {
//		return "stopindex (" . $this->stopindex .") , stopid (".$this->stopid.") , name (".$this->name."), datetime (". $this->scheduled_time_at_stop->toString().")";
		return "\n\tstopid (".$this->stopid.") , \n\tname (".$this->name."), \n\tdatetime (".$this->timeString().")";
	}
	
	public function timeString() {
	    $result = "";
	    if ($this->target_arrival_time) {
	        $result .= "A ".$this->target_arrival_time->format(DateTime::ISO8601)." ";
	    }
	    if ($this->target_departure_time) {
	        $result .= "D ".$this->target_departure_time->format(DateTime::ISO8601)." ";
	    }
	    return $result;
	}
	
	public function timingPointCodeFromStopId() {
	    $parts = preg_split("/\|/", $this->stopid);
	    return $parts[1];
	}
	
    public function __toString() {
    	return $this->toString();
    }
	
	
}

class stop_name {
	public $stopname = "wp | 5";
	public $scheduled_time_at_stop;
	public $name,$lat,$lon;
	
	function __construct() {
		$this->scheduled_time_at_stop = new mm_datetime();
	}

	public function toString() {
		return "stopname (" . $this->stopname .") , datetime (". $this->scheduled_time_at_stop->format(DateTime::ISO8601).")";
	}

    public function __toString() {
    	return $this->toString();
    }


}