<?
include('../ini.php');

@$url = explode("/",$_GET['url']);
$db = new dbClass(DB_LOCATION, DB_USER_NAME, DB_PASSWORD, DB_NAME);

$results = array();

$site   = @addslashes($_GET['site']); 
$lat    = @addslashes($_GET['lat']); 
$lng    = @addslashes($_GET['lng']);
$zoom   = @addslashes($_GET['zoom']); 


if ($zoom > 12 ) { 
    $query = "SELECT *, count(*) as count,
       ( 3959 * acos( cos( radians($lat) ) * cos( radians(manual_sites.lat) ) 
       * cos( radians(manual_sites.lng) - radians($lng)) + sin(radians($lat)) 
       * sin( radians(manual_sites.lat)))) AS distance 
    FROM manual_sites
    JOIN manual_updates ON  manual_updates.site = manual_sites.site
    GROUP BY manual_sites.site
    HAVING count > 50
    ORDER BY distance ASC
    LIMIT 10";
}
else { 
    
    $query = "SELECT *, count(*),
       ( 3959 * acos( cos( radians($lat) ) * cos( radians(manual_sites.lat) ) 
       * cos( radians(manual_sites.lng) - radians($lng)) + sin(radians($lat)) 
       * sin( radians(manual_sites.lat)))) AS distance 
    FROM manual_sites
    JOIN manual_updates ON  manual_updates.site = manual_sites.site
    GROUP BY manual_sites.site
    HAVING count(*) > 150
    ORDER BY count(*) desc
    ";
    
}    


$results['query'] = $query;
$results['results'] = $db->fetch($query);
output_json($results);

?>
