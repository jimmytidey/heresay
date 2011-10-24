<?

include ('db_functions.php');

error_reporting(0);

$domain_name 	= mysql_real_escape_string(urldecode($_GET['domain_name']));
$path 		 	= mysql_real_escape_string(urldecode($_GET['path'])); 

$lat			= mysql_real_escape_string(urldecode($_GET['lat']));
$lng 			= mysql_real_escape_string(urldecode($_GET['lng'])); 
$title 			= mysql_real_escape_string(urldecode($_GET['title']));
$type 			= mysql_real_escape_string(urldecode($_GET['type']));
$domain_name 	= mysql_real_escape_string(urldecode($_GET['domain_name']));
$path			= mysql_real_escape_string(urldecode($_GET['path']));
$sub_page_id	= mysql_real_escape_string(urldecode($_GET['sub_page_id']));


$callback 		= mysql_real_escape_string(urldecode($_GET['callback'])); //for JSONP
$debug 			= mysql_real_escape_string(urldecode($_GET['debug']));


$thread_query_array = array(); 

$search_result = array(); 
	
$distinct_thread_query = "SELECT DISTINCT thread_id
				FROM heresay_updates";

if ($lat != "") { // do lat based lookup 

	$lat_max = $lat + 0.1; 
	$lat_min = $lat - 0.1; 	

	$thread_query_array[] = "lat < '$lat_max' && lat > '$lat_min'";
}

if ($lng != "" ) { //do lng based lookup

	$lng_max = $lng + 0.1; 
	$lng_min = $lng - 0.1;	

	$thread_query_array[] = "lng < '$lng_max' && lng > '$lng_min'";
}

if ($title !="" ) { //do free text search on title 

	$thread_query_array[] = "title LIKE '%$title%'";
} 

if ($title !="" ) { //do free text search on title 

	$thread_query_array[] = "title LIKE '%$title%'";
} 

if ($type !="" ) { //do free text search on type 

	$thread_query_array[] = "type = '$type'";
}

if ($path !="" ) { //do free text search on type 

	$thread_query_array[] = "path = '$path'";
}

if ($domain_name !="" ) { //do free text search on type 

	$thread_query_array[] = "domain_name = '$domain_name'";
}

if ($sub_page_id !="" ) { //do free text search on type 

	$thread_query_array[] = "sub_page_id = '$sub_page_id'";
}


if (!empty($thread_query_array)) { // make the query from the array 
	$distinct_thread_query .=" WHERE ". implode(' && ', $thread_query_array);
}

$distinct_thread_query .=" LIMIT 50"; 


$distinct_thread_results = db_q($distinct_thread_query);

if (is_array($distinct_thread_results)) {
	
	foreach ($distinct_thread_results as $thread) {
		$thread_id= $thread['thread_id']; 
		$thread_query_results = db_q("SELECT * FROM heresay_updates WHERE thread_id = '$thread_id' ORDER BY time_stamp DESC LIMIT 1");	
		$thread_query_results[0]['body'] = strip_tags($thread_query_results[0]['body']);
		$search_result[] = $thread_query_results[0];
	}
}	
	
else 
{
	$search_result[] ='no results found';
}


if ($debug == "true") {
	echo $distinct_thread_query.'<br/>';
	print_r ($search_result);
}



else {
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Content-type: application/json');

	$return = json_encode(unstrip_array($search_result));

	
	if ($callback != "") {
		echo $_GET['callback'].'('.$return.')';
	}

	else {
		echo $return; 
	}
}






?>