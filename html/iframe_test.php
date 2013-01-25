<? include('header.php') ?>


<div class='twelve columns omega inner_shaddow' id='content' >

<h2>Iframe Code</h2>

<iframe src="http://<?= $_SERVER['HTTP_HOST'] ?>/iframe.php?lat=51.58338209999999&lng=-0.09988529999998264&tags=" width="220" scrolling="no" height="300" frameBorder="0">Browser not compatible.</iframe>


</div>


        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.8.0.min.js"><\/script>')</script>
        <script src="js/plugins.js"></script>
        
        <!--[if lte IE 9]>
             <script src="js/main_ie.js"></script>
        <![endif]-->
        
        <!--[if !IE]> -->
          <script src="js/main.js"></script>
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