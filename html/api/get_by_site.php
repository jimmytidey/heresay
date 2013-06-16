<?
include('../ini.php');

@$url = explode("/",$_GET['url']);
$db = new dbClass(DB_LOCATION, DB_USER_NAME, DB_PASSWORD, DB_NAME);

$results = array();

$site    = @addslashes($_GET['site']); 

$query = "SELECT * FROM manual_updates WHERE site= '$site' ORDER BY pubdate DESC ";

$results['query'] = $query;
$results['results'] = $db->fetch($query);
output_json($results);

?>
