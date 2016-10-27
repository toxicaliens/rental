<?php
/**
 * Created by PhpStorm.
 * User: JOEL
 * Date: 7/21/2016
 * Time: 11:57 AM
 */
include '../connection/config.php';

$query = "SELECT * FROM address WHERE address_id = '".$_POST['edit_id']."'";
$result = pg_query($query);
$rows = pg_fetch_assoc($result);
echo json_encode($rows);