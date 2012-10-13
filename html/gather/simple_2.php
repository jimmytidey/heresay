<?
include('include.php');


$sites[3]['url']    = 'http://creativeclerkenwell.com/feed/rss/atom';
$sites[3]['name']   = 'creativeclerkenwell.com';

$sites[5]['url']    = 'http://westealingneighbours.org.uk/WEN-blog/feed/';
$sites[5]['name']   = 'www.westealingneighbours.org.uk';

$sites[6]['url']    = 'http://duchessofhackney.com/feed/';
$sites[6]['name']   = 'duchessofhackney.com';

$sites[7]['url']    = 'http://davehill.typepad.com/claptonian/rss.xml';
$sites[7]['name']   = 'davehill.typepad.com/claptonian';

$sites[40]['url']    = 'http://brixtonblog.com/feed';
$sites[40]['name']   = 'brixtonblog.com';

$sites[42]['url']    = 'http://vauxhallcivicsociety.org.uk/feed/';
$sites[42]['name']   = 'vauxhallcivicsociety.org.uk';

$sites[67]['url']    = 'http://transitionstreatham.org/feed/';
$sites[67]['name']   = 'transitionstreatham.org';

$sites[68]['url']    = 'http://wandsworthsw18.com/rss.xml';
$sites[68]['name']   = 'wandsworthsw18.com';

$sites[68]['url']    = 'http://queensparkforum.org/blog.php/feed/';
$sites[68]['name']   = 'queensparkforum.org';



    
foreach($sites as $site) { 
    echo "<h1>".$site['url']."</h1>";
    
    $feed = new SimplePie();
	$feed->set_feed_url($site['url']);
	$feed->enable_cache(false);
	echo($feed->init());
	$feed->handle_content_type();
	$max = $feed->get_item_quantity();
	
	echo "<h1>".$site['name'] . " - " . $max ."</h1>"; 
	
	for ($x = 0; $x < $max; $x++)  {
		
		$item = $feed->get_item($x);
	    
	    echo "<h3>".strip_tags($item->get_title()). "<em>" .$item->get_date() ."</em></h3>"; 
        echo "<p>". strip_tags($item->get_description()). "</p>";
        
        //test for uniqueness 
        $query = "SELECT * FROM manual_updates WHERE link = '".$item->get_permalink()."'";
        echo $query; 
        $result = mysql_fetch_array(mysql_query($query)); 
        
        if (empty($result)) { 
            
            echo "<p style='color:red'>SAVING</p>"; 
            
            $query = "INSERT INTO manual_updates (site, title, description, link, pubdate) 
            VALUES (
                '".$site['name']."', 
                '".mysql_real_escape_string(strip_tags($item->get_title()))."', 
                '".mysql_real_escape_string(strip_tags($item->get_description()))."', 
                '".mysql_real_escape_string($item->get_permalink())."', 
                '".mysql_real_escape_string(strtotime($item->get_date()))."')";       


            mysql_query($query); 

        } 
        
        else { 
            echo "<p style='color:green'>Already in</p><br/>"; 
        }  
    }
    
    echo "<hr />";
}







?>