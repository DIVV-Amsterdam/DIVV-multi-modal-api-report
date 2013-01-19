<?php

require_once 'class-base.php';

class TransitInfoBase {
	public $agency = "";
	public $line = "";
	public $headsign = "";
	public $from, $to;
	
	function __construct() {
		$this->from = new place();
		$this->to = new place();
	}
	

    public function __toString()
    {
        return "" . $this->from->toString() . "\n-->" . $this->to->toString() ."\n\t(ag: ". $this->agency . " /li: ".$this->line." /hs: ".$this->headsign.")";
    }

}

class TransitInfoBus extends TransitInfoBase {
	
	function __construct() {
		$this->from = new stop_index();
		$this->to = new stop_index();
	}
}
class TransitInfoTram extends TransitInfoBase {
	function __construct() {
		$this->from = new stop_index();
		$this->to = new stop_index();
	}
	
}
class TransitInfoTrain extends TransitInfoBase {

	function __construct() {
		$this->from = new stop_name();
		$this->to = new stop_name();
	}	
}
class TransitInfoWalk extends TransitInfoBase {
	
}
class TransitInfoCar extends TransitInfoBase {
	
}
class TransitInfoSubway extends TransitInfoBase {

	function __construct() {
		$this->from = new stop_index();
		$this->to = new stop_index();
	}
	
}

class Leg {

	public $from;
	public $to;
	public $mode;
	public $transitinfo;
	public $startTime, $endTime;

	
	function __construct() {
		$this->transitinfo = new TransitInfoBase();
	}
	
    public function __toString()
    {
    	try {
	        return sprintf('%s --> %s --> (%s) (st:%s et:%s) (%s)',$this->from,$this->to,$this->mode,$this->startTime,$this->endTime,$this->transitinfo);
	    } catch(Exception $e) {
	        return $this->from . " --> " . $this->to ." (". $this->mode . ") (no transit info)";
	    }
    }
	
}

