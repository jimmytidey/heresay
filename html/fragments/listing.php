<?



function show_listing($result) {
    
    $tag_conversion_array = array(
        'pets_nature' => "Pets & Nature",
        'forsale_giveaway' => "Markets",
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
        'kids' => "Kids",
        'health' => 'Health', 
        'planning' => "Planning",
        'housing'=> 'Housing'
    );
    
    
    if($result['site_type'] == 'facebook') {
        $site_type_class='facebook_listing';
        $site_name = 'facebook.com' . $result['site'];
    }
    
    else if($result['scraper'] == 'TwitterSearch') {
        $site_type_class='twitter_listing';
        $site_name = 'Twitter search "' . $result['site']. '"';
    }
    
    else if($result['scraper'] == 'TwitterUser') {
        $site_type_class='twitter_listing';
        $site_name = 'Twitter user @' . $result['site'];
    }
    
    
    else { 
        $site_type_class='';
        $site_name = $result['site'];
    }
        
    echo "<div class='listing ".$site_type_class."' >";
    echo "<div class='row'>";
    echo "<div class='span5'>";
        echo "<p class='site'><strong>Source: " . $site_name . "</strong></p>";
        if(!empty($result['title'])){
            echo "<h4><a target='_blank' href='" . $result['link'] . "'>" . html_entity_decode($result['title']) . "</a></h4>";    
        }
        else { 
            echo "<h4><a target='_blank' href='" . $result['link'] . "'> [link] </a></h4>";    
        
        }
        echo "<p class='description'>";
        echo myTruncate($result['description'], 200); 
        echo "</p>";

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

        if (!empty($result['ward'])) {
            //echo "<p class='ward'>Ward: <em>" . $result['ward'] . "</em>,";  
        }
        if (!empty($result['constituency'])) {
            //echo " Constituency: <em>" . $result['constituency']  . "</em> </p>";
        }



        foreach($tags as $tag) { 
            echo "<span class='tags'>" . $tag . "</span>";
        }
    
        echo "<p class='pubdate'>" . date("F j, Y", $result['pubdate']) . "</p>";
    
    echo "</div>";
    echo "<div class='span4 address_column'>";
        echo "<div class='map' data-lat='".$result['manual_updates_lat']."' data-lng='".$result['manual_updates_lng']."' data-zoom='14' ></div>";
        if (!empty($location_name)) {
            echo "<p class='location_name'>" . $result['location_name'] . "</p>";
        }
    echo "</div>";    
    echo "</div></div>";
}   

function myTruncate($string, $limit, $break=".", $pad="...")
{
  // return with no change if string is shorter than $limit
  if(strlen($string) <= $limit) return $string;

  // is $break present between $limit and the end of the string?
  if(false !== ($breakpoint = strpos($string, $break, $limit))) {
    if($breakpoint < strlen($string) - 1) {
      $string = substr($string, 0, $breakpoint) . $pad;
    }
  }

  return $string;
} 
?>