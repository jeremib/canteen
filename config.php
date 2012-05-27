<?

$dbHost			= 'localhost';
$dbUser 		= 'root';
$dbPass 		= '11111111';
$dbName 		= 'campaide';
$dbPrefix 		= 'aide';

$template 		=	'default';

$webroot 		= 'c:/apache2triad/htdocs/';
$softwareRoot 	= '/canteen/';

$dateFormat 	= "m/d/Y";  // php format http://www.php.net/date
$timeFormat 	= "h:i:s A";  // php format http://www.php.net/date

######  do not edit below ##########


$packagePath = 	$webroot.$softwareRoot;




$_TABLES[users]			= $dbPrefix."_admins";
$_TABLES[campers]		= $dbPrefix."_campers";
$_TABLES[transactions]	= $dbPrefix."_transactions";
$_TABLES[weeks]			= $dbPrefix."_weeks";
?>