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
        }else{
            if (isset($_GET['filter'])) {
                if(!empty($_GET['filter'])) {
                    $condition = "maintainance_id = '" . $_GET['filter'] . "'";
                    $quote->getAllQuotesInJson($condition);
                }else{
                    $quote->getAllQuotesInJson();
                }
            } else {
                $quote->getAllQuotesInJson();
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
                </tr>
            </thead>
        </table>
        <div class="clearfix"></div>
    </div>
</div>
<?php set_js(array('src/js/rec_quotes.js'));} ?>
