<?
/**************************************************************************
*CONNECTION DETAILS
***************************************************************************/
$dbname="ebppp";
$dbuser="postgres";
$dbpass="kipkemoi";
$dbhost="localhost";

//echo "Connecting to DB...<br>";
define("DB_CONNECT_ERROR_MESSAGE","Connection temporarily unavailable - Contact the System Administrator !!");
define("DATABASE","public");
define("DAY_PARKING","1");
define("SEASON_PARKING","2");
define("HOUR_PARKING","3");
define("RESERVED_PARKING","4");
define("VIP_PARKING","5");
define("LOADING_PARKING","6");

$dbh = pg_connect("host=$dbhost port=5432 dbname=$dbname user=$dbuser password=$dbpass");
//mysql_select_db($dbname,$dbh) or die("Connection temporarily unavailable - Contact the System Administrator !!");

/*if($dbh)
  echo "Connection was successful...";
else
  echo pg_last_error() . DB_CONNECT_ERROR_MESSAGE;*/

$conn = $dbh;		
/*if (pg_last_error() == 1203) 
{
	session_destroy();
	header("Location: http://192.168.100.11/");
	exit;
}*/

?>