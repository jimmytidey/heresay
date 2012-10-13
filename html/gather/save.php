<? 
include('../db_info.php');


$lat =  mysql_real_escape_string($_GET['lat']);
$lng =  mysql_real_escape_string($_GET['lng']);
$category_1 =  mysql_real_escape_string($_GET['category_1']);
$category_2 =  mysql_real_escape_string($_GET['category_2']);
$category_3 =  mysql_real_escape_string($_GET['category_3']);
$category_4 =  mysql_real_escape_string($_GET['category_4']);
$link = mysql_real_escape_string(htmlspecialchars($_GET['link']));
$favourite = mysql_real_escape_string(htmlspecialchars($_GET['favourite']));


echo '=-'.$link.'--

';

$query = "UPDATE manual_updates SET lat='$lat', lng='$lng', favourite='$favourite', category_1='$category_1', category_2='$category_2', category_3='$category_3', category_4='$category_4' WHERE link='$link'";
echo $query; 

mysql_query ($query);



?>