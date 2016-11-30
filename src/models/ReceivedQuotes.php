<?php
require_once 'src/models/Quotes.php';
/**
 * Created by PhpStorm.
 * User: erick.murimi
 * Date: 7/15/2016
 * Time: 1:25 PM
 */
class ReceivedQuotes extends Quotes{
    public function getAllQuotesInJson($condition = null){
        $condition = (!is_null($condition)) ? $condition : '';

        $data = $this->selectQuery('contractors_quotes', '*', $condition );
        if(count($data)){
            foreach ($data as $row){
                $quote_id = $row['qoute_id'];
                $voucher_id = $row['maintainance_id'];

                $approve_btn = '';
                if(!$this->checkIfVoucherHasBeenWon($voucher_id)) {
                    $approve_btn = '<button class="btn btn-mini btn-success award-btn" quote-id="' . $quote_id . '"><i class="icon-paper-clip"></i> Award</button>';
                }
                if($row['bid_status'] == 't') {
                    $approve_btn = '<button class="btn btn-mini btn-danger cancel-btn" quote-id="' . $quote_id . '"><i class="icon-remove"></i> Cancel</button>';
                }
                if($row['bid_status']== 't'){
                    $payment_v_btn = '<button data-target="#create-payment-voucher" data-toggle="modal" class="btn btn-mini btn-success c-payment-v" quote-id="' . $quote_id . '"><i class="icon-paper-clip"></i> Create payment voucher</button>';
                }else{
                    $payment_v_btn = '';
                }

                $rows[] = array(
                    $row['qoute_id'],
                    $row['maintenance_name'],
                    $row['full_name'],
                    number_format($row['bid_amount'],2),
                    $row['bid_date'],
                    ($row['bid_status'] == 't') ? '<span class="label label-success">Approved</span>': '<span class="label label-default">Pending</span>',
                    ($row['job_status'] == 't') ? '<span class="label label-success">Complete</span>' : '<span class="label label-default">Incomplete</span>',
                    $approve_btn,
                    $payment_v_btn
                );
                $return['data'] = $rows;
            }
        }else{
            $return['data'] = array();
        }
        echo json_encode($return);
    }

    public function getApprovedVouchers(){
        $data = $this->selectQuery('maintenance_vouchers', '*', "approve_status IS TRUE");
        return $data;
    }

    public function awardQuote($quote_id){
        $this->beginTranc();
        $result = $this->updateQuery2('quotes',
            array(
                'bid_status' => '1'
            ),
            array(
                'qoute_id' => $quote_id
            )
        );
        if($result){
            $quote_d = $this->getQuoteDataFromQuoteId($quote_id);
            $contractor = "{".$quote_d['contractor_mf_id']."}";

            $body = "Dear Contractor, \n";
            $body .= "You have been awarded the maintenance voucher No: ".$quote_d['maintenance_id'].". \n";
            $body .= "Thanks.";
            $mess = array(
                'subject' => 'Award for quote#: '.$quote_id,
                'body' => $body
            );

            if($this->createMessage(Push, $contractor, $mess, array($quote_d['contractor_mf_id']))) {
                if($this->createMessage(Email, $contractor, $mess, array($quote_d['contractor_mf_id']))) {
                    if($this->createMessage(SMS, $contractor, $mess, array($quote_d['contractor_mf_id']))) {
                        $this->endTranc();
                        $return = array('success' => true);
                    }
                }
            }
        }else{
            $return = array('success' => false);
        }
        echo json_encode($return);
    }

    public function checkIfVoucherHasBeenWon($voucher_id){
        $data = $this->selectQuery('quotes', '*', "maintenance_id   = '".sanitizeVariable($voucher_id)."' AND bid_status IS TRUE");
        if(count($data)){
            return true;
        }else{
            return false;
        }
    }

    public function cancelAward($quote_id){
        $this->beginTranc();
        $result = $this->updateQuery2('quotes',
            array(
                'bid_status' => '0'
            ),
            array(
                'qoute_id' => $quote_id
            )
        );
        if($result){
            $quote_d = $this->getQuoteDataFromQuoteId($quote_id);
            $contractor = "{".$quote_d['contractor_mf_id']."}";

            $body = "Dear Contractor, \n";
            $body .= "Sorry the award was canceled. \n";
            $body .= "Thanks.";
            $mess = array(
                'subject' => 'Award Cancellation for quote#: '.$quote_id,
                'body' => $body
            );

            if($this->createMessage(Push, $contractor, $mess, array($quote_d['contractor_mf_id']))) {
                if($this->createMessage(Email, $contractor, $mess, array($quote_d['contractor_mf_id']))) {
                    if($this->createMessage(SMS, $contractor, $mess, array($quote_d['contractor_mf_id']))) {
                        $this->endTranc();
                        $return = array('success' => true);
                    }
                }
            }
        }else{
            $return = array(
                'success' => false
            );
        }
        echo json_encode($return);
    }

    public function getQuoteDataFromQuoteId($quote){
        $data = $this->selectQuery('quotes', '*', "qoute_id = '".sanitizeVariable($quote)."'");
        return $data[0];
    }

    public function createPaymentVoucher(){
        extract($_POST);
        $quote_id = $_POST['quote_id'];
        //check whether a payment voucher for this quote exists
        $quote = $this->selectQuery('payment_vouchers','*'," quote_id = '".$quote_id."' AND bill_status IS TRUE ");
        if(!count($quote)) {
            $quote_details = $this->selectQuery('quotes', '*', "qoute_id = '" . $quote_id . "'");
            $property_details = $this->selectQuery('maintenance_vouchers','*',"voucher_id = '".$quote_details[0]['maintenance_id']."'");

            if (count($quote_details)) {
                $result = $this->insertQuery('payment_vouchers', array(
                    'quote_id' => $quote_details[0]['qoute_id'],
                    'contractor_id' => $quote_details[0]['contractor_mf_id'],
                    'bill_amount' => $quote_details[0]['bid_amount'],
                    'bill_date' => date('Y/m/d', time()),
                    'bill_status' => '1',
                    'maintenance_voucher_id' => $quote_details[0]['maintenance_id'],
                    'created_by'=>$_SESSION['mf_id'],
                    'bill_balance'=>$quote_details[0]['bid_amount'],
                    'property_id'=>$property_details[0]['property_id'],
                    'unit_id'=>$property_details[0]['unit_id'],
                    'biller_mfid'=>$property_details[0]['approve_user']

                ));

                if ($result) {
                    $this->flashMessage('payment_vouchers', 'success', 'The payment voucher has been created');
                    App::redirectTo('?num=payment_vouchers');
                }else{
                    $this->flashMessage('support','error','Failed to create payment voucher'.get_last_error());
                }

            }
        }else{
            $this->setWarning('A payment voucher for quote ('.$quote_id.') already exists');
        }
    }

    public function settleVoucher(){
        extract($_POST);
//        var_dump($_POST);die;
        $validate = array(
          'amount_paid'=>array(
              'name'=>'Amout to pay',
              'required'=>true
          ),
            'payment_voucher_id'=>array(
                'name'=>'Voucher number',
                'required'=>true
            )
        );

        $this->validate($_POST,$validate);
        if($this->getValidationStatus()){
//            $maintenance = $this->selectQuery('');
            $voucher_details = $this->selectQuery('payment_vouchers','*',"payment_voucher_id = '".$payment_voucher_id."'");
            $voucher_new_balance = $voucher_details[0]['bill_balance'] - $amount_paid;
            $voucher_new_paid_amount = $voucher_details[0]['bill_amount_paid'] + $amount_paid;
//            print_r($voucher_details);die;

            $this->beginTranc();
                $result = $this->updateQuery2('payment_vouchers',array(
                    'bill_amount_paid'=>$voucher_new_paid_amount,
                    'bill_balance'=>$voucher_new_balance
                ),array(
                    'payment_voucher_id'=>$_POST['payment_voucher_id']
                ));

                if(!$result){
                    $this->setWarning('Failed to update Payment'.get_last_error());
                }else{
                    //record an expense transaction
                    $result_set2 = $this->insertQuery('ledger',array(
                        'payment_voucher_id'=>$_POST['payment_voucher_id'],
                        'payment_method'=>$_POST['payment_method'],
                        'amount'=>$_POST['amount_paid'],
                        'ledger_type'=>'DR',
                        'transacted_by'=>$_SESSION['mf_id'],
                        'contractor_id'=>$voucher_details[0]['contractor_id'],
                        'quote_id'=>(!empty($voucher_details[0]['quote_id']))? $voucher_details[0]['quote_id']: 'NULL' ,
                        'supplier_bill_id'=>(!empty($voucher_details[0]['quote_id']))? $voucher_details[0]['quote_id']: 'NULL',
                        'property_id'=>$voucher_details[0]['property_id'],
                        'unit_id'=>$voucher_details[0]['unit_id'],
                        'created_by'=>$_SESSION['mf_id'],
                        'ledger_date'=> date('Y-m-d',time()),
                        'particulars'=>$voucher_details[0]['maintenance_voucher_id']
                    ));
                }
            $this->endTranc();
            if($result_set2){
                $this->flashMessage('payment_vouchers','success','Payment details updated');
            }else{
                $this->flashMessage('payment_vouchers','error','Failed to update Payment details'.get_last_error());
            }
        }

    }

    public function addExpenseBillItem(){
        extract($_POST);
        $validate = array(
            'expense_name'=>array(
                'name'=>'Expense name',
                'required'=>true
            ),
            'code'=>array(
                'name'=>'Expense Code',
                'required'=>true
            )
        );
        $this->validate($_POST, $validate);
        if($this->getValidationStatus()){
            $results = $this->insertQuery('expense_bill_items',array(
               'expense_name'=>$expense_name,
                'code'=>$code,
                'created_by'=>$_SESSION['mf_id']
            ));

            if ($results){
                $this->flashMessage('support','success','The item has been added');
            }else{
                $this->flashMessage('support','error','Failed to add item'.get_last_error());
            }
        }
    }
    private $_destination = 'crm_images/';
    public function createExpenseVoucher(){
        extract($_POST);
//        var_dump($_FILES);die;
        $validate = array(
          'supplier_item'=>array(
              'name'=>'Supplier Item',
              'required'=>true
          ),
            'bill_amount'=>array(
                'name'=>'Voucher Amount',
                'required'=>true
            ),
            'supplier_id'=>array(
                'name'=>'Supplier',
                'required'=>true
            )
        );

        $this->validate($_POST,$validate);
        if($this->getValidationStatus()){
            $uniq_id = uniqid();
            if (!empty($_FILES['voucher_document']['name'])){
                $destination = $this->_destination.$uniq_id.$_FILES['voucher_document']['name'];
                $document_path = $this->uploadImage($_FILES['voucher_document']['tmp_name'], $destination);
            }else{
                $document_path = '';
            }
            $result = $this->insertQuery('payment_vouchers',array(
                'contractor_id'=>$supplier_id,
                'bill_amount'=>$bill_amount,
                'bill_date'=>date('Y-m-d',time()),
                'bill_status'=>'1',
                'bill_amount_paid'=>0,
                'bill_balance'=>$bill_amount,
                'property_id'=>$property_id,
                'unit_id'=>(!empty($unit_id))? $unit_id : '0',
                'created_by'=>$_SESSION['mf_id'],
                'biller_mfid'=>$_SESSION['mf_id'],
                'document_path'=>$document_path
            ));
            if($result){
                $this->flashMessage('payment_vouchers','success','The voucher has been created');
                App::redirectTo('?num=payment_vouchers');
            }else{
                $this->flashMessage('payment_vouchers','error','Failed to create a payment voucher'.get_last_error());
            }
        }
    }
}