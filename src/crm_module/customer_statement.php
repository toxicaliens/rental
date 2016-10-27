<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 24/10/16
 * Time: 13:39
 */
require_once('src/models/CustomerStatement.php');
$customer_s = new CustomerStatement();
if (App::isAjaxRequest()){
    if(isset($_GET['q'])){
        //check the logged in role
       $role = $_SESSION['role_name'];
        $return = array();
        $string = strtolower(trim($_GET['q']));
       $query = $customer_s->selectQuery('customer_statement','DISTINCT(customer_name), mf_id',"lower(customer_name) LIKE '%".$string."%' AND created_by = '".$_SESSION['mf_id']."'");
//        $query = "SELECT mf_id, CONCAT(surname,' ',firstname,' ',middlename) AS patient_name FROM patients
//		WHERE surname LIKE '%".$string."%' OR firstname LIKE '%".$string."%' OR middlename LIKE '%".$string."%' LIMIT 50";
        if (count($query)){
            foreach ($query as $q){
                $return[] = array(
                    'id' => $q['mf_id'],
                    'text' => $q['customer_name']
                );
            }
        }else{
            $return[] = array(
                'id' => '',
                'text' => 'No Customer found!'
            );
        }
        echo json_encode($return);
    }
}else{
set_title('Customer Statement');
set_layout("dt-layout.php", array(
    'pageSubTitle' => 'Statement',
    'pageSubTitleText' => '',
    'pageBreadcrumbs' => array (
        array ( 'url'=>'#', 'text'=>'Home' ),
        array ( 'text'=>'CRM' ),
        array ( 'text'=>'Customer Statement' )
    ),
    'pageWidgetTitle'=>'<i class="icon-reorder"></i>Customer Statement'
));

set_css(array(
    'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css'
));

set_js(array(
    'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js',
));

?>
<div class="widget" >
    <div class="widget-title"><h4><i class="icon-reorder"></i> Customer Statement</h4>
<!--        <span class="actions">-->
<!--			    <a href="#add_lease" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-plus"></i> Add Lease</a>-->
<!--                <a href="#update_lease" class="btn btn-small btn-success" id="edit_lease_btn"><i class="icon-edit"></i> Edit</a>-->
<!--                <input type="hidden" id="terminate_id">-->
<!--		</span>-->

    </div>
    <div class="widget-body form">
        <form action="" class="form-horizontal" method="post">
            <div class="row-fluid span12">
                <div class="control-group span6">
                    <label class="control-label span2">Customer Name: </label>
                    <div class="controls">

                            <select class="span10 patient" name="customer_id">

                            </select>

                    </div>
                </div>

                <div class="control-group span4" >
                    Search: <button class="btn btn-primary"><i class="icon-search"></i> </button>
                </div>
                <div class="span1">

                </div>
            </div>
        </form>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="center-align">Date</th>
                <th class="center-align">Service Account</th>
                <th class="center-align">Payment Mode</th>
                <th class="center-align">Particulars</th>
                <th class="center-align">Debit</th>
                <th class="center-align">Credit</th>
            </tr>
            </thead>
            <tbody>

            <?php
            $customer_name = '';
            if(isset($_POST['customer_id'])){
                $customer_name = $_POST['customer_id'];
            }
            $month_from = '';
            $month_to = '';

            $month_from = date('Y-m-01');
            $month_to = date('Y-m-d');

            $criteria = "AND journal_date::date >= '".$month_from."' AND journal_date::date <= '".$month_to."'";

            if(isset($_POST['month'])){
                $month = $_POST['month'];
                if(!empty($month)){
                    $month_from = date($month.'-01');
                    $year_month = explode('-', $month);
                    $month_to = last_day($year_month[1], $year_month[0]);

                    $criteria = "AND (journal_date::date >= '".$month_from."' AND journal_date::date <= '".$month_to."')";
                }
            }

//            $distinctQuery = "select j.*, m.*, t.payment_mode from ".DATABASE.".journal j
//           LEFT JOIN masterfile m ON m.mf_id = j.mf_id
//           LEFT JOIN transactions t On t.bill_id = j.bill_id
//           WHERE j.mf_id = '1078' $criteria ORDER by journal_date ASC
//           ";
//            $resultId = run_query($distinctQuery);
//            $total_rows = get_num_rows($resultId);
//
//            while($row = get_row_data($resultId))
            if ($_SESSION['role_name'] == SystemAdmin) {
                if(isset($_POST['customer_id'])){
                    $customer_name = $_POST['customer_id'];
                    $customer_statement = $customer_s->selectQuery('customer_statement','*',"mf_id = '".$customer_name."'");
                }else {
                    $customer_statement = $customer_s->selectQuery('customer_statement', '*');
                }
                }else{
                if(isset($_POST['customer_id'])){
                    $customer_name = $_POST['customer_id'];
                }
                $customer_statement = $customer_s->selectQuery('customer_statement','*',"mf_id = '".$customer_name."'");
            }
            if (count($customer_statement) >0 ){
                foreach ($customer_statement as $row){
                $j_date = trim(date('d/m/Y', strtotime($row['journal_date'])));
                $customer_name = $row['customer_name'];
                $amount = trim($row['amount']);
                $service_account = $row['service_account'];
                $particulars = $row['particulars'];
                $Payment = $row['payment_mode'];
                $dr_cr = $row['dr_cr'];
                if($dr_cr == 'DR')
                    $dr_cr = 'Debit';
                else
                    $dr_cr = 'Credit';
                $journal_type = $row['journal_type'];
                if($journal_type == 1)
                    $journal_type = 'Ordinary';
                else if($journal_type == 2)
                    $journal_type = 'Closing';
                else
                    $journal_type = 'Opening';
                ?>

                <tr>
                    <td><?=$j_date; ?></td>
                    <td><?=$service_account; ?></td>
                    <td><?=$Payment; ?></td>
                    <td><?=$particulars; ?></td>
                    <td style="text-align:right;">
                        <?php
                        if($dr_cr == 'Debit'){
                            echo number_format($amount, 2);
                        }
                        ?>
                    </td>
                    <td style="text-align:right;">
                        <?php
                        if($dr_cr == 'Credit'){
                            echo number_format($amount, 2);
                        }
                        ?>
                    </td>
                </tr>
                <?

            }
            ?>
            <tr>
                <td colspan="3" style="text-align:right;font-weight:bold">Totals:</td>
                <td style="text-align:right;font-weight:bold">
<!--                    --><?php
//                    $query = "SELECT SUM(amount) as total_debit FROM journal WHERE dr_cr = 'DR' AND mf_id = '".$mf_id."' $criteria";
//                    $result = run_query($query);
//                    $row = get_row_data($result);
//                    $debit_total = $row['total_debit'];
//                    echo number_format($debit_total, 2);
//                    ?>
                </td>
                <td style="text-align:right;font-weight:bold">
<!--                    --><?php
//                    $query = "SELECT SUM(amount) as total_credit FROM journal WHERE dr_cr = 'CR' AND mf_id = '".$mf_id."' $criteria";
//                    $result = run_query($query);
//                    $row = get_row_data($result);
//                    $credit_total = $row['total_credit'];
//                    echo number_format($credit_total, 2);
//                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align:right;font-weight:bold">Current Balance:</td>
                <td colspan="3" style="text-align:right;font-weight:bold">
                    <?php
//                    $credit_balance = $credit_total - $debit_total;
//                    if($credit_balance < 0){
//                        $absolute = abs($credit_balance);
//                        $negative = number_format($absolute, 2);
//                        echo "<span class='negative'>($negative)</span>";
//                    }else{
//                        echo number_format($credit_balance, 2);
//                    }

                    ?>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<?php set_js(array('src/js/customer_statement.js')); }}?>
