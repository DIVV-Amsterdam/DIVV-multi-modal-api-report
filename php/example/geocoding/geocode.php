<?php

?>
<html>

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

echo "<h1>Geocoding suggestions</h1>";


$term = $_GET["term"];
echo sprintf("<form action='geocode.php'><input type='text' name='term' value='%s'><input type='submit' value='suggest'></form>",$term);

if ($term) {
	$req = new obj();
	$req->term = $term;

	$response = $pu->geolookup($req);
	
	print_r("<table>");

	echo "<tr><td colspan='9'>MapquestAPI</td></tr>";
	foreach ($response->mapquestapi as $addr) {
		echo sprintf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",$addr->type,$addr->name,$addr->lat,$addr->lng,$addr->street,$addr->postcode);	
	}

	echo "<tr><td colspan='9'>Suggestions ov9292</td></tr>";
	foreach ($response->suggestions as $addr) {
		echo sprintf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",$addr->type,$addr->name,$addr->lat,$addr->lng,$addr->street,$addr->postcode);	
	}	

	echo "<tr><td colspan='9'>google maps</td></tr>";
	foreach ($response->gm as $addr) {
		echo sprintf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",$addr->type,$addr->name,$addr->lat,$addr->lng,$addr->street,$addr->postcode);	
	}	
	
	
	print_r("</table>");
	
	echo "Results<pre>";
	var_dump($response);
	echo "</pre>";
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


