<?php
	require_once('src/models/Database.php');
	/**
	*
	*/
	class Library extends Database{
		private $_errors = array(),
		$_success = array(),
		$_warning = array(),
		$_passed = false;

		public function flashMessage($sess_name, $type, $message){
			switch ($type) {
				case 'success':
					$_SESSION[$sess_name] = '<div class="alert alert-'.$type.'">';
					$_SESSION[$sess_name] .= '<button class="close" data-dismiss="alert">&times;</button>';
					$_SESSION[$sess_name] .= '<strong>Success!</strong> '.$message.'</div>';
					break;

				case 'warning':
					$_SESSION[$sess_name] = '<div class="alert alert-'.$type.'">';
					$_SESSION[$sess_name] .= '<button class="close" data-dismiss="alert">&times;</button>';
					$_SESSION[$sess_name] .= '<strong>Warning!</strong> '.$message.'</div>';
					break;

				case 'error':
					$_SESSION[$sess_name] = '<div class="alert alert-'.$type.'">';
					$_SESSION[$sess_name] .= '<button class="close" data-dismiss="alert">&times;</button>';
					$_SESSION[$sess_name] .= '<strong>Error!</strong> '.$message.'</div>';
					break;
			}
		}

		public function splash($sess_name){
			if(isset($_SESSION[$sess_name])){
				echo $_SESSION[$sess_name];
				unset($_SESSION[$sess_name]);
			}
		}

		public function validate($source, $items = array()){
			if(count($items)){
				foreach ($items as $item => $rules) {
					foreach ($rules as $rule => $rule_value) {
						$value = sanitizeVariable(trim($source[$item]));
						$field_name = $rules['name'];

						if($rule == 'required' && empty($value)){
							$this->_warning[] = "$field_name is required!";
						}elseif(!empty($value)){
							switch ($rule) {
								case 'unique':
									if(checkForExistingEntry($rule_value, $item, $value)){
										$this->_warning[] = "$field_name ($value) already exists!";
									}
									break;

								case 'unique2':
									if(onEditCheckForExistingEntry($rule_value['table'], $item, $value, $rule_value['skip_column'], $rule_value['skip_value'])){
										$this->_warning[] = "$field_name ($value) already exists!";
									}
									break;

								case 'numeric':
									if($rule_value){
										if(!is_numeric($value)){
											$this->_warning[] = "$field_name must be numeric!";
										}
									}
									break;

								case 'min':
									if($value < $rule_value){
										$this->_warning[] = "$field_name must be at least $rule_value characters long";
									}
									break;

								case 'max':
									if($value > $rule_value){
										$this->_warning[] = "$field_name must not be more than $rule_value characters long";
									}
									break;
							}
						}
					}
				}

				$warnings_count = count($this->getWarnings());
				if($warnings_count == 0){
					$this->_passed = true;
				}
			}
		}

		public function setPassed($boolean){
			$this->_passed = $boolean;
		}

		public function getErrors(){
			return $this->_errors;
		}

		public function getWarnings(){
			return $this->_warning;
		}

		public function setWarning($warning){
			$this->_warning[] = $warning;
		}

		public function getValidationStatus(){
			return $this->_passed;
		}

		public function get($name){
			if(isset($_POST[$name])){
				return $_POST[$name];
			}else{
				return '';
			}
		}

		public function displayWarnings($sess_name){
			$warnings = $_SESSION[$sess_name];
			if(count($warnings)){
				$splash = '<div class="alert alert-warning">';
				$splash .= '<button class="close" data-dismiss="alert">&times;</button>';
				foreach ($warnings as $warning) {
					$splash .= '<strong>Warning!</strong> '.$warning."<br/>";
				}
				$splash .= '</div>';
				echo $splash;
			}
			unset($_SESSION[$sess_name]);
		}
		
		public function uploadImage($filename, $destination){
			//var_dump($destination);exit;
			if(move_uploaded_file($filename, $destination)){
				return $destination;
			}else{
				$this->setWarning('Failed to upload the document');
				return false;
			}
		}
			
		public function validateImage($filename, $allowed_extensions){
			if(!empty($filename)){
				$file_data = explode('.', $filename);
				//var_dump($file_data);exit;
				if(in_array($file_data[1], $allowed_extensions)) {
					return true;
				}else{
					return false;
				}
			}
		}
	
		public function sendEmail($email, $subject, $body) {
			$from = "info@obulexsolutions.com";
			return (mail($email, $subject, $body, $from)) ? true: false;
		}

		public function getAllProperties(){
			$role = $_SESSION['role_name'];
			if ($role == PM){
				$results = $this->selectQuery('plots','plot_id,plot_name'," pm_mfid=  '" . $_SESSION['mf_id']. "'");
			} else if ($role == LandLord) {
				//user is a landlord
				$result =  $this->selectQuery('plots','plot_id,plot_name', " landlord_mf_id=  '" . $_SESSION['mf_id']. "' ");
			} else if ($role == SystemAdmin){
				//if role is admin
				$result = $this->selectQuery('plots', 'plot_id,plot_name');
			}
			//var_dump($result);die;
			if (count($result)) {
				return $result;
			}
		}
	}

?>
