<? 
include('../db_info.php');


$lat =  mysql_real_escape_string($_GET['lat']);
$lng =  mysql_real_escape_string($_GET['lng']);
$category =  mysql_real_escape_string($_GET['category']);
$link = mysql_real_escape_string(htmlspecialchars($_GET['link']));

echo '=-'.$link.'--

';

$query = "UPDATE manual_updates SET lat='$lat', lng='$lng', category='$category' WHERE link='$link'";
echo $query; 

mysql_query ($query);



?>