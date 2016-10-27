<?php
include '../connection/config.php';


$query = "SELECT * FROM support_ticket WHERE support_ticket_id = '".$support_ticket_id."'";
$result = pg_query($query);
$rows = pg_fetch_assoc($result);
echo json_encode($rows);
?>