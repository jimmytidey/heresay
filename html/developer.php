<? include('header.php'); ?>

<div id='container' style='top:0px; height:1400px'>
    <h1>Developer Things</h1>
    <h2>JSON Feed</h2>
    <p>You can access data (up to one month old) from this URL: http://heresay.org.uk/api/recent_threads.php using a GET request</p>
    <p>Parameters:</p>
    <ul>
        <li><strong>Category</strong> - filters by the tags, as shown in the filter section on the front page</li>
        <li><strong>Recency</strong> - takes values "today", "this_week", "this_month" - filters by the time the original conversation is published.</li>
        <li><strong>ID</strong> - picks a single conversation from the database by ID</li>                        
    </ul>
    
    <p>"This is missing some obvious things!" - <a href='mailto:jimmytidey@gmail.com'>email me</a> and I'll add them.</p>    
    
    
    <h2>iFrame</h2>
    <p>You can embed the map onto a page with an iFrame, here is an example URL, centered on London, zoomed out, and showing conversations about crime this week:</p>
    <p>http://heresay.org.uk/api/iframe.php?lat=51.5073346&lng=0&zoom=10&recency=this_week&category=crime_emergencies</p>
    
    <p>Example iFrame code: </p>
    <p><iframe src="http://heresay.org.uk/api/iframe.php?lat=51.5073346&lng=0&zoom=10&recency=this_week&category=crime_emergencies" width="700" height="300" frameBorder="0">Browser not compatible.</iframe></p>
    <p>&lt;iframe src=&quot;http://heresay.org.uk/api/iframe.php?lat=51.5073346&amp;lng=0&amp;zoom=10&amp;recency=this_week&amp;category=crime_emergencies&quot; width=&quot;700&quot; height=&quot;300&quot; frameBorder=&quot;0&quot;&gt;Browser not compatible.&lt;/iframe&gt;</iframe>
    
    <h2>Javascript helping hand</h2>
    <p>There is a javascript function that might help <a href='http://heresay.org.uk/scripts/heresay.js'>here</a> , it requires <a href='http://heresay.org.uk/scripts/mapstraction.js'>mapstraction</a>.</p> 
    
</div>

<? include('footer.php'); ?>