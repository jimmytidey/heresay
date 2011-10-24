<?

include ('db_functions.php');

$domain_name = mysql_real_escape_string($_GET['domain_name']);
if(isset($_GET['callback'])) {
	$callback = $_GET['callback']; 
}
else  {
	$callback = '';
}

$query = "SELECT DISTINCT type FROM `heresay_updates` WHERE domain_name = '$domain_name'";

$result = db_q($query);

$return = json_encode(unstrip_array($result));

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');


if ($callback != "") {
	echo $callback.'('.$return.')';
}

else {
	echo $return; 
}

?>