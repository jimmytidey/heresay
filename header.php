<?

include('db_functions.php'); 

?>

<!DOCTYPE html>
<html>
<head>

<title>Heresay</title>


<style type="text/css">

body, html {
	background-color:#daf5f5;
	margin:0px;
	padding:0px;
}

h1,p,span {
	font-family: Helvetica,
             "Helvetica Neue",
             Arial,
             sans-serif;
}

#container {
	
	position:absolute;
	width: 800px; 
	left:50%; 
	margin-left:-400px;
	background-image:url(/images/background.jpg); 
	background-repeat:no-repeat;
	padding:20px;
	padding-top:200px;
}

#iframe {
    margin-left: 11px;
    margin-top: -410px;
    margin-bottom:10px;
    width: 740px;
    height: 360px; 
    z-index:200!important;
}

a {
	color:black;
}

label {width:100px; float:left;}

#results, #search_results {border:1px solid black; padding:5px; margin-top:20px;}

</style>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>

<script type="text/javascript">



</script>

<head>

<body>
	
<div id='container'>
