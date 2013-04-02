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
legend {
	color : #0088cc;
}
body {
	background-image: url('images/glimworm02_grey.jpg');
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
</style>
</head>
<body>
<div>
<?php

ini_set("memory_limit","1024M");

error_reporting(-1);




?>
<br>
<br>
<br>
<div class='container'>
<legend>DIVV Multi Modal API Investigation Examples Site</legend>
<p>This site provides some working examples of the code produced during the commissioning of the DIVV Multi Modal API Investigation project condicted during December 2012 - March 2013 by Jonathan Carter and Paul Manwaring of Glimworm IT, Erik Romijn of SolidLinks, and Jasper Soetendal and Ron van der Lans of Braxwell.  All of the code can be found on Github at https://github.com/DIVV-Amsterdam/DIVV-multi-modal-api-report</p>

<br>
<div>Demo Pages : </div>
<br>
<div>1. <a href='planning/plan.php'>Example planning</a> : Example php script demonstrating the planning of a trip using all multimodal hubs included in the project</div>
<br>
<div>2. <a href='geocoding/geocode.php'>Example geocoding</a> : example of 3 different ways to geocode an address </div>
<br>
<div>3. <a href='planning/listmmhubs.php'>List of multimodal hubs</a> : List of all the multimodal hubs used in the proejct</div>
<br>
<br>
<h2>Below you will find a set of movies which give explanations of the example website</h2>
<legend>Introduction to the examples (1/3) - planning a trip</legend>
<iframe width="560" height="315" src="http://www.youtube.com/embed/u2OqhEvLM4g" frameborder="0" allowfullscreen></iframe>
<br>
<legend>Introduction to the examples (2/3) - understanding the results</legend>
<iframe width="420" height="315" src="http://www.youtube.com/embed/fL6X93jtSow" frameborder="0" allowfullscreen></iframe>
<br>
<legend>Introduction to the examples (3/3) - Realtime transit results</legend>
<iframe width="560" height="315" src="http://www.youtube.com/embed/xqFSe2DYJdI" frameborder="0" allowfullscreen></iframe>
<br>
<legend>Geocoding</legend>
<iframe width="560" height="315" src="http://www.youtube.com/embed/qD36cjIcp8A" frameborder="0" allowfullscreen></iframe>
<br>

<p>&copy; Divv presentation 2013</p>
</div>

<!-- 
<div>
	<img src='images/glimworm02_grey.jpg'>
</div>
-->
<footer>
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
