<!DOCTYPE html>

<html>
<head>

	<meta charset=utf-8 />


	<title>Jimmy Tidey</title>
	<meta name="description" content="heresay.org.uk iframe" />
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAOoFM_kDNJVs_SzvkytQRKBSpgYF3iu7PXc-1iPSD4CpffT2eCRRzD14PFyag3JY4SakJE5_wVYpLxw&sensor=false" type="text/javascript"></script>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.5.min.js"></script>	
	<script type="text/javascript" src="api/js/mapstraction.js"></script>    
     
    <script src='scripts/index_map.js'></script>
    <style>
        body, html { 
            margin:0px;
            padding:0px;
            width:100%;
            height:100%;
        }
        #mapstraction { 
            width:100%;
            height:100%;
        }
    </style>
    <script>

	

	   
    	$(document).ready(function() {
        	// create a lat/lon for center 
        	var center = gup('center');
        	if (center != undefined && center != '') {
        		center = center.split(',');
        		lat = center[0]; 
        		lng = center[1];		
        	}

        	else {
        		lat = 51.51066556016948;
        		lng = -0.0556182861328125;
        	}	

        	var zoom = gup('zoom');
        	if (zoom === undefined || zoom == '') {
        	     zoom=11;
        	}    	    
    	    console.log(zoom);
    	    heresay.init(lat, lng, zoom, '', '', '');
        });

    	function gup(name)
    	{
    	  name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
    	  var regexS = "[\\?&]"+name+"=([^&#]*)";
    	  var regex = new RegExp( regexS );
    	  var results = regex.exec( window.location.href );
    	  if( results == null )
    		return "";
    	  else
    		return results[1];
    	}    
    
    </script>
</head> 

<body>
    <div id="mapstraction" ></div>
</body>
</html>
