<?
include('../db_functions.php');

$query = "SELECT * FROM manual_updates WHERE category_1='publicspace_transport'";

$results = db_q($query);

foreach ($results as $result) { 
    echo $result['id']; 
    
    if($category_1 == 'local_knowlege') { 
        $category_1 = "Local_knowledge"
    }

    if($category_2 == 'local_knowlege') { 
        $category_2 = "Local_knowledge"
    }

    if($category_3 == 'local_knowlege') { 
        $category_3 = "Local_knowledge"
    }

    if($category_4 == 'local_knowlege') { 
        $category_4 = "Local_knowledge"
    }
    
    $query = "UPDATE manual_updates SET category_1='publicspace' WHERE id='".$result['id']."' "; 
    mysql_query($query);
    echo '<br/>';
}



?>