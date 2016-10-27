<?
if(isset($_GET['rev_id'])){
  $rev_id = $_GET['rev_id'];

  $query = "SELECT * FROM revenue_channel WHERE revenue_channel_id = $rev_id";
  $result = run_query($query);
  $rows = get_row_data($result);
}
set_layout("form-layout.php", array(
    'pageSubTitle' => 'Buy Service Tree',
    'pageSubTitleText' => '',
    'pageBreadcrumbs' => array (
        array ( 'url'=>'index.php', 'text'=>'Home' ),
        array ( 'url'=>'#', 'text'=>'PAYMENT & BILLS' ),
        array ( 'url'=>'?num=165', 'text'=>'Buy Service' )
    ),
    'pageWidgetTitle'=>' Buy Service Tree - Step 2 of 2'
));

?>
  <div class="widget-body">
    <div class='alert alert-success hide' id="message">
      <button class='close' data-dismiss='alert'>×</button>
      The payment was successfully recorded!
    </div>
     <form name="cdetails" method="post" action="" class="form-horizontal">
      <div class="row-fluid">
        <div class="span12">
           <div class="widget">
              <div class="widget-title">
                 <h4><i class="icon-comments"></i> The <?=$rows['revenue_channel_name']; ?> Service Tree</h4>
                 <div class="tools">
                    <a href="javascript:;" class="collapse"></a>
                    <a href="#widget-config" data-toggle="modal" class="config"></a>
                    <a href="javascript:;" class="reload"></a>
                    <a href="javascript:;" class="remove"></a>
                 </div>
              </div>
              <div class="widget-body">
                 <div class="dd" id="nestable_list_3">
                    <?php showServiceTree(0, $rows['revenue_channel_id']); ?>
                 </div>
              </div>
           </div>
        </div>
     </div>
     <!-- The modal dialog box -->
    <!--  <div id="myModal1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="myModalLabel1">Buy Service <span id="price_label"></span></h3>
        </div>
        <div class="modal-body">
            <div class="row-fluid">
                <label for="service_account">Service Account</label>
                <input type="text" id="service_account" name="service_account" class="span12">     
           </div>
            <div class="row-fluid">
                  <label for="cash_paid">Cash Received</label>
                  <input type="text" id="cash_paid" name="cash_paid" class="span12" placeholder="Enter Amount">
            </div>
        </div>
        <div class="modal-footer">
          <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
          <button class="btn btn-primary" id="save_payment">Save</button>
        </div>
      </div> -->
</form>
</fieldset>
