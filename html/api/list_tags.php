<?
include('../ini.php');

@$url = explode("/",$_GET['url']);
$db = new dbClass(DB_LOCATION, DB_USER_NAME, DB_PASSWORD, DB_NAME);

$results = array();

$site    = @addslashes($_GET['site']); 

$query = "SELECT category_1 as tag, count(*) AS count 
FROM manual_updates 
WHERE category_1 !='' && category_1 !='undefined' && category_1 !='--' 
GROUP BY category_1 
HAVING count(*) > 15";

$results['query'] = $query;
$results['results'] = $db->fetch($query);
output_json($results);

?>
