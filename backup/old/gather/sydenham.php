<?
include('include.php');

$read_url = 'http://sydenham.org.uk/forum/viewtopic.php?t=';

$sites[0]['url']    = 'http://sydenham.org.uk/forum/feed.php';
$sites[0]['name']   = 'sydenham.org.uk';



foreach($sites as $site) { 
    
    $feed = new SimplePie();
	$feed->set_feed_url($site['url']);
	$feed->enable_cache(false);
	$feed->init();
	$feed->handle_content_type();
	
	$max = $feed->get_item_quantity();
	for ($x = 0; $x < $max; $x++)  {
		
		$item = $feed->get_item($x);
	    
        $link = $item->get_link();

        $link = explode('t=', $link);
        
        
        $link = explode('&amp;p=', $link[1]);

        $original_post_url = $read_url. $link[0] ;

        $shit_html = file_get_contents($original_post_url); 

        //get title 
        $less_shit_html = explode('<h2>', $shit_html);
        $title = explode('</h2>', $less_shit_html[1]); 
        $title = strip_tags($title[0]);        
        
        //get description
        $less_shit_html = explode('<div class="content">', $shit_html);
        $description = explode('</div>', $less_shit_html[1]); 
        $description = $description[0];        
        
	    echo "<h3>".$title.'</h3>';
	    echo $description ;
	   
	    
        $query = "SELECT * FROM manual_updates WHERE link = '".$original_post_url."'";
        $result = mysql_fetch_array(mysql_query($query)); 
    
        if (empty($result)) { 
            
            $query = "INSERT INTO manual_updates (site, title, description, link, pubdate) 
            VALUES (
                '".$site['name']."', 
                '".mysql_real_escape_string($title)."', 
                '".mysql_real_escape_string($description)."', 
                '".mysql_real_escape_string($original_post_url)."', 
                '".mysql_real_escape_string(strtotime($item->get_date()))."')";       
            //echo $query; 

            mysql_query($query); 
            ?>
    	        <h3>SAVED</h3>
    	        
            <?
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



?>