<?
include('include.php');


$sites[0]['url']    = 'http://www.beckenhamtown.us/forum/categories/local-issues-and-qas/listForCategory?feed=yes&amp;xn_auth=no';
$sites[0]['name']   = 'beckenham';

$sites[1]['url']    = 'http://www.beckenhamtown.us/forum/categories/entertainment-events-whats/listForCategory?feed=yes&amp;xn_auth=no';
$sites[1]['name']   = 'beckenham';

$sites[2]['url']    = 'http://www.beckenhamtown.us/forum/categories/local-services-businesses/listForCategory?feed=yes&amp;xn_auth=no';
$sites[2]['name']   = 'beckenham';

$sites[3]['url']    = 'http://www.beckenhamtown.us/forum/categories/roads-travel-transport/listForCategory?feed=yes&amp;xn_auth=no';
$sites[3]['name']   = 'beckenham';

$sites[4]['url']    = 'http://www.beckenhamtown.us/forum/categories/local-recommendations/listForCategory?feed=yes&amp;xn_auth=no';
$sites[4]['name']   = 'beckenham';




foreach($sites as $site) { 
    
    $feed = new SimplePie();
	$feed->set_feed_url($site['url']);
	$feed->enable_cache(false);
	$feed->init();
	$feed->handle_content_type();

    	$max = $feed->get_item_quantity();
    	for ($x = 0; $x < $max; $x++)  {

    		$item = $feed->get_item($x);

            //test for uniqueness 
            $query = "SELECT * FROM manual_updates WHERE link = '".$item->get_permalink()."'";
            $result = mysql_fetch_array(mysql_query($query)); 

            if (empty($result)) { 

                $query = "INSERT INTO manual_updates (site, title, description, link, pubdate) 
                VALUES (
                    '".$site['name']."', 
                    '".mysql_real_escape_string($item->get_title())."', 
                    '".mysql_real_escape_string($item->get_description())."', 
                    '".mysql_real_escape_string($item->get_permalink())."', 
                    '".mysql_real_escape_string(strtotime($item->get_date()))."')";       
                echo $query; 

                mysql_query($query); 
                ?>
        		<div class="item">
        			<h2 class="title"><a href="<?php echo $item->get_permalink(); ?>"><?php echo $item->get_title(); ?></a></h2>
        			<?php echo $item->get_description(); ?>
        			<p><small>Posted on <?php echo $item->get_date('j F Y | g:i a'); ?></small></p>
        			<h2>SAVED!</h2>
        		</div>
                <?
            }   
        }
    }






?>