

//namespace everthing inside this function 
(function($) {

	/* check for jquery 
	var s=document.createElement('script');
	s.setAttribute('src','http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js');
	
	if(typeof jQuery!='undefined') 
	{
		var msg='This page already using jQuery v' + jQuery.fn.jquery;
	} 

	else 	
	{
		 document.getElementsByTagName('head')[0].appendChild(s);
	}
	
	*/ 
	
	function init() {		
	
		//make the post title bigger 
		jQuery('.post-title').css('height','34px'); 
		jQuery('.post-date:first').css('right','-230px');
		jQuery('.post-date:first').css('top','-30px');
		
		//find out what site we are on 
		var domain 	= document.domain;
		var url 	= location.pathname; 
		
		//settings specific to the herne hill forum 
		var icon_location = '.post-title';
		var style='margin-right:5px; margin-top:20px; float:right; cursor:pointer';
		//jQuery.noConflict();
			
		//check to see if we already have this post 
		jQuery.getJSON("http://heresay.org.uk/api/find_threads.php?domain_name="+domain+"&path="+url+"&callback=?", 
		function(data) {
						
			//if this post has not been identified, allow people to ID it
			if (data['0'] == 'no results found') 
			{		
				//add the map icon 
				//remove map icon if it's already there
				jQuery('#heresay_icon').remove();
				jQuery(icon_location).prepend("<div id='heresay_icon' style='float:right' ><img src='http://heresay.org.uk/platform/images/heresay_location_button.jpg' style='"+style+"' id='garden_fence_icon' /><p style='left: 63px; position: relative; top: -16px; width: 200px; z-index: 10;' >Locate This Thread</p></div>");		
				iconClick();

			} 				
			
			//This post has already been identified 
			else 
			{	
				data = eval(data);
				window.data = eval(data);
				locationname = data['0']['location_name'];
				
				//remove map f if it's already there
				jQuery('#heresay_icon').remove();
				jQuery(icon_location).prepend("<div id='heresay_icon' style='float:right' ><img src='http://heresay.org.uk/platform/images/heresay_location_button.jpg' style='"+style+"' id='garden_fence_icon' /><p style='left: 63px; position: relative; top: -16px; width: 200px; z-index: 10;' >"+locationname+"</p></div>");		
				iconClick();
				 
			}	
	
			
			function iconClick() {
				//open the modal window on click  
				jQuery('#garden_fence_icon').click(function() {
					
					//only add the map if it isn't already there
					if ((jQuery('#garden_fence_modal').length > 0) == false) 
					{	
						//get the data to transmit to the iFrame
						var bodytextelement = '.field-item:first';
						var titleelement 	= '.art-postcontent h2';
						var title	 		= jQuery(titleelement).html()
						title	 			= escape(title);
						var bodytext 		= jQuery(bodytextelement).html()
						bodytext 			= escape(bodytext);						
						var homeurl			= escape(location.pathname);
						var domain			= escape(document.domain);
						var thread_date		= escape(jQuery('.post-date:first').html());
						
						//add the modal window
						jQuery('body').append("<div id='garden_fence_modal' style='background-image: url(http://heresay.org.uk/platform/images/modal_background.png);background-repeat:none'><p><a id='garden_fence_close' style='float:right;' href='#'><img src='http://heresay.org.uk/platform/images/cross.png' style='margin-right:20px; margin-top:20px; ' /> </a></p><iframe id='map_iframe' src='http://jimmytidey.co.uk/geo/iframe.html?title="+title+"&body_text="+bodytext+"&home_url="+homeurl+"&domain="+domain+"&thread_date="+thread_date+"' frameborder='0' scrolling='vertical' style='height:530px; width:560px; margin: 2px 20px;' ></iframe> </div>");		
						
						//make it the right size
						jQuery('#garden_fence_modal').css({
							'width' : '600px',
							'height' : '500px'
						});
						
						//display the box
						displayBox();
					}
					
					//bind close action to cross
					jQuery('#garden_fence_close').click(function() {
						jQuery('#garden_fence_modal').remove(); 
						init(); 
					});	
				}); 			
			}
		});

	
		
	}	

	jQuery(document).ready(function() {
		init();
	});

	
	// functions 
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
