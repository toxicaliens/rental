<?php
    set_layout("form-layout.php", array(
      'pageSubTitle' => 'Edit Services & Bills',
      'pageSubTitleText' => '',
      'pageBreadcrumbs' => array (
        array ( 'url'=>'index.php', 'text'=>'Home' ),
        array ( 'text'=>'Revenue Management' ),
        array ( 'url'=>'index.php?num=642','text'=>'Services & Bills' ),
        array ( 'text'=>'Edit Services & Bills' )
      ),
      'pageWidgetTitle' => 'EDIT SERVICE & BILLS '
    ));

    set_css(array(
       'assets/plugins/bootstrap-datepicker/css/datepicker.css'
    ));
    set_js(array(
       'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
       'assets/scripts/form-validator.js',
       'src/js/delete.js',
       'src/js/manage_service_bill.js',
       'src/js/edit_service_bill.js'
    ));
    if(isset($_SESSION['RMC'])){
        echo "<p style='color:#33FF33; font-size:16px;'>".$_SESSION['RMC']."</p>";
        unset($_SESSION['RMC']);
    }

    if(isset($_GET['edit_id'])){
      $revenue_bill_id = $_GET['edit_id'];
      $result = run_query("SELECT * FROM revenue_service_bill where revenue_bill_id='".$revenue_bill_id."'");
      while($row = get_row_data($result)){
        $revenue_bill_id =($row['revenue_bill_id']);
        $bill_name = $row['bill_name'];
        $bill_description =($row['bill_description']);
        $bill_category = $row['bill_category'];
        $bill_type =($row['bill_type']);
        $amount_type = $row['amount_type'];
        $bill_code =($row['bill_code']);
        $bill_due_time = $row['bill_due_time'];
        $amount = $row['amount'];
        $revenue_channel_id = $row['revenue_channel_id'];
        $bill_interval = $row['bill_interval'];
        $service_channel_id = $row['service_channel_id'];
        $product_id = $row['product_id'];
      }
    }
?>
<!-- BEGIN FORM -->
<form action="" method="post" class="form-horizontal">
                                              
    <div class="row-fluid">
    <div class="span6">
      <div class="control-group">
          <label for="bill_name" class="control-label">Bill Name:</label>
          <div class="controls">
            <input class="span12" type="text" value="<?=$bill_name; ?>" name="bill_name"  required>
          </div>
      </div>
    </div>
    <div class="span6">
      <div class="control-group">
          <label for="bill_description" class="control-label">Bill Description:</label>
          <div class="controls">
            <input class="span12" type="text" name="bill_description" value="<?=$bill_description; ?>"  required>
          </div>
      </div>
    </div>
    </div>

    <div class="row-fluid">
    <div class="span6">
      <div class="control-group">
          <label for="bill_category" class="control-label">Bill Category:</label>
          <div class="controls">
            <select class="span12" name="bill_category" id="bill_category" required>
              <option value="">--Select Category--</option>
              <option value="Applied" <?=($bill_category == 'Applied') ? 'selected' : ''; ?>>Applied/Customized Fee</option>
              <option value="Penalty" <?=($bill_category == 'Penalty') ? 'selected' : ''; ?>>Penalty Fee</option>
              <option value="Processing" <?=($bill_category == 'Processing') ? 'selected' : ''; ?>>Processing Fee</option>
            </select>
          </div>
      </div>
    </div>
    <div class="span6">
      <div class="control-group">
          <label for="bill_code" class="control-label">Bill Code:</label>
          <div class="controls">
            <input class="span12" type="text" name="bill_code" value="<?=$bill_code; ?>" required>
          </div>
      </div>
    </div>
    </div>

    <div class="row-fluid">
    <div class="span6">
      <div class="control-group">
          <label for="bill_type" class="control-label">Bill Type:</label>
          <div class="controls">
            <select class="span12" id="bill_type" name="bill_type" required>
              <option value="">--Select Bill Type--</option>
              <option value="Onceoff" <?=($bill_type == 'Onceoff') ? 'selected': ''; ?>>Once off</option>
              <option value="Regular" <?=($bill_type == 'Regular') ? 'selected': ''; ?>>Regular</option>
            </select>
          </div>
      </div>
    </div>

    <div class="span6">
      <div class="control-group">
          <label for="interval" class="control-label">Interval:</label>
          <div class="controls">
            <select class="span12" id="interval" name="interval">
              <option value="">--Select Interval--</option>
              <option value="Daily" <?=($bill_interval == 'Daily') ? 'selected' : ''; ?>>Daily</option>
              <option value="Weekly" <?=($bill_interval == 'Weekly') ? 'selected' : ''; ?>>Weekly</option>
              <option value="Monthly" <?=($bill_interval == 'Monthly') ? 'selected' : ''; ?>>Monthly</option>
              <option value="Quarterly" <?=($bill_interval == 'Quarterly') ? 'selected' : ''; ?>>Quarterly</option>
              <option value="Semi-Annually" <?=($bill_interval == 'Semi-Annually') ? 'selected' : ''; ?>>Semi-Annually</option>
              <option value="Annually" <?=($bill_interval == 'Annually') ? 'selected' : ''; ?>>Annually</option>
            </select>
          </div>
      </div>
    </div>
    </div>

    <div class="row-fluid">
    <div class="span6">
      <div class="control-group">
          <label for="amount_type" class="control-label">Amount Type:</label>
          <div class="controls">
            <select class="span12" name="amount_type" id="amount_type" required>
              <option value="">--Select Amount Type--</option>
              <option value="Fixed" <?=($amount_type == 'Fixed') ? 'selected': ''; ?>>Fixed</option>
              <option value="Custom" <?=($amount_type == 'Custom') ? 'selected': ''; ?>>Custom</option>
            </select>
          </div>
      </div>
    </div>
    <div class="span6">
      <div class="control-group">
          <label for="bill_due_time" class="control-label">Bill Due Time:</label>
          <div class="controls">
            <select class="span12" name="bill_due_time" required>
              <option value="">--Select Bill Due Time--</option>
              <option value="Asap" <?=($bill_due_time == 'Asap') ? 'selected': ''; ?>>ASAP</option>
              <option value="7days" <?=($bill_due_time == '7days') ? 'selected': ''; ?>>7 DAYS</option>
              <option value="14days" <?=($bill_due_time == '14days') ? 'selected': ''; ?>>14 DAYS</option>
              <option value="1month" <?=($bill_due_time == '1month') ? 'selected': ''; ?>>1 MONTH</option>
              <option value="3months" <?=($bill_due_time == '3months') ? 'selected': ''; ?>>3 MONTHS</option>
            </select>
          </div>
      </div>
    </div>
    </div>

    <div class="row-fluid">
    <div class="span6">
      <div class="control-group">
          <label for="bill_code" class="control-label">Revenue Channel:</label>
          <div class="controls">
            <select class="span12" name="revenue_channel_id" id="revenue_channel" required>
              <option value="">--Choose Revenue Channel--</option>
              <?php
                $query = "SELECT * FROM revenue_channel";
                $result = run_query($query);
                while($row = get_row_data($result)){
                  $rev_chan_id = $row['revenue_channel_id'];
                  $rev_chan_name = $row['revenue_channel_name'];

              ?>
              <option value="<?=$rev_chan_id; ?>" <?=($rev_chan_id == $revenue_channel_id) ? 'selected': ''; ?>><?=$rev_chan_name; ?></option>";
              <?php } ?>
            </select>
          </div>
      </div>
    </div>

    <div class="span6">
      <div class="control-group">
          <label for="bill_code" class="control-label">Service Option:</label>
          <div class="controls">
            <select class="span12 live_search" name="service_option" id="service_option">
              <option value="">--Attach a service option--</option>
              <?php
                $query = "SELECT * FROM service_channels WHERE service_channel_id = '".$service_channel_id."'";
                // var_dump($query);exit;
                $result = run_query($query);
                while ($rows = get_row_data($result)) {
              ?>
                <option value="<?=$rows['service_channel_id']; ?>" selected><?=$rows['service_option']; ?></option>
              <?php } ?>
            </select>
          </div>
      </div>
    </div>
    </div>

    <div class="row-fluid">
        <div class="span6">
            <div class="control-group">
                <label for="amount" class="control-label">Amount:</label>
                <div class="controls">
                    <input class="span12" type="number" value="<?=$amount; ?>" id="amount" name="amount"  required>
                </div>
            </div>
        </div>
    </div>
  
    <!-- hidden fields -->
    <input type="hidden" name="revenue_bill_id" value="<?=$_GET['edit_id']; ?>">

    <input class="span12" type="hidden" name="action" id="action" value="editservicebill" class="packinput">
    <div class="form-actions">
        <?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
    </div>
</form>         