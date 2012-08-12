<?
include('../api/db_functions.php');

$query = "SELECT * FROM manual_updates WHERE category='shepherds_bush'";

$results = db_q($query);

foreach ($results as $result) { 
    echo $result['id']; 
    $query = "UPDATE manual_updates SET site='shepherdsbushw12.com' WHERE id='".$result['id']."' "; 
    mysql_query($query);
    echo '<br/>';
}



?>