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

body {
	background-image: url('../images/glimworm02_grey.jpg');
	background-repeat: no-repeat;
	background-position: 0 0;

}
.container {
	background-color: #ffffff;
	-webkit-border-radius: 10px;
	-moz-border-radius: 10px;
	border-radius: 10px;
	border : 1px solid black;
	padding : 20px;
	line-height: 1.4em;
}
.span6 {
	background-color: #ffffff;
	-webkit-border-radius: 10px;
	-moz-border-radius: 10px;
	border-radius: 10px;
	border : 1px solid black;
	padding : 20px;
	line-height: 1.4em;
}
legend {
	color : #0088cc;
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

echo "<br>";
echo "<br>";
echo "<div class='container'>";
echo "<legend>DIVV Multi Modal API report Example : List of Multi Modal Hubs used in toe project</legend>";
echo "<p>This site provides some working examples of the code produced during the commissioning of the DIVV Multi Modal API Investigation project condicted during December 2012 - March 2013 by Jonathan Carter and Paul Manwaring of Glimworm IT, Erik Romijn of SolidLinks, and Jasper Soetendal and Ron van der Lans of Braxwell.  All of the code can be found on Github at https://github.com/DIVV-Amsterdam/DIVV-multi-modal-api-report</p>";



echo "<table class='table table-bordered'>";
echo "<tr><th>Location type</th><th>Exchange type</th><th>name</th><th>Location</th></tr>";
foreach ($mmh->hubs as $mh) {

	echo sprintf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",$mh->location->type, $mh->type,$mh->location->name,$mh->location->address);


}
echo "</table>";
echo "</div>";


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
