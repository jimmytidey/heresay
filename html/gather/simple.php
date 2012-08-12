<?
include('include.php');

$sites[0]['url']    = 'http://www.hackneyhear.com/blog/feed';
$sites[0]['name']   = 'hackneyhear.com';

$sites[1]['url']    = 'http://thegallerycafe.blogspot.com/feeds/posts/default?alt=rss';
$sites[1]['name']   = 'thegallerycafe.blogspot.co.uk';

$sites[2]['url']    = 'http://clapham-omnibus.blogspot.com/feeds/posts/default?alt=rss';
$sites[2]['name']   = 'clapham-omnibus.blogspot.co.uk';

$sites[3]['url']    = 'http://www.creativeclerkenwell.com/feed/atom/';
$sites[3]['name']   = 'creativeclerkenwell.com';

$sites[5]['url']    = 'http://www.westealingneighbours.org.uk/WEN-blog/feed/';
$sites[5]['name']   = 'www.westealingneighbours.org.uk';

$sites[6]['url']    = 'http://www.duchessofhackney.com/feed/';
$sites[6]['name']   = 'duchessofhackney.com';

$sites[7]['url']    = 'http://davehill.typepad.com/claptonian/rss.xml';
$sites[7]['name']   = 'davehill.typepad.com/claptonian';

$sites[8]['url']    = 'http://swishjunction.wordpress.com/feed/';
$sites[8]['name']   = 'swishjunction.wordpress.com';

$sites[9]['url']    = 'http://www.actonw3.com/rss.xml';
$sites[9]['name']   = 'actonw3.com';

$sites[10]['url']    = 'http://www.brentfordtw8.com/rss.xml';
$sites[10]['name']   = 'brentfordtw8.com';

$sites[11]['url']    = 'http://www.dalstonpeople.co.uk/stories.rss';
$sites[11]['name']   = 'dalstonpeople.co.uk';

$sites[12]['url']    = 'http://www.chiswickw4.com/rss.xml';
$sites[12]['name']   = 'chiswickw4.com';

$sites[13]['url']    = 'http://www.ealingtoday.co.uk/rss.xml';
$sites[13]['name']   = 'ealingtoday.co.uk';

$sites[14]['url']    = 'http://www.fulhamsw6.com/rss.xml';
$sites[14]['name']   = 'fulhamsw6.com';

$sites[15]['url']    = 'http://www.hammersmithtoday.co.uk/rss.xml';
$sites[15]['name']   = 'hammersmithtoday.co.uk';

$sites[16]['url']    = 'http://kingscrossenvironment.com/feed/';
$sites[16]['name']   = 'kingscrossenvironment.com';

$sites[17]['url']    = 'http://meracouk.blogspot.com/feeds/posts/default?alt=rss';
$sites[17]['name']   = 'meracouk.blogspot.com';

$sites[18]['url']    = 'http://www.putneysw15.com/rss.xml';
$sites[18]['name']   = 'putneysw15.com';

$sites[19]['url']    = 'http://www.beckenhamtown.us/forum/categories/local-issues-and-qas/listForCategory?feed=yes&amp;xn_auth=no';
$sites[19]['name']   = 'beckenhamtown.us';

$sites[20]['url']    = 'http://www.beckenhamtown.us/forum/categories/entertainment-events-whats/listForCategory?feed=yes&amp;xn_auth=no';
$sites[20]['name']   = 'beckenhamtown.us';

$sites[21]['url']    = 'http://www.beckenhamtown.us/forum/categories/local-services-businesses/listForCategory?feed=yes&amp;xn_auth=no';
$sites[21]['name']   = 'beckenhamtown.us';

$sites[22]['url']    = 'http://www.beckenhamtown.us/forum/categories/roads-travel-transport/listForCategory?feed=yes&amp;xn_auth=no';
$sites[22]['name']   = 'beckenhamtown.us';

$sites[23]['url']    = 'http://www.beckenhamtown.us/forum/categories/local-recommendations/listForCategory?feed=yes&amp;xn_auth=no';
$sites[23]['name']   = 'beckenhamtown.us';

$sites[24]['url']    = 'http://www.bowesandbounds.org/forum?feed=yes&amp;xn_auth=no';
$sites[24]['name']   = 'bowesandbounds.org';

$sites[25]['url']    = 'http://www.shepherdsbushw12.com/rss.xml';
$sites[25]['name']   = 'www.shepherdsbushw12.com';



    
foreach($sites as $site) { 
    
    echo "<h1>".$site['name']."</h1>"; 
    
    $feed = new SimplePie();
	$feed->set_feed_url($site['url']);
	$feed->enable_cache(false);
	$feed->init();
	$feed->handle_content_type();
	
	$max = $feed->get_item_quantity();
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