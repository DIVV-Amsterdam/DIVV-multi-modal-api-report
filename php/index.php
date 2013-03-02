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
      <link href="../css/styles.css" rel="stylesheet">
      <script src="plan.js"></script>
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
.mode-PARK_BIKE {
	background-image: url('../images/glymphicons/parkbike.png');
	background-repeat: no-repeat;
	background-position: 5px 0;
}
.mmhub {
	background-image: url('../images/glymphicons/MMHUB.png');
	background-repeat: no-repeat;
	background-position: 0 0;
	width:80px;
	height:40px;
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
</style>
</head>
<body>
<div>
<?php

ini_set("memory_limit","1024M");

error_reporting(-1);




?>

<legend>DIVV-multi-modal-api-report</legend>
<div class='container'>
<div><a href='example/index.php'>Examples</a></div>

<div><a href='https://github.com/DIVV-Amsterdam/DIVV-multi-modal-api-report'>GitHub</a> : Github repository with the report and instructions</div>
</div>

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
</body>
</html>
