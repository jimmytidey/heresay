
//give a scope to all the code 
heresay = new Object();
heresay.validation = new Object();

//the api url
heresay.baseURL = 'http://test.heresay.org.uk'; 

//this is the location the pop up map centres on by default 
heresay.homeCoords = '51.4609323,-0.1160239';
heresay.lat = 51.4609323;
heresay.lng = -0.1160239;


//init function triggers icon adding
heresay.init = function() {

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
	if (location.pathname == '/forum') {
		heresay.addIndexMap(); 
	}
	
    //re-init after every ajax update
    jQuery('#Form_PostComment').click(function() {
        setTimeout(heresay.init(), 1250);
    });
}

//********************************* THIS TO ADD A MAP TO THE PAGE WHERE YOU CREATE A POST 

 
heresay.addDiscussionLoction = function() {
	
	heresay.location_touch = 0; 

	heresay.locationHTML = "<p style='position:relative; top:22px'>Location:</p>"+
	"<div style='position:relative; left:120px; margin-bottom:20px'>" +
		"<p><label for='location_possible'>This post is about a specific location</label>"+
		"<input type='checkbox' checked='checked' id='location_possible'></p>"+
		"<div id='toggle_content'><label for='location_name'>How would you refer to this location?</label>"+
		"<input type='text' id='location_name' />";
		
	var mapHtml = '<div id="map_canvas" style="width:610px; height:325px; margin-top:20px"></div></div>';
	
	var selectHtml = "<label for='type' >Categories:</label><select id='type' style='margin-left:40px'>";
	selectHtml += "<option value='select'>-select category-</option>";
	selectHtml += "<option value='Environment'>Environment</option>";
	selectHtml += "<option value='Crime'>Crime</option>";
	selectHtml += "<option value='Animals and Nature'>Animals and nature</option>";
	selectHtml += "<option value='Events'>Events</option>";
	selectHtml += "<option value='Travel'>Travel</option>";
	selectHtml += "<option value='Local Knowlege'>Local Knowledge</option>";
	selectHtml += "<option value='No Category'>No Category</option>";
	selectHtml += "</select></div>";
	
	//add the map canvas element 
	jQuery('#xj_post_dd').after(heresay.locationHTML+mapHtml+selectHtml); 

	//hide / show the map depending on the status of the check box 
	jQuery('#location_possible').change(function() {
		jQuery('#toggle_content').slideToggle(); 
		jQuery('.geo_hide').slideToggle();		
	});
	
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
	jQuery('input[value="Add Discussion"]').after('<input type="button" value="Add discussion" class="button action-primary">');
	jQuery('input[value="Add Discussion"]').remove(); 
	
	//make the submit button save to our database 
	jQuery('input[value="Add discussion"]').click(function(){
		heresay.saveAddDiscussionLoction(); 
	});
	
	//keep monitoring the validation status
	heresay.drawValidation();

}

heresay.drawValidation = function() {
	var validationHTML = '<div id="heresay_validation" style ="margin-left:120px; font-size:14px"><p><strong>Before you add.</strong> The more information you provide the more feedback you are likely to get.</p>'; 
	validationHTML +="<ul id='progress_indicator' ><li><img id='title_status' class='validation_status'  >Give your post a title (required)</li>";
	validationHTML +="<li><img id='body_status' class='validation_status'  >Explain what your post is about (required)</li>";
	validationHTML +="<li class='geo_hide'><img id='location_status' class='validation_status'  >Indicate a location on map</li>";
	validationHTML +="<li class='geo_hide'><img id='location_name_status' class='validation_status'  >Name the location (eg. 'Red Lion Pub', 'Church Street', 'Fountain in the park')</li>";
	validationHTML +="<li><img id='category_status' class='validation_status'  >Choose a category</li>";
	validationHTML +="<li><img id='tag_status' class='validation_status'  >Tag the post (eg 'child care' or 'police')</li>";		
	validationHTML +="</ul><div id='progress_bar' style='width:200px; height:20px; border: 1px solid black' ><div id='progress_bar_fill' style='background-color:red; width:0px; height:20px'></div></div><span id='percent_complete' style='position:relative; top:0px; right:21s0px;'>0%</span></li></div>";
	
	jQuery('.buttongroup').before(validationHTML);
	jQuery('.validation_tick').hide();
	
	//update the validation as soon as anyone hits the page
	heresay.validation.showCross('.validation_status');
	jQuery('li img').css('margin-right', '10px');
	
	//remove bullets 
	jQuery('#heresay_validation li').css('list-style-type', 'none');
	
	heresay.validation.update();			
}


heresay.validation.update = function() {
	
	heresay.validation.progress_bar = 0; 
	
	$("#title").keyup(function() {	
		if (jQuery('#title').val() != '') {heresay.validation.showTick('#title_status');}
		else {heresay.validation.showCross('#title_status');}
		heresay.validation.progress_bar +=1;
		heresay.validation.progressBarDraw();  
	});
	
	//can't detect clicks inside the iFrame
	setInterval( function() {
		var bodyText = jQuery('#post_ifr').contents().find('body').html();
		if (bodyText !== '<br _mce_bogus="1">' && bodyText !== '' ){heresay.validation.showTick('#body_status');}
		else {heresay.validation.showCross('#body_status');}
		heresay.validation.progressBarDraw(); 	
	}
	,2000);
	
	$("#location_name").keyup(function() {
		if (jQuery('#location_name').val() != '') {heresay.validation.showTick('#location_name_status');}
		else {heresay.validation.showCross('#location_name_status');}
		heresay.validation.progressBarDraw();
	});
	
	//check the map marker has moved 
	google.maps.event.addListener(heresay.marker, 'mouseup', function() {
		heresay.validation.showTick('#location_status');
		heresay.validation.progressBarDraw();		
	});

	$("#type").change(function() {
		
		var category = jQuery('#type').val();
		
		if (category !== 'select') {heresay.validation.showTick('#category_status');}
		else {heresay.validation.showCross('#category_status');}
		
		/*
		//also add the category to the tags... 
		var current_tags = jQuery('#tags').val();
		
		jQuery('#tags').val(category + ", " + current_tags );
		*/
		
		heresay.validation.progressBarDraw(); 		
	});	
	
	
	$("#tags").keyup(function() {
		if (jQuery('#tags').val() !== '') {heresay.validation.showTick('#tag_status');}
		else {heresay.validation.showCross('#tag_status');}
		heresay.validation.progressBarDraw(); 		
	});	
	
}

heresay.validation.showTick = function(selector) {
	var src = heresay.baseURL+"/images/tick.jpg";
	elem = jQuery(selector).attr('src', src);
	elem = jQuery(selector).attr('class', 'tick');
	return elem; 
}

heresay.validation.showCross = function(selector) {
	var src = heresay.baseURL+"/images/cross.jpg";
	elem = jQuery(selector).attr('src', src); 
	elem = jQuery(selector).attr('class', 'cross');	
	return elem; 
}

heresay.validation.progressBarDraw = function () {
	var bar_status = jQuery('.tick').length;
	
	//this because user is nearer to completing the process if they have chosen not to give location
	if ($('#location_possible').attr('checked')) {
		bar_status = bar_status * 16.66666;
	}
	
	else {
		bar_status = jQuery('.tick').length * 25;
	}
	
	//make sure it looks properly like 100%
	if (bar_status > 96) {bar_status = 100;}
	
	//colour it in nicely to encourage people 
	if (bar_status > 30) {jQuery('#progress_bar_fill').css('background-color', '#ffff00')};
	if (bar_status > 70) {jQuery('#progress_bar_fill').css('background-color', '#3eda1f')};
		
	jQuery('#progress_bar_fill').css('width', bar_status * 2 );
	jQuery('#percent_complete').html(Math.floor(bar_status)+'%'); 
} 

heresay.saveAddDiscussionLoction = function() {
		
	var url;
	var data;
	var no_specific_location; 
	var title = jQuery('#title').val();
	var body = jQuery('#post_ifr').contents().find('body').html();
	body = body.replace('<br _mce_bogus="1">', "");
	
	if (title == "") {alert("You must enter a title for this discussion");}
	else if (body == "") {alert("You must add some text to this discussion");}
	else if (jQuery('#location_name').val() == "") {alert("You must name the location, or uncheck the 'This post is about a specific location' box.");}
	else if (jQuery('#location_status').attr('class') == "cross") {alert("You indicate the location on the map,  or uncheck the 'This post is about a specific location' box.");}

	
	else {
		
		if ($('#location_possible').attr('checked')) {no_specific_location = 0;}
	 	else {no_specific_location = 1;}
	
		var save_marker_position = heresay.marker.getPosition();
		var date = new Date();
		url =  heresay.baseURL+"/api/write_comment.php?";
		data = 'domain_name='+document.domain; 
		data += '&path=/forum/topics/'+jQuery('#url').val(); ;
		data += '&sub_page_id=0';
		data += '&lat='+save_marker_position.lat(); 
		data += '&lng='+save_marker_position.lng();
		data += '&location_name='+ jQuery('#location_name').val();
		data += '&thread_date='+ parseInt(date.getTime()/1000);
		data += '&type=test';
		data += '&body='+body;
		data += '&title='+title;
		data += '&no_specific_location='+no_specific_location;
	
	
		//have to do this as a jsonp request 	
		jQuery.getJSON(url+data+"&callback=?", function(data) {
		   	//bet this doesn't work cross browser 
			window.onbeforeunload ='';
		 	jQuery('#add_topic_form').submit();
		});
	}
}

//********************************* THIS FOR ADDING AN IFRAME MAP TO A USEFUL PAGE 
heresay.addIndexMap = function() {
	var mapHtml = '<iframe style="width:735px; height:320px" src="http://test.heresay.org.uk/api/iframe.php?center='+heresay.homeCoords+'&zoom=15" id="forum_iframe" scrolling="no" frameborder="no" >';
	jQuery('.categories').before(mapHtml);
}

//********************************* THESE FUNCTIONS FOR ADDING LOCATIONS TO AFTER CREATION 	

//process every part of the page which needs a location button adding 
heresay.processPost = function(index, element) {
	
	var sub_page_id;
	var query_url
	
    //only add the locate button to posts and replies, but not replies to replies and further down 	 	
    if (jQuery(element).parent().hasClass('i0') || jQuery(element).parent().parent().hasClass('xg_headline')) {
			
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
    }	
}

//adds the map icon
heresay.insertIcon = function(data, index) {

    var html_element;

    var icon_style = 'float:right; cursor:pointer; ';

    var icon_text_style = 'margin-left:72px; margin-top:-22px; font-size:12px;';

    if (index == 0) {icon_style += 'top:-0px;';}

    else {icon_style += 'top:0px;';}
	
	// test to see if post has been located 
    if (data == 'no results found') {
        jQuery('.byline').eq(index).prepend("<div class='heresay_icon' style='" + icon_style + "' ><img src='"+heresay.baseURL+"/platform/images/heresay_location_button.jpg' class='garden_fence_icon' /><p style='" + icon_text_style + "'>Locate This Comment</p></div>");
    }

    else {
		
		//handling the case where there is no specific location 
		var location_name = data[0]['location_name'];
		
		if (data[0]['no_specific_location'] == 1) {
			location_name = "No specific location";
		}
		
        jQuery('.byline').eq(index).prepend("<div class='heresay_icon' style='" + icon_style + "'  ><img src='"+heresay.baseURL+"/platform/images/heresay_location_button.jpg' class='garden_fence_icon' /><p style='" + icon_text_style + "' >" + location_name + "</p></div>");
    }

    // attach a click handler to each of the buttons
    jQuery('.byline').eq(index).children('.heresay_icon').click(function() {
        heresay.clickIcon(this, index);
    });
}

//opens the modal window
heresay.clickIcon = function(element, index) {

    //only add the map if it isn't already there
    if ((jQuery('#garden_fence_modal').length > 0) == false)
    {

        var title = escape(jQuery(".tb h1").html());
        var bodytext = escape(jQuery('.discussion').eq(index).html());

        var domain = escape(document.domain);
        var thread_date = jQuery('.navigation li a').eq(5).html().replace('on').split('at');
        thread_date = escape(thread_date[0]);

        var homeurl = location.pathname;

        var sub_page_id = heresay.findSubPageId(element);
		
		var close_button_style = "font-size: 16px; left: 328px; position: absolute; top: 470px; width:100px; z-index: 15; height:26px;"; 

        //add the modal window
        jQuery('body').append("<div id='garden_fence_modal' style='background-image: url("+heresay.baseURL+"/platform/images/modal_background.png);background-repeat:none'><p><a id='garden_fence_close' style='float:right; z-index:20' href='#'><img src='"+heresay.baseURL+"/platform/images/cross.png' style='margin-right:20px; margin-top:20px; ' /> </a></p>	<input type='button' value='close' id='close_button_overlay' style='"+close_button_style+"' /> <iframe id='map_iframe' src='"+heresay.baseURL+"/platform/iframe_test.html?title=" + title + "&body_text=" + bodytext + "&home_url=" + homeurl + "&domain=" + domain + "&thread_date=" + thread_date + "&sub_page_id=" + sub_page_id + "&center="+heresay.homeCoords+"' frameborder='0' scrolling='vertical' style='height:485px; width:530px; margin: -10px 20px 0px 20px; z-index:10' ></iframe> </div>");
		
		$('#close_button_overlay').click(function() {
			heresay.closeModal();
		})
		
        //make it the right size
        jQuery('#garden_fence_modal').css({
            'width': '600px',
            'height': '530px'
        });

        //display the box
        displayBox();
    }

    //bind close action to cross
    jQuery('#garden_fence_close').unbind('click').click(function() {
		heresay.closeModal();
    });
}

heresay.closeModal = function() {
	jQuery('#garden_fence_modal').remove();
    heresay.init();
}

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
}



//-------------------- Couple of generic functions here 

// generic modal window function
function displayBox()
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
}


heresay.getUrlVars = function() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi,
    function(m, key, value) {
        vars[key] = value;
    });
    return vars;
}

$(document).ready(function() {
	 
	jQuery.getJSON('http://localhost:8888/heresay/switch/status.php?callback=?', function(data) {
		heresay.jsonObject = eval(data);
		if (heresay.jsonObject['status'] == 'yes') {
			heresay.init();
		}	
	});

});


heresay.getCookie = function (c_name)
{
var i,x,y,ARRcookies=document.cookie.split(";");
for (i=0;i<ARRcookies.length;i++)
{
  x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
  y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
  x=x.replace(/^\s+|\s+$/g,"");
  if (x==c_name)
    {
    return unescape(y);
    }
  }
}



