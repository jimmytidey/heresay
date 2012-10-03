<? include('header.php'); ?>


<script src='scripts/index.js'></script>

<div id='map_container'>
    <div id="mapstraction" ></div>
</div>

<div id='logo'>
    <img  src='images/logo_small.png' />
    <span id='filter' class='filter' >Filter</span>
    <img src='images/down.png' id='arrow' class='filter' />
    
    <div id='filter_controls'>
        
         <div class='filter_category' id='filter_council' >
            <label for='council'>Shared space, council matters</label>
            <input type='checkbox' value='council' name='council' />
        </div>  
        
         <div class='filter_category' id='filter_local' >
            <label for='local_knowledge'>Local knowledge</label>
            <input type='checkbox' value='local_knowledge' name='local_knowledge' />
        </div>              

         <div class='filter_category' id='filter_crime'>
            <label for='crime_emergencies'>Crime</label>
            <input type='checkbox' value='crime_emergencies' name='crime_emergencies' />
        </div>      
        
         <div class='filter_category' id='filter_community_events'>
            <label for='community_events'>Community Events</label>
            <input type='checkbox' value='community_events' name='community_events' />
        </div>          

         <div class='filter_category' id='filter_art'>
            <label for='art'>Art, Music, Culture</label>
            <input type='checkbox' value='art' name='art' />
        </div>                

         <div class='filter_category' id='filter_shops'>
            <label for='shops_restaurants'>Shops, restaurants, bars</label>
            <input type='checkbox' value='shops_restaurants' name='shops_restaurants' />
        </div>   
        
         <div class='filter_category' id='filter_animals'>
            <label for='pets_nature'>Animals and nature</label>
            <input type='checkbox' value='pets_nature' name='pets_nature' />
        </div>

         <div class='filter_category' id='filter_kids'>
            <label for='kids'>Kids / youth</label>
            <input type='checkbox' value='kids' name='kids' />
        </div>
          
         <div class='filter_category' id='filter_sport'>
            <label for='charity'>Sport</label>
            <input type='checkbox' value='sport' name='sport' />
        </div>                                  
                
        <select id='time_filter'>
            <option value='this_month'>Last Month</option>
            <option value='this_week'>Last Week</option>
            <option value='today'>Today</option>
        <select>
            
        <input type='button' value='Filter' id='filter_button' />
    </div>
</div>


<div id='container'>

    <h1>What is Heresay?</h1>
    <p>It's a map that aggregates what people are saying on locally focused forums &amp; blogs.</p>

    <p>Heresay aims to help these conversations reach a wider audience, to contribute to vigorous local politics and healthy communities.</p> 

    <p>At the moment there are about 70 sites being mapped - if you think yours isn't <a href='mailto:jimmytidey@gmail.com'>email me</a>.</p>

    <h1>A map for your forum or blog?</h1>

    <p>I'd love to get this map out to the community by having people embed it on their forum or blog. If you are interested,  <a href='mailto:jimmytidey@gmail.com'>contact me</a>. </p> 

    <h1>Developer!</h1>
    
    <p><a href='developer.php'>Take a look at this page</a></p>

</div >


<? include('footer.php'); ?>