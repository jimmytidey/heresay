<? include('header.php'); ?>

<div id='container' style='top:0px; height:100%'>
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
    <p>This URL is just a page 
    
    <h2>Javascript starting point</h2>
    <p>There is a javascript function that might help <a href='http://heresay.org.uk/scripts/heresay.js'>here</a> , it requires <a href='http://heresay.org.uk/scripts/mapstraction.js'>mapstraction</a>.</p> 
    
</div>

<? include('footer.php'); ?>