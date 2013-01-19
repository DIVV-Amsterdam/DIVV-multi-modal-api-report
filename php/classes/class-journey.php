<?php

require_once 'class-base.php';

class Journey extends BaseClass {
    private $legs = array();

    function __construct($apikey) {
    	$this->legs = array();
    }
    

}