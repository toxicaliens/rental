<?php
	class Referrals{
		public function getReferrals($visit_id){
			$query = "SELECT r.*, v.visit_id FROM referrals r
			LEFT JOIN visits v ON v.visit_id = r.visit_id
			WHERE r.visit_id = '".$visit_id."'";
			// var_dump($query);exit;
			$result = run_query($query);

			return $result;
		}

		public function addReferrals(){
			extract($_POST);
			if(!checkForExistingEntry('referrals', 'referral_id', $_POST['referral_id'])){
				//add the station
				$query = "INSERT INTO referrals(visit_id, description) 
				VALUES('".$_POST['visit_id']."', '".$_POST['description']."')";
				$result = run_query($query);
				// var_dump($_POST); exit;
				if($result){
					$_SESSION['refferalss'] = '<div class="alert alert-success">
							<button class="close" data-dismiss="alert">&times;</button>
							<strong>Success!</strong> New Referral has been Added.
						</div>';
				}
			}else{
				$_SESSION['refferalss'] = '<div class="alert alert-warning">
					<button class="close" data-dismiss="alert">&times;</button>
					<strong>Warning!</strong> The Referral for ('.$_POST["referral_id"].') already exists.
				</div>';
			}
		}

		public function editReferrals(){
			if(!empty($_POST['edit_id'])){
				//add the visit
				$query = "UPDATE referrals SET description = '".$_POST['description']."' 
				WHERE referral_id = '".$_POST['edit_id']."'";
				$result = run_query($query);
				if($result){
					$_SESSION['refferalss'] = '<div class="alert alert-success">
							<button class="close" data-dismiss="alert">&times;</button>
							<strong>Success!</strong> Service has been Updated.
						</div>';
				}
			}
		}

		public function deleteReferrals(){
			if(!empty($_POST['delete_id'])){
				$delete_id = $_POST['delete_id'];

				$query = "DELETE FROM referrals WHERE referral_id = '".$delete_id."'";
				$result = run_query($query);
				if($result){
					$_SESSION['refferalss'] = '<div class="alert alert-success">
							<button class="close" data-dismiss="alert">&times;</button>
							<strong>Success!</strong> Referrals has been removed.
						</div>';
				}else{
					$_SESSION['refferalss'] = '<div class="alert alert-warning">
						<button class="close" data-dismiss="alert">&times;</button>
						<strong>Warning!</strong> The Referrals record cannot be deleted yet since it is still referenced elsewhere in the system.
					</div>';
				}
			}
		}

		public function filterReferrals($from, $to){
			if(!empty($from) && !empty($to)){
				return " AND referral_date >= '".sanitizeVariable($from)."' AND referral_date <= '".sanitizeVariable($to)."'";
			}
		}	

		public function getReferralsFromAndToDates($daterange){
			if(!empty($daterange)){
				return explode(' - ', $daterange);
			}
		}
	}