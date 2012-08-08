
$(document).ready(function() { 
	
	filter ={};
	
	$('.filter').click(function(){ 
		var height = parseInt($('#logo').css('height')); 
		console.log(height);
		if (height < 470) { 
			$('#logo').animate({height:'480px'}, 500);
			$('#arrow').attr('src', 'images/up.png');
		}
		else { 
			$('#arrow').attr('src', 'images/down.png');
			$('#logo').animate({height:'180px'}, 500);
		}
		
		$('#filter_button').click(function(){
			var recency = $('#time_filter').val();
			filter.category = [];
			$('.filter_category input').each(function(elem){ 
			    if($(this).attr('checked')) { 
			        filter.category.push($(this).val());
			    }
			});
			console.log(filter.category);
			heresay.init(51.5073346, -0.1276831, 12, filter.category.join(","), recency)
		});
		
	});
	
	
}); 