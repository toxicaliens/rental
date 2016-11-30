<?php
    require_once 'src/models/ReceivedQuotes.php';
    $quote = new ReceivedQuotes();

    if(App::isAjaxRequest()){
        if(isset($_POST['quote_id']) && !empty($_POST['quote_id'])){
            logAction('award_voucher', $_SESSION['sess_id'], $_SESSION['mf_id']);
            $quote->awardQuote($_POST['quote_id']);
        }else if(isset($_POST['cancel_quote_id'])){
            logAction('cancel_awarded_quote', $_SESSION['sess_id'], $_SESSION['mf_id']);
            $quote->cancelAward($_POST['cancel_quote_id']);
        }else if(isset($_POST['create-payment-voucher']) && !empty($_POST['create-payment-voucher'])){
            logAction('create-payment-voucher', $_SESSION['sess_id'], $_SESSION['mf_id']);
            $quote->cratePaymentVoucher($_POST['create-payment-voucher']);
        }else{
            if (isset($_GET['filter'])) {
                if(!empty($_GET['filter'])) {
                    $condition = "maintenance_id = '" . $_GET['filter'] . "'";
                    $quote->getAllQuotesInJson($condition);
                }else{
                    $condition = "created_by = '".$_SESSION['mf_id']."' ";
                    $quote->getAllQuotesInJson($condition);
                }
            } else {
                $condition = "created_by = '".$_SESSION['mf_id']."' ";
                $quote->getAllQuotesInJson($condition);
            }
        }
    }else{
        set_title('Received Quotes');
        set_layout("dt-layout.php", array(
            'pageSubTitle' => 'Received Quotes',
            'pageSubTitleText' => '',
            'pageBreadcrumbs' => array (
                array ( 'url'=>'index.php', 'text'=>'Home' ),
                array ( 'text'=>'Maintenance' ),
                array ( 'text'=>'Received Quotes' )
            )
        ));
?>
<div class="widget">
    <div class="widget-title"><h4><i class="icon-filter"></i> Search Parameters</h4>
        <span class="tools">
            <a href="javascript::void()"><i class="icon-chevron-up"></i> </a>
        </span>
    </div>
    <div class="widget-body form" style="display: none;">
        <form id="search_quotes" action="" method="post" class="form-horizontal">
            <div class="row-fluid">
                <div class="span6">
                    <label class="control-label">Maintenance Voucher</label>
                    <div class="controls">
                        <select class="span12 live_search" name="voucher" id="voucher_id">
                            <option value="">All</option>
                            <?php
                                $rows = $quote->getApprovedVouchers();
                                if(count($rows)){
                                    foreach($rows as $row){
                            ?>
                            <option value="<?php echo $row['voucher_id']; ?>"><?php echo $row['maintenance_name']; ?></option>
                            <?php }} ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
            </div>
        </form>
    </div>
</div>
<div class="widget">
    <div class="widget-title"><h4><i class="icon-reorder"></i> All Received Quotes</h4>
        <span class="actions">
            <button class="btn btn-small btn-success" id="refresh"><i class="icon-refresh"></i> Refresh!</button>
        </span>
    </div>
    <div class="widget-body form">
        <?php
        $quote->splash('support');
        // display all encountered errors
        (isset($_SESSION['support_error'])) ? $quote->displayWarnings('support_error') : '';
        ?>
        <table id="received_quotes" class="table table-bordered">
            <thead>
                <tr>
                    <th>Quote#</th>
                    <th>Voucher</th>
                    <th>Contractor</th>
                    <th>Bid Amount</th>
                    <th>Bid Date</th>
                    <th>Bid Status</th>
                    <th>Job Status</th>
                    <th>Action</th>
                    <th>Payment Voucher</th>
                </tr>
            </thead>
        </table>
        <div class="clearfix"></div>
    </div>
</div>

        <form action=""  method="post">
            <div id="create-payment-voucher" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel1">Create Payment Voucher</h3>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to create a payment voucher for this quotation?</p>
                </div>
                <!-- hidden fields -->
                <input type="hidden" name="action" value="create-payment-voucher"/>
                <input type="hidden" id="quote_id" name="quote_id"/>
                <div class="modal-footer">
                    <?php createSectionButton($_SESSION['role_id'],$_GET['num'],'No764'); ?>
                    <?php createSectionButton($_SESSION['role_id'],$_GET['num'],'Yes763'); ?>
                </div>
            </div>
        </form>
<?php set_js(array('src/js/rec_quotes.js'));} ?>

