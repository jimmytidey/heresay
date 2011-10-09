<?

include ('db_functions.php');
include ('reverse_geocode.php');

// get the query 
$domain_name = mysql_real_escape_string($_GET['domain_name']);


$path 		 = mysql_real_escape_string($_GET['path']); 
$given_ip 	 = mysql_real_escape_string($_GET['ip']); 

$service_name   	= mysql_real_escape_string($_GET['service_name']);
$service_password   = mysql_real_escape_string($_GET['service_password']);

$cookie_id		 	= mysql_real_escape_string($_GET['cookie_id']);
$user_name  	 	= mysql_real_escape_string($_GET['user_name']);
$user_password   	= mysql_real_escape_string($_GET['user_password']);


$lat			= mysql_real_escape_string($_GET['lat']);
$lng 			= mysql_real_escape_string($_GET['lng']); 
$location_name  = mysql_real_escape_string($_GET['location_name']); 
$thread_date 	= mysql_real_escape_string(strtotime(urldecode($_GET['thread_date']))); 
$title 			= mysql_real_escape_string($_GET['title']);
$body 			= mysql_real_escape_string($_GET['body']); 
$type 			= mysql_real_escape_string($_GET['type']); 
$sub_page_id	= mysql_real_escape_string($_GET['sub_page_id']);
$no_specific_location	= mysql_real_escape_string($_GET['no_specific_location']); 

//this is required for jsonp
$callback 		= mysql_real_escape_string($_GET['callback']); 

$time_stamp = time();

$requesting_ip = $_SERVER['REMOTE_ADDR'];

$status = '';
$error = 'success';

//***********************************************************************
// check all the required data actually exists

//validate the domain
if ($domain_name =='') {
	$status .='No domain specified.<br/>';
	$error = 'fail';
}

//validate the path 
if ($path == '') {
	$status .='No path specified. <br/>';
	$error = 'fail';
}


//***********************************************************************
// If we have a valid thread id we need to check if the path exists

if ($error == 'success') {
	

	$thread_result = db_q("SELECT * FROM heresay_updates WHERE domain_name='$domain_name' && path='$path' ");
	
	
	if (count($thread_result) > 0 ) { //thread is in the database
		$thread_id = $thread_result[0]['thread_id'];
		$status .= "This thread already exists. <br/>";
		
		// copy forward any previous information that hasn't been updated 
		
		$last_row_query = "SELECT * FROM heresay_updates WHERE thread_id ='$thread_id' ORDER BY time_stamp DESC LIMIT 1"; 
		$last_row_results = db_q($last_row_query);
		
		if ($lat == "") {$lat = $last_row_results[0]['lat'];}			
		if ($lng == "") {$lng = $last_row_results[0]['lng'];}			
		if ($location_name == "") {$location_name = $last_row_results[0]['location_name'];}			
		if ($title == "") {$title = $last_row_results[0]['title'];}			
		if ($body == "") {$body = $last_row_results[0]['body'];}			
		if ($type == "") {$type = $last_row_results[0]['type'];}			
		
	}
	
	else { //thread isn't in the database - work out what id value this update should have
		
		//get the last highest thread in 
		$max_thread_results = db_q("SELECT MAX(thread_id) FROM heresay_updates");
		$thread_id = $max_thread_results[0][0]+1;
		if (!is_numeric($thread_id)) {$thread_id = 0;}
		
		$status .= "No thread was found in the DB, one was created with id ".$thread_id." <br/>";
			
	}		
}


//***********************************************************************
// If we have a valid thread id then we can check the user table for this user 

if ($error == 'success') {
	
	if ($cookie_id !="") { // look up on the basis of cookie if 
		
		if (strlen($cookie_id) != 40) { // cookie id exists, and isn't valid
			$status .= "Invalid cookie ID - I'm proceeding without a cookie id. <br/>"; 
		}
		
		else { // valid cookie id - let's try and find it
		
			$user_result = db_q("SELECT * FROM heresay_users WHERE cookie_id='$cookie_id'");
		
			if (count($user_result) > 1 ) { //test to see if more than one thread matches 
				$status .= "More than one than one user matches this cookie id. This is fatal. <br/>";	
				$error = 'fail';	
			}
	
			else if (count($user_result) == 1 ) { //domain is in the database
				$user_id = $user_result[0]['user_id'];
				$status .= "This user already exists. <br/>"; 
			}
			
			else if (count($user_result) < 1 ) { //domain is in the database
				$status .= "This cookie_id does not exist. <br/>"; 
			}			
		}	
	}

	
	if (!isset($user_id)) { //couldn't identify an existing user - let's make one up  
		
		$cookie_id = sha1($time_stamp.'tiadjsfkjadsfk');
		
		//make record 
		$user_query = "INSERT INTO heresay_users (cookie_id, date_created) VALUES ('$cookie_id', '$time_stamp') ";
		db_q($user_query); 
		
		//get the id of the record
		$user_result = db_q("SELECT * FROM heresay_users WHERE cookie_id='$cookie_id' ");
		$user_id = $user_result[0]['user_id'];
		
		if (is_numeric($user_id)) {
			$status .= "No user was found in the DB, one was created. <br/>";
		}
		
		else {
			$status .= "This user was not found in the database, I tried to create one, but failed. <br/>";
			$error = 'fail';
		}	
	}		
}



//***********************************************************************
// We now have all the required data - we can put it in the db


if ($error == 'success') {
			
	$authority = 0; 
	
	//do the geocode 
	
	$revGeoCode = reverseGeoCode($lat, $lng);
	
	$adminName2 =$revGeoCode['adminName2'];
	$adminName3 =$revGeoCode['adminName3'];
	$toponymName =$revGeoCode['toponymName'];
	
	$comment_query = "INSERT INTO heresay_updates (
		`thread_id`,
		`path`,
		`domain_name`,
		`user_id`, 
		`service_id`, 
		`lat`, 
		`lng`, 
		`location_name`,
		`adminName2`,
		`adminName3`,
		`toponymName`,
		`thread_date`,
		`time_stamp`, 
		`authority`, 
		`type`, 
		`title`, 
		`body`, 
		`requesting_ip`,	
		`given_ip`,
		`sub_page_id`,
		`no_specific_location`) VALUES (
		'$thread_id',
		'$path',
		'$domain_name',
		'$user_id',
		'$service_id',
		'$lat',
		'$lng',
		'$location_name',
		'$adminName2',
		'$adminName3',
		'$toponymName',
		'$thread_date',
		'$time_stamp',
		'$authority',
		'$type',
		'$title',
		'$body',
		'$requesting_ip',
		'$given_ip',	
		'$sub_page_id',
		'$no_specific_location'	
		)";
		
		db_q($comment_query); 
		
		$status .= "successfully written to DB: ".$comment_query; 
}	

$return_array['success'] = $error; 
$return_array['description'] = $status; 
$return_array['error_code'] = $error_code; 
$return_array['cookie_id'] = $cookie_id; 

$return = json_encode($return_array);

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

if ($callback != "") {
	echo $_GET['callback'].'('.$return.')';
}

else {
	echo "$return"; 
}

?>