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

<pre>
pu::pc planning/class-plan-utils->plan_car()
</pre>

<table>
<tr><td colspan=9>Bussen</td><td>AMS/NH</td></tr>
<tr><td>Haltes, routes en kosten</td><td>M</td><td>haltes</td><td>route</td></tr>	kost	
<tr><td>Alle planningen</td><td>M</td><td>planning</td><td></td></tr>
<tr><td>Alles real time</td><td>M</td><td>RT</td><td>RT predict</td></tr>
<tr><td colspan=9>Trams	AMS</td><td></td><td></td></tr>
<tr><td>Haltes, routes en kosten</td><td>M</td><td>haltes	route</td><td>	kost	</td></tr>
<tr><td>Alle planningen</td><td>M</td><td>planning</td><td></td></tr>
<tr><td>Alles real time</td><td>M</td><td>RT</td><td>RT predict</td></tr>
<tr><td colspan=9>Pont	AMS</td><td></td><td></td></tr>
<tr><td>Haltes, routes en kosten</td><td>M</td><td>haltes	route</td><td>	kost	</td></tr>
<tr><td>Alle planningen</td><td>M</td><td>planning</td><td></td></tr>
<tr><td>Alles real time</td><td>M</td><td>RT</td><td>RT predict</td></tr>
<tr><td colspan=9>Treinen	NL</td><td></td><td></td></tr>
<tr><td>Haltes, routes en kosten</td><td>M</td><td>haltes	route</td><td>	kost	</td></tr>
<tr><td>Alle planningen</td><td>M</td><td>planning</td><td></td></tr>
<tr><td>Alles real time</td><td>M</td><td>RT</td><td>RT predict</td></tr>
<tr><td colspan=9>Metro	AMS</td><td></td><td></td></tr>
<tr><td>Haltes, routes en kosten</td><td>M</td><td>haltes</td><td>route</td><td>kost	</td></tr>
<tr><td>Alle planningen</td><td>M</td><td>planning</td><td></td></tr>
<tr><td>Alles real time</td><td>M</td><td>RT</td><td>RT predict</td></tr>
<tr><td colspan=9>Auto 	NL</td><td></td><td></td></tr>
<tr><td>Reguliere navigatie</td><td>M</td><td>planning</td><td></td></tr>
<tr><td>Rental (greenwheels/gar2go)	M (locations only)	locations</td><td></td></tr>
<tr><td>Files RT</td><td>M</td><td>RT</td><td></td></tr>
<tr><td>Wegonderhoud RT</td><td>M</td><td>location 	RT	planned</td></tr>
<tr><td>Parkeren parkeergebouwen RT</td><td>M</td><td>location 	RT	kost	RT predict</td></tr>
<tr><td>Parkeren parkeerterreinen RT</td><td>M</td><td>location 	RT	kost	</td></tr>
<tr><td>Parkeren straat (globaal) RT + K</td><td> </td><td></td><td>location 	RT	kost	</td></tr>
<tr><td colspan=9>Fiets 	AMS</td><td></td><td></td></tr>
<tr><td>Reguliere navigatie</td><td>M</td><td>planning</td><td></td></tr>
<tr><td>++ Rental (OV)?</td><td>M</td><td>locations	availability</td><td></td></tr>
<tr><td>Wegonderhoud RT</td><td>M</td><td>static	RT</td><td></td></tr>
<tr><td>Parkeerplaats RT + K</td><td>M	location 	RT	kost	RT predict</td></tr>
<tr><td colspan=9>Scooter	AMS</td><td></td><td></td></tr>
<tr><td>Reguliere navigatie</td><td>M</td><td>planning</td><td></td></tr>
<tr><td>Wegonderhoud RT</td><td>M</td><td>static	RT</td><td></td></tr>
<tr><td>Parkeerplaats RT + K</td><td>W</td><td>location 	RT	kost	</td></tr>
<tr><td colspan=9>Motor	AMS</td><td></td><td></td></tr>
<tr><td>Reguliere navigatie	(same as car)	(same as car)</td><td></td></tr>
<tr><td>Files RT + / -	"	(same as car)</td><td></td></tr>
<tr><td>Wegonderhoud RT	"	(same as car)</td><td></td></tr>
<tr><td>Parkeren parkeergebouwen RT	"	(same as car)</td><td></td></tr>
<tr><td>Parkeren parkeerterreinen RT	"	(same as car)</td><td></td></tr>
<tr><td>Parkeren straat (globaal) RT + K	"	(same as car)</td><td></td></tr>
<tr><td colspan=9>Taxi	AMS</td><td></td><td></td></tr>
<tr><td>Timer / cost estimation</td><td>M</td><td>estimator</td><td></td></tr>
<tr><td>Standplaatsen</td><td>M</td><td>locations</td><td></td></tr>
<tr><td>information about rules and prices</td><td>M</td><td>fixed inormation</td><td></td></tr>
<tr><td colspan=9>Lopen	AMS</td><td></td><td></td></tr>
<tr><td>Reguliere navigatie</td><td>M</td><td>planning</td><td></td></tr>
<tr><td colspan=9>On the way	NH</td><td></td><td></td></tr>
<tr><td>Events which affect transport (e.g. marathon)</td><td>M</td><td>planning	RT</td><td></td></tr>
<tr><td>Emergency Locations (e.g. police/hospital)</td><td>M</td><td>planning	RT</td><td></td></tr>
</table>

						
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
						
