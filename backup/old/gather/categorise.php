<?
include('../db_functions.php');


$query      = "SELECT * FROM manual_updates WHERE lat!='' && lat!='--' && category_1='--' && category_1='' LIMIT 10"; 
$results    = db_q($query);

$location_query      = "SELECT * FROM manual_locations"; 
$location_results     = db_q($location_query);

?>


<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<title>Locate</title>
		
		<style>
	        #container { 
	            margin:auto;
	            position:relative;
	            width:900px;
	        }
	        
	        .item { 
	            width:900px;
	            border-bottom:1px solid black;
	            border-top:1px solid black;
	            float:left;
	            height:440px ;
	            margin-bottom:10px;
	        }
	        
	        .map { 
	            width:450px;
	            height:420px;
	            float:left;
	            margin-right:20px;
	        }
	        
	        .search { 
	            width:300px;
	        }
	        
	        .description { 
	            height:220px;
	            overflow:auto;
	        }
	    
	    </style>
	    
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&sensor=false"></script>
		<script type="text/javascript" src="../scripts/jquery-1.7.1.min.js"></script>
		</head>
	
	<body>
	    
	    <div id='container'>


                <script type="text/javascript">
                    function initialize() {
                            
                        <?
                        $i = 0;
                        foreach($results as $result) {
                            //set appropriate map settings 
                            foreach($location_results as $location_result) { 
                                if ($location_result['name'] == $result['site']) { 
                                    $lat = $location_result['lat'];
                                    
                                    $lng = $location_result['lng'];
                                    $zoom = $location_result['zoom'];
                                }
                            } 
                            
                            if (empty($lat)){ 
                                $lat = 51.5073346;
                                $lng = -0.1276831;
                                $zoom = 12;
                            }
                            
                            ?>
                                console.log(<?=$result['lat'] ?>);
                        var myOptions = {
                         zoom: 12,
                         center: new google.maps.LatLng(<?=$result['lat'] ?>, <?=$result['lng'] ?>),
                         mapTypeId: google.maps.MapTypeId.ROADMAP
                        };
                        
                        var link = "<? echo $result['link']; ?>";
                        var map_<?=$i?> = new google.maps.Map(document.getElementById('map_canvas_<?=$i ?>'), myOptions);
                        var myLatlng = new google.maps.LatLng(<?=$result['lat'] ?>, <?=$result['lng'] ?>);
                        var marker_<?=$i?> = new google.maps.Marker({
                            position: myLatlng, 
                            map: map_<?=$i?>,
                            draggable:true,
                            title:"move me about",
                            link: link
                        });
                        
                        //this adds the search stuff 
                        var input = document.getElementById('search_<?=$i ?>');
                        var autocomplete = new google.maps.places.Autocomplete(input);
                        autocomplete.bindTo('bounds', map_<?=$i?>);
                        
                        google.maps.event.addListener(autocomplete, 'place_changed', function() {
                            
                            var place = this.getPlace();                            
                            
                            if (place.geometry.viewport) {
                                
                                map_<?=$i?>.fitBounds(place.geometry.viewport);
                            } else {
                                map_<?=$i?>.setCenter(place.geometry.location);
                                map_<?=$i?>.setZoom(17);  // Why 17? Because it looks good.
                            }
                            
                            var point = new google.maps.LatLng(place.geometry.location.lat(), place.geometry.location.lng());
                            marker_<?=$i?>.setPosition(point);
                            
                            console.log(point);
                        });
                                                     

                        $('#save_<?=$i ?>').click(function() {                         
                             var position = marker_<?=$i?>.getPosition();
                             var lat = position.lat();
                             var lng = position.lng(); 
                             var link = encodeURIComponent($('#no_location_link_<?=$i ?>').val());
                             var category_1 = escape($('#category_<?=$i ?>_1').val());
                             var category_2 = escape($('#category_<?=$i ?>_2').val());
                             var category_3 = escape($('#category_<?=$i ?>_3').val());
                             var category_4 = escape($('#category_<?=$i ?>_4').val());                            
                             console.log(link);
                             $.get("save.php?category_1="+category_1+"&category_2="+ category_2+"&category_3="+category_3+"&category_4="+category_4+"&lat="+lat+'&lng='+lng+'&link='+link, function(html) { 
                                 console.log(html);
                             });
                         });


                         //save if there is no location 
                         $('#no_location_<?=$i ?>').click(function() { 
                            
                             if($('#no_location_<?=$i ?>').attr("checked") == 'checked') {
                                 
                                 var link = encodeURIComponent($("#no_location_link_<?=$i ?>").val());
                                 var category = escape($('#category_<?=$i ?>').val());
                                 $.get("save.php?category="+category+"&lat=--&lng=--&link="+link, function(html) {
                                     console.log(html);
                                 });
                             }                          
                         });
 
                        
                        

                        
                    
                      <?
                        $i++;
                        }
                        ?>
                    }
                    google.maps.event.addDomListener(window, 'load', initialize);
                </script>

            
            <?
            $i = 0;
            foreach($results as $result) { 
                ?>
                <div class='item'>
                    <div id='map_canvas_<?=$i ?>' class='map' ></div>
                    <h3><a href='<?echo $result['link'] ?>' target='_blank' ><?echo $result['title'] ?></a></h3>
                    <p class='description'><?echo strip_tags(htmlspecialchars_decode ($result['description'])) ?> </p>
                    <p class='site'>Site: <?echo strip_tags(htmlspecialchars_decode ($result['site'])) ?> </p>
                    <p>
                        <label for='no_location_<?=$i ?>'>This post has no location</label>
                        <input name='no_location_<?=$i ?>' id='no_location_<?=$i ?>'  type='checkbox'/>
                        <input  id='no_location_link_<?=$i ?>'  type='hidden' value='<?echo $result['link'] ?>'/>
                        <br/>
                 
                        <select id='category_<?=$i ?>_1'>
                            <option value='--'>--</option>
                            <option value='Local_knowledge'>Local knowledge</option>
                            <option value='crime_emergencies'>Crime and emergencies</option>
                            <option value='community_events'>Community events</option>
                            <option value='forsale_giveaway'>Buy Sell</option>
                            <option value='charity'>Charity</option>                            
                            <option value='pets_nature'>Pets and nature</option>   
                            <option value='shops_restaurants'>Shops / Restaurants / Bars</option>
                            <option value='art'>Art / music / culture</option>
                            <option value='sport'>Sport</option>                          
                            <option value='food_drink'>Food and Drink</option>
                            <option value='lost'>Lost</option>
                            <option value='transport'>Transport</option>
                            <option value='council'>Council business</option> 
                            <option value='kids'>Kids</option>                                                                    
                        </select>

                        <select id='category_<?=$i ?>_2'>
                            <option value='--'>--</option>
                            <option value='Local_knowledge'>Local knowledge</option>
                            <option value='crime_emergencies'>Crime and emergencies</option>
                            <option value='community_events'>Community events</option>
                            <option value='forsale_giveaway'>Buy Sell</option>
                            <option value='charity'>Charity</option>                            
                            <option value='pets_nature'>Pets and nature</option>   
                            <option value='shops_restaurants'>Shops / Restaurants / Bars</option>
                            <option value='art'>Art / music / culture</option>
                            <option value='sport'>Sport</option>                          
                            <option value='food_drink'>Food and Drink</option>
                            <option value='lost'>Lost</option>
                            <option value='transport'>Transport</option>
                            <option value='council'>Council business</option> 
                            <option value='kids'>Kids</option>                                                                     
                        </select>  

                        <select id='category_<?=$i ?>_3'>
                            <option value='--'>--</option>
                            <option value='Local_knowledge'>Local knowledge</option>
                            <option value='crime_emergencies'>Crime and emergencies</option>
                            <option value='community_events'>Community events</option>
                            <option value='forsale_giveaway'>Buy Sell</option>
                            <option value='charity'>Charity</option>                            
                            <option value='pets_nature'>Pets and nature</option>   
                            <option value='shops_restaurants'>Shops / Restaurants / Bars</option>
                            <option value='art'>Art / music / culture</option>
                            <option value='sport'>Sport</option>                          
                            <option value='food_drink'>Food and Drink</option>
                            <option value='lost'>Lost</option>
                            <option value='transport'>Transport</option>
                            <option value='council'>Council business</option> 
                            <option value='kids'>Kids</option>                                                                       
                        </select>
                        
                        <select id='category_<?=$i ?>_4'>
                            <option value='--'>--</option>
                            <option value='Local_knowledge'>Local knowledge</option>
                            <option value='crime_emergencies'>Crime and emergencies</option>
                            <option value='community_events'>Community events</option>
                            <option value='forsale_giveaway'>Buy Sell</option>
                            <option value='charity'>Charity</option>                            
                            <option value='pets_nature'>Pets and nature</option>   
                            <option value='shops_restaurants'>Shops / Restaurants / Bars</option>
                            <option value='art'>Art / music / culture</option>
                            <option value='sport'>Sport</option>                          
                            <option value='food_drink'>Food and Drink</option>
                            <option value='lost'>Lost</option>
                            <option value='transport'>Transport</option>
                            <option value='council'>Council business</option> 
                            <option value='kids'>Kids</option>                                                                     
                        </select>
             
                    
                    <p>Search <input type='text' id='search_<?=$i ?>' class='search'  /> <input type='button' value='save' id='save_<?=$i ?>' > </p>  
                </div>
               <?
               $i++;
            }           
            ?>
            
            <a href=''>MORE!!!</a>
            
        </div>
    </body>
</html>
