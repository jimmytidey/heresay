<? include('header.php') ?>
<? include('fragments/listing.php') ?>

<div class='container'>
    
    <div class='row'>
        
        <div class='span4'>
            
            <div id='description'>
                <p><em>Heresay finds conversations about local issues from blogs and forums.</em></p>
                
                <p><em class='alpha'>This is only a sample of the data Heresay gathers</em></p>
                
            </div>
            
            <div id='controls'>
                <label for='filter_by_borough'>Borough</label>
                <select id='filter_by_borough'>
                    <option value=''><em> -- all boroughs -- </em></option>
                    <option value='City'>City</option>
                    <option value='Westminster'>Westminster</option>
                    <option value='Kensington and Chelsea'>Kensington and Chelsea</option>
                    <option value='Hammersmith and Fulham'>Hammersmith and Fulham</option>
                    <option value='Wandsworth'>Wandsworth</option>
                    <option value='Camden'>Camden</option>
                    <option value='Haringey'>Haringey</option>
                    <option value='Lambeth'>Lambeth</option>
                    <option value='Southwark'>Southwark</option>                
                    <option value='Islington'>Islington</option>
                    <option value='Hackney' >Hackney</option>
                    <option value='Tower Hamlets' >Tower Hamlets</option>                                                
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
            
      
            
        </div>
        
        
        
        <div class='span8' >
            <div id='main_map'>

            </div>
            
            <div id='listing_container'>
            <h4 id='updates_header'>Selected Recent Updates</h4>
            
            
            <?
                $results = $db->fetch('SELECT * from manual_updates WHERE favourite = 1 ORDER BY pubdate desc LIMIT 10');
                foreach($results as $result) { 
                    show_listing($result);
                }
            ?>
            </div>
        </div>
    </div>    
    
</div>



<? include('footer.php') ?>
