<?php
?><html>
<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="utf-8">
      <title>DIVV-multi-modal-api-report</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- Le styles -->
      <link href="http://www.glimworm.com/_assets/moock/bootstrap/css/bootstrap.css" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="../css/prettify.css">
      <link href="http://www.glimworm.com/_assets/moock/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
      <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
      <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
      <![endif]-->
      <!-- Le fav and touch icons -->
      <link rel="shortcut icon" href="http://www.glimworm.com/_assets/moock/bootstrap/ico/favicon.ico">
      <link rel="apple-touch-icon-precomposed" sizes="144x144" href="http://www.glimworm.com/_assets/moock/bootstrap/ico/apple-touch-icon-144-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="114x114" href="http://www.glimworm.com/_assets/moock/bootstrap/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="http://www.glimworm.com/_assets/moock/bootstrap/ico/apple-touch-icon-72-precomposed.png">
      <link rel="apple-touch-icon-precomposed" href="http://www.glimworm.com/_assets/moock/bootstrap/ico/apple-touch-icon-57-precomposed.png">
      <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />
      <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
      <script src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
      <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?&sensor=false"></script>
      <link href="../css/styles.css" rel="stylesheet">
      <script src="plan.js"></script>
      <script src="../js/json2.js"></script>
      <script src="../js/jsonviewer.js"></script>
      <!-- http://listjs.com/examples -->
      <script src="../js/list.js"></script>
	<script type='text/javascript'>
		var uvOptions = {};
		(function() {
		var uv = document.createElement('script'); uv.type = 'text/javascript'; uv.async = true;
		uv.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'widget.uservoice.com/wlHMAlKuZ4MLJmN2U2w2RA.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(uv, s);
		})();
	</script>
<style>
.journey-horizontal ul {
	margin : 0;
}
.journey-horizontal li, .journey-horizontal ul {
	list-style: none;
	height :100px;
}
.journey-horizontal li {
	width : 140px;
	float: left;
	font-family: monospace;
	font-size: 12px;
	line-height: 1.4em;
	white-space: normal;
	overflow: hidden;
	border-right: 1px dotted #666666;
	padding-right: 5px;
	padding-left: 5px;	
}
.list {
	list-style: none;
	margin: 0;
	padding: 0;
	border: 0;
}
.mode-DRIVING {
	background-image: url('../images/glymphicons/glyphicons_005_car.png');
	background-repeat: no-repeat;
	background-position: 5px 0;
}
.mode-GET_TAXI {
	background-image: url('../images/glymphicons/glyphicons_005_taxi.png');
	background-repeat: no-repeat;
	background-position: 5px 0;
}
.mode-GET_CONNECTCAR {
	background-image: url('../images/glymphicons/connectcar.png');
	background-repeat: no-repeat;
	background-position: 5px 0;
}
.mode-BUS {
	background-image: url('../images/glymphicons/glyphicons_031_bus.png');
	background-repeat: no-repeat;
	background-position: 5px 0;
}
.mode-WALK {
	background-image: url('../images/glymphicons/walk-icon.png');
	background-repeat: no-repeat;
	background-position: 5px 0;
}
.mode-BICYCLE {
	background-image: url('../images/glymphicons/bike.png');
	background-repeat: no-repeat;
	background-position: 5px 0;
}
.mode-TRAM {
	background-image: url('../images/glymphicons/glyphicons_014_train.png');
	background-repeat: no-repeat;
	background-position: 5px 0;
}
.mode-RAIL {
	background-image: url('../images/glymphicons/train.jpeg');
	background-repeat: no-repeat;
	background-position: 5px 0;
}
.mode-FERRY {
	background-image: url('../images/glymphicons/glyphicons_255_boat.png');
	background-repeat: no-repeat;
	background-position: 5px 0;
}

.mode-PARKING {
	background-image: url('../images/glymphicons/parking.png');
	background-repeat: no-repeat;
	background-position: 5px 0;
}
.mode-PARK_BIKE, .mode-RENT_BIKE {
	background-image: url('../images/glymphicons/parkbike.png');
	background-repeat: no-repeat;
	background-position: 5px 0;
}
.mmhub {
	background-image: url('../images/glymphicons/MMHUB.png');
	background-repeat: no-repeat;
	background-position: 0 0;
	width:80px;
	height:32px;
}
.mode-title {
	font-family: Arial;
	font-size: 18px;
	line-height:36px;
	padding-left:36px;
}
.hid {
	display: none;
}
.journey-horizontal {
	overflow: hidden;
	overflow: scroll;
}
.mode-journey {
}
.journey-endtime {
	font-family: Arial;
	font-size: 18px;
	line-height:36px;
	padding-left:36px;
}
.ui-corner-all {
	border : 0;
	background-color: #ffffff;
}
.ui-widget-header {
	border : 0;
	background-image: none;
	border-bottom: 1px solid #aaa;
	background-color: #ffffff;
}
.ui-widget-content {
	padding-left : 8px;
}

input[type="text"] {
	height : 28px;
}

</style>
</head>
<body>
<div>
<?php
ini_set("memory_limit","1024M");

error_reporting(-1);

require_once dirname(__FILE__).'/../../etc/config.php';
require_once dirname(__FILE__).'/../../plan/class-plan-utils.php';
require_once dirname(__FILE__).'/../../plan/class-mmhubs.php';


$pu = new PlanUtils();
$mmh = new mmhubs();

echo "<legend>Plan a journey</legend>";

$locations = array(
	"52.083266,4.878896,Anjerstraat 3, Woerden",
	"52.359798,4.884206,Rijksmuseum",
	"52.626343,4.746027,Korte+Lyceumstraa Alkmar",
	"51.840118,4.966453,Prinses+Margrietstraat Gorinchem",
	"52.377012,4.819297,Politie Amtalland Lodewijk+van+Deysselstraat Slottermeer"
);


$from = $_GET["from"];
$to = $_GET["to"];
$date = $_GET["date"];
$time = $_GET["time"];
$go = $_GET["go"];
$maxwalk = $_GET["maxwalk"];

if (!$from) $from = $locations[0];
if (!$to) $to = $locations[1];
if (!$date) $date = "2013-01-27";
if (!$time) $time = "14:30";
if (!$maxwalk) $maxwalk = "3000";

echo "<div class='container'>";

echo "<div class='row-fluid'>";
echo "<div class='span6'>";




echo sprintf("<form action='plan.php'>");
echo sprintf("<input type='hidden' name='go' value='y'>");


//echo sprintf("<input type='text' name='from' value='%s'>",$from);

echo sprintf("<label>Start from </label><select name='from'>");
foreach ($locations as $location) {
	$selected = ($from == $location) ? "selected" : "";
	echo sprintf("<option value='%s' %s>%s</option>",$location,$selected,$location);
}
echo sprintf("</select>");

echo sprintf("<label>Go to </label><select name='to'>");
foreach ($locations as $location) {
	$selected = ($to == $location) ? "selected" : "";
	echo sprintf("<option value='%s' %s>%s</option>",$location,$selected,$location);
}
echo sprintf("</select>");


//echo sprintf("<input type='text' name='date' value='%s'>",$date);

echo sprintf('
<label> Start date</label>
<div class="input-append date" id="dp3" data-date="%s" data-date-format="yyyy-mm-dd">
  <input class="span2" name="date" size="16" type="text" value="%s">
  <span class="add-on"><i class="icon-th"></i></span>
</div>
',$date,$date);

echo sprintf('
<label> Start time</label>
<div class="input-append bootstrap-timepicker">
            <input id="timepicker1" type="text" name="time" class="input-small" value="%s">
            <span class="add-on"><i class="icon-time"></i></span>
        </div>',$time);


echo sprintf("
<label> Max Walking Distance (in meters)</label>
<div class='input-append'>
	<input type='text' name='timex' value='%s'>
    <span class='add-on'>M</span>
</div>",$maxwalk);


echo sprintf('</select>');


echo sprintf("<button class='btn' data-loading-text='Loading…' type='submit'>Plan route</button>");
echo sprintf("</form>");


echo "
</div>
<div class='span6'>
<b>Explanation</b>
<p>
We chose in this example to let you select from a set of locations rather than implement a geolocation lookup.  It also deliberately offers all choices and combinations of travel.
</p>
<b>Disclaimer</b>
<p>
It can take quite a while to come up with the results so yo may have to be patient. This demo also requires the api of openstreetmap.nl to be up and running and sometimes it is not.  In our experience just wait a few hours and it comes back up again.
</p>
<b>Code</b>
<p>
The code here is contained in github.  You are free to use the code, read the report, respond and contribute.
</p>
<b>Some Links</b>
<ul>
<li><a href='http://geotribu.net/applications/baselayers/'>Comparison of different maps</a></li>
<li><a href='http://dev.citysdk.waag.org/map/index.html#http://api.citysdk.waag.org/admr.nl.amsterdam/nodes?name=Amstelveenseweg'>The city SDK searching for Amstelveenseweg </a></li>
<li><a href='http://open.mapquestapi.com/directions/#advancedparameters'>Mapquest open api</a></li>
<li><a href='http://opentripplanner.nl/index.html#'>Open trip planner (.nl)</a></li>
</ul>
</div>
";

echo sprintf("</div>");
echo sprintf("</div>");

if ($go) {

	echo "routes . . .";
	echo '<a class="close" data-dismiss="alert" href="#">Please wait until the data is sorted</a>';

/*
	$req = new plan_request();
	$req->from = new place(52.339633 , 4.998495 , "");
	$req->to = new place(52.359798 , 4.884206 , "");
	$req->options->_date = "2013-01-18";
	$req->options->_time = "09:30";
*/

	$frm = explode(",", $from);
	$_from = new place($frm[0],$frm[1],$frm[2]);

	$t = explode(",", $to);
	$_to = new place($t[0],$t[1],$t[2]);

	$d = explode("-", $date);
	$tim = explode(":", $time);
	$_datetime = new mm_datetime($d[0],$d[1],$d[2],$tim[0],$tim[1]);

	echo "<div>";
	echo "results";
	echo "<pre>";
	echo sprintf("<br>begining start date : %s \n",$_datetime->toString());
	echo sprintf("<br>begining start date : %s \n",$_datetime);
	echo "</pre>";
	echo "</div>";


	$options = new obj();
	$options->debug = false;
	$options->maxWalkDistance = $maxwalk;

//	echo "<pre> planning </pre>";
	$results = $pu->plan($_from,$_to,$_datetime,$mmh,$options);
//	echo "<pre> planning done , results : </pre>";


	echo "<div id='hacker-list'>";
	
	echo "<ul class='list'>";
	for ($i=0; $i < count($results->routes); $i++) {
		echo "<li class='list'>";
		$route = $results->routes[$i];
		echo sprintf("<div class='journey-horizontal'>%s</div>",$route->summary_in_html($i));
		echo "<pre>";
		echo " ";
		echo "<a href='javascript:$"."(\"#pre_$i\").slideToggle();'>more</a>";
		echo " ";
		echo "<a href='javascript:show_on_map($i)'>Map</a>";
		echo " ";
		echo "</pre>";

		echo "<pre id='pre_$i' class='hid'>";
		echo "Route $i :: ".$route->summary()."\n";
		echo "<br><a href='javascript:$"."(\"#data_$i\").slideToggle();'>more</a>";
		echo "<textarea style='width:100%;' id='data_$i' class='hid'>";
		echo "".$route->as_json()."";
		echo "</textarea>";
		echo "</pre>";
		echo "<hr>";
		echo "</li>";
	}
	echo "</ul>";
	echo "</div>";




}

?>

<footer>
	<p>&copy; Divv presentation 2013</p>
</footer>

</div>
<div class="modal hide fade" id="modal-window"></div>
<div class="modal hide fade" id="modal-window2"></div>
<!-- Le javascript    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="http://www.glimworm.com/_assets/moock/bootstrap/js/bootstrap-transition.js"></script>
<script src="http://www.glimworm.com/_assets/moock/bootstrap/js/bootstrap-alert.js"></script>
<script src="http://www.glimworm.com/_assets/moock/bootstrap/js/bootstrap-modal.js"></script>
<script src="http://www.glimworm.com/_assets/moock/bootstrap/js/bootstrap-dropdown.js"></script>
<script src="http://www.glimworm.com/_assets/moock/bootstrap/js/bootstrap-scrollspy.js"></script>
<script src="http://www.glimworm.com/_assets/moock/bootstrap/js/bootstrap-tab.js"></script>
<script src="http://www.glimworm.com/_assets/moock/bootstrap/js/bootstrap-tooltip.js"></script>
<script src="http://www.glimworm.com/_assets/moock/bootstrap/js/bootstrap-popover.js"></script>
<script src="http://www.glimworm.com/_assets/moock/bootstrap/js/bootstrap-button.js"></script>
<script src="http://www.glimworm.com/_assets/moock/bootstrap/js/bootstrap-collapse.js"></script>
<script src="http://www.glimworm.com/_assets/moock/bootstrap/js/bootstrap-carousel.js"></script>
<script src="http://www.glimworm.com/_assets/moock/bootstrap/js/bootstrap-typeahead.js"></script>
<!-- http://www.eyecon.ro/bootstrap-datepicker/ -->
<link rel="stylesheet" href="http://www.glimworm.com/_assets/moock/bootstrap/extras/datepicker/css/datepicker.css" />
<script src="http://www.glimworm.com/_assets/moock/bootstrap/extras/datepicker/js/bootstrap-datepicker.js"></script>
<!-- http://jdewit.github.com/bootstrap-timepicker/ -->
<link rel="stylesheet" href="http://www.glimworm.com/_assets/moock/bootstrap/extras/bootstrap-timepicker-master/css/bootstrap-timepicker.css" />
<script src="http://www.glimworm.com/_assets/moock/bootstrap/extras/bootstrap-timepicker-master/js/bootstrap-timepicker.js"></script>
</body>
</html>
