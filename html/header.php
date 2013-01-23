<?

include('ini.php');
@$url = explode("/",$_GET['url']);
$db = new dbClass(DB_LOCATION, DB_USER_NAME, DB_PASSWORD, DB_NAME);

?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <link rel="stylesheet" href="css/base.css">
        <link rel="stylesheet" href="css/layout.css">
        <link rel="stylesheet" href="css/skeleton.css">
        <link rel="stylesheet" href="css/main.css">
        <link type="text/css" rel="stylesheet" href="http://fast.fonts.com/cssapi/3b8a8020-e2d5-4375-8d0a-fcf451d4b03a.css"/>        
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&sensor=false"></script>
        
        <script src="js/vendor/modernizr-2.6.1.min.js"></script>
       <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
        <![endif]-->
        
        <div id='masthead'></div>
        
        
        
            <div id='header'>
                <div class='container'>
                <div class='one-third column alpha'>
                    <h1>Heresay</h1>

                    
                </div>
                <div class='two-thirds column omega'>
                    <h2>Heresay gathers locally-focused comment from across the web and presents it in one ssearchable place.</h2>
                </div>
                </div>
            </div>
            <div class='container main_container'>
            
            