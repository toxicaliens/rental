<?
/**************************************************************************
*CONNECTION DETAILS
***************************************************************************/
$dbname="menu";
$dbuser="postgres";
$dbpass="kipkemoi";
$dbhost="192.168.100.13";

define("DB_CONNECT_ERROR_MESSAGE","Connection temporarily unavailable - Contact the System Administrator !!");
define("DATABASE","public");

$dbh3 = pg_connect("host=$dbhost port=5432 dbname=$dbname user=$dbuser password=$dbpass");

if($dbh3)
{ //echo "Connection was successful...";
}
else
  echo pg_last_error() . DB_CONNECT_ERROR_MESSAGE;

 global $conn3;
 $conn3 = $dbh3;

 date_default_timezone_set('Africa/Nairobi');
?>