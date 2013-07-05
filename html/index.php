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
            <br>
            <p><strong>Heresay is a tool for understanding communities.</strong></p>
        
            <p>All over the web there are unstructured conversations about local issues: health, planning, crime. When the bins are collected, when the bins aren't collected.</p>
        
            <p>We convert it into structured data that organisations can easily use. We locate content by borough, ward and constituency, and tag according to topic.</p>
            
            <p>We currently have about 10,000 items of located data, gathered from 140 local <strong>blogs</strong>, <strong>forums</strong>, <strong>Twitter searches</strong> and <strong>Facebook</strong> pages.</p>
            
            <p>Say hello to us: <a href='mailto:jimmy@heresay.org.uk'>jimmy@heresay.org.uk</a></p>
        </div>
        
        <div class='span3'>
            <h3 id='blog_link'><a href='http://heresay-blog.tumblr.com/'>Read our blog &rarr;</a></h3>  
        </div>    
    
    </div>
    
    
    
    <div class='row'>
            
        
        <div class='span8' >
            <h4 id='updates_header'>Example updates by borough</h4><br/>
            <select id='filter_by_borough'>
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
            <div id='main_map'></div>
        </div>
        
        
        <div class='span3'>
            <!--
            <div id='controls'>
                <label for='filter_by_borough'>Borough</label>

                
                
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
    
    <div class='row'>
        <div class='span8' >
            <h4 id='updates_header'>Case Studies </h4> <br/>
            <p>We've done two case studies in the Borough of Kensington and Chelsea, looking at data collected during June.</p> 
            <p><a href='casestudies/cremorne.php'>Cremorne</a></p>
            <p><a href='casestudies/golborne.php'>Golborne</a></p>
        </div>
    </div>
    
    <div class='row'>
        <div class='span8' >
            <h4 id='updates_header'>Aggregate Data - Visualisation </h4> <br/>
            <p></p> 
            <p><a href='http://localhost:88/vis/heatmap.php?lat=51.511214&lng=-0.119824&zoom=11&mode=tags'>By Topics</a></p>
             <p><a href='http://localhost:88/vis/heatmap.php?lat=51.511214&lng=-0.119824&zoom=11&mode=sites'>By the largest hyperlocal communities</a></p>
        </div>
        <br/><br/><br/>
    </div>
    
    
</div>



<? include('footer.php') ?>
