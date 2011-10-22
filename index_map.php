
    
   
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
					heresay.lat = 51.5001524;
					heresay.lng = -0.1262362;
				}

				myPoint = new LatLonPoint(heresay.lat, heresay.lng);

				// set zoom 
				heresay.zoom = 14;
				
				if (heresay.zoom === undefined || heresay.zoom === '') {
					heresay.zoom = 13;
				}
															
				// display the map centered on a latitude and longitude (Google zoom levels)
				heresay.mapstraction.setCenterAndZoom(myPoint, heresay.zoom);
				
				heresay.mapstraction.addControls({
					pan: true, 
					zoom: 'small',
					map_type: true 
				});
							
				//Do ajax request for points 	
				var base_url = "find_threads.php?"; 
				
				var lat = gup('lat');
				var lng = gup('lng');
				var title = gup('title');
				var type = gup('type');
				var domain_name = gup('domain_name');
				
				var query = "lat="+lat+"&lng="+lng+"&title="+title+"&type="+type+"&domain_name="+domain_name;
				
				var url = base_url+query; 
								
				$.getJSON(url, function(data) {
					
					var results = eval(data); 
				
					$.each(results, function(key, val) {
						
						if (val.no_specific_location == '0') {
					
							var myPoint = new LatLonPoint(val.lat, val.lng);
						
							var my_marker = new Marker(myPoint);
						
							var text ="<strong><a target='_parent' href='http://"+val.domain_name+val.path+"'>"+val.title+"</a></strong><br/>";
							text += val.body.substring(0,150); 
							text += "...";
							my_marker.setInfoBubble(text);		
						
							my_marker.setLabel(val.title);

							heresay.mapstraction.addMarker(my_marker);	
						}
					});
				});
		
		});
 		
	</script>
	
	
<div id="mapstraction" ></div>


