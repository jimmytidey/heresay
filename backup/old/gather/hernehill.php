<?


include('../db_info.php');
include_once('../simplepie/autoloader.php');
include_once('../simplepie/idn/idna_convert.class.php');

$sites[0]['url']    = 'http://feeds.feedburner.com/hernehillforum';
$sites[0]['name']   = 'hernehillforum.org.uk';

/*
$feeds[1]['url']    = 'https://www.ictu.nl/rss.xml';
$feeds[1]['none']   = '';

$feeds[2]['url']    = 'https://www.ictu.nl/rss.xml';
$feeds[2]['none']   = '';
*/
    
foreach($sites as $site) { 
    
    $feed = new SimplePie();
	$feed->set_feed_url($site['url']);
	$feed->enable_cache(false);
	$feed->init();
	$feed->handle_content_type();
	
	$max = $feed->get_item_quantity();
	for ($x = 0; $x < $max; $x++)  {
		
		$item = $feed->get_item($x);
	    
	    //text to make sure this is a main node 
	    $clean =  strip_tags(htmlspecialchars_decode ($item->get_description()));
	    echo $clean; 
	    echo '---';
	    
	    $clean = preg_replace( '/\s+/', ' ', $clean ); 
	    
        $original = strpos($clean,"parent node:&nbsp; -1");
        
        $clean_description = str_replace(" parent node:&nbsp; -1 Message icon:&nbsp; Standard", "", $clean);
        
        echo "<p>".$item->get_title()."</p>";
        echo "<p>".$clean_description."</p>";
        
	    if ($original == 1) { 
	        echo "found negative parent node";
            //test for uniqueness 
            $query = "SELECT * FROM manual_updates WHERE link = '".$item->get_permalink()."'";
            $result = mysql_fetch_array(mysql_query($query)); 
        
            if (empty($result)) { 
                
                $query = "INSERT INTO manual_updates (site, title, description, link, pubdate) 
                VALUES (
                    '".$site['name']."', 
                    '".mysql_real_escape_string($item->get_title())."', 
                    '".mysql_real_escape_string($clean_description)."', 
                    '".mysql_real_escape_string($item->get_permalink())."', 
                    '".mysql_real_escape_string(strtotime($item->get_date()))."')";       
                //echo $query; 

               mysql_query($query); 
                ?>
        	        <h3>SAVED</h3>
        	        
                <?
            }   
        }
        ?>
        <br/>
        <br/>
        <br/>
        <hr/>        
        <?
        
    }
}



?>