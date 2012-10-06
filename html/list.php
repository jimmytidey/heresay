<? include('header.php'); 
    ?>
    <div id='container' >
        <div class='banner'>
            <img src='images/logo_small.png' />
        </div>
        
        <p>Click on the locations below to find lists of local conversations</p>
        
        <ul>
        <?
        $results = db_q("SELECT DISTINCT human_name FROM manual_locations");
 
        foreach($results as $result) {
            $url = str_replace(" ", "-", $result[0]);
            echo "<li><a href='$url'>" . $result[0] . "</a></li>"; 
        }
        ?>
        </ul>
    </div>
<?

include('footer.php'); 
?>