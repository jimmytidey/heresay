<? include('header.php') ?>
<? include('fragments/listing.php') ?>
<?
    $ward = @addslashes($_GET['ward']);
    $borough = @addslashes($_GET['borough']);
    $tags = @addslashes($_GET['tags']);
    
?>


<div class='container' id='site_locations'>
    
    <div class='row'>
        <div class='span8 '>
            <br>
            <p>List of all the sites hyperlocal sites we've located.</p>

        </div>
        
        <div class='span4'>
            <h3 id='blog_link'><a href='http://heresay-blog.tumblr.com'>Read our blog &rarr;</a></h3>  
        </div>    
    
    </div>
    
    
    
    <div class='row'>
            
        
        <div class='span12' >
            <div id='main_map'>

            </div>
            
     
        </div>
        
        
        <div class='span3'>
            
        </div>
        
        
        
    </div>    
    
</div>



<? include('footer.php') ?>
