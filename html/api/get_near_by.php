<?
include('../ini.php');

$db = new dbClass(DB_LOCATION, DB_USER_NAME, DB_PASSWORD, DB_NAME);
$results = array();

$postcode   = @$_GET['postcode']; 
$lat        = @addslashes($_GET['lat']); 
$lng        = @addslashes($_GET['lng']); 
$time_ago   = strtotime('7 days ago');

if (!empty($postcode)) { 
  
    
    $url = 'http://mapit.mysociety.org/postcode/'. $postcode;
   
    $ch = curl_init(); 

    // set url 
    curl_setopt($ch, CURLOPT_URL, $url); 

    //return the transfer as a string 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

    // $output contains the output string 
    $output = curl_exec($ch); 

    // close curl resource to free up system resources 
    curl_close($ch);
    
    
    $location_data = json_decode($output, true);
    
    $lat = $location_data['wgs84_lat'];
    $lng = $location_data['wgs84_lon'];
}
  

$query = "SELECT 
  *, 
   ( 3959 * acos( cos( radians($lat) ) * cos( radians(lat) ) 
   * cos( radians(lng) - radians($lng)) + sin(radians($lat)) 
   * sin( radians(lat)))) AS distance 
FROM manual_updates 
WHERE pubdate > $time_ago
ORDER BY distance 
LIMIT 100";


 
 
 
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
    
    $results['results'][$key]['human_date'] = date("F j, Y", $value['pubdate']);
}




output_json($results);
