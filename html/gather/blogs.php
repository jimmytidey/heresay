<?
include('include.php');


$sites[0]['url']    = 'http://www.hackneyhear.com/blog/';
$sites[0]['name']   = 'http://www.hackneyhear.com/blog/';

$sites[1]['url']    = 'http://thegallerycafe.blogspot.co.uk/';
$sites[1]['name']   = 'http://thegallerycafe.blogspot.co.uk/';

$sites[2]['url']    = 'http://clapham-omnibus.blogspot.co.uk/';
$sites[2]['name']   = 'http://clapham-omnibus.blogspot.co.uk/';


$sites[3]['url']    = 'http://www.creativeclerkenwell.com/feed/';
$sites[3]['name']   = 'http://www.creativeclerkenwell.com/';



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