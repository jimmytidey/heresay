heresay = {} ; 
heresay.tagFilterState = [];
heresay.locationFilterLat='none';
heresay.locationFilterLng='none';
heresay.defaultLat = 51.5073346;
heresay.defaultLng = -0.1276831;


$(document).ready(function(){ 
	heresay.renderFilterMap();
	$('#tag_filter input').click(function(){
		heresay.tagFilter();
	});
	
	$('#clear_filters').click(function(){
		heresay.clearFilter();
	});
	
	if(getParameterByName('lat') != '') { 
		heresay.locationFilterLat = getParameterByName('lat');
	}

	if(getParameterByName('lng') != '') { 
		heresay.locationFilterLng = getParameterByName('lng');
	}	
	
	if(getParameterByName('tags') != '') { 
		heresay.tagFilterState = getParameterByName('tags').split(',');
	}
	
	heresay.updateFilter();
	
	
})

heresay.renderFilterMap = function() { 
	
	var center = new google.maps.LatLng(heresay.defaultLat, heresay.defaultLng);
		
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
		console.log(val);
		heresay.tagFilterState.push(val);
	});
	heresay.updateFilter();
}

heresay.updateFilter = function() {
	var tag_string = heresay.tagFilterState.join(',');
	history.pushState(null, null, "?lat=" + heresay.locationFilterLat + "&lng=" + heresay.locationFilterLng + "&tags=" + tag_string);
	
	var lat = getParameterByName('lat');
	var lng = getParameterByName('lng');
	
	$.get("/api/get_updates.php?lat=" + lat + "&lng=" + lng + "&tags=" + tag_string, function(data){
		
		if (heresay.locationFilterLat=='none' && heresay.locationFilterLng=='none' && tag_string =='') { 
			$('#results_title').html('Selected updates');
		}
		else { 
			$('#results_title').html('Filtered updates');
		}
		
		$('#results_content').html('');
		$.each(data.results, function(key,val) { 
			$('#results_content').append("<h3><a href='pages/" + val.id + "'>" + val.title + "</a></h3>");
			$('#results_content').append("<p>" + val.description + "</p>");
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
			$('#results_content').append("<p class='tags'>Tags: " + tags_string + "</p>");
			
			var date_string =  timeConverter(val.pubdate);
			$('#results_content').append("<p class='pubdate'>" + date_string + "</p>");
		});
	});	
}

heresay.clearFilter = function () { 
	var center = new google.maps.LatLng(heresay.defaultLat, heresay.defaultLng);
	heresay.filterMap.setCenter(center);
    heresay.filterMap.setZoom(10);
 	heresay.filterMarker.setPosition(center);
	$("#tag_filter input:checkbox").attr('checked', false);
	heresay.tagFilterState = [];
	heresay.locationFilterLat='none';
	heresay.locationFilterLng='none';
	heresay.updateFilter();
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

