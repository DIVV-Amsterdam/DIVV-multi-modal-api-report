<?php
ini_set("memory_limit","1024M");

error_reporting(-1);

require_once '../etc/config.php';
require_once 'class-plan-utils.php';
require_once 'class-mmhubs.php';


$pu = new PlanUtils();
$mmh = new mmhubs();



/*
// http://opentripplanner.nl/opentripplanner-api-webapp/ws/plan?maxTransfers=12
//&_dc=1358423838102
//&from=&to=&
//arriveBy=false
//&time=15%3A02
//&ui_date=14%2F01%2F13&
mode=TRANSIT%2CWALK
&optimize=QUICK
&maxWalkDistance=1000
&walkSpeed=0.833
&hst=true&date=2013-01-14&toPlace=52.359798%2C4.884206&fromPlace=52.339633%2C4.998495
*/


$req = new plan_request();
$req->from = new place(52.339633 , 4.998495 , "");
$req->to = new place(52.359798 , 4.884206 , "");
$req->options->_date = "2013-01-18";
$req->options->_time = "09:30";

$response = $pu->plan_otp($req);

echo "REQ1";
echo "\n\n rawdata:";
echo $response->rawdata;
echo "\n\n url : ";
echo $response->url;
echo "\n\n legs: ";
echo count($response->legs);
echo "\n\n ";
for ($i=0; $i < count($response->legs); $i++) {
	echo "Leg $i :: " . $response->legs[$i] . "\n";
}



$response = $pu->plan_car($req);

echo "REQ2";
echo "\n\n";
echo $response->rawdata;
echo "\n\n";
echo $response->url;
echo "\n\n";

/*
from this location 

https://maps.google.com/maps?q=utrecht+&hl=en&ll=52.083266,4.878896&spn=0.000972,0.002275&sll=52.390294,4.837804&sspn=0.007726,0.018196&geocode=FTznHgMdJDxMAA%3BFSgbHwMdwLFKAClVd5qUtT_GRzGNr8C3TP0AZg&dirflg=r&ttype=now&noexp=0&noal=0&sort=def&hnear=Utrecht,+The+Netherlands&t=m&z=19&start=0&layer=c&cbll=52.083266,4.878896&panoid=R17jGtPpsrrVwmpGma2mEQ&cbp=12,298.87,,0,0
*/



echo "REQ3 , count mmhubs = " . count($mmh->hubs);

$from = new place(52.083266,4.878896 , "Anjerstraat 3, Woerden");

$to = new place(52.359798 , 4.884206 , "");

$_datetime = new mm_datetime(2013,1,19,9,30);
echo sprintf(" begining start date : %s \n",$_datetime->toString());


for ($j=0; $j < count($mmh->hubs); $j++) {

	echo sprintf("\n\nREQ3 / HUB %s (%S) \n\n", $j,$mmh->hubs[$j]);
	
	$req = new plan_request();
	$req->from = $from;
	$req->to = $mmh->hubs[$j]->asPlace();
	$req->options->_date = $_datetime->asDate();
	$req->options->_time = $_datetime->asTime();
	$req->options->_datetime->setDate(2013,1,18);
	$req->options->_datetime->setTime(9,30);

	$response = $pu->plan_car($req);

	echo "DRIVING :: " . $response->legs[0] . " dist : " .$response->distancetxt.", duration : " .$response->durationtxt."\n";
	
	echo sprintf(" duration in mons %s \n", floor($response->duration/60));
	echo sprintf(" old start date : %s \n",$_datetime->toString());
	$_datetime->addMinutes(floor($response->duration/60));
	echo sprintf(" new start date : %s \n",$_datetime->toString());

	$req = new plan_request();
	$req->from = $mmh->hubs[$j]->asPlace();
	$req->to = $to;
	$req->options->_date = $_datetime->asDate();
	$req->options->_time = $_datetime->asTime();

	$response = $pu->plan_otp($req);
//	echo sprintf("url : %s \n\n",$response->url);
	
	
	for ($i=0; $i < count($response->legs); $i++) {
		echo "Leg $i :: " . $response->legs[$i] . "\n";
	}


}

// driving only

	echo sprintf("\n\nREQ3 / DRIVING ALL THE WAY \n\n");

	$req = new plan_request();
	$req->from = $from;
	$req->to = $to;
	$req->options->_date = $_datetime->asDate();
	$req->options->_time = $_datetime->asTime();
	$req->options->_datetime->setDate(2013,1,18);
	$req->options->_datetime->setTime(9,30);

	$response = $pu->plan_car($req);

	echo "DRIVING ALL THE WAY :: " . $response->legs[0] . " dist : " .$response->distancetxt.", duration : " .$response->durationtxt."\n";


// transit all the way
	echo sprintf("\n\nREQ3 / TRANSIT ALL THE WAY \n\n");
	$req = new plan_request();
	$req->from = $from;
	$req->to = $to;
	$req->options->_date = $_datetime->asDate();
	$req->options->_time = $_datetime->asTime();

	$response = $pu->plan_otp($req);
//	echo sprintf("url : %s \n\n",$response->url);
	
	
	for ($i=0; $i < count($response->legs); $i++) {
		echo "Leg $i :: " . $response->legs[$i] . "\n";
	}



$st = "2013-01-17T23:51:00+01:00";
list($y, $m, $d, $hh, $mm) = sscanf($st, "%d-%d-%dT%d:%d+");
echo sprintf('%s,%s,%s,%s,%s \n\n',$y,$m,$d,$hh,$mm);					

$mandate = "January 01 2000";
list($month, $day, $year) = sscanf($mandate, "%s %d %d");
echo sprintf('%s,%s,%s\n\n',$month,$day,$year);					
					/*
					$mandate = "January 01 2000";
					list($month, $day, $year) = sscanf($mandate, "%s %d %d");
					<startTime>2013-01-17T23:51:00+01:00</startTime>
					<endTime>2013-01-18T00:15:04+01:00</endTime>
					*/









?>