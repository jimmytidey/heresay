<!DOCTYPE html>
<html>
<head>


<style type="text/css">
#container {
	font-family:  Baskerville,"Baskerville old face","Hoefler Text",Garamond,"Times New Roman",serif;
	position:absolute;
	width: 900px; 
	left:50%; 
	margin-left:-450px; 
}

label {width:100px; float:left;}

#results, #search_results {border:1px solid black; padding:5px; margin-top:20px;}

</style>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>

<script type="text/javascript">

$(document).ready(function() { // you need this otherwise JQUERY will try and bind click events before the document has loaded 

	$('#submit').click(function () { 
		
	
		
		var url = "http://heresay.org.uk/api/write_comment.php?";  // construct our get query 
			url += "domain_name="+$('#domain_name').val(); 
			url += "&sub_page_id="+$('#page_sub_id').val(); 
			url += "&path="+$('#path').val(); 
			url += "&given_ip="+$('#given_ip').val(); 
			url += "&cookie_id="+$('#cookie_id').val(); 
			url += "&lat="+$('#lat').val(); 
			url += "&lng="+$('#lng').val();
			url += "&location_name="+$('#location_name').val(); 
			url += "&title="+$('#title').val();
			url += "&body="+$('#body').val();
			url += "&type="+$('#type').val();
			url += "&callback=?"; //this is required to make JQUERY use JSONP, which allows cross domain AJAX queries 
	
		alert(url);
	
		$.getJSON(url, function(json) {
			$('#results').html("QUERY STRING: "+ url+"<br/><br/>") ;
		   	$('#results').append(json.description); // Show the results in the doc
			$('#results').append("<br/><br/> COOKIE ID: "+json.cookie_id);
		 });
	}); 
	
	$('#search').click(function () { 

		var url = "http://heresay.org.uk/api/find_threads.php?";  // construct our get query 
			url += "&lat="+$('#search_lat').val(); 
			url += "&lng="+$('#search_lng').val(); 
			url += "&title="+$('#search_title').val();
			url += "&sub_page_id="+$('#search_sub_page_id').val();
			url += "&type="+$('#search_type').val();
			url += "&domain_name="+$('#search_domain_name').val(); 
			url += "&path="+$('#search_path').val();
			url += "&callback=?"; //this is required to make JQUERY use JSONP, which allows cross domain AJAX queries 
	
	
		$.getJSON(url, function(json) {
			
			$('#search_results').html("<br/> QUERY STRING: "+ url+"<br/><br/>") ;
			
			for(i=0; i<json.length; i++) {
			   	$('#search_results').append("Title: "+json[i]['title']+"<br/>"); 
				$('#search_results').append("Body: "+json[i]['body']+"<br/>");
				$('#search_results').append("Type: "+json[i]['type']+"<br/>"); 
				$('#search_results').append("Lat: "+json[i]['lat']+"<br/>");
				$('#search_results').append("Lng: "+json[i]['lng']+"<br/>");
				$('#search_results').append("<br/>=======<br/>");
			}

		 });
	});
		
});



</script>

<head>

<body>
	
<div id='container'>
	
	<h1>API test console</h1> 
	
	<h2>Writing to the DB </h2>
		 
	<p><label for='domain_name'>Domain Name </label><input id='domain_name' type='text'> The domain name of the site on which the thread is hosted</p>
	<p><label for='path'>Path </label><input id='path' type='text'> The URL with domain name removed & and any irrelevant query string removed</p>
	<p><label for='path'>Page sub ID </label><input id='page_sub_id' type='text'>For multiples of the same thing on the page</p>

	<p><label for='given_ip'>Given IP </label><input id='given_ip' type='text'> The ip of the user in question - not required (The IP of requesting server is also stored)</p>
	<p><label for='cookie_id'>Cookie_id </label><input id='cookie_id' type='text'> Users cookie ID for progressive registration </p>
	
	<p><label for='lat'>Lat </label><input id='lat' type='text'> Latitude </p>
	<p><label for='lng'>Lng </label><input id='lng' type='text'> Longitude </p>
	<p><label for='location_name'>Location Name </label><input id='location_name' type='text'> Location Name </p>	
	<p><label for='title'>Title </label><input id='title' type='text'> Required is this is the first comment in the Thread </p>
	<p><label for='body'>Body </label><input id='body' type='text'> Not required </p>
	<p><label for='type'>Type </label><input id='type' type='text'> Required if this is the first comment in the Thread</p>	
	<p><label for='submit'>Submit </label><input id='submit' type='button' value='submit'> </p>
	
	<div id='results'>Results will appear here</div>
	
	<br/><br/>
	
	<h2>Searching the DB</h2>
	
	<p><label for='search_lat'>Lat </label><input id='search_lat' type='text'> </p>
	<p><label for='search_lng'>Lng </label><input id='search_lng' type='text'> </p>
	<p><label for='search_title'>Title </label><input id='search_title' type='text'> </p>
	<p><label for='search_type'>Type </label><input id='search_type' type='text'> </p>
	<p><label for='search_type'>Page Sub ID </label><input id='search_page_sub_id' type='text'> </p>
	
	<p><label for='domain_name'>Domain Name </label><input id='search_domain_name' type='text'> </p>
	<p><label for='path'>Path </label><input id='search_path' type='text'> </p>
			
	<p><label for='search'>Search </label><input id='search' type='button' value='Search'> </p>	
	
	<div id='search_results'>Search Results </div>
	
</div>

</body>

</html>