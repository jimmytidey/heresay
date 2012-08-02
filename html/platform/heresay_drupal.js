//namespace everthing inside this function 
(function($) {

//Initialise!
jQuery(document).ready(function() {
	heresay.init();
});


heresay = new Object();

//init function triggers icon adding 
heresay.init = function init() {	

	//make the post title bigger 
	jQuery('.post-title').css('height','34px'); 
	jQuery('.post-date').css('right','-230px');
	jQuery('.post-date').css('top','-30px');
	
	jQuery('.rpforum-post').each(function(index) { 
	
	

		//remove any existing badges 
		jQuery('.heresay_icon', this).remove();	
	
		var sub_page_id = jQuery(this).prev().attr('name'); 
					
				
					
		jQuery.getJSON("http://heresay.org.uk/api/find_threads.php?domain_name="+document.domain+"&path="+location.pathname+"&sub_page_id="+sub_page_id+"&callback=?", 	
		
		function(data) {
			heresay.insertIcon(data, index);  	
		}); 		
	});
				
}

//adds the map icon 
heresay.insertIcon = function(data, index) {
	
	

	var html_element; 
	var style='margin-right:5px; margin-top:20px; float:right; cursor:pointer';
	
	if (data == 'no results found') {  //This post has not been located
		html_element = jQuery('.post-title').eq(index).prepend("<div class='heresay_icon'  style='float:right' ><img src='http://heresay.org.uk/platform/images/heresay_location_button.jpg' style='"+style+"' class='garden_fence_icon' /><p style='left: 63px; position: relative; top: -16px; width: 200px; z-index: 10; cursor:pointer' >Locate This Comment</p></div>");		
	} 				
	
	else {	//This post has already been identified 
	
		
		html_element = jQuery('.post-title').eq(index).prepend("<div class='heresay_icon' style='float:right' ><img src='http://heresay.org.uk/platform/images/heresay_location_button.jpg' style='"+style+"' class='garden_fence_icon' /><p style='left: 63px; position: relative; top: -16px; width: 200px; z-index: 10; cursor:pointer' >"+data[0]['location_name']+"</p></div>");		
	}		
	
	// attach a click handler to each of the buttons 
	jQuery(html_element).click(function() {
		heresay.clickIcon(this); 
	});
}

//opens the modal window 
heresay.clickIcon = function(element) {
	

	
	var sub_page_id = jQuery(element).parents('.rpforum-post').prev().attr('name');
	
	//only add the map if it isn't already there
	if ((jQuery('#garden_fence_modal').length > 0) == false) 
	{	
		var title	 		= escape(jQuery(".post-title").html().replace(/(<([^>]+)>)/ig,"").replace('Locate This Comment ',''));
		var bodytext 		= jQuery(element).siblings(".post-body").html().trim().replace(/(<([^>]+)>)/ig,"");
		bodytext 			= escape(bodytext);
		var homeurl			= escape(location.pathname);
		var domain			= escape(document.domain);
		var thread_date		= jQuery(element).siblings(".post-date").html();
		
		//add the modal window
		jQuery('body').append("<div id='garden_fence_modal' style='background-image: url(http://heresay.org.uk/platform/images/modal_background.png);background-repeat:none'><p><a id='garden_fence_close' style='float:right;' href='#'><img src='http://heresay.org.uk/platform/images/cross.png' style='margin-right:20px; margin-top:20px; ' /> </a></p><iframe id='map_iframe' src='http://heresay.org.uk/platform/iframe.html?title="+title+"&body_text="+bodytext+"&home_url="+homeurl+"&domain="+domain+"&thread_date="+thread_date+"&sub_page_id="+sub_page_id+"' frameborder='0' scrolling='vertical' style='height:530px; width:560px; margin: 2px 20px;' ></iframe> </div>");		
		
		//make it the right size
		jQuery('#garden_fence_modal').css({
			'width' : '600px',
			'height' : '500px'
		});
		
		//display the box
		displayBox();
	}
	
	//bind close action to cross
	jQuery('#garden_fence_close').unbind('click').click(function() {
		jQuery('#garden_fence_modal').remove(); 
		heresay.init(); 
	});	
}




// generic modal window function  
function displayBox() 
{	
	jQuery.fn.center = function (absolute) {
		return this.each(function () {
			var t = jQuery(this);
		
			t.css({
				position:    absolute ? 'absolute' : 'fixed', 
				left:        '50%', 
				top:        '50%', 
				zIndex:        '200000'
			}).css({
				marginLeft:    '-' + (t.outerWidth() / 2) + 'px', 
				marginTop:    '-' + (t.outerHeight() / 2) + 'px'
			});
		
			if (absolute) {
				t.css({
					marginTop:    parseInt(t.css('marginTop'), 10) + jQuery(window).scrollTop(), 
					marginLeft:    parseInt(t.css('marginLeft'), 10) + jQuery(window).scrollLeft()
				});
			}
		});
	};
	jQuery('#garden_fence_modal').center();
}
	
})();
