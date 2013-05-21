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
           
            <br/>
            
            <p>Heresay is a tool for understanding communities.</p>
        
            <p>All over the web there are unstructured conversations about local issues: health, planning, crime. When the bins are collected, when the bins aren't collected.</p>
        
            <p>We convert it into structured data that organisations can easily use. We locate content by borough, ward and constituency, and tag according to topic.</p>
        </div>
        
        <div class='span3'>
            <h3 id='blog_link'><a href='http://heresay-blog.tumblr.com'>Tumblr &rarr;</a></h3>  
            <h3 id='blog_link'><a href='http://heresay-blog.tumblr.com'>Main site </a></h3>  
        </div>    
    
    </div>
    
    
    
    <div class='row'>
            
        
        <div class='span8' >

            
            <div id='listing_container'>
            <h4 id='updates_header'>Selected updates from <?=$ward ?> ward</h4>
            
            
            <?  
                if (empty($ward)) {
                    $results = $db->fetch('SELECT * from manual_updates WHERE favourite = 1 ORDER BY pubdate desc LIMIT 10');
                }
                else { 
                    $query = "SELECT * from manual_updates WHERE borough LIKE '$borough' ORDER BY pubdate desc LIMIT 80";
                    $results = $db->fetch($query);
                }
                
                foreach($results as $result) { 
                    show_listing($result);
                }
            ?>
            </div>
        </div>
        
        
        <div class='span3'>
            
            <div id='controls'>
                
                <!--
                <label for='filter_by_borough'>Borough</label>
                <select id='filter_by_borough'>
                    <option value=''> -- all boroughs -- </option>
                    <option value='City of London Corporation'>City</option>
                    <option value='Westminster City Council'>Westminster</option>
                    <option value='Kensington and Chelsea Borough Council'>Kensington and Chelsea</option>
                    <option value='Hammersmith and Fulham Borough Council'>Hammersmith and Fulham</option>
                    <option value='Wandsworth Borough Council'>Wandsworth</option>
                    <option value='Camden Borough Council'>Camden</option>
                    <option value='Haringey Borough Council'>Haringey</option>
                    <option value='Lambeth Borough Council'>Lambeth</option>
                    <option value='Southwark Borough Council'>Southwark</option>                
                    <option value='Islington Borough Council'>Islington</option>
                    <option value='Hackney Borough Council' >Hackney</option>
                    <option value='Tower Hamlets Borough Council' >Tower Hamlets</option>                                                
                </select>
                
                
                <label for='tags'>Category</label>
                <select id='tags'>
                    <option value=''> -- all topics -- </option>
                    <option value='crime_emergencies'>Crime</option>
                    <option value='community_events'>Events</option>                
                    <option value='kids,disabilities,elderly'>Demographics</option>
                    <option value='restaurants_bars,art,sport,food_drink,jobs,parks'>Community</option>
                    <option value='transport' >Transport</option>                                                
                </select>
                
                
            </div>
        
            <p class='btn' id='seach_btn' >Search</p>
            <div id='description'>
           
            
                <p><em class='alpha'>Results represent a sample of the data Heresay gathers</em></p>
            
            </div>
            -->
        
        </div>
        
        
        
    </div>    
    
</div>



<? include('footer.php') ?>
