
    
   
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAOoFM_kDNJVs_SzvkytQRKBSpgYF3iu7PXc-1iPSD4CpffT2eCRRzD14PFyag3JY4SakJE5_wVYpLxw&sensor=false" type="text/javascript"></script>
		
	<script type="text/javascript" src="api/js/mapstraction.js"></script>    
     
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
			
		
				// create a lat/lon for center 
				var center = gup('center');
				
				if (center != undefined && center != '') {
					heresay.center = center.split(',');
					heresay.lat = heresay.center[0]; 
					heresay.lng = heresay.center[1];		
				}

				else {
					heresay.lat = 51.51066556016948;
					heresay.lng = -0.0556182861328125;
				}

				myPoint = new LatLonPoint(heresay.lat, heresay.lng);

				// set zoom 
				var zoom = gup('zoom');
				console.log(zoom);
				
				if (zoom === undefined || zoom == '') {
		             zoom=11;
				}
                
                console.log(zoom);
                
				heresay.zoom = parseInt(zoom);
										
				// display the map centered on a latitude and longitude (Google zoom levels)
				heresay.mapstraction.setCenterAndZoom(myPoint, heresay.zoom);
				
				heresay.mapstraction.addControls({
					pan: true, 
					zoom: 'small',
					map_type: true 
				});
							
				//Do ajax request for points 	
				var base_url = "api/recent_threads.php?"; 
				
									
				$.getJSON(base_url, function(data) {
					
					var results = eval(data); 
					
					$.each(results, function(key, val) {
						
						var myPoint = new LatLonPoint(val.lat, val.lng);
				
						var my_marker = new Marker(myPoint);
						if (val.category == 'events') { 
						    console.log('events');
						    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/009900/');
						}
						if (val.category == 'crime') {
						    console.log('crime');
						    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/999900/');
						}
						if (val.category == 'transport') { 
						    console.log('transport');
						    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/009999/');
						}					
						if (val.category == 'council') { 
						    console.log('council');
						    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/990000/');
						}						
						if (val.category == 'other') { 
						    console.log('other');
						     console.log(val.title);
						    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/000099/');
						}	

						if (val.category == 'buy_sell') { 
						    console.log('other');
						     console.log(val.title);
						    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/990099/');
						}											
			
						if (val.category == 'animals') { 
						    console.log('other');
						     console.log(val.title);
						    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/e7d56d/');
						}											

						if (val.category == 'local') { 
						    console.log('other');
						     console.log(val.title);
						    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/303e95/');
						}	
						
						if (val.category == 'sport') { 
						    console.log('other');
						     console.log(val.title);
						    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/df6899/');
						}								
						if (val.category == 'music') { 
						    console.log('other');
						     console.log(val.title);
						    my_marker.setIcon('http://www.googlemapsmarkers.com/v1/5cb59f/');
						}
						if (val.category == 'food') { 
						    console.log('other');
						     console.log(val.title);
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
		
            heresay.interval=self.setInterval("heresay.rndBubble()",12000);

            heresay.rndBubble = function() {
            	var numberOfMarkers = heresay.mapstraction.markers.length; 

            	var randomnumber=Math.floor(Math.random()*numberOfMarkers)
            	heresay.mapstraction.markers[randomnumber].openBubble();
            }		



		
    		$('#mapstraction').click(function() {
    		   
    			clearInterval(heresay.interval); 
    		});		
		
});
		

 		
	</script>
	
	
<div id="mapstraction" ></div>



