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

# enron.json

This contains parking tarrifs and times.  it contains
- area table (geographic areas)
- regulation table (start end end of policies and days)
- fare table (per hour and evening and day cards)

The fare table contains data like this

<pre>
                      {
                EndDateFare = 29991231;
                FareCalculationCode = TC2; (**link to other data)
                FareCalculationDesc = "Tariefcode 02 (4,00)";
                FarePartTable =                 {
                    FarePartData =                     {
                        AmountFarePart = "0.06666667"; (**this is euros per minute, we know that because 'StepSizeFarePart' is 1)
                        EndDateFarePart = 29991231;
                        EndDurationFarePart = 999999;
                        StartDateFarePart = 20050101;
                        StartDurationFarePart = 0;
                        StepSizeFarePart = 1;
                        TotalAmountParts = "0.00000000";
                    };
                };
                StartDateFare = 20050101;
                VATPercentage = "0.00";
</pre>

The regulation table contains entries like this

<pre>
 EndDateRegulation = 29991231;
                RegulationDesc = "Basistarief TC4B";
                RegulationId = BP14B; (** id code used in other tables)
                StartDateRegulation = 20050101;
                TimeFrameTable =                 {
                    TimeFrameData =                     (
                                                {
                            ClaimRightPossible = Y;
                            DayTimeFrame = MAANDAG; (** day of week)
                            EndTimeTimeFrame = 2100; (** end 21:00)
                            FareTimeFrame = TC4; (**link to fare table)
                            StartTimeTimeFrame = 900; (** start 09:00)
                        },
                                                {
                            ClaimRightPossible = Y;
                            DayTimeFrame = DINSDAG;
                            EndTimeTimeFrame = 2100;
                            FareTimeFrame = TC4;
                            StartTimeTimeFrame = 900;
                        },
                                                {
                            ClaimRightPossible = Y;
                            DayTimeFrame = WOENSDAG;
                            EndTimeTimeFrame = 2100;
                            FareTimeFrame = TC4;
                            StartTimeTimeFrame = 900;
                        },
                                                {
                            ClaimRightPossible = Y;
                            DayTimeFrame = DONDERDAG;
                            EndTimeTimeFrame = 2100;
                            FareTimeFrame = TC4;
                            StartTimeTimeFrame = 900;
                        },
                                                {
                            ClaimRightPossible = Y;
                            DayTimeFrame = VRIJDAG;
                            EndTimeTimeFrame = 2100;
                            FareTimeFrame = TC4;
                            StartTimeTimeFrame = 900;
                        },
                                                {
                            ClaimRightPossible = Y;
                            DayTimeFrame = ZATERDAG;
                            EndTimeTimeFrame = 2100;
                            FareTimeFrame = TC4;
                            StartTimeTimeFrame = 900;
                        },
                                                {
                            ClaimRightPossible = N;
                            DayTimeFrame = ZONDAG;
                            EndTimeTimeFrame = 2400;
                            StartTimeTimeFrame = 0;
                        },
                                                {
                            ClaimRightPossible = N;
                            DayTimeFrame = VRIJPARK; (** free parking days)
                            EndTimeTimeFrame = 2400;
                            StartTimeTimeFrame = 0;
                        }
                    );
                };
            },
</pre>

The area table contains entries like this

<pre>
                       {
                AreaDesc = "T14B_H01 ma-za 09-21";
                AreaId = "T14B_H01";
                AreaRegulationTable =                 {
                    AreaRegulationData =                     (
                                                {
                            RegulationIdArea = "BP14_D0919";
                            StartDateAreaRegulation = "2005-01-01T00:00:00Z";
                        },
                                                {
                            RegulationIdArea = "BP14_D0921";
                            StartDateAreaRegulation = "2005-01-01T00:00:00Z";
                        },
                                                {
                            RegulationIdArea = BP14B; (** link to regulation table)
                            StartDateAreaRegulation = "2005-01-01T00:00:00Z";
                        }
                    );
                };
                GracePeriodAfter = 10; 
                GracePeriodBefore = 1;
                PriceOneHourParking = 0; (** note - this is not used)
                StartDateArea = 20050101;
                UsageDesc = BetaaldParkeren;
                UsageId = BETAALDP; (** this means paid parking)
            },



</pre>


