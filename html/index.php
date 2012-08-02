<? include('header.php'); ?>

<img src='images/logo_small.png' id='logo' />

<div id='map_container'>
	<? include('index_map.php'); ?>
</div>

<div id='container'>

<script>
//randomly open bubbles every few seconds 

heresay.interval=self.setInterval("heresay.rndBubble()",4000);

heresay.rndBubble = function() {
	var numberOfMarkers = heresay.mapstraction.markers.length; 
	
	var randomnumber=Math.floor(Math.random()*numberOfMarkers)
	heresay.mapstraction.markers[randomnumber].openBubble();
}
</script>

<h1>What is Heresay?</h1>
<p>It's a map that aggregates what people are saying on local forums.</p>
<p>At the moment the forums are:</p>
<ul>
    <li><a href='http://harringayonline.com'>harringayonline.com</a></li>
    <li><a href='http://hernehillforum.org.uk'>hernehillforum.org.uk</a></li>
    <li><a href='http://thebrixtonforum.co.uk'>thebrixtonforum.co.uk</a></li>
    <li><a href='http://bowesandbounds.org'>bowesandbounds.org</a></li>
    <li><a href='http://dalstonpeople.co.uk'>dalstonpeople.co.uk</a></li>
    <li><a href='http://urban75.com'>urban75.com</a></li>
    <li><a href='http://se5forum.org'>se5forum.org</a></li>
    <li><a href='http://london-se1.co.uk'>london-se1.co.uk</a></li>
    <li><a href='http://www.southeastcentral.co.uk'>southeastcentral.co.uk</a></li>                
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