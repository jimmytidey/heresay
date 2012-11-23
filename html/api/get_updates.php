<?
include('../ini.php');

@$url = explode("/",$_GET['url']);
$db = new dbClass(DB_LOCATION, DB_USER_NAME, DB_PASSWORD, DB_NAME);

$lat    = @addslashes($_GET['lat']); 
$lng    = @addslashes($_GET['lng']); 
$tags   = @addslashes($_GET['tags']);

$tags = explode(',', $tags);

if ($lat && $lng) { 
    
    $query = "SELECT *,
    SQRT(
        POW(69.1 * (lat - $lat), 2) +
        POW(69.1 * ($lng - lng) * COS(lat / 57.3), 2)) AS distance
    FROM manual_updates";
    
    $tag_q = array();
    
    if ($tags[0] != '') { 
        $query .= " WHERE ";
        foreach ($tags as $tag) {
            if ($tag != '') { 
                $tag_query  = '';
                $tag_query .= "category_1 = '$tag' || ";
                $tag_query .= "category_2 = '$tag' || ";
                $tag_query .= "category_3 = '$tag' || ";
                $tag_query .= "category_4 = '$tag' ";
                $tag_q[] =  $tag_query;
            }                                       
        }
        $where = implode('||', $tag_q);
        $query .= $where;
    }
    
    $query .= " HAVING distance < 25 ORDER BY distance,pubdate LIMIT 50"; 
}


$results = $db->fetch($query);
output_json($results);

?>