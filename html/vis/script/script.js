heresay = {};
heresay.heatmap = [];  
heresay.heatmap_points = [];
 
heresay.heatmap[1] = [];
heresay.heatmap_points[1] = [];

heresay.heatmap[2] = []; 
heresay.heatmap_points[2] = [];

heresay.heatmap[3] = [];
heresay.heatmap_points[3] = [];

heresay.heatmap[4] = [];            
heresay.heatmap_points[4] = [];
heresay.options = [];


//init settings 
heresay.mode    = 'site';
heresay.lat     = 51.5073346;
heresay.lng     = -0.1276831;
heresay.zoom    = 11;
heresay.layer = "toner";

if  (gup('mode') !== '') { 
    heresay.mode = gup('mode');
}

if (gup('lat') !== '') { 
    heresay.lat = parseFloat(gup('lat'));
}

if (gup('lng') !== '') { 
    heresay.lng = parseFloat(gup('lng'));
}

if (gup('zoom') !== '') { 
    heresay.zoom = parseInt(gup('zoom'));
}


$(document).ready(function(){
  
   heresay.renderMap();
    
   $('.dropdown').change(function(){
   	    heresay.dropDownChange($(this));
   });    
   
   heresay.getOptions();
   
   $('#loading').hide();
   
});

heresay.getOptions = function() { 
    
    var url; 
    
    if(heresay.mode === 'sites') { 
        url = '/api/list_sites.php?lat=' + heresay.lat + "&lng=" + heresay.lng + "&zoom=" + heresay.zoom;
        
        $.get(url, function(data){
            $.each(data.results, function(key,val){
                heresay.options.push(val.site);
            });
            
            heresay.renderDropDowns();
        });
    }
    
    else { 
        url = '/api/list_tags.php';
        
        $.get(url, function(data){
            $.each(data.results, function(key,val){
                heresay.options.push(val.tag);
            });
            
            heresay.renderDropDowns();
        });
    }
}
   
heresay.renderMap = function(){
    var myLatlng = new google.maps.LatLng(heresay.lat, heresay.lng); 

   	heresay.map = new google.maps.Map(document.getElementById("map-canvas"), {
        zoom: heresay.zoom,
        center: myLatlng,
   	mapTypeId: heresay.layer,
    	mapTypeControlOptions: {
        	mapTypeIds: [heresay.layer]
   	}
	});  
	heresay.map.mapTypes.set(heresay.layer, new google.maps.StamenMapType(heresay.layer)); 
	heresay.draw_brockley();
}



heresay.renderDropDowns = function() {
    if(heresay.mode === 'sites') { 
        $('#header .function_description').html('<p id="filter_type">Filter by top sites</p>');
    } else { 
        $('#header  .function_description').html('<p id="filter_type">Filter by tag</p>');
    }
    
    $('#option_1').empty();
    $('#option_1').append('<option value="">--select--</option>');
    $('#option_1').append('<option value="">All</option>');
    $.each(heresay.options, function(option_key, option_val){
        $('#option_1').append('<option value="'+option_val+'">'+option_val.replace("_"," & ")+'</option>');
    });
    
    $('#option_2').empty();
    $('#option_2').append('<option value="">--select--</option>');
    $('#option_2').append('<option value="">All</option>');
    $.each(heresay.options, function(option_key, option_val){
        $('#option_2').append('<option value="'+option_val+'">'+option_val.replace("_"," & ") +'</option>');
    });
    
    $('#option_3').empty();
    $('#option_3').append('<option value="">--select--</option>');
    $('#option_3').append('<option value="">All</option>');
    $.each(heresay.options, function(option_key, option_val){
        $('#option_3').append('<option value="'+option_val+'">'+option_val.replace("_"," & ") +'</option>');
    });
}


heresay.dropDownChange = function(elem){ 
    var url;
 	var value = $(elem).val();
    	
	if(heresay.mode === 'sites') { 
	    url = '/api/get_by_site.php?site=' + value ; 
	}
	else {
	    url = '/api/get_by_tag.php?tag=' +  value;
	}

	heresay.current_id = parseInt($(elem).attr('data-id'));
	
	//remove all the pervious heatmaps on this 'layer' from the map
	//you cannot delete heatmaps
    if(heresay.heatmap[heresay.current_id].length > 0 ) {
    	$.each(heresay.heatmap[heresay.current_id], function(key,val){
    	    val.setMap(null);
    	});
    }	
	
	heresay.heatmap_points[heresay.current_id] = [];
	
	$('#loading').show();
   
	
	$.get(url, function(data){
         setTimeout(function(){$('#loading').hide();},2000);
	   console.log(data); 
        heresay.data_count = data['results'].length -1; 
	    $.each(data['results'],function(key, value) {
	        if (key<1000) {
	            var lat = value['lat'];
	            var lng = value['lng'];
	            heresay.heatmap_points[heresay.current_id].push(new google.maps.LatLng(lat, lng)); 
            }
            if(key == heresay.data_count){
                
            }
	    });

	    var pointArray = new google.maps.MVCArray(heresay.heatmap_points[heresay.current_id]);
        
        heresay.heatmap[heresay.current_id].push(new google.maps.visualization.HeatmapLayer({
            data: pointArray,
            dissipating: true,
            maxIntensity: 8,
            radius: 50
        }));
        
        var last_map_id = heresay.heatmap[heresay.current_id].length -1;
        
        heresay.heatmap[heresay.current_id][last_map_id].setMap(heresay.map);
        
        changeGradient(heresay.heatmap[heresay.current_id][last_map_id], heresay.current_id);
        changeRadius(heresay.heatmap[heresay.current_id][last_map_id]);
        changeOpacity(heresay.heatmap[heresay.current_id][last_map_id]); 
        
    });
}





function changeGradient(elem, id) {
   if (id == 1) {
       var gradient = [
       'rgba(225, 4, 104, 0)',
       'rgba(201, 57, 53, 1)',
       'rgba(169, 4, 255, 1)',
       'rgba(255,255,255, 1)'
       ];
   }
   
   else if (id == 2) { 
       var  gradient = [
       'rgba(0,0,0, 0)', 
       'rgba(0, 0, 0, 1)', 
       'rgba(0,0,0, 1)',
       'rgba(255,255,255, 1)'

       ];
   }
   
   else if (id == 3) { 
       var  gradient = [
       'rgba(0, 0, 191, 0)',
       'rgba(4, 87, 255, 1)',
       'rgba(4, 255, 199, 1)',
       'rgba(255,255,255, 1)'
       ];
   }
   
   else if (id == 4) { 
       var  gradient = [
       'rgba(255, 150, 150, 0.0)',
       'rgba(255, 150, 150, 1)',
       'rgba(255, 150, 150, 1)',
       'rgba(255, 150, 150, 1)',
        'rgba(255, 150, 150, 1)',
       'rgba(255, 100, 100, 1)',
       'rgba(255, 0, 0, 1)',
       'rgba(255, 0, 0, 1)',
       'rgba(255, 0, 0, 1)',
       'rgba(255,255,255, 1)'
       ];
       

   }

   
   elem.setOptions({
       gradient: gradient
   });
}

function changeRadius(elem) {
   elem.setOptions({radius: 30});
}

function changeOpacity(elem) {
   elem.setOptions({opacity: 0.7});
}


function gup( name ){
   name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");  
   var regexS = "[\\?&]"+name+"=([^&#]*)";  
   var regex = new RegExp( regexS );  
   var results = regex.exec( window.location.href ); 
   if( results == null )  {  return "";}  
   else    {return results[1];}
}

heresay.draw_brockley = function(){ 

console.log('draw fun');
	heresay.data_count = brockley_central.length -1;
	heresay.current_id = 4; 
	$.each(brockley_central,function(key, value) {
console.log(value);

console.log('hi');

		if (key<1000) {
			var lat = value['lat'];
			var lng = value['lng'];
			heresay.heatmap_points[heresay.current_id].push(new google.maps.LatLng(lat, lng));
		}
		if(key == heresay.data_count){

		}
	});

	var pointArray = new google.maps.MVCArray(heresay.heatmap_points[heresay.current_id]);

	heresay.heatmap[heresay.current_id].push(new google.maps.visualization.HeatmapLayer({
		data: pointArray,
		dissipating: true,
		maxIntensity: 8,
		radius: 50
	}));


	var last_map_id = heresay.heatmap[heresay.current_id].length -1;

	heresay.heatmap[heresay.current_id][last_map_id].setMap(heresay.map);

	changeGradient(heresay.heatmap[heresay.current_id][last_map_id], heresay.current_id);
	heresay.heatmap[heresay.current_id][last_map_id].setOptions({radius: 30})

	changeOpacity(heresay.heatmap[heresay.current_id][last_map_id]);
}
