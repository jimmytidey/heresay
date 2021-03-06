
//give a scope to all the code 
var heresay = {};
heresay.validation = {};

//the api url
heresay.baseURL = 'http://heresay.org.uk'; // don't forget that the iframe location needs to change 

//this is the location the pop up map centres on by default 
heresay.homeCoords = '51.577629,-0.091721';
heresay.lat = 51.577629;
heresay.lng = -0.091721;


//init function triggers icon adding
heresay.init = function () {

	//this for forum posts 
	if (jQuery('.byline').length > 0) {
		
		//remove any existing badges
		jQuery('.heresay_icon').remove();
				
		//sort out some balls display stuff
		jQuery('.byline').css('display', 'block');
	
	    jQuery('.byline').each(function(index) {
			heresay.processPost(index, this);
	    });
	}
	
	//this for posts as they are created 
	if (jQuery('input[value="Add Discussion"]').length > 0) { 
		heresay.addDiscussionLoction(); 
	}
	
	//this for the forum homepage - adding a map 
	if (location.pathname === '/forum') {
		heresay.addIndexMap(); 
	}
	
	//re-init after every ajax update
	jQuery('#Form_PostComment').click(function() {
	    setTimeout(heresay.init(), 1250);
	});
};

//********************************* THIS TO ADD A MAP TO THE PAGE WHERE YOU CREATE A POST 

 
heresay.addDiscussionLoction = function () {
	
	heresay.location_touch = 0; 

	heresay.locationHTML = "<p style='position:relative; top:22px'>Location:</p>"+
	"<div style='position:relative; left:120px; margin-bottom:20px'>" +
		"<p><label for='location_possible'>This post is about a specific location</label>"+
		"<input type='checkbox' checked='checked' id='location_possible' /></p>"+
		"<div id='toggle_content'><label for='location_name'>How would you refer to this location?</label>"+
		"<input type='text' id='location_name' />";
		
	var mapHtml = '<br/><p>Now drag the red marker to the location you want to refer to</p>';
	mapHtml += '<div id="map_canvas" style="width:610px; height:325px; margin-top:20px"></div></div>';
	
	var selectHtml = "<br/><!--<label for='type' >Categories:</label><select id='type' style='margin-left:40px'>";
	
	selectHtml += "<option value='select'>-select category-</option>";
	selectHtml += "<option value='Local shops and cafes'>Local shops and cafes</option>";
	selectHtml += "<option value='Crime'>Crime</option>";
	selectHtml += "<option value='Planning'>Planning</option>";
	selectHtml += "<option value='Local Policy'>Council / public policy</option>";
	selectHtml += "<option value='Events'>Events</option>";
	selectHtml += "<option value='Travel'>Travel</option>";
	selectHtml += "<option value='Item or service'>Item or service</option>";
	selectHtml += "<option value='No Category'>No Category</option>";

	selectHtml += "</select>--></div>";
	
	//add the map canvas element 
	jQuery('#xj_post_dd').after(heresay.locationHTML+mapHtml+selectHtml); 


	
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
	
	//Stop the form from submitting when the user clicks the add button
	//for some reason you cannot change the type of an element once it is in the DOM 
	jQuery('input[value="Add Discussion"]').remove(); 
	jQuery('.xj_preview_button').before('<input type="button" class="button" id="heresay_submit" value="Add Discussion" />');
	
	jQuery('#heresay_submit').unbind('click');
		
	//make the submit button save to our database 
	jQuery('#heresay_submit').click(function(){
		heresay.saveAddDiscussionLoction(); 
	});
	
	//keep monitoring the validation status
	heresay.drawValidation();
	
	//hide or show the map depending on the status of the check box 
	jQuery('#location_possible').click(function() {
		jQuery('#toggle_content').toggle(); 
		jQuery('.geo_hide').toggle();		
	});

};

heresay.drawValidation = function() {
	var validationHTML = '<div id="heresay_validation" style ="margin-left:120px; font-size:14px">';
	validationHTML += '<p><strong>Before you add.</strong> The more information you provide the more feedback you are likely to get.</p>'; 
	validationHTML += "<ul id='progress_indicator' style='list-style-type:none' >";
	validationHTML += "<li><img id='title_status' class='validation_status'  >Give your post a title (required)</li>";
	validationHTML += "<li><img id='body_status' class='validation_status'  >Explain what your post is about (required)</li>";
	validationHTML += "<li class='geo_hide'><img id='location_status' class='validation_status'  />Indicate a location on map</li>";
	validationHTML += "<li class='geo_hide'><img id='location_name_status' class='validation_status'  />Name the location (eg. 'Red Lion Pub', 'Church Street', 'Fountain in the park')</li>";
	validationHTML += "<li><img id='category_status' class='validation_status'  >Choose a category</li>";
	validationHTML += "<li><img id='tag_status' class='validation_status'  >Tag the post (eg 'child care' or 'police')</li>";		
	validationHTML += "</ul>";
	validationHTML += "<div id='progress_bar' style='width:200px; height:20px; border: 1px solid black' ><div id='progress_bar_fill' style='background-color:red; width:0px; height:20px'></div></div>";
	validationHTML += "<span id='percent_complete' style='position:relative; top:0px; right:21s0px;'>0%</span>";
	validationHTML += "</div>";
	jQuery('.buttongroup').before(validationHTML);
	jQuery('.validation_tick').hide();
	
	//so that validation makes sense, need to add a null category to the select drop down 
	if (jQuery('#category').attr('type') !== 'hidden' ) { 
		jQuery('#category').prepend('<option val="default">---Select ---</option>');
		jQuery('#category').val('default');
	}	
	
	//update the validation as soon as anyone hits the page
	heresay.validation.showCross('.validation_status');
	jQuery('li img').css('margin-right', '10px');
	
	//remove bullets 
	jQuery('#heresay_validation li').css('list-style-type', 'none');
	
	heresay.validation.update();			
};


heresay.validation.update = function() {
	
	heresay.validation.progress_bar = 0; 
	
	jQuery("#title").keyup(function() {	
		if (jQuery('#title').val() !== '') {heresay.validation.showTick('#title_status');}
		else {heresay.validation.showCross('#title_status');}
		heresay.validation.progress_bar +=1;
		heresay.validation.progressBarDraw();  
	});
	
	//can't detect clicks inside the iFrame
	setInterval( function() {
		//if it's a forum post 
		var bodyText = jQuery('#post_ifr').contents().find('body').html();
		//if it's an blog post
		if (bodyText === null) {bodyText = jQuery('#post_body_ifr').contents().find('body').html();}
		//if it's an event
		if (bodyText === null) {bodyText = jQuery('#description_ifr').contents().find('body').html();}
		
		if (bodyText !== '<br _mce_bogus="1">' && bodyText !== '' ){heresay.validation.showTick('#body_status');}
		else {heresay.validation.showCross('#body_status');}
		heresay.validation.progressBarDraw();
	}
	,2000);
	
	jQuery("#location_name").keyup(function() {
		if (jQuery('#location_name').val() !== '') {heresay.validation.showTick('#location_name_status');}
		else {heresay.validation.showCross('#location_name_status');}
		heresay.validation.progressBarDraw();
	});
	
	//check the map marker has moved 
	google.maps.event.addListener(heresay.marker, 'mouseup', function() {
		heresay.validation.showTick('#location_status');
		heresay.validation.progressBarDraw();
	});

	jQuery("#category").change(function() {
		
		var category = jQuery('#category').val();
		
		if (category !== '---Select ---') {heresay.validation.showTick('#category_status');}
		else {heresay.validation.showCross('#category_status');}
		
		/*
		//also add the category to the tags... 
		var current_tags = jQuery('#tags').val();
		
		jQuery('#tags').val(category + ", " + current_tags );
		*/
		
		heresay.validation.progressBarDraw();
	});	
	
	
	jQuery("#tags").keyup(function() {
		if (jQuery('#tags').val() !== '') {heresay.validation.showTick('#tag_status');}
		else {heresay.validation.showCross('#tag_status');}
		heresay.validation.progressBarDraw();
	});
	
};

heresay.validation.showTick = function(selector) {
	var src = heresay.baseURL+"/images/tick.jpg";
	jQuery(selector).attr('src', src);
	jQuery(selector).attr('class', 'tick');
};

heresay.validation.showCross = function(selector) {
	var src = heresay.baseURL+"/images/cross.jpg";
	jQuery(selector).attr('src', src); 
	jQuery(selector).attr('class', 'cross');	 
};

heresay.validation.progressBarDraw = function () {
	var bar_status = jQuery('.tick').length;
	
	//this because user is nearer to completing the process if they have chosen not to give location
	if (jQuery('#location_possible').attr('checked')) {
		bar_status = bar_status * 16.66666;
	}
	
	else {
		bar_status = jQuery('.tick').length * 25;
	}
	
	//make sure it looks properly like 100%
	if (bar_status > 96) {bar_status = 100;}
	
	//colour it in nicely to encourage people 
	if (bar_status > 30) {jQuery('#progress_bar_fill').css('background-color', '#ffff00');}
	if (bar_status > 70) {jQuery('#progress_bar_fill').css('background-color', '#3eda1f');}
		
	jQuery('#progress_bar_fill').css('width', bar_status * 2 );
	jQuery('#percent_complete').html(Math.floor(bar_status)+'%'); 
};

heresay.saveAddDiscussionLoction = function() {
		
	var data;
	var no_specific_location; 
	var title = escape(jQuery('#title').val());
	var body = jQuery('#post_ifr').contents().find('body').html();
	body = escape(body.replace('<br _mce_bogus="1">', ""));
	
	if (title === "") {alert("You must enter a title for this discussion");}
	
	else if (body === "") {alert("You must add some text to this discussion");}
	
	else if (jQuery('#location_possible').attr('checked') && jQuery('#location_name').val() === "") { 
		alert("You must name the location, or uncheck the 'This post is about a specific location' box.");
	}
	
	else if (jQuery('#location_possible').attr('checked') && jQuery('#location_status').attr('class') !== "tick") {
		alert("You indicate the location on the map, or uncheck the 'This post is about a specific location' box.");
	}
	
	else {
		
		if (jQuery('#location_possible').attr('checked')) {no_specific_location = 0;}
		else {no_specific_location = 1;}
	
		var save_marker_position = heresay.marker.getPosition();
		var date = new Date();
	
		data = 'domain_name='+document.domain; 
		//data += '&path=/forum/topics/'+jQuery('#url').val(); ;
		data += '&sub_page_id=0';
		data += '&lat='+save_marker_position.lat(); 
		data += '&lng='+save_marker_position.lng();
		data += '&location_name='+ jQuery('#location_name').val();
		data += '&thread_date='+ parseInt(date.getTime()/1000, 10);
		data += '&type='+escape(jQuery("#category option:selected").text());
		data += '&body='+body;
		data += '&title='+title;
		data += '&no_specific_location='+no_specific_location;
		
		// instead of saving this on the fly, submit it a cookie which can save on the next page load 
		heresay.setCookie('heresay_data', data, 30, '/', '', '' );
		window.onbeforeunload ='';
		jQuery('#add_topic_form').submit();
		 
		/*
		//have to do this as a jsonp request
			url =  heresay.baseURL+"/api/write_comment.php?";
			jQuery.getJSON(url+data+"&callback=?", function(data) {
			//bet this doesn't work cross browser 
			window.onbeforeunload ='';
			jQuery('#add_topic_form').submit();
		});
		*/
		
	}
};

//********************************* THIS FOR ADDING AN IFRAME MAP TO A USEFUL PAGE 
heresay.addIndexMap = function() {
	var mapHtml = '<iframe style="width:735px; height:320px" src="'+heresay.baseURL+'/api/iframe.php?center='+heresay.homeCoords+'&zoom=13&domain_name='+window.location.hostname+'" id="forum_iframe" scrolling="no" frameborder="no" >';
	jQuery('.categories').before(mapHtml);
};

//********************************* THESE FUNCTIONS FOR ADDING LOCATIONS TO AFTER CREATION

//process every part of the page which needs a location button adding 
heresay.processPost = function(index, element) {
	
	var sub_page_id;
	var query_url;
	
    //only add the locate button to posts and replies, but not replies to replies and further down
	//if (jQuery(element).parent().hasClass('i0') || jQuery(element).parent().parent().hasClass('xg_headline')) {
			
        if (jQuery(element).hasClass("navigation")) {heresay.sub_page_id = 0;}

        else {
            sub_page_id = jQuery('a:first-child', element).attr('id').split(':');
            heresay.sub_page_id = sub_page_id[2];
        }

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
	    var icon_style = 'float:right; cursor:pointer; margin-left:3px; ';
	    var icon_text_style = 'margin-left:72px; margin-top:-22px; font-size:12px;';
	
		// test to see if post has been located 
	    if (data[0] === 'no results found') {
	        jQuery('.byline').eq(index).prepend("<div class='heresay_icon' style='" + icon_style + "' ><img src='"+heresay.baseURL+"/platform/images/heresay_button.png' class='garden_fence_icon' /></div>");
	    }
	
		else if (data[0].no_specific_location === "1") {
	        jQuery('.byline').eq(index).prepend("<div class='heresay_icon' style='" + icon_style + "' ><img src='"+heresay.baseURL+"/platform/images/no_specific_button.png' class='garden_fence_icon' /></div>");			
		}

	    else {
	        jQuery('.byline').eq(index).prepend("<div class='heresay_icon' style='" + icon_style + "'  ><img src='"+heresay.baseURL+"/platform/images/heresay_location_button.png' class='garden_fence_icon' /><p style='" + icon_text_style + "' >" + data[0].location_name + "</p></div>");
	    }

	    // attach a click handler to each of the buttons
	    jQuery('.byline').eq(index).children('.heresay_icon').click(function() {
	        heresay.clickIcon(this, index);
	    });
	}
};

//opens the modal window
heresay.clickIcon = function(element, index) {

    //only add the map if it isn't already there
    if ((jQuery('#garden_fence_modal').length > 0) === false)
    {

        var title = escape(jQuery(".tb h1").html());
		var bodytext = escape(jQuery('.xg_user_generated').eq(index).html());

        var domain = escape(document.domain);
        var thread_date = jQuery('.navigation li a').eq(5).html().replace('on').split('at');
        thread_date = escape(thread_date[0]);

        var homeurl = location.pathname;
		
		//this to work out what the category of the post is 
		var category; 
		var location_array = window.location.pathname.split('/'); 
		if (location_array[1] === 'events') {category = 'Events';}
		if (location_array[2] === 'events') {category = 'blog';}
		
		//this to extract the category from the post  
		else { 
			var category_link;
			category = jQuery('.byline a').eq(3).html();
			category_link = jQuery('.byline a').eq(3).attr('href');
			if (category_link !== undefined) {
			    category_link = category_link.split('/'); 
			    if (jQuery.inArray('category', category_link > -1)) {
			        category = escape(category.replace('&amp;', '&')); 
			    }
			}
		}
		
		if (category === null) {category ='none';}
		

        var sub_page_id = heresay.findSubPageId(element);
		var close_button_style = "font-size: 16px; left: 328px; position: absolute; top: 462px; width:100px; z-index: 15; height:26px;"; 

        //add the modal window
        jQuery('body').append("<div id='garden_fence_modal' style='background-image: url("+heresay.baseURL+"/platform/images/modal_background.png);background-repeat:none; z-index:5;'><p><a id='garden_fence_close' style='float:right; z-index:20' href='#'><img src='"+heresay.baseURL+"/platform/images/cross.png' style='margin-right:20px; margin-top:20px; ' /> </a></p>	<iframe id='map_iframe' src='"+heresay.baseURL+"/platform/iframe.html?title=" + title + "&body_text=" + bodytext + "&home_url=" + homeurl + "&domain=" + domain + "&thread_date=" + thread_date + "&sub_page_id=" + sub_page_id +"&type="+category+"&center="+heresay.homeCoords+"' frameborder='0' scrolling='vertical' style='height:485px; width:530px; margin: -10px 20px 0px 20px; z-index:10' ></iframe><input type='button' value='close' id='close_button_overlay' style='"+close_button_style+"' />  </div>");
		
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

			jQuery.getJSON(heresay.baseURL + "/api/write_comment.php?" + cookie_write_data + "&callback=?", function() {
				heresay.setCookie('heresay_data', 'no_write', 30, '/', '', '');
				heresay.init();
			}).error(function() {
				heresay.setCookie('heresay_data', 'no_write', 30, '/', '', '');
				heresay.init();
			});
		
		}
		//no data needs writing 
		else {
			
			//init if the cookie has been set and if this is not a blog post preview 
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




