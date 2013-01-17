<?php

require 'class-base-class.php';

class Journey extends BaseClass {
    private $legs = array();

    function __construct($apikey) {
    	$this->legs = array();
    }
    

}