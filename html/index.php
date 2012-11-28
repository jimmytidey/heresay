<? include('header.php') ?>

<? include('sidebar.php') ?>

<div class='two-thirds column omega inner_shaddow' id='content' >
    <h2 id='results_title'>Selected Updates</h2>
    <div class='padder'>
        <div id='results_content'>
            <?
                $results = $db->fetch('SELECT * from manual_updates WHERE favourite="1" ORDER BY pubdate desc LIMIT 100');
                foreach($results as $result) { 
                    echo "<h3><a href='" . $result['link'] . "'>" . $result['title'] . "</a></h3>";
                    
                    
                    echo "<p>" . $result['description'] . "</p>";

                    
                    $tags = array(); 
                    
                    for($i=1; $i<5; $i++) { 
                        $cat = $result['category_'.$i];
                        if(!empty($cat) && $cat != 'undefined') { 
                            $tags[] = $result['category_'.$i];
                        }
                    }
                    
                    $tags_string = implode(', ', $tags);
                    echo "<p class='tags'>Tags: " . $tags_string . "</p>";
                    echo "<p class='pubdate'>" . date("F j, Y, g:i a", $result['pubdate']) . "</p>";
                }
            ?>
        </div>
    </div>    
</div>



<? include('footer.php') ?>
