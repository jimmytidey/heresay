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

        if(!isNumber(lat)) { 
            lat = 51.5073346;
        }  
        if(!isNumber(lng)) { 
            lng = -0.1276831;
        }        
        
        if (id) { 
            heresay.init(lat, lng, 12, "", '', id);
        }  
        
        else { 
            if(recency !='today') { 
                recency = "last_week";
            }  
             heresay.init(lat, lng, 12, "", recency, '');
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
    <a href='/'><img  src='images/logo_small.png' /></a>
        <a id='location_home' href='/'>View all entries</a>
    </p>
</div>


<div id='container'>



<h1>What is Heresay?</h1>
<p>It's a map that aggregates what people are saying on locally focused forums &amp; blogs.</p>
<p>At the moment the forums are:</p>
<ul>
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

<p>jimmytidey@gmail.co.uk</p> 

</div >


<? include('footer.php'); ?>