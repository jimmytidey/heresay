<?
//set timezone
date_default_timezone_set ('Europe/London');

//phpQuery;
require_once __DIR__ .'/../classes/phpQuery.php';

//Instantiate the DB class, constructor will connect to the DB
require_once  __DIR__ .'/../classes/dbClass.php';


//Report and People use classes that extent this class
require_once __DIR__ ."/../classes/scraperBaseClass.php";


require_once  __DIR__ .'/json.php';
require_once  __DIR__ .'/url_clean.php';
?>