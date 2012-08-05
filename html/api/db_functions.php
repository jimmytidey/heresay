<? 
include('../db_info.php');

function db_q($query)  
{
	$result = mysql_query($query) or die(mysql_error());
	
	if ($result) {
		$i = 0; 
		while($row=@mysql_fetch_array($result))
		{   
			$data[$i]=$row;
			$i++;
		}
		if (empty($data)) { 
		    $data= "";
		}
		return($data);
	}
}


function unstrip_array($array){
    foreach($array as &$val){
        if(is_array($val)){
            $val = unstrip_array($val);
        }else{
            $val = stripslashes($val);
        }
    }
return $array;
}
?>