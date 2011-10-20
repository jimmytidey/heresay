<? include('../header.php'); ?>
	

		<h1 id='status'></status>

	
	<script type="text/javascript">
		
		//ajust the style of this page 
		
		$('#container').css('padding-left', '30px'); 
		$('#container').css('height', '1000px'); 		
		
		var yes_state ='';
		var no_state ='';
	
		if (getCookie('heresay_harringay') == 'yes') {
			$('#status').html('yes');
		}
		else {
			$('#status').html('no');			
		}
	
		
		
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



	</script>
	
<?	include('../footer.php'); ?>