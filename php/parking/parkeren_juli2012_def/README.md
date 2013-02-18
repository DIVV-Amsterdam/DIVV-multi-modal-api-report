
#locaties.json

This contains all of the registeredparking locations in amsterdam with the following types
- Parkeergarage
- P+R
- Taxistandplaats

The format is as follows:
<pre>
   parkeerlocaties =     (
                {
            parkeerlocatie =             {
                Locatie = "{\"type\":\"Point\",\"coordinates\":[4.901786,52.3673221]}";
                adres = "Valkenburgerstraat 238";
                postcode = 1011ND;
                title = "P1 Parking Waterlooplein";
                type = Parkeergarage;
                url = "http://www.p1.nl/parkeren/p1-parking-waterlooplein/";
                woonplaats = Amsterdam;
            };
        },
     
</pre>

Issue 1
- Issue : for cross referencing it would be beter to have the house number and sub number (a,b,c) also in this data because many commercial data sets contain this
- However : this is reccommended in the report

Issue 2
- Issue : this does not contain the information whether there is parking available for motor bikes or scooters

Issue 3
- Issue : this does not contain a reference to linked data with more details about the garages such as opening hours of tarrifs

Issue 4
- Issue : this does not contain any reference to charging models and prices

Issue 5
- Issue : this does not contain any reference to real time availability feeds

Issue 6
- Issue : this does not contain any reference to future prediction models or historic data
 
Issue 7
- Issue : this does not contain any reference to on street parking


