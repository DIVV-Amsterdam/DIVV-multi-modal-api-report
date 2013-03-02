<?php

require_once dirname(__FILE__).'/class-base.php';

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
    			$retval = $retval . "\t" . $leg->type . " (et:".$leg->endTime.", dur:".$leg->duration.", cost:".$leg->cost.") \n";
    			$retval = $retval . "\t" . $leg->url ."\n" ;
//    			$retval = $retval . "\t" . $leg->rawdata ."\n" ;
		    	foreach ($leg->legs as $leg2) {
				    $retval = $retval . "\t\t". $leg2->summary()."\n";
		    	}
		    }
		}
		return $retval;
    	
    }

    public function as_json() {
		return json_encode($this);
    }
    
    public function summary_in_html($N) {
    	$CNT = 0;
    	$retval = "<ul>";
    	$endtime = "";
    	foreach ($this->legs as $leg) {
	    	$endtime = $leg->endTime->asTime();
		}
    	$retval = $retval . sprintf("<li class='mode-journey'><div class='mode-title'>Journey</div><div class='journey-endtime'>%s</div></li>",$endtime);

    	foreach ($this->legs as $leg) {
	    	$CNT1 = 0;
    		if ($leg->type == "STATIC") {
    			try {
	    			$ad = $leg->from->name;
	    		} catch (Exception $e) {
	    			$ad = "";
	    		}
    			$retval = $retval . sprintf("<li class='mode-%s'><div class='mode-title'>%s</div><div class='mmhub'></div>%s</li>", $leg->mode, $leg->mode,$ad);
    		} else {
    			$details = "et:".$leg->endTime."<br>dur:".$leg->duration."<br>cost:".$leg->cost."";
    			
			    $lnk = sprintf("<a href='javascript:replan(%s,%s)'>re-plan</a>",$N,$CNT);
    			
    			$retval = $retval . sprintf("<li><div class='mode-title'>%s</div> <div>%s</div>%s</li>", $leg->type,$details,$lnk);
		    	foreach ($leg->legs as $leg2) {
	    			$retval = $retval . $leg2->summary_in_html($N,$CNT,$CNT1);
				    $CNT1++;
		    	}
		    }
		    $CNT++;
		}
		$retval = $retval . "</ul>";
		return $retval;
    	
    }
    

}