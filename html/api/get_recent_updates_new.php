<? 
header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");
//if(mt_rand(0,1) > 0.5) { 
?>
{"query":"SELECT 1  FROM manual_updates  WHERE pubdate > 0 && borough='Kensington and Chelsea Borough Council' ORDER BY pubdate DESC LIMIT 4","results":[{"id":"01","title":"London food walk: Golborne Road W10","ward":"From: London Food Essentials (24th Jan)","short_url":"http://bit.ly/LPIbAN","tags":["Tags: Food",""],"human_date":"20th Jan 2014"},{"id":"02","title":"Kensal Green NPT will also be holding their Drop-in surgery tonight. Please come along","ward":"Brent MPS via Twitter  (24th Jan)","short_url":" http://ow.ly/sU8Fp ","tags":["Tag: Crime",""],"human_date":""},{"id":"03","title":"Tfl Finance and Planning Committee disregards calls for greater democratic scrutiny.","ward":"saveearlscourt.com (23nd Jan)","short_url":"saveearlscourt.com","tags":["Tags: Local Planning ",""],"human_date":"20th Jan 2014"},{"id":"04","title":"The January Community Cuppa E-Newsletter is now out!!","description":"","ward":"From: citylivinglocallife.wordpress.com (23rd Jan)","short_url":"citylivinglocallife.wordpress.com","":"","tags":["Tags: Local Politics ",""],"human_date":"20th Jan 2014"}]}

