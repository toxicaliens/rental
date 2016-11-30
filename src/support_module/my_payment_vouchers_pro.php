<?php
include_once('src/models/SupportTickets.php');
include_once('src/models/ReceivedQuotes.php');
$Support = new SupportTickets;
$quote = new ReceivedQuotes();
if(App::isAjaxRequest()){
    if(isset($_POST['action']) && !empty($_POST['action'])){
        switch ($_POST['action']){
            case 'get-voucher-details':
                $voucher_id = $_POST['voucher_id'];
                $result = $quote->selectQuery('payment_vouchers_view','*',"payment_voucher_id = '".$voucher_id."'");
                echo json_encode($result[0]);
        }
    }
}else{
    set_layout("dt-layout.php", array(
        'pageSubTitle' => 'All Payment Vouchers',
        'pageSubTitleText' => '',
        'pageBreadcrumbs' => array (
            array ( 'url'=>'index.php', 'text'=>'Home' ),
            array ( 'text'=>'Payment Vouchers' ),
            array ( 'text'=>'All Payment Vouchers' )
        )
    ));

    ?>
    <div class="widget">
        <div class="widget-title"><h4><i class="icon-comments-alt"></i> All Payment Vouchers</h4>
            <div class="actions">
                <a href="#create-payment-voucher" class="btn btn-primary btn-small" data-toggle="modal">Create Voucher</a>
            </div>

        </div>
        <div class="widget-body form">
            <?php
            $Support->splash('payment_vouchers');
            // display all encountered errors
            (isset($_SESSION['support_error'])) ? $Support->displayWarnings('support_error') : '';
            ?>
            <table id="table1" style="width: 100%" class="table table-bordered">
                <thead>
                <tr>
                    <th>ID#</th>
                    <th>Quote Id</th>
                    <th>Maintenance Name </th>
                    <th>Contractor</th>
                    <th>Voucher Amount</th>
                    <th>Voucher Amount Paid</th>
                    <th>Voucher Balance</th>
                    <th>Settle Voucher</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    if($_SESSION['role_name'] != SystemAdmin){
                        $vouchers = $Support->selectQuery('payment_vouchers_view','*'," created_by = '".$_SESSION['mf_id']."'");
                    }else{
                        $vouchers = $Support->selectQuery('payment_vouchers_view','*');
                    }
                    if (count($vouchers)){
                        foreach ($vouchers as $voucher){
                            ?>
                    <tr>
                        <td> <?php echo $voucher['payment_voucher_id'] ?></td>
                        <td> <?php echo $voucher['quote_id'] ?></td>
                        <td> <?php echo $voucher['maintenance_name'] ?></td>
                        <td> <?php echo $voucher['contractor'] ?></td>
                        <td> <?php echo number_format($voucher['bill_amount'],2) ?></td>
                        <td> <?php echo number_format($voucher['bill_amount_paid'],2) ?></td>
                        <td> <?php echo number_format($voucher['bill_balance'],2) ?></td>
                        <td><?php if($voucher['bill_balance'] == 0){
                                echo '<span class="label label-success">Voucher settled</span>';
                            }else{
                                ?><a href="#settle-voucher" voucher-id="<?php echo $voucher['payment_voucher_id'] ?>" data-toggle="modal" class="btn btn-success btn-mini settle_voucher_btn">Settle voucher</a>
                                <?php
                            }?></td>
                    </tr>
                <?php
                        }
                    }
                ?>
                </tbody>
            </table>
            <div class="clearfix"></div>
        </div>
    </div>
<!--modal for creating a payment voucher-->
    <form action="" id="" method="post" enctype="multipart/form-data">
        <div id="create-payment-voucher" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1"><i class="icon-comments"></i> Create payment Voucher</h3>
            </div>
            <div class="modal-body">
                <label for="property_id">Property</label>
                <div class="row-fluid" style="margin-bottom: 10px">
                    <select id="property_id" name="property_id" class="span12 live_search" required>
                        <option value="">--Select Property--</option>
                        <?php
                        if($_SESSION['role_name'] != SystemAdmin){
                            $condition = "pm_mfid = '".$_SESSION['mf_id']."'";
                        }else{
                            $condition = Null;
                        }
                        $datas = $Support->selectQuery('plots','plot_id,plot_name',$condition);
                        if(count($datas)){
                            foreach ($datas as $data){
                                ?>
                                <option value="<?php echo $data['plot_id']?>"><?php echo $data['plot_name']?></option>
                                <?php
                            }
                        }

                        ?>
                    </select>
                </div>

                <label for="unit_id">Unit</label>
                <div class="row-fluid" style="margin-bottom: 10px">
                    <select id="unit_id" name="unit_id" class="span12 live_search">
                        <option value="">--Select unit--</option>

                    </select>
                </div>
                <label for="supplier_item">Select Supplier Item</label>
                <div class="row-fluid" style="margin-bottom: 13px">
                    <select name="supplier_item" class="span12 live_search" required>
                        <option value="">Select item</option>
                        <?php
                        $results = $Support->selectQuery('expense_bill_items','*',"created_by = '".$_SESSION['mf_id']."'");
                        if(count($results)){
                            foreach ($results as $result){
                                ?>
                                <option value="<?php echo $result['expense_id']?>"><?php echo $result['expense_name'] ?></option>
                                <?php
                            }
                        }
                        ?>

                    </select>
                </div>

                <label for="supplier_item">Supplier</label>
                <div class="row-fluid" style="margin-bottom: 13px">
                    <select name="supplier_id" class="span12 live_search" required >
                        <option value="">Select supplier</option>
                        <?php
                        $results = $Support->selectQuery('masterfile','*'," b_role = 'supplier' AND created_by = '".$_SESSION['mf_id']."'");
                        if(count($results)){
                            foreach ($results as $result){
                                ?>
                                <option value="<?php echo $result['mf_id']?>"><?php echo $result['surname'] ?></option>
                                <?php
                            }
                        }
                        ?>

                    </select>
                </div>
                <div class="row-fluid">
                    <label for="bill_amout">Bill amount</label>
                    <input type="number" name="bill_amount" required class="span12">
                </div>
                <label for="upload-image">Upload voucher document</label>
                <div class="row-fluid">
                    <div class="fileupload fileupload-new span12" data-provides="fileupload">
                        <div class="input-append ">
                            <div class="uneditable-input" style="width:430px">
                                <i class="icon-file fileupload-exists"></i>
                                <span class="fileupload-preview"></span>
                            </div>
                            <label class="btn btn-file">
                               <span class="fileupload-new">Select file</span>
                               <input type="file" style="display: none;" name="voucher_document">
                           </label>
<!--                            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>-->
                        </div>
                    </div>
                </div>

            </div>
            <!-- the hidden fields -->
            <input type="hidden" name="action" value="raise-payment-voucher"/>
            <div class="modal-footer">
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Can766'); ?>
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Pay765'); ?>
            </div>
        </div>
    </form>

    <!-- modal for settling a voucher-->
    <form action="" id="settle-voucher-form" method="post">
    <div id="settle-voucher" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel1"><i class="icon-comments"></i> Settle Voucher</h3>
        </div>
        <div class="modal-body">
            <label for="voucher_amount">Payment Mode</label>
            <div class="row-fluid" style="margin-bottom: 13px">
                <select name="payment_method" class="span12 live_search" >
                <?php
                    $results = $quote->selectQuery('payment_mode','*');
                if(count($results)){
                    foreach ($results as $result){
                        ?>
                    <option value="<?php echo $result['payment_mode_id']?>"><?php echo $result['payment_mode_name'] ?></option>
                    <?php
                    }
                }
                ?>

                </select>
            </div>
            <div class="row-fluid">
                <label for="voucher_amount">Voucher initial amount</label>
                <input type="number" id="initial_voucher_amount" name="bill_amount" class="span12" readonly>
            </div>

            <div class="row-fluid">
                <label for="voucher_amount">Voucher balance</label>
                <input type="number" id="voucher_balance" name="voucher_balance" class="span12" readonly>
            </div>

            <div class="row-fluid">
                <label for="voucher_amount">Amount paid</label>
                <input type="number" id="amount-paid" name="amount_paid" class="span12">
            </div>
        </div>
        <!-- the hidden fields -->
        <input type="hidden" name="action" value="pay-voucher"/>
        <input type="hidden" name="payment_voucher_id" id="payment_voucher_id" >
        <div class="modal-footer">
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Can766'); ?>
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Pay765'); ?>
        </div>
    </div>
</form>

    <?php set_js(array('src/js/payment_vouchers.js')); }?>


