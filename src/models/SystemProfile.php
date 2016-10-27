<?php
/**
* 
*/
class SystemProfile
{
	private $_sys_data = array();

	public function __construct(){
		$query = "SELECT * FROM system_value";
		if($result = run_query($query)){
			if(get_num_rows($result)){
				while ($rows = get_row_data($result)) {
					$this->_sys_data[] = $rows;
				}
			}
		}
	}

	public function getSystemData(){
		return $this->_sys_data;
	}

	public function addSetting(){
		extract($_POST);

		if(!empty($setting_name) && !empty($setting_value) && !empty($setting_code)){
			if(!checkForExistingEntry('system_value', 'setting_name', $setting_name)){
				if(!checkForExistingEntry('system_value', 'setting_code', $setting_code)){
					$query = "INSERT INTO system_value(setting_name, setting_value, setting_code) 
					VALUES('".sanitizeVariable($setting_name)."', '".sanitizeVariable($setting_value)."', '".sanitizeVariable($setting_code)."')";
					if(run_query($query)){
						$_SESSION['setting'] = '<div class="alert alert-success">
						<button class="close" data-dismiss="alert">&times;</button>
						<strong>Success! </strong> Setting has been added!
						</div>';
					}else{
						return false;
					}
				}else{
					$_SESSION['setting'] = '<div class="alert alert-warning">
						<button class="close" data-dismiss="alert">&times;</button>
						<strong>Warning! </strong> Setting Code ('.$setting_code.') already exists!
						</div>';
				}
			}else{
				$_SESSION['setting'] = '<div class="alert alert-warning">
						<button class="close" data-dismiss="alert">&times;</button>
						<strong>Warning! </strong> Setting Name('.$setting_name.') already exists!
						</div>';
			}
		}
	}

	public function editSetting(){
		extract($_POST);

		if(!empty($setting_name) && !empty($setting_value) && !empty($setting_code)){
			if(!onEditcheckForExistingEntry('system_value', 'setting_name', $setting_name, 'setting_id', $edit_id)){
				if(!onEditcheckForExistingEntry('system_value', 'setting_code', $setting_code, 'setting_id', $edit_id)){
					$query = "UPDATE system_value SET setting_name = '".sanitizeVariable($setting_name)."',
					setting_code = '".sanitizeVariable($setting_code)."', setting_value = '".sanitizeVariable($setting_value)."'
					WHERE setting_id = '".$edit_id."'";
					if(run_query($query)){
						$_SESSION['setting'] = '<div class="alert alert-success">
						<button class="close" data-dismiss="alert">&times;</button>
						<strong>Success! </strong> Setting has been updated!
						</div>';
					}else{
						return false;
					}
				}else{
					$_SESSION['setting'] = '<div class="alert alert-warning">
						<button class="close" data-dismiss="alert">&times;</button>
						<strong>Warning! </strong> Setting Code ('.$setting_code.') already exists!
						</div>';
				}
			}else{
				$_SESSION['setting'] = '<div class="alert alert-warning">
						<button class="close" data-dismiss="alert">&times;</button>
						<strong>Warning! </strong> Setting Name('.$setting_name.') already exists!
						</div>';
			}
		}
	}

	public function deleteSetting(){
		extract($_POST);

		$query = "DELETE FROM system_value WHERE setting_id = '".sanitizeVariable($delete_id)."'";
		if(run_query($query)){
			$_SESSION['setting'] = '<div class="alert alert-success">
				<button class="close" data-dismiss="alert">&times;</button>
				<strong>Success! </strong> Setting has been deleted!
			</div>';
		}
	}
}