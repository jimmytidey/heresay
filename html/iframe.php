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
        
        <style>
            #main_map { 
                width:200px;
                height:200px;
            }
        
            body, html {margin:0px; padding:0px; height:200px; width:200px;}
            
            #see_more { 
                position:relative;
                top:-39px;
                background-color:white;
                padding-left:5px;
            }
            
            #see_more a {
                font-weight:bold;
                color:black!important;
            }     
        
            .infowindow { 
                width:180px;
            }
        </style>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&sensor=false"></script>
        <script type="text/javascript" src="http://fast.fonts.com/jsapi/3b8a8020-e2d5-4375-8d0a-fcf451d4b03a.js"></script>      
        <script src="js/vendor/modernizr-2.6.1.min.js"></script>
    <body>
        <div id='main_map'>
    
        </div>
        <p id='see_more'><a target="_blank" href='http://heresay.org.uk/'>See more &raquo;</a></p>
        
    </body>
            <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
            <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.8.0.min.js"><\/script>')</script>
            <script src="js/plugins.js"></script>

            <!--[if lte IE 9]>
                 <script src="js/iframe_ie.js"></script>
            <![endif]-->

            <!--[if !IE]> -->
              <script src="js/iframe.js"></script>
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