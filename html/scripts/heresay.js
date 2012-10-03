heresay = {};

heresay.init_from_url = function (div_id) { 
    var recency = gup('recency'); 
    var id = gup('id'); 
    var lat = gup('lat'); 
    var lng = gup('lng'); 
    var id = gup('id');
    var category = gup('category'); 
    
    //center the page 
    if(!isNumber(lat)) { 
        lat = 51.5073346;
    }  
    if(!isNumber(lng)) { 
        lng = -0.1276831;
    }        
    
    //if this page has a specific id, we can stop here
    if (id) { 
        heresay.draw_map(lat, lng, 12, category, '', id,div_id);
    }  
    
    //otherwise get recency from the URL 
    else { 
        if(recency =='') { 
            recency = "this_month";
        }  
        heresay.draw_map(lat, lng, 12, category, recency, '',div_id);
    }		
}

heresay.draw_map = function (lat, lng, zoom, categories, recency, id, div_id) {

    //Do ajax request for points 	
    var base_url = "http://heresay.org.uk/api/recent_threads.php?";

    if (id) {
        base_url += "id=" + id;
    } else {

        if (categories != '') {
            base_url += "category=" + categories;
        }

        if (recency != '') {
            base_url += "&recency=" + recency;
        }
    }

    // initialise the map with your choice of API
    heresay.mapstraction = new Mapstraction('mapstraction', 'openstreetmap');

    heresay.mapstraction.addControls({
        pan: true,
        zoom: 'small',
        map_type: true
    });

    if (!id) {
        center = new LatLonPoint(lat, lng);
        heresay.mapstraction.setCenterAndZoom(center, parseInt(zoom));
    }

	$(div_id).append("<div id='loading-gif' style='width:100px; position:absolute; top:300px; z-index:100000; left:325px; text-align:center; height:100px;><img src='images/loading.gif' /> </div>") 
	
    $.getJSON(base_url, function (data) {
		
		$('#loading-gif').remove();
		
        var results = eval(data);

        $.each(results.data, function (key, val) {


            if (val.category_1 != '--' && val.category_1 != '') {
              
                var myPoint = new LatLonPoint(val.lat, val.lng);

                if (id != '') {
                    heresay.center_lat = val.lat;
                    heresay.center_lng = val.lng;
                }

                var my_marker = new Marker(myPoint);
                if (val.category_1 == 'local_knowledge') {
                    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/A50026/');
                } else if (val.category_1 == 'crime_emergencies') {
                    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/D73027/');
                
				} else if (val.category_1 == 'community_events') {
                    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/F46D43/');
                
				} else if (val.category_1 == 'shops_restaurants') {
                    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/FDAE61/');
                
				} else if (val.category_1 == 'transport') {
                    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/FEE090/');
                
				} else if (val.category_1 == 'animals' || val.category_1 == 'pets_nature') {
                    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/313695/');
                
				} else if (val.category_1 == 'kids') {
                    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/74ADD1/');
                
				} else if (val.category_1 == 'sport') {
                    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/df6899/');
                
				} else if (val.category_1 == 'art') {
                    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/5cb59f/');
                
				} else if (val.category_1 == 'council') {
                    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/4575B4/');
				}
	            else {
	                my_marker.setIcon('http://www.googlemapsmarkers.com/v1/faa54f/');
	            }



                var milli = parseInt(val.pubdate) * 1000;
                var date = new Date(milli);
				
				var monthNames = [ "January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December" ];
                var day = date.getDate();
                var month = monthNames[date.getMonth()]
                var year = date.getFullYear();
				
				
				var tags; 
				if (val.category_1 != '' && val.category_1 != '--' && typeof val.category_1 !== "undefined") {tags = val.category_1;} 
				if (val.category_2 != '' && val.category_2 != '--' && typeof val.category_2 !== "undefined") {tags += ", " + val.category_2;} 
				if (val.category_3 != '' && val.category_3 != '--' && typeof val.category_3 !== "undefined") {tags += ", " + val.category_3;} 
				

                var text = "<div style='height:210px!important; width:200px!important;overflow-x:hidden; overflow-y:auto;'>";
				text += "<strong><a target='_blank' href='" + val.link + "'>" + unescape(val.title) + "</a></strong> <br />";
				text += "<em class='bubble_date'> " + day + ' ' + month +" </em><br/>";
				

                if (val.description != undefined) {


                    if (val.description.length > 120) {
                        text += val.description.substring(0, 120);
                        text += "...";
                    } else {
                        text += val.description;
                    }
                }
				
				text += "<span style='position:absolute; bottom:5px; width:210px; font-size:10px; left:2px'><strong>Tags: </strong>" +tags+ "  </span>";

                text += '</div>';

                my_marker.setInfoBubble(text);

                my_marker.setLabel(val.title);

                heresay.mapstraction.addMarker(my_marker);
                if (id != '') {
                    console.log(my_marker);
                    my_marker.openBubble();
                }
				else { 
				 	if (key == 0) { 
						my_marker.openBubble();
					} 	
				}

            };
        });

        if (id) {
            console.log('YES single points case');
            center = new LatLonPoint(heresay.center_lat, heresay.center_lng);
            heresay.mapstraction.setCenterAndZoom(center, parseInt(zoom));
        }

        // display the map centered on a latitude and longitude (Google zoom levels)

    });
};

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

function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}