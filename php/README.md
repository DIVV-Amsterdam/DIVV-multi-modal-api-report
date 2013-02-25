#file contents

<table>
<tr>
<td>api/</td>
<td>this folder contains some working code for a potential api.  It uses the classes and utilities in the other folders in order to achieve multi modal planning</td>
</tr>
<tr>
<td>classes/</td>
<td>This folder contains some necessary classes for planning</td>
</tr>
<tr>
<td>datasources/</td>
<td>This folder contains some downloaded datasources and is documented in a readme.md file</td>
</tr>
<tr>
<td>etc/</td>
<td>This folder contains some configuration and setup information</td>
</tr>
<tr>
<td>example/</td>
<td>This folder contains some working examples</td>
</tr>
<tr>
<td>plan/</td>
<td>This folder contains code showing how the planning is done</td>
</tr>
<tr>
<td>rt/</td>
<td>This folder contains code showing how the real time data is obtained</td>
</tr>
<tr>
<td>parking/</td>
<td>Downloaded parking files which can be imported.  There is documentaiton in the folder [ parking / parkeren_juli2012_def ] </td>
</tr>
</table>

# Table of methods matched to the code functions

<pre>
*pu = planning/class-plan-utils.php
*rti = rt/realtimeinterface
</pre>

<table>
<tr><td colspan=9>Bussen AMS/NH</td></tr>
<tr>
<td>Haltes, routes en kosten</td><td>M</td><td>haltes<br>routes<br>kost</td>
<td>?<br>?<br>?</td>
</tr>

<tr>
<td>Alle planningen</td><td>M</td>
<td>planning</td>
<td><pre>planutils . plan_otp()</pre></td>
</tr>

<tr>
<td>Alles real time</td><td>M</td>
<td>RT<br>RT predict</td>
<td>
 <pre>rti.RealtimeDataKV78</pre>
 <pre>rti.RealtimeDataKV78</pre>
</td>
</tr>


<tr><td colspan=9>Trams	AMS</td></tr>
<tr>
<td>Haltes, routes en kosten</td><td>M</td>
<td>haltes<br>route<br>	kost	</td>
<td>
KV1?<br>
KV1?<br>
KV1</td>
</tr>
<tr>
<td>Alle planningen</td><td>M</td>
<td>planning</td>
<td><pre>planutils.plan_otp()</pre></td>
</tr>
<tr>
<td>Alles real time</td><td>M</td>
<td>RT<br>RT predict</td>
<td>
 <pre>rti.RealtimeDataKV78</pre>
 <pre>rti.RealtimeDataKV78</pre>
</td>
</tr>


<tr><td colspan=9>Pont	AMS</td></tr>
<tr>
<td>Haltes, routes en kosten</td><td>M</td>
<td>haltes<br>route<br>	kost	</td>
<td>?<br>?<br>?</td>
</tr>
<tr>
<td>Alle planningen</td><td>M</td>
<td>planning</td>
<td><pre>planutils.plan_otp()</pre></td>
</tr>
<tr>
<td>Alles real time</td><td>M</td>
<td>RT<br>RT predict</td>
<td>
 <pre>rti.RealtimeDataKV78</pre>
 <pre>no prediction is necessary because they wait until they are ontime</pre>
</td>
</tr>

<tr><td colspan=9>Treinen	NL</td></tr>
<tr>
<td>Haltes, routes en kosten</td><td>M</td>
<td>haltes<br>route<br>	kost	</td>
<td>?<br>?<br>?</td>
</tr>
<tr>
<td>Alle planningen</td><td>M</td>
<td>planning</td>
<td><pre>planutils.plan_otp()</pre></td>
</tr>
<tr>
<td>Alles real time</td><td>M</td>
<td>RT<br>RT predict</td>
<td>
 <pre>rti.RtRequestNS</pre>
 <pre>rti.RtRequestNS</pre>
</td>
</tr>

<tr><td colspan=9>Metro	AMS</td></tr>
<tr>
<td>Haltes, routes en kosten</td><td>M</td>
<td>haltes<br>route<br>	kost	</td>
<td>?<br>?<br>?</td>
</tr>
<tr>
<td>Alle planningen</td><td>M</td>
<td>planning</td>
<td><pre>planutils.plan_otp()</pre></td>
</tr>
<tr>
<td>Alles real time</td><td>M</td>
<td>RT<br>RT predict</td>
<td>
 <pre>rti.RealtimeDataKV78</pre>
 <pre>rti.RealtimeDataKV78</pre>
</td>
</tr>

<tr><td colspan=9>Auto 	NL</td></tr>
<tr>
<td>Reguliere navigatie</td><td>M</td>
<td>planning</td>
<td><pre>planutils.plan_car() + planutils.plan_car_mapquest() </pre></td>
</tr>

<tr>
<td>Rental (greenwheels/gar2go)</td><td>M</td>
<td> (locations only)	locations</td>
<td><pre>greenwheels and connectcar are added as multimodal hubs by hand</pre><pre>car2go has an api</pre></td>
</tr>

<tr>
<td>Files RT</td><td>M</td>
<td>RT files</td>
<td>?jc</td>
</tr>

<tr>
<td>Wegonderhoud RT</td><td>M</td>
<td>location<br>RT<br>planned</td>
<td>?jc<br>?jc<br>?jc</td>
</tr>

<tr>
<td>Parkeren parkeergebouwen RT</td><td>M</td>
<td>location<br>RT<br>kost<br>RT predict</td>
<td>
<pre>planutils.mmhubs</pre>
<pre>NOT POSSIBLE</pre>
<pre>?jc</pre>
<pre>NOT POSSIBLE</pre>
</td>
</tr>

<tr>
<td>Parkeren parkeerterreinen RT</td><td>M</td>
<td>location<br>RT<br>kost<br>RT predict</td>
<td>
<pre>planutils.mmhubs</pre>
<pre>NOT POSSIBLE</pre>
<pre>?jc</pre>
<pre>NOT POSSIBLE</pre>
</td>
</tr>

<tr><td>Parkeren straat (globaal) RT + K</td><td>M</td>
<td>location<br>RT<br>kost</td>
<td>
Locations are downloadable from divv - see /parking<br>
RT is not available<br>
Prices cane be calculated - formulas are in parkshark
</td>
</tr>


<tr><td colspan=9>Fiets 	AMS</td></tr>
<tr>
<td>Reguliere navigatie</td><td>M</td>
<td>planning</td>
<td><pre>planutils.plan_otp()</pre></td>
</tr>



<tr><td>++ Rental (OV)?</td>
<td>M</td><td>locations	availability</td>
<td>
locations are added by hand into the mmhubs<br>
we could not find an API for avaiabilty
</td></tr>
<tr><td>Wegonderhoud RT</td><td>M</td><td>static	RT</td><td></td></tr>

<tr>
<td>Parkeerplaats</td><td>M</td>
<td>location<br>cost<br>RT prediction</td>
<td><pre>planutils.mmhubs</pre><pre>NOT POSSIBLE</pre><pre>NOT POSSIBLE</pre></td>
</tr>

<tr><td colspan=9>Scooter	AMS</td><td></td><td></td></tr>
<tr><td>Reguliere navigatie</td><td>M</td><td>planning</td><td></td></tr>
<tr><td>Wegonderhoud RT</td><td>M</td><td>static	RT</td><td></td></tr>
<tr><td>Parkeerplaats RT + K</td><td>W</td><td>location 	RT	kost	</td></tr>

<tr><td colspan=9>Motor	AMS</td><td></td><td></td></tr>
<tr><td>Reguliere navigatie</td><td>(same as car)</td><td></td></tr>
<tr><td>Files RT</td><td>(same as car)</td><td></td></tr>
<tr><td>Wegonderhoud</td><td>(same as car)</td><td></td></tr>
<tr><td>Parkeren parkeergebouwen</td><td>(same as car)</td><td></td></tr>
<tr><td>Parkeren parkeerterreinen</td><td>(same as car)</td><td></td></tr>
<tr><td>Parkeren straat (globaal)</td><td>(no restrictions)</td><td></td></tr>

<tr><td colspan=9>Taxi	AMS</td><td></td><td></td></tr>
<tr>
<td>Timer / cost estimation</td><td>M</td>
<td>cost estimation</td>
<td><pre>planutils.taxicosts()</pre></td>
</tr>

<tr>
<td>Standplaatsen</td><td>M</td>
<td>location</td>
<td><pre>planutils.mmhubs</pre></td>
</tr>


<tr>
<td>information about rules and prices</td><td>M</td>
<td>fixed inormation</td>
<td>This is available from i-Amsterdam</td>
</tr>

<tr>
<td colspan=9>Lopen	AMS</td><td>M</td>
<td>planning</td>
<td><pre>planutils.plan_car() + planutils.plan_car_mapquest() </pre></td>
</tr>



<tr><td colspan=9>On the way	NH</td></tr>
<tr><td>Events which affect transport (e.g. marathon)</td><td>M</td><td>planning	RT</td><td></td></tr>
<tr><td>Emergency Locations (e.g. police/hospital)</td><td>M</td><td>planning	RT</td><td></td></tr>
</table>

<pre>
planutils.geolookup()
returns 
 mapquest	// suggestions frm mapquest 
 sugestions	// suggestions from ov9292
 gm		// suggestions from google maps
</pre>

						
Global options						
						
	I prefer not to use certain modes of transport	S				
						
	I am traveling with a family or a group ,	C 				
	now tell me if this makes a difference					
						
	I am disabled	W				
						
Additional items						
						
	In trip updates via non official sources	M				
	twitter etc..					
						
	The api data should be available to tom-tom and  other					
	in car routing companies in a format they can easily 					
	incorporate, Cor asked us to contact tom-tom and find					
	out if there is a standard format.					
						
