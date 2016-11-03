<?php
    require_once('src/models/LeaseAgreement.php');
    $lease = new LeaseAgreement();

    set_title('Customer Statement');
    set_layout("dt-layout.php", array(
        'pageSubTitle' => 'Statement',
        'pageSubTitleText' => '',
        'pageBreadcrumbs' => array (
            array ( 'url'=>'#', 'text'=>'Home' ),
            array ( 'text'=>'Rent Management' ),
            array ( 'url'=>'?num=6011', 'text'=>'My Lease' ),
            array (  'text'=>'Lease Details' )
        )
    ));

    set_css(array(
        'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css'
    ));

    set_js(array(
        'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js',
    ));

?>
<table class="table table-bordered">
    <thead>
    <tr>
        <th class="center-align">Date</th>
        <th class="center-align">Service Account</th>
        <th class="center-align">Journal Type</th>
        <th class="center-align">Particulars</th>
        <th class="center-align">Debit</th>
        <th class="center-align">Credit</th>
    </tr>
    </thead>
    <tbody>

    <?php
        $tenant = $_GET['tenant'];
        $unit = $_GET['unit'];
        $rows = $lease->getMyLeaseStatement();
        $rows = $rows['all'];
        //var_dump($rows);exit;
        if(count($rows)){
            foreach ($rows as $row ){
                $journal_date = trim(date('d/m/Y', strtotime($row['journal_date'])));
                $amount = trim($row['amount']);
                $service_account = $row['service_account'];
                $particulars = $row['particulars'];
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
                <td><?php echo $journal_date; ?></td>
                <td><?php echo $service_account; ?></td>
                <td><?php echo $journal_type; ?></td>
                <td><?php echo $particulars; ?></td>
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
        <?php }} ?>
    <tr>
        <td colspan="4" style="text-align:right;font-weight:bold">Totals:</td>
        <td style="text-align:right;font-weight:bold">
            <?php
            $query = "SELECT SUM(amount) as total_debit FROM journal WHERE dr_cr = 'DR' AND unit_number = '".$unit."' ";
            $result = run_query($query);
            $row = get_row_data($result);
            $debit_total = $row['total_debit'];
            echo number_format($debit_total, 2);
            ?>
        </td>
        <td style="text-align:right;font-weight:bold">
            <?php
            $query = "SELECT SUM(amount) as total_credit FROM journal WHERE dr_cr = 'CR' AND unit_number = '".$unit."' ";
            $result = run_query($query);
            $row = get_row_data($result);
            $credit_total = $row['total_credit'];
            echo number_format($credit_total, 2);
            ?>
        </td>
    </tr>
    <tr>
        <td colspan="4" style="text-align:right;font-weight:bold">Current Balance:</td>
        <td colspan="4" style="text-align:right;font-weight:bold">
            <?php
            $credit_balance = $credit_total - $debit_total;
            if($credit_balance < 0){
                $absolute = abs($credit_balance);
                $negative = number_format($absolute, 2);
                echo "<span class='negative'>($negative)</span>";
            }else{
                echo number_format($credit_balance, 2);
            }
            ?>
        </td>
    </tr>
    </tbody>
</table>
