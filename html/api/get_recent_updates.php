<?
include('../ini.php');

$db = new dbClass(DB_LOCATION, DB_USER_NAME, DB_PASSWORD, DB_NAME);
$results = array();

$borough = @addslashes($_GET['borough']); 
$tags    = @addslashes($_GET['tags']); 
$tags = explode(',', $tags);
$results = array();

$lat       = @addslashes($_GET['lat']); 
$lng       = @addslashes($_GET['lng']); 
$tags      = @addslashes($_GET['tags']);
$mode      = @addslashes($_GET['mode']);
$borough   = @addslashes($_GET['borough']);

$tags = explode(',', $tags);

$query = "SELECT * "; 
if(!empty($lat) && !empty($lng)) {
    $query .= ",SQRT(
        POW(69.1 * (lat - $lat), 2) +
        POW(69.1 * ($lng - lng) * COS(lat / 57.3), 2)) AS distance";
}
 
$query .= " FROM manual_updates ";

$tag_q = array();

if(!empty($tags)) { 
    $query .= " WHERE pubdate > 0  ";
    if ($tags[0] != '') { 
   
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
        $query .= " && (" . $where .")";
    }
}

if(!empty($borough)) { 
    $query .= " && borough='" . $borough ."' ";
}


 
if(!empty($lat) && !empty($lng)) {
    $query .= "  HAVING distance < 2 " ;
}



$query .= "ORDER BY pubdate DESC LIMIT 60"; 
 
$results['query'] = $query;
$results['results'] = $db->fetch($query);

$tag_conversion_array = array(
    'pets_nature' => "Pets & Nature",
    'forsale_giveaway' => "Selling / Giving away",
    'sport' => "Sports",
    'lost' => "Lost",
    'community_events' => "Community Events",
    'local_knowledge'=>"Local Knowledge",
    'crime_emergencies' => "Crime and emergency",
    'art'=> 'Arts & Culture',
    'jobs' => "Jobs", 
    'charity' => "Charity",
    'elderly' => "Elderly",
    'parks' => "Parks",
    'shops'=> "Shops",
    'restaurants_bars'=> "Restaurants, bars & pubs",
    'shops_restaurants'=> "Restaurants, bars & pubs",
    'buy_sell'=> "Buying and Selling",
    'food_drink' => "Food & Drink",
    'council'=> "Local Government",
    'transport' => "Transport",
    'councils'=> "Local Government",
    'disabilities' => "Disabilities",
    'kids' => "Kids",
    'publicspace' => "Public Space"
);

foreach($results['results'] as $key=>$value) { 
    
    $tags = array();
    
    for($i=1; $i<5; $i++) { 
        $cat = $value['category_'.$i];
        
        if(!empty($cat) && $cat != 'undefined' && $cat !='--') { 
            $tags[] = $tag_conversion_array[$cat];
        }
    }
    
    $results['results'][$key]['tags'] = $tags;
}




output_json($results);
