//namespace everthing inside this function 
(function($) {

//Initialise!
jQuery(document).ready(function() {
	heresay.init();
});


heresay = new Object();

//init function triggers icon adding 
heresay.init = function init() {	

	//remove any existing badges 
	jQuery('.heresay_icon').remove();
	
	//work out the path for this discussion
	
	//first, need to work out if the what folder vanilla is installed in 
	var base_folder  =  jQuery('.Title').attr('href');
	
	var discussion_id;
	
	discussion_id = jQuery('#DiscussionID').val(); 
	
	var path = base_folder+'discussion/'+discussion_id;	
	
	heresay.path = path; 
	
	jQuery('.Comment .Meta').each(function(index) { 
		
		var sub_page_id = heresay.findSubPageId(this);
				
		var query_url = "http://heresay.org.uk/api/find_threads.php?domain_name="+document.domain+"&path="+path+"&sub_page_id="+sub_page_id+"&callback=?";
		
		jQuery.getJSON(query_url, 	
		function(data) {
			heresay.insertIcon(data, index);  	
		}); 		
	});
	
	//re-init after every ajax update 

	jQuery('#Form_PostComment').click(function(){
			setTimeout(heresay.init(),1250);
	}); 
				
}

//adds the map icon 
heresay.insertIcon = function(data, index) {
	
	var html_element; 

	var icon_style = 'margin-right:3px; margin-top:-22px; float:right; cursor:pointer';
	
	var icon_text_style = 'position:relative; top:-33px; left:65px';
	
	if (data == 'no results found') {  //This post has not been located
		html_element = jQuery('.Meta').eq(index).append("<div class='heresay_icon' style='"+icon_style+"' ><img src='http://heresay.org.uk/platform/images/heresay_location_button.jpg' class='garden_fence_icon' /><p style='"+icon_text_style+"'>Locate This Comment</p></div>");		
	} 				
	
	else {	//This post has already been identified 
		html_element = jQuery('.Meta').eq(index).append("<div class='heresay_icon' style='"+icon_style+"'  ><img src='http://heresay.org.uk/platform/images/heresay_location_button.jpg' class='garden_fence_icon' /><p style='"+icon_text_style+"' >"+data[0]['location_name']+"</p></div>");		
	}		
	
	// attach a click handler to each of the buttons 
	jQuery(html_element).click(function() {
		heresay.clickIcon(this); 
	});
}

//opens the modal window 
heresay.clickIcon = function(element) {
	
	//only add the map if it isn't already there
	if ((jQuery('#garden_fence_modal').length > 0) == false) 
	{	
		var title	 		= escape(jQuery(".SubTab").html());
		var bodytext 		= jQuery(element).siblings(".Message").html();
		bodytext 			= escape(bodytext);

		var domain			= escape(document.domain);
		var thread_date		= jQuery(element).children(".DateCreated").html();
		
		var homeurl = heresay.path; 
		
		var sub_page_id = heresay.findSubPageId(element);
				
		//add the modal window
		jQuery('body').append("<div id='garden_fence_modal' style='background-image: url(http://heresay.org.uk/platform/images/modal_background.png);background-repeat:none'><p><a id='garden_fence_close' style='float:right;' href='#'><img src='http://heresay.org.uk/platform/images/cross.png' style='margin-right:20px; margin-top:20px; ' /> </a></p><iframe id='map_iframe' src='http://heresay.org.uk/platform/iframe.html?title="+title+"&body_text="+bodytext+"&home_url="+homeurl+"&domain="+domain+"&thread_date="+thread_date+"&sub_page_id="+sub_page_id+"&center=51.52751593393153,-0.05604743957519531' frameborder='0' scrolling='vertical' style='height:530px; width:560px; margin: 2px 20px;' ></iframe> </div>");		
		
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

heresay.findSubPageId = function(element) {
	//find the sub page id
	var sub_page_id;
	
	if (jQuery(element).parent().parent().is('.FirstComment')) {
		sub_page_id = 0; 
	}  
	
	else {
		sub_page_id = jQuery(element).parent().parent().attr('id');
		sub_page_id = sub_page_id.split('_'); 
		sub_page_id = sub_page_id[1]; 
	}	
	
	return sub_page_id; 
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
