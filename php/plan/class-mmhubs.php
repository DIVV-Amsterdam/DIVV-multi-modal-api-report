<?php

/* 
	defintion of a location 
	lat, lon, name, address (all obvious)
	optname 	: name or reference in opentripplanner
	gmname		: name or reference in gogle maps
	type		: TRANSIT, CARPARK
*/
class location {
	public $lat = 0;
	public $lon = 0;
	public $name = "";
	public $address = "";
	public $otpname = "";
	public $gmname = "";
	public $type = "";

	function __construct($LAT=0, $LON=0, $NAME="", $ADDR="") {
		$this->lat = $LAT;
		$this->lon = $LON;
		$this->name = $NAME;
		$this->address = $ADDR;
	}
    public function __toString() {
    	return $this->lat . "," . $this->lon;
    }

}

/*
	a connection from a multimodal hub
*/
class mmhub_connection {
	public $timetochange = 0;
	public $location;
	public $type;
	
	public function setLocation($NAME) {
		return $location;
	}
	public function getLocation() {
		return $location;
	}
}

/*
	multi modal hub , a place where you can swap from car to public transit
*/

class mmhub {
	public $id = "";
	public $location;
	public $type;
	public $connections = array();
	
	
	function __construct($LAT=0, $LON=0, $NAME, $ADDR ) {
		$this->location = new location( $LAT, $LON, $NAME, $ADDR);
	}
	
	public function addConnection($CON) {
		array_push($this->connections , $CON);
	}
	
	public function asPlace() {
		$pl = new place($this->location->lat, $this->location->lon,$this->location->name);
		return $pl;
	}
	
}

/*
	List of all multi modal hubs
*/

class mmhubs {
	public $hubs = array();
	
	function __construct() {
	
		$hub = new mmhub(52.313831,4.940286,"P+R ArenA Transferium","Burgemeester+Stramanweg+130,+1101+EP+Amsterdam");
		$hub->location->type = "CARPARK";
		$hub->type = "CARPARK-TO-TRANSIT";
		
		$con = new mmhub_connection();
		$con->type = "TRANSIT";
		$con->location = new location(52.31867,4.94136,"Strandvliet","no address");
		$con->timetochange = 120;
		$con->howtochange = "Walking directions from P+R to Strandvliet GVB station";
		$hub->addConnection($con);

		array_push($this->hubs , $hub);

		$hub = new mmhub(52.390294,4.837804,"P+R Sloterdijk","Piarcoplein%2B1,Amsterdam");
		$hub->location->type = "CARPARK";
		$hub->type = "CARPARK-TO-TRANSIT";
		
		$con = new mmhub_connection();
		$con->type = "TRANSIT";
		$con->location = new location(52.3891616609,4.83841001987,"Amsterdam Sloterdijk","no address");
		$con->timetochange = 120;
		$con->howtochange = "Walking directions from P+R to Sloterdijk GVB station";
		$hub->addConnection($con);

		array_push($this->hubs , $hub);


		$hub = new mmhub(52.344254,4.853961,"P+R Olympisch Stadion","Olympisch+Stadion+44,+1076+DE+Amsterdam");
		$hub->location->type = "CARPARK";
		$hub->type = "CARPARK-TO-TRANSIT";
		
		$con = new mmhub_connection();
		$con->type = "TRANSIT";
		$con->location = new location(52.34379,4.85696,"Amsterdam, Stadionplein","no address");
		$con->timetochange = 120;
		$con->howtochange = "Walking directions from P+R to bus stop";
		$hub->addConnection($con);

		array_push($this->hubs , $hub);


	
	}





}



?>