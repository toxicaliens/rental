<div>
    <div style="float:left; width:450px; margin:left">
       <?php
          if ($service_option_type=='Leaf') {
          ?>
          <a href="#myModal1" role="button" class="btn btn-success btn-small" data-toggle="modal">
          <i class="icon-cogs"></i> Attach Inputs</a>
          <a href="#myModal2" role="button" class="btn btn-warning btn-small" id="edit_btn">
          <i class="icon-edit"></i> Edit Input</a>
          <a href="#myModal3" role="button" class="btn btn-danger btn-small" id="del_btn">
          <i class="icon-trash"></i> Detach Input</a>
         <?php
          }
          ?>
    </div>
</div>
<table id="table1" class="table table-bordered">
                   <thead>
                    <tr>
                      <th>Input Id</th>
                     <th>Service Id</th>
                     <th>Data source</th>
                     <th>Input Category</th>
                     <th>Input Type</th>
                     <th>Input Label</th>
                     <th>Default Value</th>
                    </tr>
                   </thead>
                                                 
                   <tbody>

 <?
   $distinctQuery = "SELECT * FROM service_channel_inputs where service_id = '".$service_channel_id."' Order by input_id DESC";
   $resultId = run_query($distinctQuery);
   //var_dump($total_rows);exit;

  $con = 1;
  $total = 0;
  while($row = get_row_data($resultId))
  {
    $input_id =$row['input_id'];
    $service_id = $row['service_id'];
    $data_source = $row['data_source'];
    $input_category = $row['input_category'];
    $input_type =$row['input_type'];
    $input_label = $row['input_label'];
    $default_value = $row['default_value'];
    
    
     ?>
      <tr>
        <td><?=$input_id; ?></td>
       <td><?=$service_id; ?></td>
       <td><?=$data_source; ?></td>
       <td><?=$input_category; ?></td>
       <td><?=$input_type; ?></td>
       <td><?=$input_label; ?></td>
       <td><?=$default_value; ?></td>
      </tr>
     <?
  }
  ?>
  </tbody>
</table>
<div class="clearfix"></div>
<form action="" method="POST">  
  <div id="myModal1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 name="myModalLabel1">Attach Service Channel Inputs</h3>
      </div>
      <div class="modal-body">
           <div class="row-fluid">
                <label for="service_id">Service Id</label>
                <input type="text" name="service_id" value="<?=$service_channel_id; ?>" class="span12" readonly>     
           </div>
            <div class="row-fluid">
                  <label for="input_category">Input Category</label>
                  <select name="input_category" class="span12" required>
                    <option value="">--Choose Input Category--</option>
                    <option value="service_account">Service Account</option>
                    <option value="quantity">Quantity</option>
                    <option value="unit_price">Unit Price</option>
                    <option value="total_amount">Total Amount</option>
                    <option value="other_data">Other Data1</option>
                    <option value="other_data2">Other Data2</option>
                    <option value="other_data3">Other Data3</option>
                  </select>
            </div>
            <div class="row-fluid">
                  <label for="input_type">Input type</label>
                  <select name="input_type" class="span12" required>
                     <option value="">--Choose Input type--</option>
                    <option value="selectlist">Selectlist</option>
                    <option value="textfield">Textfield</option>
                  </select>
            </div>
            <div class="row-fluid">
                  <label for="data_source">Data Source</label>
                  <select name="data_source" class="span12" required>
                     <option value="">--Data Source--</option>
                    <option value="user">User</option>
                    <option value="auto">Auto</option>
                    <option value="api">API</option>
                    <option value="streets">Streets</option>
                    <option value="markets">Markets</option>
                    <option value="regions">Regions</option>
                  </select>
            </div>
             <div class="row-fluid">
                  <label for="input_label">Input label</label>
                  <input type="text" name="input_label" class="span12">
            </div>
             <div class="row-fluid">
                  <label for="default_value">Default Value</label>
                  <input type="text" name="default_value" class="span12">
            </div>
      </div>
      <!-- hidden fields -->
      <input type="hidden" name="action" value="add_channel_inputs"/>
      <div class="modal-footer">
        <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo418'); ?>
        <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav422'); ?>
      </div>
    </div>  
</form>

<form action="" method="post">
    <div id="myModal2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 name="myModalLabel">Edit Service Channel Inputs</h3>
      </div>
      <div class="modal-body">
           <div class="row-fluid">
                <label for="service_id">Service Id</label>
                <input type="text" name="service_id" id="service_id" value="<?=$service_channel_id; ?>" class="span12" readonly>     
           </div>
            <div class="row-fluid">
                  <label for="input_category">Input Category</label>
                  <select name="input_category" id="input_category" class="span12" required>
                    <option value="">--Choose Input Category--</option>
                    <option value="service_account">Service Account</option>
                    <option value="quantity">Quantity</option>
                    <option value="unit_price">Unit Price</option>
                    <option value="total_amount">Total Amount</option>
                    <option value="other_data">Other Data1</option>
                    <option value="other_data2">Other Data2</option>
                    <option value="other_data3">Other Data3</option>
                  </select>
            </div>
            <div class="row-fluid">
                  <label for="input_type">Input type</label>
                  <select name="input_type" id="input_type" class="span12" required>
                     <option value="">--Choose Input type--</option>
                    <option value="selectlist">Selectlist</option>
                    <option value="textfield">Textfield</option>
                  </select>
            </div>
            <div class="row-fluid">
                  <label for="data_source">Data Source</label>
                  <select name="data_source" id="data_source" class="span12" required>
                     <option value="">--Data Source--</option>
                    <option value="user">User</option>
                    <option value="auto">Auto</option>
                    <option value="api">API</option>
                    <option value="streets">Streets</option>
                    <option value="markets">Markets</option>
                    <option value="regions">Regions</option>
                  </select>
            </div>
             <div class="row-fluid">
                  <label for="input_label">Input label</label>
                  <input type="text" name="input_label" id="input_label" class="span12">
            </div>
             <div class="row-fluid">
                  <label for="default_value">Default Value</label>
                  <input type="text" name="default_value" id="default_value" class="span12">
            </div>
      </div>
      <!-- hidden fields -->
      <input type="hidden" name="action" value="edit_channel_input"/>
      <input type="hidden" name="edit_id" id="edit_id"/>
      <div class="modal-footer">
        <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Can424'); ?>
         <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav425'); ?>
      </div>
    </div>
</form>
<form action="" method="post">
    <div id="myModal3" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 name="myModalLabel3">Delete Inputs</h3>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete the selected input?</p>
      </div>
      <!-- hidden fields -->
      <input type="hidden" name="delete_id" id="delete_id"/>
      <input type="hidden" name="action" value="delete_channel_input"/>
      <div class="modal-footer">
        <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo418'); ?>
        <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Con423'); ?>
      </div>
    </div> 
</form>