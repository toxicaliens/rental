<?php
function getUserLevelName($userLevelId)
{
$query="SELECT userlevelname FROM ".DATABASE.".userlevels WHERE userlevelid=$userLevelId";
$data=run_query($query);
$row=get_row_data($data);

return $row[userlevelname];

}
function getUserLevelId($userLevelName)
{
$query="SELECT userlevelid FROM ".DATABASE.".userlevels WHERE userlevelname='$userLevelName'";
$data=run_query($query);
$result=get_row_data($data);
return $result[userlevelid];
}
function getJobName($job_id)
	{
	$query="SELECT job_name FROM ".DATABASE.".jobs WHERE job_id=$job_id";
	$data=run_query($query);
	$job_name=get_row_data($data);
	return $job_name[job_name];
	}
function getDepartmentName($department_id)
{
$query="SELECT department_name FROM ".DATABASE.".departments WHERE department_id=$department_id";
$data=run_query($query);
$result=get_row_data($data);
return $result[department_name];
}
function getDepartmentId($department_name)
	{
	$query="SELECT department_id FROM departments WHERE department_name='$department_name'";
	$data=run_query($query);
	$result=get_row_data($data);
	return $result[department_id];
	}
function getJobId($job_name)
	{
	$query="SELECT job_id FROM jobs WHERE job_name LIKE '%$job_name%'";
	$data=run_query($query);
	$job_id=get_row_data($data);
	return $job_id[job_id];

	}
?>
