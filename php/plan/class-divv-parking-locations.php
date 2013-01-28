<?php

/*
	List of all multi modal hubs
*/

class divvlocations {
	public $locations = array();
	
	function __construct() {
	
		$my_file = file_get_contents("../parking/parkeren_juli2012_def/locaties.json");
		$this->locations = json_decode($my_file);
	
	}





}



?>