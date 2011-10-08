
//give a scope to all the code 
heresay = new Object();

heresay.baseURL = 'http://test.heresay.org.uk'; 

//this is the location the pop up map centres on by default 
heresay.homeCoords = '51.4609323,-0.1160239';


//When the page has loaded, we can parse it and add in the stuff we need 
jQuery(document).ready(function() {
	
		heresay.addjQuery(); //add jquery because Ning apparently doesn't have it 

		    //remove any existing badges
		        jQuery('.heresay_icon').remove();

			    //change the nav size
			        jQuery('.byline').css('display', 'block'); 	

					heresay.init();
					});


					heresay.addjQuery() {	
						var script = document.createElement('script');
							script.src = 'http://jqueryjs.googlecode.com/files/jquery-1.2.6.min.js';
								script.type = 'text/javascript';
									document.getElementsByTagName('head')[0].appendChild(script);
									}


									//init function triggers icon adding
									heresay.init = function() {

									    jQuery('.byline').each(function(index) {
									    		heresay.processPost(index);
											    });

											        //re-init after every ajax update
												    jQuery('#Form_PostComment').click(function() {
												            setTimeout(heresay.init(), 1250);
													        });

														}

														//process every part of the page which needs a location button adding 
														heresay.processPost = function(index) {
															
																var sub_page_id;
																	
																	    //only add the locate button to posts and replies, but not replies to replies and further down 	 	
																	        if (jQuery(this).parent().hasClass('i0') || jQuery(this).parent().parent().hasClass('xg_headline')) {

																		        if (jQuery(this).hasClass("navigation")) {heresay.sub_page_id = 0;}

																			        else {
																				            sub_page_id = jQuery('a:first-child', this).attr('id').split(':');
																					                heresay.sub_page_id = sub_page_id[2];
																							        }

																								        var query_url = "/api/find_threads.php?domain_name=" + document.domain + "&path=" + location.pathname + "&sub_page_id=" + heresay.sub_page_id + "&callback=?";

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

																															    var icon_text_style = 'margin-left:78px; margin-top:-23px; font-size:12px;';

																															        if (index == 0) {icon_style += 'top:-0px;';}

																																    else {icon_style += 'top:0px;';}
																																    	
																																		// test to see if post has been located 
																																		    if (data == 'no results found') {
																																		            jQuery('.byline').eq(index).prepend("<div class='heresay_icon' style='" + icon_style + "' ><img src='"+heresay.baseURL+"/platform/images/heresay_location_button.jpg' class='garden_fence_icon' /><p style='" + icon_text_style + "'>Locate This Comment</p></div>");
																																			        }

																																				    else {
																																				            jQuery('.byline').eq(index).prepend("<div class='heresay_icon' style='" + icon_style + "'  ><img src='"+heresay.baseURL+"/platform/images/heresay_location_button.jpg' class='garden_fence_icon' /><p style='" + icon_text_style + "' >" + data[0]['location_name'] + "</p></div>");
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

																																										        var title = escape(jQuery("h1").html());
																																											        var bodytext = escape(jQuery('.discussion').eq(index).html());

																																												        var domain = escape(document.domain);
																																													        var thread_date = jQuery('.navigation li a').eq(5).html().replace('on').split('at');
																																														        thread_date = escape(thread_date[0]);

																																															        var homeurl = location.pathname;

																																																        var sub_page_id = heresay.findSubPageId(element);

																																																	        //add the modal window
																																																		        jQuery('body').append("<div id='garden_fence_modal' style='background-image: url("+heresay.baseURL+"platform/images/modal_background.png);background-repeat:none'><p><a id='garden_fence_close' style='float:right;' href='#'><img src='"+heresay.baseURL+"/platform/images/cross.png' style='margin-right:20px; margin-top:20px; ' /> </a></p><iframe id='map_iframe' src='"+heresay.baseURL+"/platform/iframe_test.html?title=" + title + "&body_text=" + bodytext + "&home_url=" + homeurl + "&domain=" + domain + "&thread_date=" + thread_date + "&sub_page_id=" + sub_page_id + "&center="+heresay.homeCoords+"' frameborder='0' scrolling='vertical' style='height:530px; width:560px; margin: 2px 20px;' ></iframe> </div>");

																																																			        //make it the right size
																																																				        jQuery('#garden_fence_modal').css({
																																																					            'width': '600px',
																																																						                'height': '500px'
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
																																																																																	                 zIndex: '200000'
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




