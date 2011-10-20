<? include('../header.php'); ?>
	
	<h1>Turn Heresay on and off</h1> 
	
	<form id='form'>
		<fieldset class="nolegend" id="heresayButtons" >
			<input type="radio" name="state" value="On"> On<br>
			<input type="radio" name="state" value="Off"> Off<br>
		</fieldset>
	</form>	
	
	<script type="text/javascript">
		
		var yes_state ='';
		var no_state ='';
	
		if (getCookie('heresay_harringay') == 'yes') {yes_state ='checked="checked"';}
	
		else {no_state ='checked="checked"';}
			
		//init if the cookie has been set 
		if (getCookie('heresay_harringay') === undefined) {
			alert('setting a cookie because - none found');
			setCookie('heresay_harringay', 'no');
		}		
		
		jQuery('#heresayButtons').change(function(){
			alert('change');
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