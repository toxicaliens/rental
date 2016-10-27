<?php
include_once('src/models/Bills.php');
$bills = new Bills();
set_layout("dt-layout.php", array(
    'pageSubTitle' => 'Bills',
    'pageSubTitleText' => '',
    'pageBreadcrumbs' => array (
        array ( 'url'=>'index.php', 'text'=>'Home' ),
        array ( 'text'=>'Payments & Bills' ),
        array ( 'text'=>'<a href="?num=168">Billing Files</a>' )
    )
));
?>

<div class="widget">
    <div class="widget-title">
        <h4>Customer Details</h4>
    </div>
    <div class="widget-body form">

        <table id="table1" class="table table-bordered">
            <thead>
            <tr>
                <th>Bill#</th>
                <th>Bill Date</th>
                <th>Bill Amount</th>
                <th>Tenant</th>
                <th>B.Amount</th>
                <th>B.Due Date</th>
                <th>Service Account</th>
                <th>B.Balance</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>

            <?php
            $date_range = (isset($_POST['date_range'])) ? Bills::getFromAndToDates($_POST['date_range']) : '';
            $condition = (isset($_POST['date_range'])) ? Bills::filterBills($date_range[0], $date_range[1]) : '';

            $distinctQuery = "select c.*, m.*, sc.service_option, sc.price from ".DATABASE.".customer_bills c
  LEFT JOIN masterfile m ON m.mf_id = c.mf_id
  LEFT JOIN service_channels sc ON sc.service_channel_id = c.service_channel_id
  WHERE bill_status <> '2' $condition;";
            $resultId = run_query($distinctQuery);
            $total_rows = get_num_rows($resultId);
    if (isset($_GET['b_id'])){
                $all_bills = $bills->selectQuery('customer_bills','*',"billing_file_id = '".$_GET['b_id']."' ");
                if(count($all_bills)){
                    foreach ($all_bills as $row){
                $trans_id = trim($row['bill_id']);
                $duedate= $row['bill_due_date'];
                $bill_date = $row['bill_date'];
                $customer_id = $row['mf_id'];
                $full_name = $row['surname'].' '.$row['firstname'].' '.$row['middlename'];
                $bill_amt = $row['bill_amount'];
                // $bstatus = $row['bill_status'];
                $serviceaccount = $row['service_account'];
                $bill_balance = $row['bill_balance'];
//                $serviceaccounttype = $row['service_option'];
//                $price = $row['price'];

                ?>
                <tr>
                    <td><?=$trans_id; ?></td>
                    <td><?php echo $bill_date; ?></td>
                    <td><? //=number_format($price, 2); ?></td>
                    <td><?=$full_name; ?></td>
                    <td><?=$bill_amt; ?></td>
                    <td><?php echo $duedate; ?></td>
                    <td><?=$serviceaccount; ?></td>
                    <td><?=($bill_balance > 0) ? $bill_balance : 0; ?></td>
                    <td><?=($row['bill_status']=='0') ? 'Not Paid': 'Paid'; ?></td>
                    <td><?php echo ($bill_balance > 0 )? '<a href=index.php?num=140&bill_id='.$trans_id.'class="btn btn-mini">
                    <i class="icon-money"></i> Pay</a>':'';?> </td>
                </tr>
                <?
            }}}
            ?>
            </tbody>
        </table>
        <div class="clearfix"></div>
    </div>
</div>