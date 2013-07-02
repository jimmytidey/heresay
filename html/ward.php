<? include('header.php') ?>
<? include('fragments/listing.php') ?>
<?
    $ward = @addslashes($_GET['ward']);
    $borough = @addslashes($_GET['borough']);
    $tags = @addslashes($_GET['tags']);
?>


<div class='container'>
    
    <div class='row'>
        <div class='span8 '>
            <h4 id='updates_header'>Updates from <?=$ward ?> ward</h4><br/>
            <p>This represents one month of updates.</p>
        </div>
        
        <div class='span3'>
            <h3 id='blog_link'><a href='http://heresay-blog.tumblr.com'>Tumblr &rarr;</a></h3>  
            <h3 id='blog_link'><a href='http://heresay-blog.tumblr.com'>Main site </a></h3>  
        </div>    
    
    </div>
    
    <div class='row'>       
        <div class='span10' >
            <div id='listing_container'>
            
            <?      
                $horizon = time()-(40*24*60*60);
                
                if (empty($ward)) {
                    $results = $db->fetch('SELECT *, manual_updates.lat as manual_updates_lat, manual_updates.lng as manual_updates_lng from manual_updates WHERE favourite = 1 ORDER BY pubdate desc LIMIT 10');
                }
                else { 
                    $query = "SELECT * from manual_updates JOIN manual_sites ON manual_updates.site = manual_sites.site WHERE ward LIKE '$ward' && pubdate > $horizon ORDER BY pubdate desc LIMIT 30";
                }
                
                $results = $db->fetch($query);
                
                foreach($results as $result) { 
                    show_listing($result);
                }
            ?>
            </div>
        </div>
    </div>    
</div>

<? include('footer.php') ?>