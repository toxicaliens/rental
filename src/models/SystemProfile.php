<?php
require_once 'src/models/Library.php';
require_once 'src/models/PHPMailer/PHPMailerAutoload.php';
/**
* 
*/
class SystemProfile extends Library
{
    private $_sys_data = array();
    private $_destination = 'crm_images/';

    public function __construct()
    {
        $query = "SELECT * FROM system_value";
        if ($result = run_query($query)) {
            if (get_num_rows($result)) {
                while ($rows = get_row_data($result)) {
                    $this->_sys_data[] = $rows;
                }
            }
        }
    }

    public function getSystemData()
    {
        return $this->_sys_data;
    }

    public function addSetting()
    {
        extract($_POST);

        if (!empty($setting_name) && !empty($setting_value) && !empty($setting_code)) {
            if (!checkForExistingEntry('system_value', 'setting_name', $setting_name)) {
                if (!checkForExistingEntry('system_value', 'setting_code', $setting_code)) {
                    $query = "INSERT INTO system_value(setting_name, setting_value, setting_code) 
					VALUES('" . sanitizeVariable($setting_name) . "', '" . sanitizeVariable($setting_value) . "', '" . sanitizeVariable($setting_code) . "')";
                    if (run_query($query)) {
                        $_SESSION['setting'] = '<div class="alert alert-success">
						<button class="close" data-dismiss="alert">&times;</button>
						<strong>Success! </strong> Setting has been added!
						</div>';
                    } else {
                        return false;
                    }
                } else {
                    $_SESSION['setting'] = '<div class="alert alert-warning">
						<button class="close" data-dismiss="alert">&times;</button>
						<strong>Warning! </strong> Setting Code (' . $setting_code . ') already exists!
						</div>';
                }
            } else {
                $_SESSION['setting'] = '<div class="alert alert-warning">
						<button class="close" data-dismiss="alert">&times;</button>
						<strong>Warning! </strong> Setting Name(' . $setting_name . ') already exists!
						</div>';
            }
        }
    }

    public function editSetting()
    {
        extract($_POST);

        if (!empty($setting_name) && !empty($setting_value) && !empty($setting_code)) {
            if (!onEditcheckForExistingEntry('system_value', 'setting_name', $setting_name, 'setting_id', $edit_id)) {
                if (!onEditcheckForExistingEntry('system_value', 'setting_code', $setting_code, 'setting_id', $edit_id)) {
                    $query = "UPDATE system_value SET setting_name = '" . sanitizeVariable($setting_name) . "',
					setting_code = '" . sanitizeVariable($setting_code) . "', setting_value = '" . sanitizeVariable($setting_value) . "'
					WHERE setting_id = '" . $edit_id . "'";
                    if (run_query($query)) {
                        $_SESSION['setting'] = '<div class="alert alert-success">
						<button class="close" data-dismiss="alert">&times;</button>
						<strong>Success! </strong> Setting has been updated!
						</div>';
                    } else {
                        return false;
                    }
                } else {
                    $_SESSION['setting'] = '<div class="alert alert-warning">
						<button class="close" data-dismiss="alert">&times;</button>
						<strong>Warning! </strong> Setting Code (' . $setting_code . ') already exists!
						</div>';
                }
            } else {
                $_SESSION['setting'] = '<div class="alert alert-warning">
						<button class="close" data-dismiss="alert">&times;</button>
						<strong>Warning! </strong> Setting Name(' . $setting_name . ') already exists!
						</div>';
            }
        }
    }

    public function deleteSetting()
    {
        extract($_POST);

        $query = "DELETE FROM system_value WHERE setting_id = '" . sanitizeVariable($delete_id) . "'";
        if (run_query($query)) {
            $_SESSION['setting'] = '<div class="alert alert-success">
				<button class="close" data-dismiss="alert">&times;</button>
				<strong>Success! </strong> Setting has been deleted!
			</div>';
        }
    }

    public function updateClientSettings()
    {
        extract($_POST);
        $file_path = '';
        $uniq_id = uniqid();
        $results = $this->selectQuery('client_settings', '*', "mf_id = '" . $_SESSION['mf_id'] . "'");
        if (!count($results)) {
            $this->validate($_POST, array(
                'title' => array(
                    'name' => 'Title',
                    'required' => true
                )
            ));

            if ($this->getValidationStatus()) {
                $destination = $this->_destination . $uniq_id . $_FILES['logo_path']['name'];
                if (empty($_FILES['logo_path']['name'])) {
                    $this->setWarning('The logo is required');
                }
                $name = explode('.', $_FILES['logo_path']['name']);
//                if ($name[1] != 'png' ||$name[1] != 'img' ||$name[1] != 'jpg') {
//                    $this->setWarning('The file type (' . $name[1] . ') is not allowed');
//                }

                if (count($this->getWarnings()) <= 0) {
                    $image_path = $this->uploadImage($_FILES['logo_path']['tmp_name'], $destination);
//                    var_dump($image_path);die;
                    $results = $this->insertQuery('client_settings', array(
                        'mf_id' => $_SESSION['mf_id'],
                        'logo_path' => $image_path,
                        'title' => $title
                    ));
                    if ($results) {
                        $this->flashMessage('client_settings', 'success', 'The details have been uploaded');
                    }
                }
            }
        } else {
            if (!empty($_FILES['logo_path']['name'])) {
                $name = explode('.', $_FILES['logo_path']['name']);
//                if ($name[1] != 'png' || $name[1] != 'img' || $name[1] != 'jpg') {
//                    $this->setWarning('The file type (' . $name[1] . ') is not allowed');
//                }
                if (count($this->getWarnings()) <= 0) {
                    $destination = $this->_destination . $uniq_id . $_FILES['logo_path']['name'];
                    $image_path = $this->uploadImage($_FILES['logo_path']['tmp_name'], $destination);
                    $results = $this->updateQuery2('client_settings', array(
                        'title' => $title,
                        'logo_path' => $image_path
                    ), array(
                        'mf_id' => $_SESSION['mf_id']
                    ));
                    if ($results) {
                        $this->flashMessage('client_settings', 'success', 'Client details updated');
                    } else {
                        $this->setWarning('Failed to update client record' . get_last_error());
                    }
                }
            } else {
                $results = $this->updateQuery2('client_settings', array(
                    'title' => $title
                ), array(
                    'mf_id' => $_SESSION['mf_id']
                ));
                if ($results) {
                    $this->flashMessage('client_settings', 'success', 'Client details updated');
                } else {
                    $this->setWarning('Failed to update client record' . get_last_error());
                }
            }
        }

    }

    public function changeEmail($new_email)
    {
        $message = array();
        $result = $this->selectQuery('user_requests', '*', "mf_id = '" . $_SESSION['mf_id'] . "'");
        if (count($result)) {
            $query = $this->updateQuery2('user_requests', array(
                'status' => '0'
            ), array(
                'mf_id' => $_SESSION['mf_id']
            ));
        }
        $existin_email = $this->selectQuery('user_login2', 'email', "mf_id = '" . $_SESSION['mf_id'] . "'");
        $email_address = $existin_email[0]['email'];
        if (!empty($new_email)) {
            $request_new_email = $new_email;
            $insert = $this->insertQuery('user_requests', array(
                'request_type' => 'Change Email',
                'request_value' => $request_new_email,
                'request_date' => date('Y-m-d', time()),
                'mf_id' => $_SESSION['mf_id'],
                'status' => '1'
            ), 'request_id'
            );
            $emai_request_id = $insert['request_id'];
            if (!$insert) {
                $message[] = array('user_request_insert_error' => false);
            } else {
                $sendmail = $this->sendMail($email_address, $emai_request_id);
                $this->endTranc();

                if ($sendmail) {
                    $message[] = array('send_mail' => true);
                } else {
                    $message[] = array('send_mail' => false);
                }

            }


        }
        return $message;

    }

    public function sendMail($sendto, $code)
    {
        $result = $this->selectQuery('message_type','message_type_id',"message_type_code = 'EMAIL'");
        $message_type = $result[0][0];
        $this->beginTranc();
        $broadcast = $this->insertQuery('message',array(
            'body'=> 'Your Email reset code is '.$code.' provide to complete email change process',
            'subject'=> 'Email change verification code',
            'sender'=>$_SESSION['mf_id'],
            'recipients'=> '{'.$_SESSION['mf_id'].'}',
            'message_type_id'=>'{'.$message_type.'}',
            'status'=>'1'
        ),'message_id');
        $broadcast['message_id'];
//        var_dump($broadcast);die;
        if(!$broadcast){
            $message[] = array('error'=> get_last_error());
        }

        $customer_message = $this->insertQuery('customer_messages',array(
            'message_id'=>$broadcast['message_id'],
            'mf_id'=>$_SESSION['mf_id'],
            'read'=>'0'
        ));
//        var_dump($customer_message);die;
        if($customer_message){

            return true;
        }else{
            return false;
        }
//        $mail = new PHPMailer;
//        $mail->isSendmail();
//
////            $mail->SMTPDebug = 3;                               // Enable verbose debug output
//
//        $mail->isSendmail();
//        $mail->isSMTP();                                      // Set mailer to use SMTP
//        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
//        $mail->SMTPAuth = true;                               // Enable SMTP authentication
//        $mail->Username = 'al3xicy@gmail.com';                 // SMTP username
//        $mail->Password = 'k1nuth1a';                           // SMTP password
//        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
//        $mail->Port = 587;                                    // TCP port to connect to
//        $mail->setFrom('obulexsolutions.com', 'Rental solution');
//        $mail->addAddress($sendto, 'System User');     // Add a recipient
////        $mail->addAddress('ellen@example.com');               // Name is optional
////        $mail->addReplyTo('info@example.com', 'Information');
////        $mail->addCC('cc@example.com');
////        $mail->addBCC('bcc@example.com');
//
////        $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
////        $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
//        $mail->isHTML(true);                                  // Set email format to HTML
//
//        $mail->Subject = 'Email Change Code';
//        $mail->Body = 'Dear Customer, Your email change code is <b>' . $code . '</b><br><br> Thank you for using choosing rental';
////        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
//
//        if (!$mail->send()) {
//            return $error = $mail->ErrorInfo;
//        } else {
//            return true;
//        }

    }

    public function verifyEmailChange($code)
    {
        $success = array();
        $result = $this->selectQuery('user_requests', 'mf_id', " mf_id = '" . $_SESSION['mf_id'] . "' AND request_id = '" . $code . "' AND status = '1'  "
        );
//        var_dump($result);
        if (!count($result)) {
            $success[] = array('success' => false,
                'error' => 'The request code does not exist, please verify the email and try again'
            );
        } else {
            $email = $this->selectQuery('user_requests', 'request_value', "request_id = '" . $code . "' AND mf_id = '" . $_SESSION['mf_id'] . "'");
            $new_email = $email[0]['request_value'];
            if ($email) {
                $result = $this->updateQuery2('user_login2', array(
                    'email' => $new_email,
                    'username' => $new_email
                ), array(
                    'mf_id' => $_SESSION['mf_id']
                ));
                if ($result) {
                    $success[] = array(
                        'success' => true,
                        'new_email' => $new_email

                    );
                    session_destroy();
                } else {
                    $success[] = array(
                        'success' => false,
                        'error' => get_last_error()
                    );
                }
            }
        }
        return $success;
    }

    public function resetPhoneNumber($phone_number)
    {
        $message = array();
        $result = $this->selectQuery('user_requests', '*', "mf_id = '" . $_SESSION['mf_id'] . "'");
        if (count($result)) {
            $query = $this->updateQuery2('user_requests', array(
                'status' => '0'
            ), array(
                'mf_id' => $_SESSION['mf_id']
            ));
        }
        $existing_phone_number = $this->selectQuery('address', 'phone', "mf_id = '" . $_SESSION['mf_id'] . "'");
        $existing_phone_number = $existing_phone_number[0]['phone'];
        if (!empty($phone_number)) {
            $request_new_phone_number = $phone_number;
            $insert = $this->insertQuery('user_requests', array(
                'request_type' => 'Change Phone Number',
                'request_value' => $request_new_phone_number,
                'request_date' => date('Y-m-d', time()),
                'mf_id' => $_SESSION['mf_id'],
                'status' => '1'
            ), 'request_id'
            );
            $phone_request_id = $insert['request_id'];
            if (!$insert) {
                $message[] = array('user_request_insert_error' => false);
            } else {
                $broadcast = $this->sendPhoneResetRequest($phone_request_id,$existing_phone_number);
                $this->endTranc();
                if ($broadcast) {
                    $message[] = array('send_phone_number' => true);
                } else {
                    $message[] = array('send_phone_number' => false);
                }

            }

        }
        return $message;
    }

    public function sendPhoneResetRequest($request_id,$existing_phone_number){
        $result = $this->selectQuery('message_type','message_type_id',"message_type_code = 'SMS'");
        $message_type = $result[0][0];
        $this->beginTranc();
        $broadcast = $this->insertQuery('message',array(
            'body'=> 'Your phone number reset code is '.$request_id.' provide to complete reset',
            'subject'=> 'Phone number reset code',
            'sender'=>$_SESSION['mf_id'],
            'recipients'=> '{'.$existing_phone_number.'}',
            'message_type_id'=>'{'.$message_type.'}',
            'status'=>'1'
        ),'message_id');
        $broadcast['message_id'];
//        var_dump($broadcast);die;
        if(!$broadcast){
            $message[] = array('error'=> get_last_error());
        }

        $customer_message = $this->insertQuery('customer_messages',array(
            'message_id'=>$broadcast['message_id'],
            'mf_id'=>$_SESSION['mf_id'],
            'read'=>'0'
        ));
//        var_dump($customer_message);die;
        if($customer_message){

            return true;
        }else{
            return false;
        }
    }

    public function confirmResetPhoneNumber($code){
        $success = array();
        $result = $this->selectQuery('user_requests', 'mf_id', " mf_id = '" . $_SESSION['mf_id'] . "' AND request_id = '" . $code . "' AND status = '1'  "
        );
//        var_dump($result);
        if (!count($result)) {
            $success[] = array('success' => false,
                'error' => 'The request code does not exist, please verify the sms and try again'
            );
        } else {
            $phone_number = $this->selectQuery('user_requests', 'request_value', "request_id = '" . $code . "' AND mf_id = '" . $_SESSION['mf_id'] . "'");
            $new_phone_number = $phone_number[0]['request_value'];
            if ($new_phone_number) {
                $result = $this->updateQuery2('address', array(
                    'phone' => $new_phone_number
                ), array(
                    'mf_id' => $_SESSION['mf_id']
                ));
                if ($result) {
                    $success[] = array(
                        'success' => true,
                        'new_phone' => $new_phone_number

                    );
                } else {
                    $success[] = array(
                        'success' => false,
                        'error' => get_last_error()
                    );
                }
            }
        }
        return $success;
    }
}