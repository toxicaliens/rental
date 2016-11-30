<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 24/10/16
 * Time: 13:39
 */
require_once('src/models/ReceivedQuotes.php');
$property_ledger = new ReceivedQuotes();
if (App::isAjaxRequest()){

}else{
    set_title('Property Ledger');
    set_layout("dt-layout.php", array(
        'pageSubTitle' => 'Statement',
        'pageSubTitleText' => '',
        'pageBreadcrumbs' => array (
            array ( 'url'=>'#', 'text'=>'Home' ),
            array ( 'text'=>'Property manager' ),
            array ( 'text'=>'Property Ledger' )
        ),
        'pageWidgetTitle'=>'<i class="icon-reorder"></i>Property Statement'
    ));

    set_css(array(
        'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css'
    ));

    set_js(array(
        'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js',
    ));

    ?>
    <div class="widget" >
        <div class="widget-title"><h4><i class="icon-reorder"></i> Property Statement</h4>

        </div>
        <div class="widget-body form">
            <form action="" class="form-horizontal" method="post">
                <div class="row-fluid span12">
                    <div class="control-group span6">
                        <label class="control-label span2">Property Name: </label>
                        <div class="controls">

                            <select class="span10 live_search" name="property_id" required>
                                <option value="">Select a property</option>
                                <?php
                                if($_SESSION['role_name'] == SystemAdmin){
                                    $results = $property_ledger->selectQuery('plots','plot_id,plot_name');
                                }else{
                                    $results = $property_ledger->selectQuery('plots','plot_id,plot_name'," pm_mfid = '".$_SESSION['mf_id']."'");
                                }
                                if(count($results)){
                                    foreach ($results as $result){
                                        ?>
                                        <option value="<?php echo $result['plot_id']?>"><?php echo $result['plot_name'] ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>

                        </div>
                    </div>

                    <div class="control-group span4" >
                        Search: <button class="btn btn-primary btn-small"><i class="icon-search"></i> </button>
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
                ;$total_debit = 0;
                $total_credit = 0;
                if(isset($_POST['property_id'])) {
                    $records = $property_ledger->selectQuery('ledger', '*', " property_id = '" . $_POST['property_id'] . "'");
//    }else{
//        $records = $property_ledger->selectQuery('ledger', '*', " created_by = '". $_SESSION['mf_id']."' ");
//    }
                    if(count($records)){
                        foreach ($records as $record){
                            ?>
                            <tr>
                                <td><?php echo $record['ledger_date']; ?></td>
                                <td><?php echo $record['ledger_date']; ?></td>
                                <td><?php echo $record['payment_method']; ?></td>
                                <td><?php echo $record['payment_voucher_id']; ?></td>
                                <th style="text-align:right;">
                                    <?php

                                    if($record['ledger_type'] == 'DR'){
                                        $total_debit =($total_debit) + ($record['amount']);
                                        echo '- '. number_format($record['amount'], 2);
                                    }
                                    ?>
                                </th>
                                <th style="text-align:right;">
                                    <?php
                                    if($record['ledger_type'] == 'Credit'){
                                        $total_credit = $total_credit + $record['amount'];
                                        echo number_format($record['amount'], 2);
                                    }
                                    ?>
                                </th>
                            </tr>
                        <?php }}} ?>


                <tr>
                    <td colspan="4" style="text-align:right;font-weight:bold">Totals:</td>
                    <td style="text-align:right;font-weight:bold">
                        <?php

                        echo '- '. number_format($total_debit, 2);
                        ?>
                    </td>
                    <td style="text-align:right;font-weight:bold">
                        <?php
                        echo number_format($total_credit, 2);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" style="text-align:right;font-weight:bold">Current Balance:</td>
                    <td colspan="4" style="text-align:right;font-weight:bold">
                        <?php
                        $credit_balance = $total_credit - $total_debit;
                        if($credit_balance < 0){
                            $absolute = abs($credit_balance);
//                    $negative = number_format($absolute, 2);
                            $negative = number_format($credit_balance, 2);
                            echo "<span class='negative'>($negative)</span>";
                        }else{
                            echo number_format($credit_balance, 2);
                        }

                        ?>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

<?php }?>
