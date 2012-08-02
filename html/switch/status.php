<?
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

$status = $_COOKIE['heresay_harringay']; 
$jsonArray = array('status' => $status);

$jsonData = json_encode($jsonArray );
 
echo $_GET['callback'] . '(' . $jsonData . ');';
?>