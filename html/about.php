<? include('header.php') ?>

<div id='sidebar' class='one-third column alpha inner_shaddow'>
    <div class='padder'>
        <ul>
              <li><a href='about.php'>About</a></li>
              <li><a href='about.php#data-sources'>Data Sources</a></li>
              <li><a href='about.php#contact'>Contact</a></li>
              <li><a href='http://jimmytidey.co.uk'>Jimmy Tidey</a></li>
          </ul>
    </div>    
    
</div>

<div class='two-thirds column omega inner_shaddow' id='content' >
    <h2 id='results_title'>About</h2>
    <div class='padder'>
        <p>Heresay came out of a hack day a long time ago. All over the web there are people having discussion about important community issues local to their area.</p>
        <p>The idea is to try and gather those conversations in one place to make them as accessible as possible.</p>
        
        <h3><a name='contact'>Contact</a></h3>
        <p>Jimmytidey@gmail.com. If your a developer and you'd like to get data through an API, I can help...</p>
        <p>If you're from an organisation interested in using the data to improve your services, I could also help with that.</p>
        
        <h3><a name='data-sources'>Data Sources</a></h3>
        <p>Here is a list of sites which Heresay links to</p>
        <ul>
            <?
            $results = $db->fetch("SELECT DISTINCT site FROM manual_sites");

                foreach($results as $result) {
                    echo "<li>". $result['site'] . "</li>";
                } 
            
            ?>
        </ul>
    </div>
      
</div>



<? include('footer.php') ?>