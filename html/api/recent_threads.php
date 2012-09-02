<?

include ('../db_functions.php');

$callback 		= @mysql_real_escape_string(urldecode($_GET['callback'])); //for JSONP
$debug 			= @mysql_real_escape_string(urldecode($_GET['debug']));

$category 		= @mysql_real_escape_string(urldecode($_GET['category']));


$recency 		= @mysql_real_escape_string(urldecode($_GET['recency']));
$id 	    	= @mysql_real_escape_string(urldecode($_GET['id']));

$query =  "SELECT * FROM manual_updates WHERE lat!='--' && lat!='' ";

if (!empty($id)) { 
     $query .= " && id = $id ";
    
}

else {
    if (!empty($recency)) {
        if($recency=='today') { 
            $date = time()-(60*60*24);
        }

        if($recency=='this_week') { 
            $date = time()-(60*60*24*7);    
        }

        if($recency=='this_month') { 
            $date = time()-(60*60*24*30);    
        }
    }

    if(isset($date)) { 
        $query .= " && pubdate > $date ";
    }

    if (!empty($category)) {
        $query .="&& (";
        $categories = explode(',', $category);
        $query_array = array();
        foreach ($categories as $category) { 
            $query_array[] = " category_1='$category' || category_2='$category' || category_3='$category' || category_4='$category' "; 
        }

        $query .= implode(" || ", $query_array);
        $query .=")";
    }
}


$query .=' ORDER BY pubdate DESC LIMIT 1000'; 

$search_result = db_q($query);



if (empty($search_result)) { 
    $search_result['error'] = 'no results';
}

$json = unstrip_array($search_result);
$json['query'] = $query; 


header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

$return = json_encode($json);


if ($callback != "") {
	echo $_GET['callback'].'('.$return.')';
}

else {
	echo $return; 
}







?>