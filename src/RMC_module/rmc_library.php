<?php
function getHeadCodeName($head_code_id)
{
$query="SELECT head_code_name FROM ifmis_headcodes WHERE head_code_id=$head_code_id";
$data=run_query($query);
$result=get_row_data($data);
return $result['head_code_name'];
}

function getCountyName($county_ref_id)
{
$query="SELECT county_name FROM  county_ref WHERE county_ref_id=$county_ref_id";
$data=run_query($query);
$result=get_row_data($data);
return $result['county_name'];
}

function getParentName($parent_id){
	if(!empty($parent_id)){
	  $query = "SELECT DISTINCT(service_option) AS parent_name FROM service_channels WHERE service_channel_id = '".$parent_id."'";
	  $result = run_query($query);
	  $array = get_row_data($result);
	  return $array['parent_name'];
	}
}
?>
