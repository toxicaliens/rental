<?
/**************************************************************************
*CONNECTION DETAILS
***************************************************************************/
$dbname="ebppp";
$dbuser="postgres";
$dbpass="kipkemoi";
$dbhost="192.168.100.13";

//echo "Connecting to DB...<br> Username: $dbuser <br> Password: $dbpass  <br>Host: $dbhost <br> Database: $dbname";
define("DB_CONNECT_ERROR_MESSAGE","Connection temporarily unavailable - Contact the System Administrator !!");
define("DATABASE","public");
define("SCHEMA","public");
define("DAY_PARKING","1");
define("SEASON_PARKING","2");
define("HOUR_PARKING","3");
define("RESERVED_PARKING","4");
define("VIP_PARKING","5");
define("LOADING_PARKING","6");

define("PARKING_COMPLETE","72");

define("PARKING_TYPE","1");
define("MARKETS_TYPE","5");
define("RATES_TYPE","3");

date_default_timezone_set('Africa/Nairobi');

$dbh = pg_connect("host=$dbhost port=5432 dbname=$dbname user=$dbuser password=$dbpass");
//mysql_select_db($dbname,$dbh) or die("Connection temporarily unavailable - Contact the System Administrator !!");

if($dbh)
{ //echo "Connection was successful...";
}
else
  echo pg_last_error() . DB_CONNECT_ERROR_MESSAGE;

 global $conn;
 $conn = $dbh;		
/*if (pg_last_error() == 1203) 
{
	session_destroy();
	header("Location: http://192.168.100.11/");
	exit;
}*/

?>