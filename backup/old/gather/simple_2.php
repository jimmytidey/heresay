<?
include('include.php');


$sites[3]['url']    = 'http://creativeclerkenwell.com/feed/rss';
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

$sites[69]['url']    = 'http://queensparkforum.org/blog.php/feed/';
$sites[69]['name']   = 'queensparkforum.org';

$sites[70]['url']    = 'http://littlelambeth.blogspot.com/feeds/posts/default?alt=rss';
$sites[70]['name']   = 'littlelambeth.blogspot.com';

$sites[71]['url']    = 'http://www.streathamguardian.co.uk/news/rss/';
$sites[71]['name']   = 'streathamguardian.co.uk';

$sites[72]['url']    = 'http://www.westbourneforum.org.uk/blog.php/?feed=rss2';
$sites[72]['name']   = 'westbourneforum.org.uk';

$sites[73]['url']    = 'http://www.peckhamforum.org.uk/feed/rss/';
$sites[73]['name']   = 'peckhamforum.org.uk';

$sites[74]['url']    = 'http://www.gonag.org.uk/?feed=rss2';
$sites[74]['name']   = 'gonag.org.uk';

$sites[75]['url']    = 'http://www.kentishtowner.co.uk/feed/';
$sites[75]['name']   = 'kentishtowner.co.uk';









    
foreach($sites as $site) { 
    echo "<h1>".$site['url']."</h1>";
    $feedUrl = $site['url'];
    $rawFeed = file_get_contents($feedUrl);
    $xml = new SimpleXmlElement($rawFeed);
	
	echo "<h1>".$site['name'] . "</h1>"; 
    foreach ($xml->channel->item as $item)
    {
    	    
    	    
    	    echo "<h3>".strip_tags($item->title). "<em>" .$item->pubDate ."</em></h3>"; 
            echo "<p>". strip_tags($item->description). "</p>";
          
            //test for uniqueness 
            $query = "SELECT * FROM manual_updates WHERE title = '".$item->title."' && site= '" .$site['name']."' ";
            echo $query; 
            $result = mysql_fetch_array(mysql_query($query)); 

            if (empty($result)) { 

              echo "<p style='color:red'>SAVING</p>"; 

              $query = "INSERT INTO manual_updates (site, title, description, link, pubdate) 
              VALUES (
                  '".$site['name']."', 
                  '".mysql_real_escape_string(strip_tags($item->title))."', 
                  '".mysql_real_escape_string(strip_tags($item->description))."', 
                  '".mysql_real_escape_string($item->guid)."', 
                  '".mysql_real_escape_string(strtotime($item->pubDate))."')";       


              mysql_query($query); 

            } 

            else { 
              echo "<p style='color:green'>Already in</p><br/>"; 
            }
    }
	    

    
    echo "<hr />";
}







?>