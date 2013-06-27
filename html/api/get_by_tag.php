<?
include('../ini.php');

@$url = explode("/",$_GET['url']);
$db = new dbClass(DB_LOCATION, DB_USER_NAME, DB_PASSWORD, DB_NAME);

$results = array();

$tag = @addslashes($_GET['tag']);

if(!empty($tag)) {

    $query = "SELECT * FROM manual_updates 
        WHERE (category_1 = '$tag' || category_2= '$tag' || category_3= '$tag' || category_4= '$tag') 
        && lat !=''  
        ORDER BY pubdate DESC LIMIT 600";
}
else { 
    
    $query = "SELECT * FROM manual_updates 
        WHERE lat !=''  
        ORDER BY pubdate DESC LIMIT 600";
    
}        

$results['query'] = $query;
$results['results'] = $db->fetch($query);
output_json($results);

?>
