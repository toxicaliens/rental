<form action="" class="form-horizontal" method="post">
    <div class="control-group">
        <label class="control-label">Tenant</label>
        <div class="controls">
            <select name="full_name" id="select2_sample1" class="span6 select2">
                <option value=""></option>
                <?php
                $tenants = $lease->getPmTenants();
                if(count($tenants)){
                    foreach ($tenants as $tenant){
                        ?>
                        <option value="<?php echo $tenant['mf_id']; ?>"
                            <?php echo ($lease->get('full_name') == $tenant['mf_id']) ? 'selected': ''; ?>>
                            <?php echo $tenant['full_name']; ?>
                        </option>
                    <?php }} ?>
            </select>
        </div>
    </div>
</form>
<table class="table table-bordered">
    <thead>
    <tr>
        <th class="center-align">Date</th>
        <th class="center-align">Service Account</th>
        <th class="center-align">Particulars</th>
        <th class="center-align">Debit</th>
        <th class="center-align">Credit</th>
    </tr>
    </thead>
    <tbody>

    <?php
        $tenant_name = '';

        $criteria = "AND mf_id == '".$tenant_name."' ";

        if(isset($_POST['tenant'])){
            $tenant = $_POST['tenant'];
            if(!empty($tenant)){
                $tenant_name = $tenant;

                $criteria = "AND (mf_id == '".$tenant_name."')";
            }
        }

    $distinctQuery = "SELECT j.*, m.*, t.payment_mode FROM journal j
       LEFT JOIN masterfile m ON m.mf_id = j.mf_id
       LEFT JOIN transactions t On t.bill_id = j.bill_id
       WHERE j.mf_id = '".$mf_id."' $criteria ORDER by journal_date ASC
       ";
    $resultId = run_query($distinctQuery);
    $total_rows = get_num_rows($resultId);

    while($row = get_row_data($resultId))
    {
        $j_date = trim(date('d/m/Y', strtotime($row['journal_date'])));
        $customer_name = $row['surname'].' '.$row['firstname'].' '.$row['middlename'];
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
            <td><?php echo $j_date; ?></td>
            <td><?php echo $service_account; ?></td>
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
        <?php } ?>
    <tr>
        <td colspan="3" style="text-align:right;font-weight:bold">Totals:</td>
        <td style="text-align:right;font-weight:bold">
            <?php
            $query = "SELECT SUM(amount) as total_debit FROM journal WHERE dr_cr = 'DR' AND mf_id = '".$mf_id."' $criteria";
            $result = run_query($query);
            $row = get_row_data($result);
            $debit_total = $row['total_debit'];
            echo number_format($debit_total, 2);
            ?>
        </td>
        <td style="text-align:right;font-weight:bold">
            <?php
            $query = "SELECT SUM(amount) as total_credit FROM journal WHERE dr_cr = 'CR' AND mf_id = '".$mf_id."' $criteria";
            $result = run_query($query);
            $row = get_row_data($result);
            $credit_total = $row['total_credit'];
            echo number_format($credit_total, 2);
            ?>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="text-align:right;font-weight:bold">Current Balance:</td>
        <td colspan="3" style="text-align:right;font-weight:bold">
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