heresay = {}; 
heresay.tagFilterState = [];

heresay.locationFilterLat= 'none';
heresay.locationFilterLng= 'none';
heresay.borough ='Default';

heresay.locations =  {
    'Hackney Borough Council': {lat:51.54420497912117, lng:-0.054214999999999236},
    'City of London Corporation': {lat: 51.528868434293244, lng:-0.10179429999993772},
    'Westminster City Council': {lat:51.5123061975624, lng:-0.16359510000006594},
    'Kensington and Chelsea Borough Council': {lat:51.50379489352665, lng:-0.1893608000000313},
    'Hammersmith and Fulham Borough Council': {lat:51.498338052397315, lng:-0.21720075000007455},
    'Wandsworth Borough Council': {lat:51.45142395803735, lng:-0.1927382999999736},
    'Camden Borough Council': {lat:51.5428253969205, lng:-0.15942554999992353}, 
    'Haringey Borough Council': {lat:51.577504834351345, lng: -0.09968294999998761},              
    'Tower Hamlets': {lat:51.51515452914685, lng:-0.034831199999985074},
    'Southwark Borough Council': {lat:51.490597908468544, lng:-0.08619304760736357},
    'Islington Borough Council': {lat:51.546506, lng:-0.105806},
    'Lambeth Borough Council': {lat:51.45967697948443, lng:-0.12342899999998735},
    Default: {lat:51.5073346, lng:-0.1276831}
};
    

$(document).ready(function(){
    
    var center = new google.maps.LatLng(heresay.defaultLat, heresay.defaultLng);
    
    var myOptions = {
		zoom: 10,
		center: center,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	
	heresay.mainMap  = new google.maps.Map($("#main_map")[0], myOptions);
	

	if ($('#site_locations').length === 1) { 
	    $.get('/api/get_sites.php', function(data){
    	    heresay.data = data;
            heresay.updateMainMap();
    	});
	}
	
	else { 
    	$.get('/api/get_recent_favourites.php', function(data){
    	    heresay.data = data;
            heresay.updateMainMap();
    	});
    }	
	
	
	var preset = getUrlVars(); 
	if (typeof preset['borough'] !== 'undefined') { 
	    heresay.search(decodeURIComponent(preset['borough']));
	}
	
    $('#seach_btn').click(function(){ 

       var search_val   =   $('#filter_by_borough').val();
       heresay.search(search_val);
    });
    
    $('#user_seach_btn').click(function(){ 

       var search_val   =   $('#user').val();
       heresay.search_by_user(search_val);
    });
});


heresay.search = function(search_val) { 
    var tags         =   $('#tags').val();

    if (search_val == '') { 
        heresay.borough = "Default";
        var url  = '/api/get_recent_updates.php?tags=' + tags;
    }
    
    else { 
        heresay.borough = search_val;
        var lat = heresay.locations[search_val].lat;
        var lng = heresay.locations[search_val].lng;
        var url  = '/api/get_recent_updates.php?borough=' + heresay.borough + '&tags=' + tags;
        
    }       
    heresay.renderData(url);
}

heresay.search_by_user = function(search_val) { 
     var url  = '/api/get_by_user.php?user=' + search_val ; 
    heresay.renderData(url);
}

heresay.renderData = function(url) { 
    $.get(url, function(data){
        $('#listing_container').html('');
        
        heresay.data = data;
        heresay.updateMainMap();
        
        $.each(data['results'], function(key, val){
          
             var html = '';
             html += "<div class='listing' >";
             html += "<h3><a target='_blank' href='" + val.link + "'>" + val.title + "</a></h3>";
             html += "<p class='site'><strong>" + val.site + "</strong></p>";
             html += "<p class='description'>" + val.description + "</p>";
             html += "<p class='location_name'>" + val.location_name + "</p>";
             if (typeof val.ward !== 'undefined') {
                 html += "<p class='ward'>Ward: <em>" + val.ward + "</em>,";  
             }
             if (typeof val.constituency !== 'undefined') {
                 html += "Constituency: <em>" + val.constituency  + "</em> </p>";
             }    
             
             //html += "<span class='tags'>" + $tag + "</span>";
             
             var myDate      = new Date(val.pubdate*1000);
             var date_string = myDate.format('M jS, Y');       
             
             $.each(val.tags, function(key, val){
                 html += '<span class="tags">' + val + '</span>';
                 
             });       
             
             html += "<p class='pubdate'>" + date_string  + "</p>";
             html += "</div>";
             

             
            $('#listing_container').append(html);
        });
    });    
}

heresay.updateMainMap = function() { 
	var location = heresay.borough; 
	
	var lat = heresay.locations[location].lat;
    var lng = heresay.locations[location].lng;
	if (location == 'Default') {
	    var zoom = 10;
	}
	else {
	    var zoom = 13;
	}
	
	var center = new google.maps.LatLng(lat, lng);
		
	var myOptions = {
		zoom: zoom,
		center: center,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	
	heresay.mainMap  = new google.maps.Map($("#main_map")[0], myOptions);
	

	heresay.mainMap.points = []; 
	heresay.mainMap.infoWindows = []; 
	heresay.mainMap.markers = [];
	

	heresay.mainMapAddMarkers(heresay.data.results);
		
}




//abstract away adding markers, needs doing a lot 
heresay.mainMapAddMarkers = function(results) { 

	heresay.mainMap.points.length = 0; 
	heresay.mainMap.infoWindows.length = 0; 
	heresay.mainMap.markers.length = 0;
	
	$.each(results, function(key,val) { 	
		heresay.mainMap.points[key] = new google.maps.LatLng(val.lat, val.lng);
		console.log(val);
        
        //if we have a site
        if (typeof val.site_id !== 'undefined')  {
            
            var contentString = "<a target='_blank' href='" + val.url + "'>"+ val.site +"</a><br/>" 
        } 
        
        //if we have an update
        else { 
    		if (val.title != null) {
    			var short_desc = val.title.substring(0, 300); 
	
    			if (short_desc.length > 199) { 
    				short_desc += "...";
    			}
    		}	
    		else { 
    			var short_desc = 'no title';
    		}
    	    var myDate      = new Date(val.pubdate*1000);
            var date_string = myDate.format('M jS, Y');
	    
    		var contentString = "<a target='_blank' href='" + val.link + "'>"+ short_desc +"</a><br/>" 
    		contentString += "<span class='tagstring'>Tags: " + heresay.tagString(val) + "</span><br/>"; 
    		contentString += date_string;
    	}	
	
		heresay.mainMap.infoWindows[key] = new google.maps.InfoWindow({
		    content: contentString,
		    maxWidth: 400
		});
	
		heresay.mainMap.markers[key] = new google.maps.Marker({
		    position: heresay.mainMap.points[key], 
		    map: heresay.mainMap,
		    draggable:false,
		    title: val.title,
		    icon: '/img/marker.png'
		});

		google.maps.event.addListener(heresay.mainMap.markers[key], 'click', function() {
		
			$.each(heresay.mainMap.infoWindows, function(key, val) { 
				val.close();
			});
		
			heresay.mainMap.infoWindows[key].open(heresay.mainMap, heresay.mainMap.markers[key]);
		});	
	});	
}



//helpers
heresay.tagString = function(val) { 

	var tags_array = [];
	if(val.category_1 != '' && val.category_1 != '--' && val.category_1 != 'undefined' && typeof val.category_1 != undefined) { 
		tags_array.push(val.category_1);
	}
	if(val.category_2 != '' && val.category_2 != '--' && val.category_2 != 'undefined' && typeof val.category_2 != undefined) { 
		tags_array.push(val.category_2);
	}
	if(val.category_3 != '' && val.category_3 != '--' && val.category_3 != 'undefined' && typeof val.category_3 != undefined) { 
		tags_array.push(val.category_3);
	}			
	if(val.category_4 != '' && val.category_4 != '--' && val.category_4 != 'undefined' && typeof val.category_4 != undefined) { 
		tags_array.push(val.category_4);
	}						
	var tags_string =  tags_array.join(', ');	
	
	return tags_string;
}



function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}



// Simulates PHP's date function
Date.prototype.format=function(e){var t="";var n=Date.replaceChars;for(var r=0;r<e.length;r++){var i=e.charAt(r);if(r-1>=0&&e.charAt(r-1)=="\\"){t+=i}else if(n[i]){t+=n[i].call(this)}else if(i!="\\"){t+=i}}return t};Date.replaceChars={shortMonths:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],longMonths:["January","February","March","April","May","June","July","August","September","October","November","December"],shortDays:["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],longDays:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],d:function(){return(this.getDate()<10?"0":"")+this.getDate()},D:function(){return Date.replaceChars.shortDays[this.getDay()]},j:function(){return this.getDate()},l:function(){return Date.replaceChars.longDays[this.getDay()]},N:function(){return this.getDay()+1},S:function(){return this.getDate()%10==1&&this.getDate()!=11?"st":this.getDate()%10==2&&this.getDate()!=12?"nd":this.getDate()%10==3&&this.getDate()!=13?"rd":"th"},w:function(){return this.getDay()},z:function(){var e=new Date(this.getFullYear(),0,1);return Math.ceil((this-e)/864e5)},W:function(){var e=new Date(this.getFullYear(),0,1);return Math.ceil(((this-e)/864e5+e.getDay()+1)/7)},F:function(){return Date.replaceChars.longMonths[this.getMonth()]},m:function(){return(this.getMonth()<9?"0":"")+(this.getMonth()+1)},M:function(){return Date.replaceChars.shortMonths[this.getMonth()]},n:function(){return this.getMonth()+1},t:function(){var e=new Date;return(new Date(e.getFullYear(),e.getMonth(),0)).getDate()},L:function(){var e=this.getFullYear();return e%400==0||e%100!=0&&e%4==0},o:function(){var e=new Date(this.valueOf());e.setDate(e.getDate()-(this.getDay()+6)%7+3);return e.getFullYear()},Y:function(){return this.getFullYear()},y:function(){return(""+this.getFullYear()).substr(2)},a:function(){return this.getHours()<12?"am":"pm"},A:function(){return this.getHours()<12?"AM":"PM"},B:function(){return Math.floor(((this.getUTCHours()+1)%24+this.getUTCMinutes()/60+this.getUTCSeconds()/3600)*1e3/24)},g:function(){return this.getHours()%12||12},G:function(){return this.getHours()},h:function(){return((this.getHours()%12||12)<10?"0":"")+(this.getHours()%12||12)},H:function(){return(this.getHours()<10?"0":"")+this.getHours()},i:function(){return(this.getMinutes()<10?"0":"")+this.getMinutes()},s:function(){return(this.getSeconds()<10?"0":"")+this.getSeconds()},u:function(){var e=this.getMilliseconds();return(e<10?"00":e<100?"0":"")+e},e:function(){return"Not Yet Supported"},I:function(){var e=null;for(var t=0;t<12;++t){var n=new Date(this.getFullYear(),t,1);var r=n.getTimezoneOffset();if(e===null)e=r;else if(r<e){e=r;break}else if(r>e)break}return this.getTimezoneOffset()==e|0},O:function(){return(-this.getTimezoneOffset()<0?"-":"+")+(Math.abs(this.getTimezoneOffset()/60)<10?"0":"")+Math.abs(this.getTimezoneOffset()/60)+"00"},P:function(){return(-this.getTimezoneOffset()<0?"-":"+")+(Math.abs(this.getTimezoneOffset()/60)<10?"0":"")+Math.abs(this.getTimezoneOffset()/60)+":00"},T:function(){var e=this.getMonth();this.setMonth(0);var t=this.toTimeString().replace(/^.+ \(?([^\)]+)\)?$/,"$1");this.setMonth(e);return t},Z:function(){return-this.getTimezoneOffset()*60},c:function(){return this.format("Y-m-d\\TH:i:sP")},r:function(){return this.toString()},U:function(){return this.getTime()/1e3}}


