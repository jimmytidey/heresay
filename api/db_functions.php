<? 
$dbhost = 'internal-db.s96975.gridserver.com';
$dbuser = 'db96975_jimmy';
$dbpass = 'drowssap';
$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
$dbname = 'db96975_jimmy';
mysql_select_db($dbname) or die ('Error connecting to mysql');


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