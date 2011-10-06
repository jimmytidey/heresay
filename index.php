<?

	include('header.php'); 

?>


<img src='images/iframe_box.jpg' id='iframe_box' /> 

<iframe src="api/iframe.php?center=51.538114321228925,-0.0542449951171875" id="iframe" scrolling="no" frameborder="no" align="center">
</iframe>

<h1>TWAT Recent Posts</h1> 

<?

$distinct_thread_query = "SELECT DISTINCT thread_id FROM heresay_updates ORDER BY time_stamp DESC LIMIT 10"; 	

$distinct_thread_results = db_q($distinct_thread_query);

if (is_array($distinct_thread_results)) {

	foreach ($distinct_thread_results as $thread) {
		$thread_id= $thread['thread_id']; 
		$thread_result = db_q("SELECT * FROM heresay_updates WHERE thread_id = '$thread_id' ORDER BY time_stamp DESC LIMIT 1");	
		
		$time = $thread_result[0]['thread_date'];
		
		?>
		
		<p><a target='_blank' href="<? echo urlencode($thread_result[0]['location_name']); ?>/<? echo urlencode($thread_result[0]['title']);   ?>/<? echo urlencode($thread_result[0]['thread_id']); ?>"><? echo $thread_result[0]['title']; ?></a></p>
		
		<?
	}
}	


?>

<h1>What is Heresay?</h1>

<p>Finding out what's being said about your area online can be difficult. Heresay gathers geographically specific conversations together and puts them on a map to make them easier to find.</p>

<p>The Heresay icon is integrated into forums and blogs, and allows users to drop a pin on a map to identify the location that page is specific too. Once the conversation has been given a location we can put it on our central map.</p> 

<p>Any portion of the Heresay central map (above) can be integrated into blogs, forums or social networking sites, helping users navigate that site in a geographical way.</p>

<p>Sometimes it can be handy to know the facts on the ground too. Heresay will integrate with data sources such as crime statistics. As well as indicating what's being said about a location Heresay will collate civic data to keep everyone informed about what's going on.</p>

<h1>Get in touch</h1>

<p>hello@heresay.org.uk</p> 

<?

	include('footer.php'); 

?>



