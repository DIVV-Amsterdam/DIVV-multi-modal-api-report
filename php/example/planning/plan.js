var divvplan = {};

function replan(journey_index,leg_index) {
	var data = $("#data_"+journey_index).val();
	eval("var dta="+data);
	
	var leg = dta.legs[leg_index];
	console.log("leg");
	console.log(leg);
	var h = "";

	h += "<ul class='nav nav-tabs' id='nav-tabs'>";
  	h += "<li><a id='nav-tabs-home' href='#home' data-toggle='tab'>Narative</a></li>";
  	h += "<li><a href='#jsoncode' data-toggle='tab'>JSON explorer</a></li>";
  	h += "<li><a href='#rawcode' data-toggle='tab'>RAW data</a></li>";
  	/*
  	h += "<li><a id='nav-tabs-map' href='#tmap' data-toggle='tab'>MAP</a></li>";
  	h += "<li><a href='#rt' data-toggle='tab'>RT</a></li>";
  	*/
  	h += "</ul>";
  	
  	
	h += '<div class="tab-content">';
	h += '  <div class="tab-pane active" id="home">';
	h += "<legend>Leg Type : "+leg.type+"</legend>";
	h += "  	<div id='narrative'>Re-loading plan. . . <div><img src='../images/ajax-loader.gif' height='40'></div></div>";
	h += '  </div>';

	h += '  <div class="tab-pane" id="jsoncode">';
	h += "  	<div id='basic_usage'></div>";
	h += '  </div>';

	h += '  <div class="tab-pane" id="rawcode">';
	h += "  	<pre id='fakediv'></pre>";
	h += '  </div>';

	/*
	h += '  <div class="tab-pane" id="tmap">';
	h += '	<div id="map_canvas" style="width:780px; height:350px;"></div>';
	h += '  </div>';
	h += '  <div class="tab-pane" id="rt">';
	h += '  </div>';
	*/
	h += '</div>';
  	

	$("#modal-window").css("height","500px");
	$("#modal-window").css("width","700px");
	$("#modal-window").html(h);


	$.post('proxy.php',{
		url : leg.url
	}).done(function(data) {
	  $('#fakediv').html(data);
	  
	  var dta = $.parseJSON(data);
		$('#basic_usage').jsonviewer({
            json_name: 'dta', // specifies a display name for the JSON object
            json_data: dta    // specifies the JSON object data
        });	  
        
		var narrative = "";
		if (leg.type == "transit/OTP") {
			narrative += "<h2>This trip had been re-planned to see if the results still match and here are the results:</h2>";
			narrative += "<table class='table'>";
			narrative += "<tr><td>Planing tool used for this leg</td><td>"+leg.type+"</td></tr>";
			narrative += "<tr><td>re-planned End Time</td><td>"+(new Date(dta.plan.itineraries[0].endTime))+"</td></tr>";
			narrative += "<tr><td>Original end time was planned for </td><td> "+(leg.endTime.hour+":"+leg.endTime.minute)+"</td></tr>";
			narrative += "</table>";
		} else {
			narrative += "<table class='table'>";
			narrative += "<h2>This trip had been re-planned to see if the results still match and here are the results:</h2>";
			narrative += "<tr><td>Planing tool used for this leg</td><td>"+leg.type+"</td></tr>";
			narrative += "<tr><td>The new planning returns a duration of </td><td> "+dta.route.time+"</td></tr>";
			narrative += "<tr><td>Original duration was planned for  </td><td> "+(leg.duration)+"</td></tr>";
			narrative += "</table>";
			narrative += "<br>";
			narrative += "<h2>The turn by turn narrative is as follows :</h2>"
			narrative += "<br>";
			narrative += renderNarrative(dta);
		}
		$("#narrative").html(narrative);
		
	  
	});	

	$('#myTab a').click(function (e) {
	  e.preventDefault();
	  $(this).tab('show');
	});
	

//	$.get(leg.url,function(data) {
//	  $('#fakediv').html(data);
//	});	

	divvplan.resizemap = function() {
		console.log("resizemap");
		try {
			$("#map_canvas").show();
			google.maps.event.trigger(map, 'resize');
			map.setCenter(myLatLng);
		} catch (E){
			console.log(E);
		}
	};
	divvplan.popupopen = false;

	$("#modal-window").on('shown', function() {
		if (divvplan.popupopen == true) return;
		divvplan.popupopen = true;
		try {
			$('#nav-tabs-home').tab('show');
			$('#nav-tabs-map').on('shown',divvplan.resizemap);
		} catch (E){
			console.log(E);
		}
	});

	$("#modal-window").modal('show');
	
}

function track(journey_index,leg_index,leg_index_2) {
	var data = $("#data_"+journey_index).val();
	eval("var dta="+data);
	
	var leg = dta.legs[leg_index].legs[leg_index_2];
	console.log(leg);
	
	var h = "";

	h += "<ul class='nav nav-tabs' id='nav-tabs'>";
  	h += "<li><a id='nav-tabs-home' href='#home' data-toggle='tab'>NARRATIVE</a></li>";
  	h += "<li><a href='#jsoncode' data-toggle='tab'>JSON EXPLORER</a></li>";
  	h += "<li><a href='#rawcode' data-toggle='tab'>RAW DATA</a></li>";
  	h += "<li><a id='nav-tabs-map' href='#tmap' data-toggle='tab'>GOOGLE MAP</a></li>";
  	h += "<li><a id='nav-tabs-rt' href='#rt' data-toggle='tab'>REALTIME</a></li>";
  	h += "</ul>";
  	
  	
	h += '<div class="tab-content">';
	h += '  <div class="tab-pane active" id="home">';
	if (leg.mode == "WALK") {
		h += "<legend>Leg Type : "+leg.mode+"</legend>";
	} else {
		h += "<legend>Leg Type : "+leg.mode+"</legend>";
	}
	
	h += "		<div id='narrative'></div>";
	h += '  </div>';

	h += '  <div class="tab-pane" id="jsoncode">';
	h += "		<div id='basic_usage'></div>";
	h += '  </div>';
	h += '  <div class="tab-pane" id="rawcode">';
	h += "		<pre id='rawcode1'></pre>";
	h += '  </div>';
	h += '  <div class="tab-pane" id="tmap">';
	h += '	<div id="map_canvas" style="width:780px; height:350px;"></div>';
	h += '  <a href="javascript:divvplan.resizemap();">redraw</a>';
	h += '  </div>';
	h += '  <div class="tab-pane" id="rt">';
	h += "		<pre id='fakediv'></pre>";
	h += '  </div>';
	h += '</div>';




	$("#modal-window").css("height","500px");
	$("#modal-window").css("width","700px");
	$("#modal-window").html(h);

	$('#basic_usage').jsonviewer({
		json_name: 'leg', // specifies a display name for the JSON object
		json_data: leg    // specifies the JSON object data
	});	  
	$('#rawcode1').html(JSON.stringify(leg));

	
	$.post('../track/track_'+leg.mode+'.php',{
		json : JSON.stringify(leg)
	}).done(function(data) {
	  $('#fakediv').html(data);
	});	

	
	try {
		var myLatLng = new google.maps.LatLng(leg.from.lat, leg.from.lon);
		var mapOptions = {
			zoom: 12,
			center: myLatLng,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
	  	var map = new google.maps.Map(document.getElementById("map_canvas"),mapOptions);
		var points = [];
		points.push({
			lat : leg.from.lat ,
			lng: leg.from.lon ,
			title: leg.from.name
		});
		points.push({
			lat : leg.to.lat ,
			lng: leg.to.lon ,
			title: leg.to.name
		});
		var lineCoordinates = [];
		for (var i=0; i < points.length; i++) {
			lineCoordinates.push(new google.maps.LatLng(points[i].lat,points[i].lng));
		}
  	
		var line = new google.maps.Polyline({
	  		path: lineCoordinates,
	  		map: map
		});  	
  	
	  	divvplan.latlngbounds = new google.maps.LatLngBounds();
		for (var i=0; i < points.length; i++) {
			var marker = new google.maps.Marker({
				position: new google.maps.LatLng(points[i].lat,points[i].lng),
				map: map,
				title: points[i].title
			});
			divvplan.latlngbounds.extend(new google.maps.LatLng(points[i].lat,points[i].lng));
		}
		var narrative = "";
			
			narrative += "<h2>This type of leg has no specific narrative, for instance turn by turn directions.</h2>";
			
		if (leg.mode == "DRIVING") {
			narrative = renderNarrative(leg.rawlegdata);
			
		}
		$("#narrative").html(narrative);
		
		if (leg && leg.transitinfo && leg.transitinfo.legGeometry && leg.transitinfo.legGeometry.points) {
			var encodedPolyline = leg.transitinfo.legGeometry.points;
			var decodedPath = google.maps.geometry.encoding.decodePath(encodedPolyline);	// produces type error
    		var poly = new google.maps.Polyline({
    			path : decodedPath,
   			    strokeColor: "#FF0000",
		        strokeOpacity: 1.0,
		        strokeWeight: 2
		    });
    		poly.setMap(map);
		}
		
	} catch (E){
		console.log(E);
	}
	
	divvplan.resizemaprt_delegate = function() {}
	divvplan.resizemaprt = function() {
		divvplan.resizemaprt_delegate.call(this,{});	
	};
	divvplan.resizemap = function() {
		console.log("resizemap");
		try {
			$("#map_canvas").show();
			google.maps.event.trigger(map, 'resize');
			map.setCenter(myLatLng);
			map.fitBounds( divvplan.latlngbounds );			
			
		} catch (E){
			console.log(E);
		}
	};
	divvplan.popupopen = false;

	$("#modal-window").on('shown', function() {
		console.log("MODAL SHOWN track popupopen:["+divvplan.popupopen+"]");
		if (divvplan.popupopen == true) return;
		divvplan.popupopen = true;
		try {
			$('#nav-tabs-home').tab('show');
			$('#nav-tabs-map').on('shown',divvplan.resizemap);
			$('#nav-tabs-rt').on('shown',divvplan.resizemaprt);
		} catch (E){
			console.log(E);
		}
	});
	$("#modal-window").modal('show');


//	h += "<iframe name='fake_frame' src='#' style='width:90%;height:90%'></iframe>";
//	h += "<form name='myform' action='../track/track_"+leg.mode+".php' method='post' target='fake_frame'><input type='text' value='' name='json' id='fake_json'></form>";

	
//	alert(JSON.stringify(leg));
	
//	$("#fake_json").val(JSON.stringify(leg));
	
//	myform.submit();

}

function show_on_map(journey_index) {
//TRANSIT-TO-CONNECTCAR
	var data = $("#data_"+journey_index).val();
	var h = "";
	
	h += "<pre>"+data+"</pre>";
	
	eval("var dta="+data);
	console.log(dta);

	$("#modal-window").css("height","500px");
	$("#modal-window").css("width","800px");
//	$("#modal-window").html(h);
	$("#modal-window").html('<legend>Map</legend><div class="well"><div id="map_canvas" style="width:780px; height:350px;"></div></div>');

	
	
	
	var points = [];
	var lastleg = null;
	for (var i=0 ; i < dta.legs.length; i++) {
		var sleg = dta.legs[i];
		if (sleg.legs) {
			for (var j=0 ; j < sleg.legs.length; j++) {
				var leg = sleg.legs[j];
				try {
					points.push({
						lat : leg.from.lat ,
						lng: leg.from.lon ,
						title: "leg"+i
					});
					
					lastleg = leg;
				} catch (E) {
					console.log(E);
				}
			}
		}
	}
	if (lastleg != null) {
		points.push({
			lat : leg.from.lat ,
			lng: leg.from.lon ,
			title: "destination"
		});
	}


	console.log(points);
	var myLatLng = new google.maps.LatLng(points[0].lat,points[0].lng);
	var mapOptions = {
		zoom: 12,
		center: myLatLng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
  	var map = new google.maps.Map(document.getElementById("map_canvas"),mapOptions);


	var lineCoordinates = [];
	for (var i=0; i < points.length; i++) {
		lineCoordinates.push(new google.maps.LatLng(points[i].lat,points[i].lng));
	}
  	
	var line = new google.maps.Polyline({
  		path: lineCoordinates,
  		map: map
	});  	
  	
  	divvplan.latlngbounds = new google.maps.LatLngBounds();
	for (var i=0; i < points.length; i++) {
		var marker = new google.maps.Marker({
			position: new google.maps.LatLng(points[i].lat,points[i].lng),
			map: map,
			title: points[i].title
		});
		divvplan.latlngbounds.extend(new google.maps.LatLng(points[i].lat,points[i].lng));
	}
	
	
	divvplan.resizemap = function() {
		console.log("resizemap");
		try {
			$("#map_canvas").show();
			google.maps.event.trigger(map, 'resize');
			map.setCenter(myLatLng);
			map.fitBounds( divvplan.latlngbounds );			
			
		} catch (E){
			console.log(E);
		}
	};
	divvplan.popupopen2 = false;

	$("#modal-window").on('shown', function() {
		console.log("MODAL SHOWN show_on_map popupopen2:["+divvplan.popupopen2+"]");
		if (divvplan.popupopen2 == true) return;
		divvplan.popupopen2 = true;
		divvplan.resizemap();
	});
	$("#modal-window").modal('show');
	
	
}

function trya(a){
	if (a == "true"){
		alert(a);
	}
	else{alert("false");}
}


/* from map quest */


function showBasicURL() {
    var safe = SAMPLE_POST;
    document.getElementById('basicSampleUrl').innerHTML = safe.replace(/</g, '&lt;').replace(/>/g, '&gt;');
};

function doClick() {
	document.getElementById('narrative').innerHTML = 'Pending...';
    var script = document.createElement('script');
    script.type = 'text/javascript';
    showBasicURL();
    var newURL = SAMPLE_POST.replace('YOUR_KEY_HERE', APP_KEY);
    script.src = newURL;
    document.body.appendChild(script);
};

function renderNarrative(response) {
    var legs = response.route.legs;
    var html = '';
    var i = 0;
    var j = 0;
    var trek;
    var maneuver;
    
    if (response.route.distance) {
        html += "<p>Your trip is <b> " + response.route.distance.toFixed(2) + "</b> miles.</p>";
    }
    html += '<table><tr><th colspan=2>Narrative</th>'
    html += '<th colspan=1>Distance</th></tr><tbody>'

    var unit = response.route.options.unit;
    if (unit) {
        if (unit == 'K') {
            unit = 'km';
        } else if (unit == 'M') {
            unit = 'miles';
        }
    }
    for (; i < legs.length; i++) {
        for (j = 0; j < legs[i].maneuvers.length; j++) {
        	var last = legs[i].maneuvers.length - 1;
            maneuver = legs[i].maneuvers[j];
            
            html += '<tr>';
            html += '<td>&nbsp;';
            if (maneuver.iconUrl) {
                html += '<img src="' + maneuver.iconUrl + '">  '; 
            } 
            for (k = 0; k < maneuver.signs.length; k++) {
                var sign = maneuver.signs[k];
                if (sign && sign.url) {
                    html += '<img src="' + sign.url + '">  '; 
                }
            }
            
            html += '</td>'
            //added following because we're only using lat/lngs currently
            if (j == last){
            	html += '<td>' + maneuver.narrative.replace(maneuver.narrative, "Welcome to your destination.")
            }
            else {
            	html += '<td>' + maneuver.narrative 
            }
            if (unit && maneuver.distance) {
                maneuver.distance = 
                html += '<td>  (' + maneuver.distance.toFixed(2) + ' ' + unit + ')'
                html += '</td>';
            }    
            else {
	            html += '<td>  &nbsp; '
	            html += '</td>';
            }
            
            html += '</tr>';
        }
    }
    
    html += '</tbody></table>';
    return html;
//    document.getElementById('narrative').style.display = "";
//    document.getElementById('narrative').innerHTML = html;
}

/* end from map quest */



$(function() {
	$('#dp3').datepicker();
	$('#timepicker1').timepicker({
		showMeridian : false
	});
	
	var options = {
	    valueNames: [ 'journey-endtime' ]
	};

	var hackerList = new List('hacker-list', options);
	hackerList.sort('journey-endtime', { asc: true });	
	$('#loading-div').html("<div><legend>Results are show below sorted into the order of arrival</legend><br><h2>Key</h2><img src='../images/divvexample-legend-32.png'><br></div>");
});