<?



function show_listing($result) {
    
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
        'food_drink' => "Food & Drink",
        'council'=> "Local Government",
        'transport' => "Transport",
        'councils'=> "Local Government",
        'disabilities' => "Disabilities",
        'kids' => "Kids"
    );
        
    echo "<div class='listing' >";
    echo "<h3><a href='" . $result['link'] . "'>" . $result['title'] . "</a></h3>";
    
    echo "<p class='site'><strong>" . $result['site'] . "</strong></p>";
    
    echo "<p class='description'>" . $result['description'] . "</p>";

    $tags = array(); 

    for($i=1; $i<5; $i++) { 
        $cat = $result['category_'.$i];
        if(!empty($cat) && $cat != 'undefined') { 
            
            $tag_code = $result['category_'.$i];
            
            if($tag_code) {
                $tags[] = $tag_conversion_array[$tag_code];
            }
        }
    }

    $location_name = $result['location_name'];

    if (!empty($location_name)) {
        echo "<p class='location_name'>" . $result['location_name'] . "</p>";
    }

    foreach($tags as $tag) { 
        echo "<span class='tags'>" . $tag . "</span>";
    }
    
    echo "<p class='pubdate'>" . date("F j, Y", $result['pubdate']) . "</p>";
    echo "</div>";
}    
?>