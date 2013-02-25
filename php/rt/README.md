Realtime data API
=================

This code offers access to two realtime data sources: KV78Turbo data from 
OpenOV's OV-API (with realtime tram and bus data); and train data from NS-API.

Based on a set of search parameters, it returns the expected actual arrival
and departure time at the departure and destination stops, and the delay
compared to the planned time. For trains, it also adds the track, if changed,
and any remarks.

See the demo file for example calls and some helpers. Both of these data
sources can only retrieve data for the very near future, so the example 
code as is will not return results: you need to match it up to a trip
in the near future.


Train data
----------
For the train data, you need to know the ritnummer (train number) and 
the departure and destination station names.

Note that due to limitations in the NS API, the arrival delay at the 
destination is inaccurate: the result is actually the departure time. This is
a mismatch in case a train arrives 5 minutes late, but is scheduled to wait
at the destination station for 10 minutes. It will depart on time, but arrived
late.

To run this, you will also need to (register for an NS-API account)[https://www.ns.nl/ews-aanvraagformulier/]).
Once you have your details, set them in `OV_NS_USERNAME` and `OV_NS_KEY`.


KV78 data
---------
For KV78 data, there are two steps: retrieving the trip ID, and retrieving the
status for a trip. In the example code, `process_and_print_kv78_request` takes
care of both of these. In an actual application, you would cache the result
of the first call.

You will need: the route ID (e.g. `CXX|M172`), the stop ID of the departure
and destination stops, and the planned/targeted arrival time at the destination.

