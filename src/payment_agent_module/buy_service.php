<?
set_layout("dt-layout.php", array(
	'pageSubTitle' => 'COUNTY CASHIER: Buy Service',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'PAYMENT & BILLS' ),
		array ( 'text'=>'Buy Service' ),
    'pageWidgetTitle'=>'Add Service Bill - Step 2 of 2'
	)
));

if(isset($_POST['revenue_channel'])){
  $revenue_channel = $_POST['revenue_channel'];

  if(!empty($revenue_channel)){
    App::redirectTo('?num=166&rev_id='.$revenue_channel);
  }else{
    echo 'You must choose a revenue channel first!';
  }
}
?>

<div>
    <div style="clear:both;"> </div>
</div>
<br/>

<div class="widget">
  <div class="widget-title">
    <h4><i class="icon-reorder"></i> Select Revenue Channel - Step 1 of 2</h4>
  </div>
  <div class="widget-body form">
     <form name="cdetails" method="post" action="" class="form-horizontal">
      <div class="row-fluid">
        <div class="span6">
          <div class="control-group">
            <label for="revenue_channel" class="control-label">Revenue Channel<span class="required">*</span></label>
            <div class="controls">
              <select name="revenue_channel" id="select2_sample80" class="span12 select2" required>
                 <option value="">--Select Revenue Channel--</option>
                 <?php
                    $categories=run_query("select * from revenue_channel");
                     while ($fetch=get_row_data($categories))
                     {
                     echo "<option value='".$fetch['revenue_channel_id']."'>".$fetch['revenue_channel_name']."</option>";
                     }
                 ?>
             </select>
            </div>
          </div>
        </div>  
      </div>
      <div class="form-actions">
        <input type="hidden" name="details"/>
        <?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
      </div>
</form>
</fieldset>
  </div>
</div>
