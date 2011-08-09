<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<style type="text/css">
  html { height: 100% }
  body { height: 100%; margin: 0px; padding: 0px }
  #map_canvas { height: 100% }
</style>

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>

<script type="text/javascript">
 
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

heresay = new Object(); 
 

$(document).ready(function() {
    heresay.init(); 
}); 

heresay.init = function () { 

	heresay.location_touch = 0;
	
	//check to see if anyone has touched the location box 
	$('#location_name').focus(function() {
  		heresay.location_touch = 1;
	});
		
	
	//see if this thread already exists
	var title = gup('title');
	var body_text = gup('body_text');
	var home_url = gup('home_url');
	var domain_name = gup('domain');
	var home_url = gup('home_url');
	var sub_page_id = gup('sub_page_id');

	jQuery.getJSON("http://heresay.org.uk/api/find_threads.php?domain_name="+domain_name+"&sub_page_id="+sub_page_id+"&path="+home_url+"&callback=?", 
	function(data) {
		
        var center = gup('center'); 
				
		heresay.center = center;
				
		if (heresay.center != undefined) {
			var heresay.centerObject = new LatLonPoint(heresay.center);
		}
		
		else {
			var heresay.centerObject = new LatLonPoint(51.456708, -0.101163);
		}
                
		var location_name = '';

		if (data != 'no results found') {
			data = eval(data);
			heresay.lat = data['0']['lat'];
			heresay.lng = data['0']['lng'];
			heresay.location_name = data['0']['location_name'];
			heresay.type = data['0']['type'];
			$('#location_name').val(heresay.location_name); 
			$('#type').val(heresay.type); 		
		}
		


	    var myOptions = {
	      zoom: 14,
	      center: heresay.centerObject,
	      mapTypeId: google.maps.MapTypeId.ROADMAP
	    };

		heresay.map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
		
		
		var marker_position = new google.maps.LatLng(heresay.lat, heresay.lng);
		heresay.marker = new google.maps.Marker({
			map:heresay.map,
			draggable:true,
			animation: google.maps.Animation.DROP,
			position: marker_position
		});
		
		//this to autopopulate the location name
		google.maps.event.addListener(heresay.marker, 'mouseup', function() {
		  
		  //make sure we don't already have a name for this location 
		  if (heresay.location_name =='' ||  heresay.location_name ==undefined) {
		  	
		  	//check to make sure the user hasn't typed something in manually 
		  	if (heresay.location_touch == 0)  {
		  		var save_marker_position = heresay.marker.getPosition();	
			  	jQuery.getJSON('http://api.geonames.org/findNearbyPlaceNameJSON?lat='+save_marker_position.lat()+'&lng='+save_marker_position.lng()+'&username=jimmytidey', 
					function(data) { 
											 
						heresay.autosuggest = eval(data);
						
						$('#location_name').val(heresay.autosuggest.geonames[0]['name']);
				});	
		  	}
		  }	  
  		});

	
	});
	
	$('#heresay_more_btn').click(function() {
	  $('#heresay_more').slideToggle('slow');
	});
	

	$('#more_close').click(function() {
	  $('#heresay_more').slideToggle('slow');
	});


  
	$('#save_button').click(function() {
		var save_marker_position = heresay.marker.getPosition();
		var location_name = $('#location_name').val();
		var type = $('#type').val();

		var title = gup('title');
		var body_text = gup('body_text');
		var home_url = gup('home_url');
		var domain_name = gup('domain');
		var home_url = gup('home_url');	
		var thread_date = gup('thread_date');	

		if (location_name=="" || location_name=="null") {
			alert('You must enter a location name');
		}
		
		else if (type=="" || type=="null" || type=='select') {
			alert('You must enter a category');
		}		

	

		else {
			 $("#header").html("<center><strong>Saving...</strong></center>");
		
			url = 'http://heresay.org.uk/api/write_comment.php?';
			data = 'domain_name='+domain_name; 
			data += '&path='+home_url;
			data += '&sub_page_id='+sub_page_id;
			data += '&lat='+save_marker_position.lat(); 
			data += '&lng='+save_marker_position.lng();
			data += '&location_name='+ location_name;
			data += '&thread_date='+ thread_date;
			data += '&type='+ type;
			data += '&body='+body_text;
			data += '&title='+title;

			$.ajax({
			   type: "GET",
			   url: url,
			   data: data,
			   
			   success: function(msg){
				 $("#header").html("<center><strong>Saved</strong></center>");
			   }
			});
		}	
	});
};
    

 

</script>

<style>
body, p, input, label {
	font-family:"Helvetica Neue", Arial, Helvetica, sans-serif;
	font-size:13px;
} 

#location_name {
	width:300px;
}

</style>

</head>
<body>
	
	<p  id='header' style='margin-top:0px; margin-left:30px;'>Move the icon on the map to indicate the location which this post is about. <a href='javascript:void(0)' id='heresay_more_btn'>More...</a></p>
	
	<p id='heresay_more' style='display:none; position:absolute; background-color:white; margin-left:30px; padding:4px 0px; z-index:300; width:100%' >
		Heresay is a way of locating information to make it easier to find. It's still in beta at the moment, so please excuse us if there are any problems. 
		
		<br/>Find out more <a href='http://heresay.org.uk/' target='_blank'>here</a>.
		
		<br/><br/>
		<a href='javascript:void(0)' id='more_close'>Close</a>
	</p>
	
	<div id="map_canvas" style="width:500px; height:325px; left:30px"></div>

	<div style='margin-top:10px;'>
	
		<label for='location_name' style='margin-left:70px'>Location name* </label>
		
		<input type='text' id='location_name'>
		
		<br /><br />
		
		<select id='type' style='margin-left:180px'>
			<option value='select'>-select category-</option>
			<option value='Environment'>Environment</option>
			<option value='Crime'>Crime</option>
			<option value='Animals and Nature'>Animals and nature</option>
			<option value='Events'>Events</option>
			<option value='Travel'>Travel</option>
			<option value='Local Knowlege'>Local Knowledge</option>
			<option value='No Category'></option> 
		</select>
		
		<input type='button' value='save' id='save_button'  /> 
	
	</div>
  
</body>
