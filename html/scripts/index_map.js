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
			if (val.category_1 == 'local_knowledge' ) {
			    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/009900/');
			}

			else if (val.category_1 == 'crime_emergencies' ) {			    
			    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/999900/');
			}

			else if (val.category_1 == 'community_events'   ) {			    
			    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/009999/');
			}	
			
			else if (val.category_1 == 'shops_restaurants'   ) {			    
			    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/0099aa/');
			}							
			
			else if (val.category_1 == 'publicspace' ) { 
			    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/990000/');
			}				

			else if (val.category_1 == 'transport'  ) {
			    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/000099/');
			}	

			else if (val.category_1 == 'buy_sell'  ) {
			    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/990099/');
			}											

			else if (val.category_1 == 'animals' || val.category_1 == 'pets_nature'   ) {
			    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/e7d56d/');
			}											

			else if (val.category_1 == 'kids'  ) {
			    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/303e95/');
			}	

			else if (val.category_1 == 'sport'   ) {		
			    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/df6899/');
			}		
									
			else if (val.category_1 == 'art'   ) {		
			    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/5cb59f/');
			}

			else if (val.category_1 == 'food_drink'  ) {
			    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/aaa54f/');
			}
			
			else if (val.category_1 == 'charity'  ) {
			    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/aaa54f/');
			}			
			
			else  { 
				console.log("not found:" + val.category_1 + "--");
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