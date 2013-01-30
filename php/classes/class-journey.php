<?php

require_once 'class-base.php';

class Journey extends BaseClass {
    public $legs = array();

    function __construct() {
    	$this->legs = array();
    }
    
    public function addleg($leg) {
	    array_push($this->legs , $leg);
    }
    
    public function summary() {
    	$retval = "Journey\n";
    	foreach ($this->legs as $leg) {
    		if ($leg->type == "STATIC") {
    			$retval = $retval . "\t" . $leg->mode . "\n";
    		} else {
    			$retval = $retval . "\t" . $leg->type . " (et:".$leg->endTime.", dur:".$leg->duration.") \n";
    		
		    	foreach ($leg->legs as $leg2) {
				    $retval = $retval . "\t\t". $leg2->summary()."\n";
		    	}
		    }
		}
		return $retval;
    	
    }
    

}