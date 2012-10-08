<? 
include("db_functions.php");

//give the file an id of the current page name
$id = explode(".", $_SERVER['PHP_SELF']);  
$id = explode('/', $id[0]); 
$number = count($id)-1; 
$id = $id[$number];

?>

<!DOCTYPE html>

<html>

<head>
<meta charset="utf-8">
<title>Heresay</title>
    <meta name="google-site-verification" content="ZuChEhlvuI1zxLGX7PYcfhNkF9ypHBqI8cGChpHyOZU" />
     
     
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAOoFM_kDNJVs_SzvkytQRKBSpgYF3iu7PXc-1iPSD4CpffT2eCRRzD14PFyag3JY4SakJE5_wVYpLxw&sensor=false" type="text/javascript"></script>
   
   
    <script type="text/javascript" src="scripts/mapstraction.js"></script>
    <link rel=StyleSheet href="/style/style.css" type="text/css" media='screen' />
    <script src='/scripts/heresay.js'></script>
<head>

<body id='<?=$id ?>' >
	

