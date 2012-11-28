<?
include('../ini.php');

@$url = explode("/",$_GET['url']);
$db = new dbClass(DB_LOCATION, DB_USER_NAME, DB_PASSWORD, DB_NAME);

$results = array();

$lat    = @addslashes($_GET['lat']); 
$lng    = @addslashes($_GET['lng']); 
$tags   = @addslashes($_GET['tags']);
$mode   = @addslashes($_GET['mode']);

$tags = explode(',', $tags);

if (is_numeric($lat) && is_numeric($lng)) { 
    $results['method'] = "Tags and location";
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


else if (!empty($tags[0])) { 

    $results['method'] = "No location, just tags"; 
    $query = "SELECT *  FROM manual_updates ";
    
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

     $query .= " ORDER BY pubdate DESC LIMIT 50";
}

else if ($mode == 'selected'){ 
    $results['method'] = "Favourites";
    $query = "SELECT * from manual_updates WHERE favourite='1' ORDER BY pubdate DESC LIMIT 20";
}

else if ($mode == 'recent'){ 
    $results['method'] = "Recent";
    $query = "SELECT * from manual_updates WHERE lat != '--' &&  lat != '' ORDER BY pubdate DESC LIMIT 100";
}

$results['query'] = $query;
$results['results'] = $db->fetch($query);
output_json($results);

?>
