<?

function reverseGeoCode($lat, $lng) {
	

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://api.geonames.org/findNearbyPlaceNameJSON?lat=$lat&lng=$lng&style=full&username=jimmytidey");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$data = curl_exec($ch);
	curl_close($ch); 
	
	$geodata =json_decode($data, true); 
	
	$geodata = $geodata['geonames'][0];
	
	//print_r($geodata); 
	
	$return_array['adminName2'] = $geodata['adminName2'];
	$return_array['adminName3'] = $geodata['adminName3'];
	$return_array['toponymName'] = $geodata['toponymName'];
	
	return($return_array); 
}

if ($_GET['debug']=='true') {	
	$location = reverseGeoCode($_GET['lat'], $_GET['lng']);
	print_r($location); 
}

?>