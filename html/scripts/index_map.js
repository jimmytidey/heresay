heresay = new Object(); 

heresay.init = function(lat, lng, zoom, categories, recency) { 

	// initialise the map with your choice of API
	heresay.mapstraction = new Mapstraction('mapstraction','openstreetmap');
	myPoint = new LatLonPoint(lat, lng);
	console.log('ssd'+zoom);
	// display the map centered on a latitude and longitude (Google zoom levels)
	heresay.mapstraction.setCenterAndZoom(myPoint, parseInt(zoom));
	heresay.mapstraction.addControls({
		pan: true, 
		zoom: 'small',
		map_type: true 
	});
			
	//Do ajax request for points 	
	var base_url = "api/recent_threads.php?"; 
	
	if (categories != '') { 
		base_url += "category="+categories; 
	}
	
	if (recency != '') { 
		base_url += "&recency="+recency;
	}
	
	$.getJSON(base_url, function(data) {
	
		var results = eval(data); 
	
		$.each(results, function(key, val) {
			
			var myPoint = new LatLonPoint(val.lat, val.lng);
			
			
			var my_marker = new Marker(myPoint);
			if (val.category == 'events') { 
			    
			    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/009900/');
			}
			if (val.category == 'crime') {
			    
			    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/999900/');
			}
			if (val.category == 'transport') { 

			    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/009999/');
			}					
			if (val.category == 'council') { 
			    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/990000/');
			}						
			if (val.category == 'other') { 

			    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/000099/');
			}	

			if (val.category == 'buy_sell') { 
			    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/990099/');
			}											

			if (val.category == 'animals') { 
			    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/e7d56d/');
			}											

			if (val.category == 'local') { 
			    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/303e95/');
			}	
		
			if (val.category == 'sport') { 
			    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/df6899/');
			}								
			if (val.category == 'music') { 

			    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/5cb59f/');
			}
			if (val.category == 'food') { 

			    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/aaa54f/');
			}


		    var milli = parseInt(val.pubdate)*1000;
	    
		    var date = new Date(milli);
	    
		    var day = date.getDate();
		    var month = date.getMonth() + 1;
		    var year = date.getFullYear();
	    
			var text ="<div style='height:110px!important; width:200px!important;overflow-x:hidden; overflow-y:auto;'><strong><a target='_blank' href='"+val.link+"'>"+unescape(val.title)+"</a></strong> <br /> <em class='bubble_date'> "+ day + '/' +month +"/"+year +" </em><br/>";
        
		
			if (val.description != undefined) {
			
			
				if (val.description.length > 120) { 
					text += val.description.substring(0,120); 
					text += "...";
				}	
				else {
					text += val.description;
				}					
			}
		
			text += '</div>';						
		
			my_marker.setInfoBubble(text);		
	
			my_marker.setLabel(val.title);
       
			heresay.mapstraction.addMarker(my_marker);	
		});	
	});
};	