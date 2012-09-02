<?
include('../db_functions.php');

for($i = 1; $i<5; $i++) { 
    $query = "SELECT * FROM manual_updates WHERE category_$i='Local_knowledge'";
    echo $query;
    $results = db_q($query);

    foreach ($results as $result) { 
        echo $result['id']; 
    
        $query = "UPDATE manual_updates SET category_$i='local_knowledge' WHERE id='".$result['id']."' "; 
        mysql_query($query);
        echo '<br/>';
    }
}



?>