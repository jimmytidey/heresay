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
  
        <title>Heresay Widget</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <link rel="stylesheet" href="css/base.css">
        <link rel="stylesheet" href="css/layout.css">
        <link rel="stylesheet" href="css/skeleton.css">
        <link rel="stylesheet" href="css/main.css">
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&amp;sensor=false"></script>
        <script type="text/javascript" src="http://fast.fonts.com/jsapi/3b8a8020-e2d5-4375-8d0a-fcf451d4b03a.js"></script>      
        <script src="js/vendor/modernizr-2.6.1.min.js"></script>
       <body>

        
        <div id='masthead'></div>
        
        
    
        <div id='header'>
            <div class='container'>
                <div class='one-third column alpha'>
                    <h1>Heresay</h1>

                
                </div>
                <div class='two-thirds column omega'>
                    <h2>Heresay gathers locally-focused comment from across the web and presents it in one searchable place.</h2>
                </div>
            </div>
        </div>
        
        <div class='container main_container'>
            



            <div class='twelve columns omega inner_shaddow' id='content' >

            <h2>Iframe Code</h2>

            <iframe src="http://<?= $_SERVER['HTTP_HOST'] ?>/iframe.php?lat=51.58338209999999&amp;lng=-0.09988529999998264&amp;tags=" width="220" scrolling="no" height="300" frameBorder="0">Browser not compatible.</iframe>


            </div>


            <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
            <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.8.0.min.js"><\/script>')</script>
        
        </div>
        <!--[if lte IE 9]>
             
        <![endif]-->
        
        <!--[if !IE]> -->
          
        <!-- <![endif]-->
  
        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
    </body>
</html>