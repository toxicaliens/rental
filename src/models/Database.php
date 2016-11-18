<?php
	/**
	* 
	*/
	class Database{
		private $_data = array();

		public function insertQuery($table, $inputs = array(), $return_field = ''){
            $field_string = '';
            $input_string = '';

			if(!empty($return_field))
				$return_field = 'RETURNING '.$return_field;
			else
				$return_field = '';

			if(!empty($table)){
				if(count($inputs)){
					foreach ($inputs as $index => $value) {
                        $field_string .= "$index,";
						$input_string .= ($value != 'NULL') ? "'".sanitizeVariable($value)."'," : sanitizeVariable($value).",";
					}

                    $field_string = rtrim($field_string, ',');
                    $input_string = rtrim($input_string, ',');

					$query = "INSERT INTO $table(".$field_string.") VALUES(".$input_string.") $return_field";
                    var_dump($query);
//                    traceActivity($query, '');
					if($result = run_query($query)){
						if(empty($return_field))
							return $result;
						else
							return get_row_data($result);
					}else{
						return false;
					}
				}
			}
		}

		public function updateQuery($table, $fields_values, $condition = ''){
			if(!empty($table) && !empty($fields_values)){
				$condition = (!empty($condition)) ? 'WHERE '.$condition : '';

				$query = "UPDATE $table SET ".$fields_values." $condition";
//				var_dump($query);exit;
				if(run_query($query)){
					return true;
				}else{
					return false;
				}
			}
		}

		public function updateQuery2($table, $fields_values = array(), $conditions= array()){
			if(!empty($table)){
				$fields_values_string = '';
				$condition_string = '';
				$prefix = (count($conditions)) ? 'WHERE' : '';
				if(count($fields_values)) {
					foreach ($fields_values as $key => $fv) {
						$fields_values_string .= ($fv == 'NULL') ?  " $key = " . sanitizeVariable($fv) . "," : " $key = '".$fv."',";
					}
					$fields_values_string = rtrim($fields_values_string, ',');

					if(count($conditions)) {
						foreach ($conditions as $key => $cond_value) {
							$condition_string .= ($cond_value == 'NULL') ? " $key = " . sanitizeVariable($cond_value) . "," : " $key = '" . sanitizeVariable($cond_value) . "',";
						}
						$condition_string = rtrim($condition_string, ',');
					}

					$query = "UPDATE $table SET " . $fields_values_string . "  $prefix $condition_string";
					//				var_dump($query);exit;
                    traceActivity($query, 'lksjdl');
					if (run_query($query)) {
						return true;
					} else {
						return false;
					}
				}
			}
		}

		public function deleteQuery($table, $condition){
			if(!empty($table) && !empty($condition)){
				$condition = (!empty($condition)) ? 'WHERE '.$condition : '';
				$query = "DELETE FROM ".$table." $condition";
//                var_dump($query);die;
				if(run_query($query)){
					return true;
				}else{
					return false;
				}
			}
		}

		public function deleteQuery2($table, $conditions = array()){
			if(!empty($table)){
				$condition_string = ' WHERE ';
				if(count($conditions)){
					foreach ($conditions as $key => $val){
						$condition_string .= " $key = '".sanitizeVariable($val)."',";
					}
					$condition_string = rtrim($condition_string, ',');
				}
				$query = "DELETE FROM ".$table." $condition_string";
//				var_dump($query);exit;
				if(run_query($query)){
					return true;
				}else{
					return false;
				}
			}
		}

		public function selectQuery($table, $fields, $condition = '', $order_field = '', $order_type = ''){
			$return = array();
			/*
				example:
				selectQuery(
		 			'subjects', 
		 			'*', 
		 			"school_id = '".$_SESSION['school_id']."'"
		 		);
			*/
			$field_string = '';
			if(!empty($table)){
				if(is_array($fields)){
					if(count($fields)){
						foreach ($fields as $field) {
							$field_string .= $field.',';
						}
					}
				}

				if(count($fields)){
					$field_string = rtrim($field_string, ',');
					$field_string = (!is_array($fields)) ? $fields : $field_string; 
					$condition = (!empty($condition)) ? 'WHERE '.$condition: '';
					$order_string = (!empty($order_field) && !empty($order_type)) ? 'ORDER BY '.$order_field.' '.$order_type : '';

					$query = "SELECT ".$field_string." FROM $table $condition $order_string";
//					traceActivity($query, 'hjghjg');
//                    var_dump($query);
					if($result = run_query($query)){
						$return = array();
					    if(get_num_rows($result)){
							while ($rows = get_row_data($result)) {
								$return[] = $rows;
							}
						}
                        return $return;
					}else{
//                        traceActivity($query, 'hjghjg');
						return false;
					}
				}
			}
		}

		public function getRows(){
			return $this->_data;
		}

		public function getStatus($status){
			return ($status == 't') ? 'Active' : 'Inactive';
		}

		public function beginTranc(){
			run_query("BEGIN TRANSACTION;");
		}

		public function endTranc(){
			run_query("END TRANSACTION;");
		}
	}
?>