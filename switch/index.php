<? include('../header.php'); ?>
	
	<h1>Turn Heresay on and off for harringayonline.com</h1> 
	
	<form id='form' style='border:none;'>
		<fieldset class="nolegend" id="heresayButtons" style='border:none;' >
			<input type="radio" name="state" value="On" id='On' > On<br>
			<input type="radio" name="state" value="Off" id='Off' > Off<br>
		</fieldset>
	</form>	
	
	<script type="text/javascript">
		
		//ajust the style of this page 
		
		$('#container').css('padding-left', '30px'); 
		$('#container').css('height', '1000px'); 		
		
		var yes_state ='';
		var no_state ='';
	
		if (getCookie('heresay_harringay') == 'yes') {$('#On').attr('checked','checked');}
	
		else {$('#Off').attr('checked','checked');}
			
		//init if the cookie has been set 
		if (getCookie('heresay_harringay') === undefined) {	
			setCookie('heresay_harringay', 'no');
		}		
		
		jQuery('#heresayButtons').change(function(){
			if ($('input:radio[name=state]:checked').val() == 'On') {
				setCookie('heresay_harringay', 'yes');
			}
			
			else {setCookie('heresay_harringay', 'no');}
			
			alert('Saved');
		});
	
		function getCookie(c_name)
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

		function setCookie(c_name,value)
		{
			var exdate = new Date();
			var exdays ='600'; 
			exdate.setDate(exdate.getDate() + exdays);
			var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
			document.cookie=c_name + "=" + c_value;
		}
		

	</script>
	
<?	include('../footer.php'); ?>