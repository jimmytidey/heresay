<? include('header.php') ?>
<? include('fragments/listing.php') ?>
<?
    $ward = @addslashes($_GET['ward']);
    $borough = @addslashes($_GET['borough']);
    $tags = @addslashes($_GET['tags']);
    
?>


<div class='container'>
    
    <div class='row'>
            
        <div class='span8' >
            <div id='main_map'></div>
            
            <div id='listing_container'></div>
        </div>
        
        
        <div class='span3'>
            
            <div id='controls'>
                <label for='user'>User</label>
                <select id='user'>
                <?
                    $query = "SELECT DISTINCT (user) FROM `manual_updates`";
                    $users = $db->fetch($query);
                    foreach($users as $user) {
                        $name = $user['user'];
                        echo "<option value='$name'>$name</option>";
                    }
                
                ?>
                </select>
                
      
            </div>
        
            <p class='btn' id='user_seach_btn' >Search</p>
       
  
        
        </div>
        
        
        
    </div>    
    
</div>



<? include('footer.php') ?>
