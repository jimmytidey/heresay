heresay = {};
heresay.heatmap = [];  
heresay.heatmap_points = [];
 
heresay.heatmap[1] = [];
heresay.heatmap_points[1] = [];

heresay.heatmap[2] = []; 
heresay.heatmap_points[2] = [];

heresay.heatmap[3] = [];            
heresay.heatmap_points[3] = [];
heresay.options = [];


//init settings 
heresay.mode    = 'site';
heresay.lat     = 51.5073346;
heresay.lng     = -0.1276831;
heresay.zoom    = 11;

if (gup('mode') !== '') { 
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
   
});

heresay.getOptions = function() { 
    
    var url; 
    
    if(heresay.mode === 'sites') { 
        url = 'http://localhost:88/api/list_sites.php';
        
        $.get(url, function(data){
            $.each(data.results, function(key,val){
                heresay.options.push(val.site);
            });
            
            heresay.renderDropDowns();
        });
    }
    
    else { 
        url = 'http://localhost:88/api/list_tags.php';
        
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
        mapTypeId: google.maps.MapTypeId.ROADMAP
   	});   
}


heresay.renderDropDowns = function() {
    if(heresay.mode === 'sites') { 
        $('#header').prepend('<p id="filter_type">Filter by top sites</p>');
    } else { 
        $('#header').prepend('<p id="filter_type">Filter by tag</p>');
    }
    
    $('#option_1').append('<option value="">All</option>');
    $.each(heresay.options, function(option_key, option_val){
        $('#option_1').append('<option value="'+option_val+'">'+option_val+'</option>');
    });
    
    $('#option_2').append('<option value="">All</option>');
    $.each(heresay.options, function(option_key, option_val){
        $('#option_2').append('<option value="'+option_val+'">'+option_val+'</option>');
    });
    
    $('#option_3').append('<option value="">All</option>');
    $.each(heresay.options, function(option_key, option_val){
        $('#option_3').append('<option value="'+option_val+'">'+option_val+'</option>');
    });
}


heresay.dropDownChange = function(elem){ 
    var url;
 	var value = $(elem).val();
    	
	if(heresay.mode === 'sites') { 
	    url = '/api/get_by_site.php?site=' + value; 
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
	
	$.get(url, function(data){
	    
        heresay.data_count = data['results'].length -1; 
	    $.each(data['results'],function(key, value) {
	        if (key<800) {
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
       'rgba(0, 255, 255, 0)',
       'rgba(0, 255, 255, 1)',
       'rgba(0, 191, 255, 1)',
       'rgba(0, 127, 255, 1)',
       'rgba(0, 63, 255, 1)',
       'rgba(0, 0, 255, 1)',
       'rgba(0, 0, 223, 1)',
       'rgba(0, 0, 191, 1)',
       'rgba(0, 0, 159, 1)',
       'rgba(0, 0, 127, 1)',
       'rgba(63, 0, 91, 1)',
       'rgba(127, 0, 63, 1)',
       'rgba(191, 0, 31, 1)',
       'rgba(255, 0, 0, 1)'
       ];

       elem.setOptions({
           gradient: gradient
       });
   }
   
   else if (id == 2) { 
       var  gradient = [
           'rgba(169,3,41,0.0)', 
           'rgba(169,3,41,1)', 
           'rgba(242,234,4,1)', 
           'rgba(252,0,29,1)'
       
       ];

       elem.setOptions({
           gradient: gradient
       });
   }
}

function changeRadius(elem) {
   elem.setOptions({radius: 20});
}

function changeOpacity(elem) {
   elem.setOptions({opacity: 0.6});
}


function gup( name ){
   name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");  
   var regexS = "[\\?&]"+name+"=([^&#]*)";  
   var regex = new RegExp( regexS );  
   var results = regex.exec( window.location.href ); 
   if( results == null )    return "";  
   else    return results[1];
}
   