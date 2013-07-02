$(document).ready(function(){ 

    $('.map').each(function(){
        
        var lat     = $(this).attr('data-lat');
        var lng     = $(this).attr('data-lng');
        var zoom    = parseInt($(this).attr('data-zoom'));
        
        var center  = new google.maps.LatLng(lat, lng);
        
    	var myOptions = {
    		zoom: zoom,
    		center: center,
    		mapTypeId: google.maps.MapTypeId.ROADMAP
    	};

    	var map = new google.maps.Map($(this)[0], myOptions); 
    	
    	new google.maps.Marker({
		    position: center, 
		    map: map,
		    draggable:false,
		    icon: '/img/marker.png'
		});   
    });
});