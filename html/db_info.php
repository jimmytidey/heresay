<?
$dbhost = 'internal-db.s96975.gridserver.com';
$dbuser = 'db96975_heresay';
$dbpass = 'octagon8';
$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
$dbname = 'db96975_heresayII';
mysql_select_db($dbname) or die ('Error connecting to mysql');

function mysql_fetch_all($res) {
   while($row=mysql_fetch_array($res)) {
       $return[] = $row;
   }
   return $return;
}

?>
