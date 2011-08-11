<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Mapstraction - demo</title>
    
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.5.min.js"></script>

<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAtMGi9FIBTgJEO7_c1ZK0JRSpgYF3iu7PXc-1iPSD4CpffT2eCRQqiY_qfPWMu5QnCq_UpmKELt30EA&sensor=false" type="text/javascript"></script>

<script type="text/javascript" src="js/mapstraction.js"></script>
     
    <script type="text/javascript" >

//get the query string values
function gup(name)
{
name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
var regexS = "[\\?&]"+name+"=([^&#]*)";
var regex = new RegExp( regexS );
var results = regex.exec( window.location.href );
if( results == null )
return "";
else
return results[1];
}

$(document).ready(function() {

heresay = new Object();

// initialise the map with your choice of API
heresay.mapstraction = new Mapstraction('mapstraction','openstreetmap');

// create a lat/lon object

var center = gup('center');

heresay.center = center;

if (heresay.center != undefined) {
var myPoint = new LatLonPoint(heresay.mapCenter);
}

else {
var myPoint = new LatLonPoint(51.456708, -0.101163);
}


// display the map centered on a latitude and longitude (Google zoom levels)
heresay.mapstraction.setCenterAndZoom(myPoint, 13);

heresay.mapstraction.addControls({
pan: true,
zoom: 'small',
map_type: true
});


//Do ajax request for points
var base_url = "http://heresay.org.uk/api/find_threads.php?&";

var lat = gup('lat');
var lng = gup('lng');
var title = gup('title');
var type = gup('type');
var domain_name = gup('domain_name');

var query = "lat="+lat+"&lng="+lng+"&title="+title+"&type="+type+"&domain_name="+domain_name+"&callback=?";

var url = base_url+query;



$.getJSON(url, function(data) {

var results = eval(data);

$.each(results, function(key, val) {

var myPoint = new LatLonPoint(val.lat, val.lng);

var my_marker = new Marker(myPoint);

var text ="<strong><a target='_blank' href='http://"+val.domain_name+val.path+"'>"+val.title+"</a></strong><br/>";
text += val.body.substring(0,150);
text += "...";
my_marker.setInfoBubble(text);

my_marker.setLabel(val.title);

heresay.mapstraction.addMarker(my_marker);

});
});

});
 
</script>



<style type="text/css">

body,html {margin:0px; border:0px; height:100%;}

#mapstraction {
height: 100%;
width: 100%;
}
    </style>
</head>
<body>


<div id="mapstraction" style="position:relative; height: 100%; width: 100% "></div>


</body>
</html>