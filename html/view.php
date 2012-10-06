<? include('header.php'); 
echo $_GET['url'];
$url = explode("/",$_GET['url']);

print_r($url);

?> 
<div id='container' >
    <div class='banner'>
        <img src='/images/logo_small.png' />
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
        <li><a href='<?=$url[0]?>/crime'>Crime</a></li>
        <li><a href='<?=$url[0]?>/community_events'>Community Events</a></li>
        <li><a href='<?=$url[0]?>/art_music_culture'>Art, Music, Culture</a></li>
        <li><a href='<?=$url[0]?>/shops_bars'>Shops, Bars, Restaurants</a></li>
        <li><a href='<?=$url[0]?>/animales_nature_parks'>Animals, nature, parks</a></li>
        <li><a href='<?=$url[0]?>/kids'>Kids</a></li>
        <li><a href='<?=$url[0]?>/sports'>Sports</a></li>                
    </ul>    
    <?
}

else {
    $query = "SELECT name FROM manual_locations WHERE human_name=$url[1]";
    echo $query;
}

?> </div> <?

include('footer.php');

?>

















<? include('footer.php'); ?>