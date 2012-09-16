<? include('header.php'); ?>

<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAOoFM_kDNJVs_SzvkytQRKBSpgYF3iu7PXc-1iPSD4CpffT2eCRRzD14PFyag3JY4SakJE5_wVYpLxw&sensor=false" type="text/javascript"></script>
<script type="text/javascript" src="api/js/mapstraction.js"></script>
<script src='scripts/index.js'></script>
<script src='scripts/index_map.js'></script>

<script>
    $(document).ready(function() { 
        
        var recency = gup('recency'); 
        var id = gup('id'); 
        var lat = gup('lat'); 
        var lng = gup('lng'); 
        var id = gup('id');
        var category = gup('category'); 

        if(!isNumber(lat)) { 
            lat = 51.5073346;
        }  
        if(!isNumber(lng)) { 
            lng = -0.1276831;
        }        
        
        if (id) { 
            heresay.init(lat, lng, 12, category, '', id);
        }  
        
        else { 
            if(recency =='') { 
                recency = "this_week";
            }  
            console.log(recency);
            heresay.init(lat, lng, 12, category, recency, '');
        }
       
        
    	function gup(name)
    	{
    	  name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
    	  var regexS = "[\\?&]"+name+"=([^&#]*)";
    	  var regex = new RegExp( regexS );
    	  var results = regex.exec( window.location.href );
    	  if( results == null )
    		return "";
    	  else
    		return results[1];
    	}     
    	
    	function isNumber(n) {
          return !isNaN(parseFloat(n)) && isFinite(n);
        }
           
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
        
         <div class='filter_category' id='filter_council' >
            <label for='council'>Shared space, council matters</label>
            <input type='checkbox' value='council' name='council' />
        </div>  
        
         <div class='filter_category' id='filter_local' >
            <label for='local_knowledge'>Local knowledge</label>
            <input type='checkbox' value='local_knowledge' name='local_knowledge' />
        </div>              

         <div class='filter_category' id='filter_crime'>
            <label for='art'>Crime</label>
            <input type='checkbox' value='crime_emergencies' name='crime_emergencies' />
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
            <option value='today'>Today</option>
            <option value='this_week'>Last Week</div>
            <option value='this_month'>Last Month</div>
        <select>
            
        <input type='button' value='Filter' id='filter_button' />
    </div>
</div>


<div id='container'>



<h1>What is Heresay?</h1>
<p>It's a map that aggregates what people are saying on locally focused forums &amp; blogs.</p>
<p>At the moment the forums are:</p>
<ul>
    <li><a href='http://www.hackneyhear.com/blog/feed'>hackneyhear.com</a></li>
    <li><a href='http://thegallerycafe.blogspot.com/feeds/posts/default?alt=rss'>thegallerycafe.blogspot.co.uk</a></li>
    <li><a href='http://clapham-omnibus.blogspot.com/feeds/posts/default?alt=rss'>clapham-omnibus.blogspot.co.uk</a></li>
    <li><a href='http://www.creativeclerkenwell.com/feed/atom/'>creativeclerkenwell.com</a></li>
    <li><a href='http://www.westealingneighbours.org.uk/WEN-blog/feed/'>westealingneighbours.org.uk</a></li>
    <li><a href='http://www.duchessofhackney.com/feed/'>duchessofhackney.com</a></li>
    
    
    <li><a href='http://www.actonw3.com/'>Acton</a></li>
    <li><a href='http://www.beckenhamtown.us'>Beckenhamtown</a></li>
    <li><a href='http://bowesandbounds.org'>Bowes and Bounds</a></li>
     <li><a href='http://www.brentfordtw8.com'>Brentford</a></li>
    <li><a href='http://www.chiswickw4.com'>Chiswick</a></li>
    <li><a href='http://dalstonpeople.co.uk'>dalstonpeople.co.uk</a></li>
    <li><a href='http://www.ealingtoday.co.uk'>Ealing</a></li>
    <li><a href='http://www.eastdulwichforum.co.uk'>East Dulwich Forum</a></li>
    <li><a href='http://www.fulhamsw6.com'>Fullham</a></li>    
    <li><a href='http://www.hammersmithtoday.co.uk'>Hammersmith</a></li>
    <li><a href='http://harringayonline.com'>harringayonline.com</a></li>
    <li><a href='http://hernehillforum.org.uk'>hernehillforum.org.uk</a></li>
    <li><a href='http://kingscrossenvironment.com'>Kings Cross</a></li>   
    <li><a href='http://meracouk.blogspot.co.uk/'>Mile End Residents Association</a></li> 
    <li><a href='http://www.putneysw15.com/'>Putney</a></li> 
    <li><a href='http://london-se1.co.uk'>london-se1.co.uk</a></li>
    <li><a href='http://www.shepherdsbushw12.com'>Shepherds Bush</a></li>
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

<p>jimmytidey@gmail.com</p> 

</div >


<? include('footer.php'); ?>