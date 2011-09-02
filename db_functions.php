<? 
include('db_info.php');

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

		return($data);
	}
}




?>