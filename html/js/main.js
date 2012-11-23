heresay = {} ; 
heresay.tagFilterState = [];
heresay.locationFilterState;

$(document).ready(function(){ 
	heresay.renderFilterMap();
	$('#tag_filter input').click(function(){
		heresay.tagFilter();
	});
})

heresay.renderFilterMap = function() { 
	
	var myLatlng = new google.maps.LatLng(51.5073346, -0.1276831);
		
	var myOptions = {
		zoom: 10,
		center: myLatlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	
	heresay.filterMap  = new google.maps.Map($("#filter_map")[0], myOptions);

	heresay.filterMarker = new google.maps.Marker({
	    position: myLatlng, 
	    map: heresay.filterMap,
	    draggable:true,
	    title:"move me about"
	});
	
    heresay.autocomplete = new google.maps.places.Autocomplete($("#location_filter")[0]);
    heresay.autocomplete.bindTo('bounds', heresay.filterMap);

    google.maps.event.addListener(heresay.autocomplete, 'place_changed', function() {
		var place = this.getPlace();
        if (place.geometry.viewport) {
            heresay.filterMap.fitBounds(place.geometry.viewport);
        } else {
           	heresay.filterMap.setCenter(place.geometry.location);
            heresay.filterMap.setZoom(12);  
        }
    
        var point = new google.maps.LatLng(place.geometry.location.lat(), place.geometry.location.lng());
        heresay.filterMarker.setPosition(point);
		heresay.locationFilter(point);
    });	

	google.maps.event.addListener(heresay.filterMarker, 'dragend', function() { 
		var latlng = this.getPosition();
		heresay.locationFilter(latlng)
	});
}

heresay.locationFilter = function(latlng){ 
	var lat = latlng.lat();
	var lng = latlng.lng();
	heresay.locationFilterState = "lat=" + lat + "&lng=" + lng;
	heresay.updateFilter();
}

heresay.tagFilter = function() { 
	heresay.tagFilterState = [];
	$('#tag_filter input:checked').each(function(key, val) { 
		var val = $(this).attr('id');
		console.log(val);
		heresay.tagFilterState.push(val);
	});
	heresay.updateFilter();
}

heresay.updateFilter = function() {
	var tag_string = heresay.tagFilterState.join(',');
	history.pushState(null, null, "?" + heresay.locationFilterState + "&tags=" + tag_string);
	
	var lat = getParameterByName('lat');
	var lng = getParameterByName('lng');	
	$.get("/api/get_updates.php?lat=" + lat + "&lng=" + lng, function(data){
		$('#results_title').html('Location updates');
		$('#results_content').html('');
		$.each(data, function(key,val) { 
			$('#results_content').append("<h3><a href='pages/" + val.id + "'>" + val.title + "</a></h3>");
			$('#results_content').append("<p>" + val.description + "</p>");
			var d_string =  timeConverter(val.pubdate);
			$('#results_content').append("<p class='pubdate'>" + d_string + "</p>");
		});
	});
}


//helpers
function getParameterByName(name)
{
  name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
  var regexS = "[\\?&]" + name + "=([^&#]*)";
  var regex = new RegExp(regexS);
  var results = regex.exec(window.location.search);
  if(results == null)
    return "";
  else
    return decodeURIComponent(results[1].replace(/\+/g, " "));
}

function timeConverter(UNIX_timestamp){
 var a = new Date(UNIX_timestamp*1000);
 var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
     var year = a.getFullYear();
     var month = months[a.getMonth()];
     var date = a.getDate();
     var hour = a.getHours();
     var min = a.getMinutes();
     var sec = a.getSeconds();
     var time = date+','+month+' '+year;
     return time;
 }

