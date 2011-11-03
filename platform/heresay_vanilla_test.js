
//give a scope to all the code 
var heresay = {};
heresay.validation = {};

//the api url
heresay.baseURL = 'http://test.heresay.org.uk'; // don't forget that the iframe location needs to change 

//this is the location the pop up map centres on by default 
heresay.homeCoords = '51.573102,-0.112888';
heresay.lat = 51.573102;
heresay.lng = -0.112888;


//init function triggers icon adding
heresay.init = function () {
	
	//put a link in the right hand column
	heresay.addPanelLink(); 
	
	//this for forum posts 
	if (jQuery('.DiscussionTabs').length > 0) {
		
		//remove any existing badges
		jQuery('.heresay_icon').remove();
				
	    jQuery('.DiscussionTabs').each(function(index) {
			heresay.processPost(index, this);
	    });
	}
	
	//this for posts as they are created 
	if (jQuery('#DiscussionForm').length > 0) { 
		heresay.addDiscussionLoction(); 
	}
	
	//this for the forum homepage - adding a map 
	heresay.addIndexMap();
	
	//re-init after every ajax update
	jQuery('#Form_PostComment').click(function() {
	    setTimeout(heresay.init(), 1250);
	});
};

//********************************* THIS TO ADD A MAP TO THE PAGE WHERE YOU CREATE A POST 

 
heresay.addDiscussionLoction = function () {
	
	heresay.location_touch = 0; 

	var locationHTML = "<div style='margin:10px'>"+
		"<label for='location_possible' margin-bottom:5px;>This post is about a specific location</label>"+
		"<input type='checkbox' checked='checked' id='location_possible' />"+
		"<div id='toggle_content'><label for='location_name'>How would you refer to this location?</label>"+
		"<input type='text' id='location_name' style='margin-left:5px;'/>"+
		'<br/><p>Now drag the red marker to the location you want to refer to</p>'+
		'<div id="map_canvas" style="width:700px; height:325px; margin-top:20px"></div>'+
		'</div>';
	
	//add the map canvas element 
	jQuery('#Form_Body').after(locationHTML); 

	//load the map into it's div 
    var myOptions = {
      zoom: 14,
      center: new google.maps.LatLng(heresay.lat, heresay.lng),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };

	heresay.map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	
	var marker_position = new google.maps.LatLng(heresay.lat, heresay.lng);
	heresay.marker = new google.maps.Marker({
		map:heresay.map,
		draggable:true,
		animation: google.maps.Animation.DROP,
		position: marker_position
	});
	

	//make the submit button save to our database 
	jQuery('#Form_PostDiscussion').click(function(){
		heresay.saveAddDiscussionLoction(); 
	});

	//hide or show the map depending on the status of the check box 
	jQuery('#location_possible').click(function() {
		jQuery('#toggle_content').toggle(); 
		jQuery('.geo_hide').toggle();		
	});

};


heresay.saveAddDiscussionLoction = function() {
	var data;
	var no_specific_location; 
	var title = escape(jQuery('#Form_Name').val());
	var body = jQuery('#Form_Body').val();
	
	if (!jQuery('#location_possible').attr('checked')) { 
		no_specific_location = 1; 
	}
	
	else {
		no_specific_location = 0; 	
	}

	var save_marker_position = heresay.marker.getPosition();
	var date = new Date();

	data = 'domain_name='+document.domain; 
	//data += '&path=/forum/topics/'+jQuery('#url').val(); ;
	data += '&sub_page_id=0';
	data += '&lat='+save_marker_position.lat(); 
	data += '&lng='+save_marker_position.lng();
	data += '&location_name='+ jQuery('#location_name').val();
	data += '&thread_date='+ parseInt(date.getTime()/1000, 10);
	data += '&type='+escape(jQuery("#Form_CategoryID option:selected").text());
	data += '&body='+body;
	data += '&title='+title;
	data += '&no_specific_location='+no_specific_location;
	
	// instead of saving this on the fly, submit it a cookie which can save on the next page load 
	heresay.setCookie('heresay_data', data, 30, '/', '', '' );
	window.onbeforeunload ='';
	jQuery('#add_topic_form').submit();
};

//********************************* THIS FOR ADDING AN IFRAME MAP TO A USEFUL PAGE 
heresay.addIndexMap = function() {
	var mapHtml = '<iframe style="width:680px; height:520px" src="'+heresay.baseURL+'/api/iframe.php?center='+heresay.homeCoords+'&zoom=13&domain_name='+window.location.hostname+'" id="forum_iframe" scrolling="no" frameborder="no" >';
	jQuery('#heresay_map').html(mapHtml);
};


//********************************* THIS FOR ADDING A LINK TO THE RIGHT HAND COLUMN 

heresay.addPanelLink = function() {
	//only display on non-heresay pages 
	if (jQuery('#heresay_map').length === 0 && jQuery('#heresay_link').length) {   
		var html = '<div id="heresay_link" class="category"><div id="inner">'+
		'<div id="image" style="width:90px; float:left;"><a href="/forum/plugin/page/heresay"><img border="0" src="http://heresay.org.uk/platform/images/vanilla_logo.png"></a></div>'+
		'<div id="text" style="width:143px; float:right;"><h1><a href="/forum/plugin/page/heresay">Heresay</a></h1>'+
		'<p>View discussions by location</p>'+
		'</div></div><br style="clear:both; margin-bottom:10px;" />'; 

		jQuery('#Panel').prepend(html); 
	}
}

//********************************* THESE FUNCTIONS FOR ADDING LOCATIONS TO AFTER CREATION

//process every part of the page which needs a location button adding 
heresay.processPost = function(index, element) {
	
	var sub_page_id;
	var query_url;
	
    //only add the locate button to posts and replies, but not replies to replies and further down
	//if (jQuery(element).parent().hasClass('i0') || jQuery(element).parent().parent().hasClass('xg_headline')) {
			
        heresay.sub_page_id = 0;

        query_url = heresay.baseURL+"/api/find_threads.php?domain_name=" + document.domain + "&path=" + location.pathname + "&sub_page_id=" + heresay.sub_page_id + "&callback=?";
		
        jQuery.getJSON(query_url,
        function(data) {
            heresay.insertIcon(data, index);
        });
    //}	
};

//adds the map icon
heresay.insertIcon = function(data, index) {
		
	//hack to put this against the first topic only
	if (index === 0 ) {
	    var icon_style = 'float:right; cursor:pointer; margin-left:10px; margin-top:6px ';
	    var icon_text_style = 'margin-left:74px; margin-top:-26px; font-size:12px;';
	
		// test to see if post has been located 
	    if (data[0] === 'no results found') {
	        jQuery('.DiscussionTabs').eq(index).prepend("<div class='heresay_icon' style='" + icon_style + "' ><img src='"+heresay.baseURL+"/platform/images/heresay_button.png' class='garden_fence_icon' /></div>");
	    }
	
		else if (data[0].no_specific_location === "1") {
	        jQuery('.DiscussionTabs').eq(index).prepend("<div class='heresay_icon' style='" + icon_style + "' ><img src='"+heresay.baseURL+"/platform/images/no_specific_button.png' class='garden_fence_icon' /></div>");			
		}

	    else {
	        jQuery('.DiscussionTabs').eq(index).prepend("<div class='heresay_icon' style='" + icon_style + "'  ><img src='"+heresay.baseURL+"/platform/images/heresay_location_button.png' class='garden_fence_icon' /><p style='" + icon_text_style + "' >" + data[0].location_name + "</p></div>");
	    }

	    // attach a click handler to each of the buttons
	    jQuery('.DiscussionTabs').eq(index).children('.heresay_icon').click(function() {
	        heresay.clickIcon(this, index);
	    });
	}
};

//opens the modal window
heresay.clickIcon = function(element, index) {

    //only add the map if it isn't already there
    if ((jQuery('#garden_fence_modal').length > 0) === false)
    {

        var title = escape(jQuery('.DiscussionTabs .SubTab').html());
		var bodytext = escape(jQuery('.FirstComment .Message').html());

        var domain = escape(document.domain);
        var thread_date = jQuery('.DateCreated').html();
        thread_date = escape(thread_date[0]);

        var homeurl = location.pathname;
		
		//this to work out what the category of the post is 
		var category = jQuery('.DiscussionTabs li a').html();

		if (category === null) {category ='none';}

        var sub_page_id = '0';

		var close_button_style = "font-size: 16px; left: 328px; position: absolute; top: 462px; width:100px; z-index: 15; height:26px;"; 

        //add the modal window
        jQuery('body').append("<div id='garden_fence_modal' style='background-image: url("+heresay.baseURL+"/platform/images/modal_background.png);background-repeat:none; z-index:5;'><p><a id='garden_fence_close' style='float:right; z-index:20' href='#'><img src='"+heresay.baseURL+"/platform/images/cross.png' style='margin-right:20px; margin-top:20px; ' /> </a></p>	<iframe id='map_iframe' src='"+heresay.baseURL+"/platform/iframe_test.html?title=" + title + "&body_text=" + bodytext + "&home_url=" + homeurl + "&domain=" + domain + "&thread_date=" + thread_date + "&sub_page_id=" + sub_page_id +"&type="+category+"&center="+heresay.homeCoords+"' frameborder='0' scrolling='vertical' style='height:485px; width:530px; margin: -10px 20px 0px 20px; z-index:10' ></iframe><input type='button' value='close' id='close_button_overlay' style='"+close_button_style+"' />  </div>");
		
		jQuery('#close_button_overlay').click(function() {
			heresay.closeModal();
		});
		
        //make it the right size
        jQuery('#garden_fence_modal').css({
            'width': '600px',
            'height': '530px'
        });

        //display the box
        heresay.displayBox();
    }

    //bind close action to cross
    jQuery('#garden_fence_close').unbind('click').click(function() {
		heresay.closeModal();
    });
};

heresay.closeModal = function() {
	jQuery('#garden_fence_modal').remove();
    heresay.init(); 
};

heresay.findSubPageId = function(element) {

    //find the sub page id
    var sub_page_id;

    if (jQuery(element).parent().parent().parent().hasClass('xg_headline')) {
        sub_page_id = 0;
    }

    else {
        sub_page_id = jQuery(element).siblings('a').eq(0).attr('id');
        sub_page_id = sub_page_id.split(':');
        sub_page_id = sub_page_id[2];
    }

    return sub_page_id;
};



//-------------------- Couple of generic functions here 

// generic modal window function
heresay.displayBox = function ()
 {
    jQuery.fn.center = function(absolute) {
        return this.each(function() {
            var t = jQuery(this);

            t.css({
                position: absolute ? 'absolute': 'fixed',
                left: '50%',
                top: '50%',
                zIndex: '200'
            }).css({
                marginLeft: '-' + (t.outerWidth() / 2) + 'px',
                marginTop: '-' + (t.outerHeight() / 2) + 'px'
            });

            if (absolute) {
                t.css({
                    marginTop: parseInt(t.css('marginTop'), 10) + jQuery(window).scrollTop(),
                    marginLeft: parseInt(t.css('marginLeft'), 10) + jQuery(window).scrollLeft()
                });
            }
        });
    };

    jQuery('#garden_fence_modal').center();
};


jQuery(document).ready(function() {
	
	//exclude old IE 
	var version = heresay.getInternetExplorerVersion();
	
	if (version === -1 || version >= 8) {
		
		//first, check, is there any cookie data that needs to go in the db?
		var cookie_write_data = heresay.getCookie('heresay_data');
	
		if (cookie_write_data !== null && cookie_write_data !== 'no_write') {

			cookie_write_data += "&path="+window.location.pathname;

			jQuery.getJSON(heresay.baseURL + "/api/write_comment.php?" + cookie_write_data + "&callback=?", function () {
				heresay.setCookie('heresay_data', 'no_write', 30, '/', '', '');
				heresay.init();
			}).error(function () {
				heresay.setCookie('heresay_data', 'no_write', 30, '/', '', '');
				heresay.init();
			});
		
		}
		//no data needs writing 
		else {
			
			heresay.init();
			
			//init if the cookie has been set and if this is not a blog post preview 
			/* cookie stuff... 
			if (heresay.getCookie('heresay_harringay') === 'yes' && window.location.pathname !== '/profiles/blog/create') {
				heresay.init();
			}

			if (heresay.getCookie('heresay_harringay') === undefined) {
				heresay.setCookie('heresay_harringay', 'no', 30, '/', '', '' );
			}
			

			//put a control in for adding a cookie
			var path_array;
			path_array = location.pathname.split('/');

			if (jQuery('.xg_sprite-setting').length > 0 && path_array[1] === "profile") {
				heresay.addCookieSettings();
			}
			
			*/
		}
	}	

});

heresay.addCookieSettings = function() {
	
	var yes_state ='';
	var no_state ='';

	if (heresay.getCookie('heresay_harringay') === 'yes') {yes_state ='checked="checked"';}

	else {no_state ='checked="checked"';}

	var html = '<div class="xj_sidebar_content"><div class="xg_module"> ';
	html += '<div class="xg_module_head" >Heresay Mapping Plugin </div>';
	html += '<div class="xg_module_body"><ul class="nobullets">';
	html += '<li style="margin-bottom:6px"><label><input id="heresayOn" type="radio" class="radio heresaybtn" name="heresaySetting" value="On" '+yes_state+' />On</label></li>';
	html += '<li><label><input id="heresayOff" type="radio" class="radio heresaybtn" name="heresaySetting" value="Off" '+no_state+' />Off</label></li>';
	html += '</ul>';
	html += '</div>';
	html += '</div></div>';

	jQuery('#xg_module_account').after(html); 

	jQuery('.heresaybtn').click(function(){
		if (jQuery('input:radio[name=heresaySetting]:checked').val() === 'On') {
			heresay.setCookie('heresay_harringay', 'yes', 30, '/', '', '');
			alert('Heresay is now turned on');	
		}

		else {
			heresay.setCookie('heresay_harringay', 'no', 30, '/', '', '');
			alert('Heresay is switched off');	
		}	 
	});
};


heresay.getCookie = function( check_name ) {
	// first we'll split this cookie up into name/value pairs
	// note: document.cookie only returns name=value, not the other components
	var a_all_cookies = document.cookie.split( ';' );
	var a_temp_cookie = '';
	var cookie_name = '';
	var cookie_value = '';
	var b_cookie_found = false; // set boolean t/f default f
	var i; 
	
	for ( i = 0; i < a_all_cookies.length; i++ )
	{
		// now we'll split apart each name=value pair
		a_temp_cookie = a_all_cookies[i].split( '=' );


		// and trim left/right whitespace while we're at it
		cookie_name = a_temp_cookie[0].replace(/^\s+|\s+$/g, '');

		// if the extracted name matches passed check_name
		if ( cookie_name === check_name )
		{
			b_cookie_found = true;
			// we need to handle case where cookie has no value but exists (no = sign, that is):
			if ( a_temp_cookie.length > 1 )
			{
				cookie_value = unescape( a_temp_cookie[1].replace(/^\s+|\s+$/g, '') );
			}
			// note that in cases where cookie is initialized but no value, null is returned
			return cookie_value;
			//break;
		}
		a_temp_cookie = null;
		cookie_name = '';
	}
	if ( !b_cookie_found )
	{
		return null;
	}
};
	
heresay.setCookie = function(name, value, expires, path, domain, secure )
{
	// set time, it's in milliseconds
	var today = new Date();
	today.setTime( today.getTime() );

/*
	if the expires variable is set, make the correct
	expires time, the current script below will set
	it for x number of days, to make it for hours,
	delete * 24, for minutes, delete * 60 * 24
*/
	if ( expires )
	{
	expires = expires * 1000 * 60 * 60 * 24;
	}
	var expires_date = new Date( today.getTime() + (expires) );

	document.cookie = name + "=" +escape( value ) +
	( ( expires ) ? ";expires=" + expires_date.toGMTString() : "" ) +
	( ( path ) ? ";path=" + path : "" ) +
	( ( domain ) ? ";domain=" + domain : "" ) +
	( ( secure ) ? ";secure" : "" );
};



heresay.getInternetExplorerVersion = function ()
// Returns the version of Internet Explorer or a -1
// (indicating the use of another browser).
{
	var rv = -1; // Return value assumes failure.
	if (navigator.appName === 'Microsoft Internet Explorer')
	{
		var ua = navigator.userAgent;
		var re  = new RegExp("MSIE ([0-9]{1,}[.\0-9]{0,})");
		if (re.exec(ua) !== null) {
			rv = parseFloat( RegExp.$1 );
		}
	}
  return rv;
};




