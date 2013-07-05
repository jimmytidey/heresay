<?
include('ini.php');
@$url = explode("/",$_GET['url']);
$db = new dbClass(DB_LOCATION, DB_USER_NAME, DB_PASSWORD, DB_NAME);
?>

<!DOCTYPE html>  
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Heresay: Discovering local discussion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="/css/bootstrap.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&sensor=false"></script>

   
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
    <![endif]-->


    <link rel="shortcut icon" href="ico/favicon.png">
</head>
<body>
      
    <header>
      <div class='container'>
          <div class='row'>
              <h1 class='span12'><a href='/'>Heresay</a></h1>
          </div>
      </div>
    </header>
      

