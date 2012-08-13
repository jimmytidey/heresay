<?
include('../db_functions.php');

$query = "SELECT * FROM manual_updates WHERE category_1='publicspace_transport'";

$results = db_q($query);

foreach ($results as $result) { 
    echo $result['id']; 
    $query = "UPDATE manual_updates SET category_1='publicspace' WHERE id='".$result['id']."' "; 
    mysql_query($query);
    echo '<br/>';
}



?>