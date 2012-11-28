heresay = {} ; 
heresay.tagFilterState = [];

heresay.defaultLat = 51.5073346;
heresay.defaultLng = -0.1276831;

heresay.locationFilterLat= 'none';
heresay.locationFilterLng= 'none';

heresay.mode = "unfiltered";



$(document).ready(function(){ 
	
	//attach filter events 
	$('#tag_filter input').click(function(){
		heresay.tagFilter();
	});
	
	$('#clear_filters').click(function(){
		heresay.clearFilter();
	});
	

	
	//if the url is set to something, replace the defaults
	if(getParameterByName('lat') != '') { 
		heresay.locationFilterLat = getParameterByName('lat');
	}

	if(getParameterByName('lng') != '') { 
		heresay.locationFilterLng = getParameterByName('lng');
	}	
	
	if(getParameterByName('tags') != '') { 
		heresay.tagFilterState = getParameterByName('tags').split(',');
		
		$.each(heresay.tagFilterState, function(key, val) { 
			$('#'+val).attr('checked', 'checked');
		});
	}
	
	if ((getParameterByName('lat') != '' && getParameterByName('lng') != '') || getParameterByName('tags') != '') {
		console.log('filter detected');
		heresay.mode = "filtered";
		heresay.updateFilter();
	}
	
	else {
		heresay.mode = "unfiltered"; 
		heresay.updateMainMap();
	}
	
	//draw the maps 
	heresay.renderFilterMap();
	
})


heresay.updateMainMap = function() { 
	
	if ( heresay.locationFilterLat != 'none') { 
		var center = new google.maps.LatLng(heresay.locationFilterLat, heresay.locationFilterLng);
	}
	else { 
		var center = new google.maps.LatLng(heresay.defaultLat, heresay.defaultLng);
	}
		
	var myOptions = {
		zoom: 10,
		center: center,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	
	heresay.mainMap  = new google.maps.Map($("#main_map")[0], myOptions);
	
	if (heresay.locationFilterLat != 'none') { 
		heresay.mainMap.setZoom(13);
	}	
	
	else { 
		heresay.mainMap.setZoom(10);
	}

	heresay.mainMap.points = []; 
	heresay.mainMap.infoWindows = []; 
	heresay.mainMap.markers = [];
	
	if (heresay.mode == 'unfiltered') {
		console.log('points ufil')
		$.get("/api/get_updates.php?mode=recent", function(data){
			heresay.mainMapAddMarkers(data.results);
		});
		$.get("/api/get_updates.php?mode=selected", function(data){
			heresay.renderContent(data.results);
		});		
	}
	else {
		console.log('points filtered');
		heresay.mainMapAddMarkers(heresay.data.results);
		
	}	
}


//abstract away adding markers, needs doing a lot 
heresay.mainMapAddMarkers = function(results) { 

	heresay.mainMap.points.length = 0; 
	heresay.mainMap.infoWindows.length = 0; 
	heresay.mainMap.markers.length = 0;
	
	$.each(results, function(key,val) { 	
		heresay.mainMap.points[key] = new google.maps.LatLng(val.lat, val.lng);
		
		if (val.title != null) {
			var short_desc = val.title.substring(0, 300); 
	
			if (short_desc.length > 199) { 
				short_desc += "...";
			}
		}	
		else { 
			var short_desc = 'no title';
		}
	
		var contentString = "<a target='_blank' href='" + val.link + "'>"+ short_desc +"</a><br/>" 
		contentString += "<span class='tagstring'>" + heresay.tagString(val) + "</span><br/>"; 
		contentString += window.timeConverter(val.pubdate);
	
		heresay.mainMap.infoWindows[key] = new google.maps.InfoWindow({
		    content: contentString,
		    maxWidth: 400
		});
	
		heresay.mainMap.markers[key] = new google.maps.Marker({
		    position: heresay.mainMap.points[key], 
		    map: heresay.mainMap,
		    draggable:true,
		    title: val.title
		});

		google.maps.event.addListener(heresay.mainMap.markers[key], 'click', function() {
		
			$.each(heresay.mainMap.infoWindows, function(key, val) { 
				val.close();
			});
		
			heresay.mainMap.infoWindows[key].open(heresay.mainMap, heresay.mainMap.markers[key]);
		});	
	});	
}


heresay.renderFilterMap = function() { 
	
	if ( heresay.locationFilterLat != 'none') { 
		var center = new google.maps.LatLng(heresay.locationFilterLat, heresay.locationFilterLng);
	}
	else { 
		var center = new google.maps.LatLng(heresay.defaultLat, heresay.defaultLng);
	}
	
	var myOptions = {
		zoom: 10,
		center: center,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	
	heresay.filterMap  = new google.maps.Map($("#filter_map")[0], myOptions);

	heresay.filterMarker = new google.maps.Marker({
	    position: center, 
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

heresay.renderContent = function(results) {
	
	$('#results_content').html('');
	$.each(results, function(key,val) { 

		$('#results_content').append("<h3><a href='" + val.link + "'>" + val.title + "</a></h3>");
		$('#results_content').append("<p>" + val.description + "</p>");
		
		
		var location_name = val.location_name; 
		if (location_name != '' && location_name != 'undefined') {
			$('#results_content').append("<p class='location_name'>" + tags_string + "</p>");
		}
		
		var tags_string = heresay.tagString(val);
		$('#results_content').append("<p class='tags'>Tags: " + tags_string + "</p>");
		
		var date_string =  window.timeConverter(val.pubdate);
		$('#results_content').append("<p class='pubdate'>" + date_string + "</p>");
	});	
}

//detect filter events
heresay.locationFilter = function(latlng){ 
	var lat = latlng.lat();
	var lng = latlng.lng();
	heresay.locationFilterLat = lat;
	heresay.locationFilterLng = lng;
	heresay.updateFilter();
}

heresay.tagFilter = function() { 
	heresay.tagFilterState = [];
	$('#tag_filter input:checked').each(function(key, val) { 
		var val = $(this).attr('id');
		heresay.tagFilterState.push(val);
	});
	heresay.updateFilter();
}


//update map on detection 
heresay.updateFilter = function() {
	var tag_string = heresay.tagFilterState.join(',');
	var lat = heresay.locationFilterLat;
	var lng = heresay.locationFilterLng;
	heresay.mode = 'filtered'
	
	history.pushState(null, null, "?lat=" + lat + "&lng=" + lng + "&tags=" + tag_string);
	
	$('#results_title').html('Filtered updates');

	$.get("/api/get_updates.php?lat=" + lat + "&lng=" + lng + "&tags=" + tag_string , function(data){
		heresay.data = data;
		heresay.renderContent(data.results);
		heresay.updateMainMap();
	});	
}



heresay.clearFilter = function () { 		
	history.pushState(null, null, "/");
	location.reload(true); 
}


//helpers
heresay.tagString = function(val) { 

	var tags_array = [];
	if(val.category_1 != '' && val.category_1 != '--' && val.category_1 != 'undefined' && typeof val.category_1 != undefined) { 
		tags_array.push(val.category_1);
	}
	if(val.category_2 != '' && val.category_2 != '--' && val.category_2 != 'undefined' && typeof val.category_2 != undefined) { 
		tags_array.push(val.category_2);
	}
	if(val.category_3 != '' && val.category_3 != '--' && val.category_3 != 'undefined' && typeof val.category_3 != undefined) { 
		tags_array.push(val.category_3);
	}			
	if(val.category_4 != '' && val.category_4 != '--' && val.category_4 != 'undefined' && typeof val.category_4 != undefined) { 
		tags_array.push(val.category_4);
	}						
	var tags_string =  tags_array.join(', ');	
	
	return tags_string;
}

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

window.timeConverter = function(UNIX_timestamp){
 var a = new Date(UNIX_timestamp*1000);
 var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
     var year = a.getFullYear();
     var month = months[a.getMonth()];
     var date = a.getDate();
     var hour = a.getHours();
     var min = a.getMinutes();
     var sec = a.getSeconds();
     var time = date+', '+month+' '+year;
     return time;
 }

