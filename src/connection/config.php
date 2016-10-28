<?php
/**************************************************************************
*CONNECTION DETAILS
***************************************************************************/

$dbname="rental";
$dbuser="postgres";
$dbpass="postgres";
$dbhost="127.0.0.1";
/*
$dbname="ebpp";
$dbuser="ccn_test";
$dbpass="ccn_t3st";
$dbhost="localhost";
=======
*/
define("DB_CONNECT_ERROR_MESSAGE","Connection temporarily unavailable - Contact Ken");
define("DATABASE","public");

$dbh = pg_connect("host=$dbhost port=5433 dbname=$dbname user=$dbuser password=$dbpass");

if($dbh)
{ //echo "Connection was successful...";
}
else
  echo pg_last_error() . DB_CONNECT_ERROR_MESSAGE;

 global $conn;
 $conn = $dbh;

