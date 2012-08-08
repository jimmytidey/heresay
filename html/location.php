<?

include('db_functions.php'); 

include('header.php');
?>
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAOoFM_kDNJVs_SzvkytQRKBSpgYF3iu7PXc-1iPSD4CpffT2eCRRzD14PFyag3JY4SakJE5_wVYpLxw&sensor=false" type="text/javascript"></script>
<script type="text/javascript" src="api/js/mapstraction.js"></script>
<script src='scripts/index.js'></script>
<script src='scripts/index_map.js'></script>
	


<div id='location_container'>


$thread_id = mysql_real_escape_string(urldecode($_GET['thread_id']));


if (!empty($thread_id)) {// just write a single thread out 

	$thread_query = "SELECT * FROM manual_updates WHERE id='$thread_id' "; 
	
	$thread_result = db_q($thread_query); 
	 
	$time = $thread_result[0]['thread_date'];

	?>
	
	<h1><a target='_blank' href="http://<? echo $thread_result[0]['domain_name']; ?>/<? echo $thread_result[0]['path']; ?>"><? echo stripslashes($thread_result[0]['title']); ?></a></h1>
	
	<p><? echo stripslashes($thread_result[0]['body']); ?></p>
	
	<p><em><? echo date("F j, Y, g:i a", $time ); ?></em> | <a target='_blank' href="http://<? echo $thread_result[0]['domain_name']; ?>/<? echo $thread_result[0]['path']; ?>">View &raquo;</a></p>
	
	<?
}

else { // find all locations with matchign place names
	$distinct_thread_query = "SELECT DISTINCT thread_id FROM heresay_updates WHERE location_name='$loction_name' && adminName3='$adminName3' "; 	

	$distinct_thread_results = db_q($distinct_thread_query);
	
	if (is_array($distinct_thread_results)) {
	
		foreach ($distinct_thread_results as $thread) {
			$thread_id= $thread['thread_id']; 
			$thread_result = db_q("SELECT * FROM heresay_updates WHERE thread_id = '$thread_id' ORDER BY time_stamp DESC LIMIT 1");	
			
			$time = $thread_result[0]['thread_date'];
			
			?>
			
			<h1><a target='_blank' href="http://<? echo $thread_result[0]['domain_name']; ?>/<? echo $thread_result[0]['path']; ?>"><? echo stripslashes($thread_result[0]['title']); ?></a></h1>
	
			<p><? echo stripslashes($thread_result[0]['body']); ?></p>
		
			<p><em><? echo date("F j, Y, g:i a", $time ); ?></em> | <a target='_blank' href="http://<? echo $thread_result[0]['domain_name']; ?>/<? echo $thread_result[0]['path']; ?>">View &raquo;</a></p>
			
			<br/> <br/> 
			
			<?
		}
	}	
	


}

?>

</div>
<?


	include('footer.php'); 

?>