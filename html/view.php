<? include('header.php'); 

$url = explode("/",$_GET['url']);

?> 
<div id='container' >
    <div class='banner'>
        <a href='/'><img src='/images/logo_small.png' /></a>
    </div>
<?

if (!isset($url[1]))  { //select what area 
    ?>
    <h1>Category</h1>  
    <p>Choose the category that you are looking for</p>
    <ul>
        <li><a href='<?=$url[0]?>/all'>All</a></li>
        <li><a href='<?=$url[0]?>/local_council'>Local Government / Official Business</a></li>
        <li><a href='<?=$url[0]?>/local_knowledge'>Local Knowledge</a></li>
        <li><a href='<?=$url[0]?>/crime'>Crime, emergencies, antisocial-behaviour</a></li>
        <li><a href='<?=$url[0]?>/community_events'>Community Events</a></li>
        <li><a href='<?=$url[0]?>/art_music_culture'>Art, Music, Culture</a></li>
        <li><a href='<?=$url[0]?>/shops_restaurants'>Shops, Bars, Restaurants</a></li>
        <li><a href='<?=$url[0]?>/animales_nature_parks'>Animals, nature, parks</a></li>
        <li><a href='<?=$url[0]?>/kids'>Kids</a></li>
        <li><a href='<?=$url[0]?>/sports'>Sports</a></li>                
    </ul>    
    <?
}

else {
    $human_name=str_replace("-", " ", $url[0]); 
    $query = "SELECT name FROM manual_locations WHERE human_name='$human_name'";
    $location_names = db_q($query);
    $location_array = array();
    foreach ($location_names as $location_name) { 
        $location_array[] = " '". $location_name['name'] ."' ";
    }
    
    $site_clause = implode("|| site=", $location_array);
    if ($url[1]=='all') { 
        $query = "SELECT * FROM manual_updates WHERE site= $site_clause ORDER BY pubdate DESC"; 
    }
    else { 
        if ($url[1] == "local_council") { $url[1] = "council";}
        if ($url[1] == "local_knowledge") { $url[1] = "local_knowledge";}
        if ($url[1] == "crime") { $url[1] = "crime_emergencies";}
        if ($url[1] == "community_events") { $url[1] = "community_events";}
        if ($url[1] == "art_music_culture") { $url[1] = "art";}
        if ($url[1] == "animales_nature_parks") { $url[1] = "pets_nature";}
        if ($url[1] == "kids") { $url[1] = "kids";}
        if ($url[1] == "sport") { $url[1] = "sport";}
        
        $query = "SELECT * FROM manual_updates WHERE (site=$site_clause) && category_1='$url[1]' ORDER BY pubdate DESC"; 
    }
   
    $results = db_q($query);
    if(!empty($results)) { 
        foreach($results as $result) { 
            $tag_array = array();
            if ($result['category_1']!="" && $result['category_1']!="--" && $result['category_1']!='undefined') {$tag_array[]=$result['category_1']; }; 
            if ($result['category_2']!="" && $result['category_2']!="--" && $result['category_2']!='undefined') {$tag_array[]=$result['category_2']; }; 
            if ($result['category_3']!="" && $result['category_3']!="--" && $result['category_3']!='undefined') {$tag_array[]=$result['category_3']; }; 
            if ($result['category_4']!="" && $result['category_4']!="--" && $result['category_4']!='undefined') {$tag_array[]=$result['category_4']; }; 
            $tag_string = implode(',', $tag_array);
            ?>
            <h2><a href='<?=$result['link'] ?>'><?=$result['title'] ?></a></h2>
            <p><em><? echo date('F j, Y' ,$result['pubdate']); ?></em></p>
            <p class='list_description'><?=$result['description'] ?></p>
            <p><strong>Tags:<?=$tag_string ?></strong></p>
            <hr/>
        <? }
    }
    else {
        echo "<br/>"; 
        echo "<a href='../list.php'>Nothing in this category... </a>";
    }
}

?> </div> <?

include('footer.php');

?>

















<? include('footer.php'); ?>