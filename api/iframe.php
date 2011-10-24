<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Heresay</title>
    
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.5.min.js"></script>

    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAOoFM_kDNJVs_SzvkytQRKBSpgYF3iu7PXc-1iPSD4CpffT2eCRRzD14PFyag3JY4SakJE5_wVYpLxw&sensor=false" type="text/javascript"></script>
		
	<script type="text/javascript" src="js/mapstraction.js"></script>    
     
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
				
				heresay.lat = gup('lat');
				heresay.lng = gup('lng');
				heresay.title = gup('title');
				heresay.type = gup('type');
				heresay.domain_name = gup('domain_name');
				heresay.category = gup('category');
		
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
				heresay.zoom = parseInt(gup('zoom'));
				
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
				
				heresay.addPoints = function() { 
							
					//Do ajax request for points 	
					var base_url = "find_threads.php?"; 
			
				
					var query = "lat="+heresay.lat+"&lng="+heresay.lng+"&title="+heresay.title+"&type="+heresay.category+"&domain_name="+heresay.domain_name;
				
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
				}	
				
				heresay.categoryFilter= function() {
					var domain_name = gup('domain_name');
					var base_url = "get_categories.php?";
					var query = "domain_name="+domain_name;
					var url = base_url+query;
					
					$.getJSON(url, function(data) {
							
						heresay.results = eval(data); 
						var selected; 

						$.each(heresay.results, function(key, val) {
							
							
							if (heresay.catetory === val.type) {selected ="selected='selected'";}
							else {selected ='';}
							
							$('#filter').append('<option '+selected+' name="'+val.type+'" >'+val.type+'</option>');
						}); 
						
						$('#filter').change(function() {
								heresay.category = $('#filter').val();
								heresay.addPoints(); 
						}); 
						
					});
				} 
				
				heresay.categoryFilter()
		});
 		
	</script>
	
	
	
	<style type="text/css">
		
		body,html {
			margin:0px; 
			border:0px; 
			height:100%;
			font:arial;
		}
		
		p, select {margin:0px; padding:0x; display:inline; font-family:helvetica,arial;}
		
		#mapstraction {
			height: 100%;
			width: 100%;
			z-index:1;
		}
		
		#category_filter {
			padding:2px;
			position:absolute;
			top:5px;
			right:5px;
			background-color:white;
			width:300px;
			height:22px;
			z-index:200;
		}
		
		#filter {
			width:150px;
		}
		
    </style> 
</head>
<body>

	<div id='category_filter'>
		<p>Filter by category</p>
		<select id='filter' name='filter'>
		
		</select>
	</div>
	
	<div id="mapstraction" style="position:relative;  height: 100%; width: 100% "></div>


</body>
</html>

