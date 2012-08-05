<? include('header.php'); ?>

<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAOoFM_kDNJVs_SzvkytQRKBSpgYF3iu7PXc-1iPSD4CpffT2eCRRzD14PFyag3JY4SakJE5_wVYpLxw&sensor=false" type="text/javascript"></script>
<script type="text/javascript" src="api/js/mapstraction.js"></script>
<script src='scripts/index.js'></script>
<script src='scripts/index_map.js'></script>

<script>
    $(document).ready(function() { 
        heresay.init(51.5073346, -0.1276831, 12, "", "last_week")
    }); 
</script>
<div id='map_container'>
    <div id="mapstraction" ></div>
</div>

<div id='logo'>
    <img  src='images/logo_small.png' />
    <span id='filter' class='filter' >Filter</span>
    <img src='images/down.png' id='arrow' class='filter' />
    
    <div id='filter_controls'>
        
        <div class='filter_category'>
            <label for='events'>Events</label>
            <input type='checkbox' value='events' name='events' />
        </div>
        
        <div class='filter_category'>
            <label for='buy_sell'>For sale</label>
            <input type='checkbox' value='buy_sell' name='buy_sell' />    
        </div>
        
         <div class='filter_category'>
            <label for='animals'>Animals and Wildlife</label>
            <input type='checkbox' value='animals' name='animals' />
        </div>

         <div class='filter_category'>
            <label for='local'>Local knowledge</label>
            <input type='checkbox' value='local' name='local' />
        </div>       

         <div class='filter_category'>
            <label for='animals'>Sport</label>
            <input type='checkbox' value='sport' name='sport' />
        </div>                

         <div class='filter_category'>
            <label for='crime'>Crime</label>
            <input type='checkbox' value='crime' name='crime' />
        </div>

         <div class='filter_category'>
            <label for='transport'>Transport</label>
            <input type='checkbox' value='transport' name='transport' />
        </div>   
        
         <div class='filter_category'>
            <label for='animals'>Music</label>
            <input type='checkbox' value='music' name='music' />
        </div>
        
         <div class='filter_category'>
            <label for='food'>Food</label>
            <input type='checkbox' value='food' name='food' />
        </div> 
        
         <div class='filter_category'>
            <label for='council'>Pubic space</label>
            <input type='checkbox' value='council' name='council' />
        </div>                            
        
        <select id='time_filter'>
            <option value='today'>Today</option>
            <option value='last_week'>Last Week</div>
            <option value='last_week'>Last Month</div>
        <select>
            
        <input type='button' value='Filter' id='filter_button' />
    </div>
</div>


<div id='container'>



<h1>What is Heresay?</h1>
<p>It's a map that aggregates what people are saying on locally focused forums &amp; blogs.</p>
<p>At the moment the forums are:</p>
<ul>
    <li><a href='http://www.beckenhamtown.us'>Beckenhamtown</a></li>
    <li><a href='http://bowesandbounds.org'>Bowes and Bounds</a></li>
    <li><a href='http://www.chiswickw4.com'>Chiswick</a></li>
    
    <li><a href='http://dalstonpeople.co.uk'>dalstonpeople.co.uk</a></li>
    
    <li><a href='http://www.ealingtoday.co.uk'>Ealing</a></li>
    <li><a href='http://www.eastdulwichforum.co.uk'>East Dulwich Forum</a></li>
    
    <li><a href='http://harringayonline.com'>harringayonline.com</a></li>
    <li><a href='http://hernehillforum.org.uk'>hernehillforum.org.uk</a></li>
    <li><a href='http://kingscrossenvironment.com'>Kings Cross</a></li>   
    <li><a href='http://meracouk.blogspot.co.uk/'>Mile End Residents Association</a></li> 
    <li><a href='http://www.putneysw15.com/'>Putney</a></li> 
    <li><a href='http://london-se1.co.uk'>london-se1.co.uk</a></li>
    <li><a href='http://www.southeastcentral.co.uk'>southeastcentral.co.uk</a></li>
    <li><a href='http://thebrixtonforum.co.uk'>thebrixtonforum.co.uk</a></li>
    <li><a href='http://urban75.com'>urban75.com</a></li>
    
  
   
    
                
</ul>
 
<p>I would like to add others - please let me know if there is a forum you would like adding.</p>
        
<p><strong>JSON feed:</strong> http://heresay.org.uk/api/recent_threads.php</p>
<p>[RSS coming soon...]</p>

<p><strong>Iframe embed:</strong></p>
<p>&lt;iframe src=&quot;http://heresay.org.uk/iframe.php?zoom=11&amp;center=51.548470058664954,-0.0556182861328125&quot; width=&quot;300&quot; height=&quot;300&quot; frameBorder=&quot;0&quot; scrolling=&quot;no&quot;&gt;Browser not compatible. &lt;/iframe &gt;</p>

<h1>Get in touch</h1>

<p>jimmytidey@gmail.co.uk</p> 

</div >


<? include('footer.php'); ?>