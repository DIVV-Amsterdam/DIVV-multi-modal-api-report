<?php
    function RD2WGS84($x, $y){
        /* Conversie van Rijksdriehoeksmeting naar latitude en longitude (WGS84)
        Voorbeeld: Station Utrecht    
        x = 136013;
        y = 455723;
        */

        $dX = ($x - 155000) * pow(10,-5);
        $dY = ($y - 463000) * pow(10,-5);

        $SomN = (3235.65389 * $dY) + (-32.58297 * pow($dX,2)) + (-0.2475 * pow($dY,2)) + (-0.84978 * pow($dX,2) * $dY) + (-0.0655 * pow($dY,3)) + (-0.01709 * pow($dX,2) * pow($dY,2)) + (-0.00738 * $dX) + (0.0053 * pow($dX,4)) + (-0.00039 * pow($dX,2) * pow($dY,3)) + (0.00033 * pow($dX,4) * $dY) + (-0.00012 * $dX * $dY);
        $SomE = (5260.52916 * $dX) + (105.94684 * $dX * $dY) + (2.45656 * $dX * pow($dY,2)) + (-0.81885 * pow($dX,3)) + (0.05594 * $dX * pow($dY,3)) + (-0.05607 * pow($dX,3) * $dY) + (0.01199 * $dY) + (-0.00256 * pow($dX,3) * pow($dY,2)) + (0.00128 * $dX * pow($dY,4)) + (0.00022 * pow($dY,2)) + (-0.00022 * pow($dX,2)) + (0.00026 * pow($dX,5));

        $lat = 52.15517 + ($SomN / 3600);
        $lon = 5.387206 + ($SomE / 3600);
        
        return(Array("lat" => $lat, "lon" => $lon));
    }
    
?><?php

$json = $_POST["json"];
$data = json_decode($json);

//echo "<legend>Track options for driving</legend>";
//echo "<pre>";
//var_dump($data->rawlegdata->route->shape->shapePoints);
$points = $data->rawlegdata->route->shape->shapePoints;

$route = ("var myroute = [");
$split = "";
for ($i=0; $i < count($points); $i+=2) {
	$route = $route . ($split . " new google.maps.LatLng(". $points[$i] .", ". $points[$i+1] .")");
	$split = ",";
}
$route = $route . ("];\n");
//echo $route;
//echo "</pre>";

/*
echo "<pre>";
echo $json;
echo "</pre>";

echo "<pre>";
var_dump($data);
echo "</pre>";

echo "<pre>";
*/
echo "The only way we could find to track driving was to overlay the route (black) over the divv data on a msp so that the user can perform a visual check.  This can be improved with computer matching <a href='javascript:divvplan.resizemaprt();'>refresh</a>";
echo "<div id='map1' style='border: 1px solid black; width: 680px; height: 350px;'></div>";
echo "<script type='text/javascript'>"
?>
     var myLatlng = new google.maps.LatLng(52.36500, 4.90000);
     zoom = 12;

     var myOptions = {
        zoom: zoom,
        mapTypeId: google.maps.MapTypeId.TERRAIN
     }
     var map1 = new google.maps.Map(document.getElementById("map1"), myOptions);        
     map1.setCenter(myLatlng,zoom);
     
	$("#map1").show();
	google.maps.event.trigger(map1, 'resize');
	
	divvplan.resizemaprt_delegate = function() {
		try {
			$("#map1").show();
			google.maps.event.trigger(map1, 'resize');
			map1.fitBounds( divvplan.latlngbounds );			
			
		} catch (E){
			console.log(E);
		}
	};


<?php
            $count = 0;
            $jsontxt = file_get_contents("http://www.trafficlink-online.nl/trafficlinkdata/wegdata/TrajectSensorsNH.GeoJSON");
            $json = json_decode($jsontxt);
            foreach($json->features as $feature){
                $count++;
                $color = $feature->properties->COLOR;
                $points = $feature->geometry->coordinates;
                $info = "". $feature->properties->LOCATION . " ";
                $info .= "Lengte: ". $feature->properties->LENGTH ." meter ";
                $info .= "Snelheid: ". $feature->properties->VELOCITY ." km/u ";
                $info .= "Normale reistijd: ". floor($feature->properties->TRAVELTIME_FF / 60) .":". str_pad($feature->properties->TRAVELTIME_FF % 60,2,"0") ." ";
                $info .= "Huidige reistijd: ". floor($feature->properties->TRAVELTIME / 60) .":". str_pad($feature->properties->TRAVELTIME % 60,2,"0") ."";
                $split = "";
                print("var path". $count ." = [");
                foreach($points as $point){
                    $latlon = RD2WGS84($point[0], $point[1]);
                    $lat = $latlon["lat"];
                    $lon = $latlon["lon"];
                    print($split . " new google.maps.LatLng(". $lat .", ". $lon .")");
                    $split = ",";
                }
                print("];\n");
           
                print("var line". $count ." = new google.maps.Polyline({map: map1, path: path". $count .", strokeColor: '". $color ."', strokeOpacity: 1.0,strokeWeight: 3, title: '". $title ."'});\n");
                print("google.maps.event.addListener(line". $count .", 'click', function() {alert('". $info ."'); });\n");
            }

echo "</script>";
echo "<script>";
echo $route;
print("var myline = new google.maps.Polyline({map: map1, path: myroute, strokeColor: '#000000', strokeOpacity: 0.8,strokeWeight: 5, title: 'Driving route'});\n");
echo "</script>";
echo "</pre>";



?>