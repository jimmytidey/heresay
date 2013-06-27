
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
     
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=visualization"></script>
        
        <link rel="stylesheet" type="text/css" href="style/style.css">
        <link rel="stylesheet" href="/css/bootstrap.css">
    </head>
    <body>
        <!--[if lt IE 7]>
        <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
        
        <!-- Add your site or application content here -->
        
        <h1 id='title'><a href="/">Heresay Heatmap</a></h1>
        <!--[if lt IE 9]><!--> <p style='float:left; width:200px;color:red;margin-left:20px'>Displaying this amount of data can cause problem in older versions of Internet Explorer.<!--<![endif]-->
        <div id='header'>
            
            <div class='function_description'></div>
            
            <div id='selector_1' class='selector'>
                <select id='option_1' class='dropdown' data-id='1' ><option> -- select -- </option></select>
                <div class='graident' id='gradient_1' ></div>
            </div>
            
            <div id='selector_2' class='selector'>
                <select id='option_2' class='dropdown' data-id='2' ><option> -- select -- </option></select>
                <div class='graident' id='gradient_2' ></div>
            </div>
            
            <div id='selector_3' class='selector' >
                <select id='option_3' class='dropdown' data-id='3' ><option> -- select -- </option></select>
                <div class='graident' id='gradient_3' ></div>
            </div>
            
            <img id='loading' src='image/ajax-loader-balls.gif' />
                
            <span id='instructions'><a href='/'>More about Heresay &raquo;</a></span>
        </div>
        
        <div id='map-canvas'></div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.1.min.js"><\/script>')</script>
        
        <script script="javascript" src="script/script.js"></script>


        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->


        <script type="text/javascript">

          var _gaq = _gaq || [];
          _gaq.push(['_setAccount', 'UA-33853115-1']);
          _gaq.push(['_trackPageview']);

          (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
          })();

        </script>
    
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/jquery.js"><\/script>')</script>    
       
   
    </body>
</html>