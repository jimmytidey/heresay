<?

include ('db_functions.php');

$callback 		= @mysql_real_escape_string(urldecode($_GET['callback'])); //for JSONP
$debug 			= @mysql_real_escape_string(urldecode($_GET['debug']));


$query =  "SELECT * FROM manual_updates";

$search_result = db_q($query);


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







?>