<?
include('../ini.php');

@$url = explode("/",$_GET['url']);
$db = new dbClass(DB_LOCATION, DB_USER_NAME, DB_PASSWORD, DB_NAME);

$results = array();

$user    = @addslashes($_GET['user']); 

$query = "SELECT * FROM manual_updates WHERE user= '$user' ORDER BY pubdate DESC ";

$results['query'] = $query;
$results['results'] = $db->fetch($query);
output_json($results);

?>
