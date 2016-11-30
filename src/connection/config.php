<?php
/**************************************************************************
*CONNECTION DETAILS
***************************************************************************/

$dbname="rentalss";
$dbuser="postgres";
$dbpass="postgres";
$dbhost="127.0.0.1";
$dbport=5432;
/*
$dbname="ebpp";
$dbuser="ccn_test";
$dbpass="ccn_t3st";
$dbhost="localhost";
=======
*/
//define("DB_CONNECT_ERROR_MESSAGE","Connection temporarily unavailable - Contact Ken");
//define("DATABASE","public");

$dbh = pg_connect("host=$dbhost port=$dbport dbname=$dbname user=$dbuser password=$dbpass");

if($dbh)
{ //echo "Connection was successful...";
}
else
  echo pg_last_error();

 global $conn;
 $conn = $dbh;

