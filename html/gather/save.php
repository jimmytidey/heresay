<?
include('../db_info.php');

$lat =  mysql_real_escape_string($_GET['lat']);
$lng =  mysql_real_escape_string($_GET['lng']);
$link = mysql_real_escape_string(htmlspecialchars(urldecode($_GET['link'])));

$query = "UPDATE manual_updates SET lat='$lat', lng='$lng' WHERE link='$link'";
echo $query; 

mysql_query ($query);



?>