<? include('header.php') ?>
<? include('fragments/listing.php') ?>

<div class='container'>
    
    <div class='row'>
        
        <div class='span4'>    
            <select id='filter_by_borough'>
                <option><em>Filter by borough</em></option>
                <option value='Islington'>Islington</option>
                
                <option value='Hackney' >Hackney</option>
                <option value='Tower Hamlets' >Tower Hamlets</option>                                                
            </select>
        </div>
        
        <div class='span8' id='listing_container'>
            <?
                $results = $db->fetch('SELECT * from manual_updates  ORDER BY pubdate desc LIMIT 20');
                foreach($results as $result) { 
                    show_listing($result);
                }
            ?>
        </div>
    </div>    
    
</div>



<? include('footer.php') ?>
