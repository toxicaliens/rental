<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include '../connection/config.php';
include '../library.php';
include 'library.php';

$account = $_REQUEST["account"];
$type = $_REQUEST["request"];

print_r(getbill($account,$type));

?>
