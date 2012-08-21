heresay = new Object(); 

heresay.init = function(lat, lng, zoom, categories, recency , id) { 
			
	//Do ajax request for points 	
	var base_url = "api/recent_threads.php?"; 
	
	if (id) { 
		base_url += "id="+id; 
	}
	
	else {
	
		if (categories != '') { 
			base_url += "category="+categories; 
		}
	
		if (recency != '') { 
			base_url += "&recency="+recency;
		}
	}	
	
	// initialise the map with your choice of API
	heresay.mapstraction = new Mapstraction('mapstraction','openstreetmap');

	heresay.mapstraction.addControls({
		pan: true, 
		zoom: 'small',
		map_type: true 
	});	
	
	if (!id) { 
		center = new LatLonPoint(lat, lng);
		heresay.mapstraction.setCenterAndZoom(center, parseInt(zoom));
	}
	
	
	$.getJSON(base_url, function(data) {
	
		var results = eval(data); 
	
		$.each(results, function(key, val) {
			
			var myPoint = new LatLonPoint(val.lat, val.lng);
			
			if (id !='') {
				heresay.center_lat = val.lat;
				heresay.center_lng = val.lng;
			}
			
			var my_marker = new Marker(myPoint);
			if (val.category_1 == 'Local_knowledge' || val.category_2 == 'Local_knowledge' || val.category_3 == 'Local_knowledge' || val.category_4 == 'Local_knowledge'  ) {
			    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/009900/');
			}

			if (val.category_1 == 'crime_emergencies' || val.category_2 == 'crime_emergencies' || val.category_3 == 'crime_emergencies' || val.category_4 == 'crime_emergencies'  ) {			    
			    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/999900/');
			}

			if (val.category_1 == 'community_events' || val.category_2 == 'community_events' || val.category_3 == 'community_events' || val.category_4 == 'community_events'  ) {			    
			    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/009999/');
			}					
			
			if (val.category_1 == 'coucil' || val.category_2 == 'coucil' || val.category_3 == 'coucil' || val.category_4 == 'coucil'  ) { 
			    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/990000/');
			}				

			if (val.category_1 == 'other' || val.category_2 == 'other' || val.category_3 == 'other' || val.category_4 == 'other'  ) {
			    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/000099/');
			}	

			if (val.category_1 == 'buy_sell' || val.category_2 == 'buy_sell' || val.category_3 == 'buy_sell' || val.category_4 == 'buy_sell'  ) {
			    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/990099/');
			}											

			if (val.category_1 == 'animals' || val.category_2 == 'animals' || val.category_3 == 'animals' || val.category_4 == 'animals'  ) {
			    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/e7d56d/');
			}											

			if (val.category_1 == 'local' || val.category_2 == 'local' || val.category_3 == 'local' || val.category_4 == 'local'  ) {
			    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/303e95/');
			}	

			if (val.category_1 == 'sport' || val.category_2 == 'sport' || val.category_3 == 'sport' || val.category_4 == 'sport'  ) {		
			    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/df6899/');
			}		
									
			if (val.category_1 == 'music' || val.category_2 == 'music' || val.category_3 == 'music' || val.category_4 == 'music'  ) {		
			    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/5cb59f/');
			}

			if (val.category_1 == 'food' || val.category_2 == 'food' || val.category_3 == 'food' || val.category_4 == 'food'  ) {
			    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/aaa54f/');
			}


		    var milli = parseInt(val.pubdate)*1000;
	    
		    var date = new Date(milli);
	    
		    var day = date.getDate();
		    var month = date.getMonth() + 1;
		    var year = date.getFullYear();
	    
			var text ="<div style='height:210px!important; width:200px!important;overflow-x:hidden; overflow-y:auto;'><strong><a target='_blank' href='"+val.link+"'>"+unescape(val.title)+"</a></strong> <br /> <em class='bubble_date'> "+ day + '/' +month +"/"+year +" </em><br/>";
        
		
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
			if (id !='') {
				console.log(my_marker);
				my_marker.openBubble();
			}
		});	
		
		if (id) { 
			console.log('YES single points case');
			center = new LatLonPoint(heresay.center_lat , heresay.center_lng);
			heresay.mapstraction.setCenterAndZoom(center, parseInt(zoom));
		}

		// display the map centered on a latitude and longitude (Google zoom levels)

	});
};	