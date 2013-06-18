<?
include('../ini.php');

@$url = explode("/",$_GET['url']);
$db = new dbClass(DB_LOCATION, DB_USER_NAME, DB_PASSWORD, DB_NAME);

$query = 'SELECT * from manual_updates WHERE favourite = 1 ORDER BY pubdate desc LIMIT 30';


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

?>