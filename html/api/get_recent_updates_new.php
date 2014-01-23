<? 
header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");
if(mt_rand(0,1) > 0.5) { 
?>

{"query":"SELECT 1  FROM manual_updates  WHERE pubdate > 0   && borough='Kensington and Chelsea Borough Council' ORDER BY pubdate DESC LIMIT 4","results":[{"id":"01","title":"Public Meeting on Policing in North Kensington and Across the Borough","ward":"citylivinglocallife.wordpress.com (22nd Jan)","short_url":"citylivinglocallife.wordpress.com","tags":["Tags: Local Politics",""],"human_date":"20th Jan 2014"},{"id":"02","title":"Contribution of Earls Court exhibition centre to London's culture and heritage - MPs debate","ward":"saveearlscourt.com (22nd Jan)","short_url":"http://bit.ly/KJWyWo","tags":["Tag: Planning",""],"human_date":"saveearlscourt.com (22nd Jan)"},{"id":"03","title":"#upcycling class tomorrow at @goldfingerHQ . Make money upcycling old furniture with folk art, £5, 6.30- 8.30! ","ward":"Clement James Centre via Twitter (22nd Jan)","short_url":"http://bit.ly/1bjOcf3","tags":["Tags: Art","Recycling"],"human_date":"20th Jan 2014"},{"id":"04","title":"Shared Video: Portobello Road Street Market - some 360 degree views whilst standing at various locations.","description":"","ward":" RBKC Markets via Facebook (22nd Jan)","short_url":"facebook.com/RBKCMarkets","":"","tags":["Tags: Markets",""],"human_date":"20th Jan 2014"}]}
<? } else { ?>

{"query":"SELECT 2  FROM manual_updates  WHERE pubdate > 0   && borough='Kensington and Chelsea Borough Council' ORDER BY pubdate DESC LIMIT 4","results":[{"id":"01","title":"House of Commons debate of Earl's Court Exhibition Centre","ward":"saveearlscourt.com (21th Jan)","short_url":"http://bit.ly/1cPC854","tags":["Tags: Planning",""],"human_date":"21th Jan 2014"},{"id":"02","title":"We are looking for a Casual Labour  - Yard Sales Assistant in Kensal Green, London North West","ward":"Travis Perkins via Twitter (23rd Jan)","short_url":"twitter.com/TP_Careers","tags":["Tag: Jobs",""],"human_date":"21st Jan 2014"},{"id":"03","title":"Thank you to The Eagle Pub, Ladbroke Grove - for supporting us, as for every Fish and Chips bought, £1 will be donated to Full of Life! ","ward":"Full of Life Kensington and Chelsea on Facebook (21st Jan)","short_url":"facebook.com/fullofliferbkc","tags":["Tag: Charity","Pubs & Bars"],"human_date":"20th Jan 2014"},{"id":"04","title":"History of K&C hospital ","description":"","ward":"RBKC Library (22nd Jan)","short_url":"rbkclocalstudies.wordpress.com","":"","tags":["Tag: Local History",""],"human_date":"20th Jan 2014"}]}
<? }?>
