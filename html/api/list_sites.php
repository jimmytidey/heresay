<?
include('../ini.php');

@$url = explode("/",$_GET['url']);
$db = new dbClass(DB_LOCATION, DB_USER_NAME, DB_PASSWORD, DB_NAME);

$results = array();

$site    = @addslashes($_GET['site']); 

$query = "SELECT *, count(*) FROM manual_sites
JOIN manual_updates ON  manual_updates.site = manual_sites.site
GROUP BY manual_sites.site
HAVING count(*) > 150";

$results['query'] = $query;
$results['results'] = $db->fetch($query);
output_json($results);

?>
