<?php
include '../connection/config.php';


$query = "SELECT * FROM gtel_device_models_attributes WHERE attribute_id = '".$_POST['edit_id']."'";
$result = pg_query($query);
$rows = pg_fetch_assoc($result);
echo json_encode($rows);
?>