<?php
include_once('src/models/Import.php');
$import = new Import();

set_title('Import Client Groups');
set_layout("dt-layout.php", array(
	'pageSubTitle' => 'Import Masterfile',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Payments & Bills' ),
		array ( 'text'=>'Import Masterfile' )
	)
));

set_css(array(
  'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css'
  // 'assets/plugins/bootstrap-datepicker/css/datepicker.css'
));

// set_js(array(
 // 'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js'
 // 'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js'
// )); 
?>

<div class="widget">
  <div class="widget-title">
    <h4><i class="icon-file"></i> Add Masterfile from CSV</h4>
    <div class="actions">
      <a href="assets/csv/client_groups.csv" class="btn btn-small btn-info">Download Template <i class="icon-download"></i></a>
    </div>
  </div>
  <div class="widget-body form">
      <?php
        if (isset($_SESSION['success'])) {
          $succ_messages = $_SESSION['succ_messages'];
          // var_dump($success);exit;
          if(count($succ_messages)){
      ?>
      <div class="alert alert-success">
        <button class="close" data-dismiss="alert">&times;</button>
        <?php
          foreach ($succ_messages as $succ_message) {
            echo "<strong>Success!</strong> $succ_message <br/>"; 
          }
        ?>
      </div>
      <?php }} unset($_SESSION['success']);  ?>

      <?php
        if(isset($_POST['action'])){
          $errors = $_SESSION['errors'];
          // var_dump($errors);exit;
          if(count($errors)){
      ?>  
      <div class="alert alert-error">
        <button class="close" data-dismiss="alert">&times;</button>
        <?php 
          foreach ($errors as $error) {
            echo "<strong>Error!</strong> $error <br/>"; 
          }
        ?>
      </div>
      <?php }} unset($_SESSION['errors']);  ?>
    <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
      <div class="row-fluid">  
        <div class="control-group">
          <label class="control-label">Upload a CSV file: </label>
          <div class="controls">
            <div class="fileupload fileupload-new" data-provides="fileupload">
              <div class="input-append">
                <div class="uneditable-input">
                   <i class="icon-file fileupload-exists"></i> 
                   <span class="fileupload-preview"></span>
                </div>
                <span class="btn btn-file">
                <span class="fileupload-new">Select file</span>
                <span class="fileupload-exists">Change</span>
                <input type="file" class="default" name="client_groups_csv" accept=".csv" required/>
                </span>
                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- hidden fields -->
      <input type="hidden" name="action" value="import_client_groups"/>

      <div class="form-actions">
        <?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
      </div>
    </form>
  </div>
</div>

<div class="widget">
  <div class="widget-title">
    <h4><i class="icon-reorder"></i> Upload History</h4>
    <span class="actions">
      <!-- <a href="#add_types" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-search"></i> Search</a> -->
    </span>
  </div>
  <div class="widget-body">  
    <table id="table1" class="table table-bordered">
      <thead>
      <tr>
        <th>Upload#</th>
        <th>Upload Date</th>
        <th>Total Count</th>
        <th>Report</th>
        <th>Uploader</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $distinctQuery = "SELECT muh.*, CONCAT(m.surname,' ',m.firstname,' ',m.middlename) AS full_name FROM company_upload_history muh 
          LEFT JOIN masterfile m ON m.mf_id = muh.uploader_mf_id";
          $resultId = run_query($distinctQuery);
          while($row = get_row_data($resultId)){
        ?>
        <tr>
         <td><?=$row['upload_id']; ?></td>
         <td><?=$row['upload_date']; ?></td>
         <td><?=$row['record_count']; ?></td>
         <td><?=$row['error_report']; ?></td>
         <td><?=$row['full_name']; ?></td>                                
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <div class="clearfix"></div>
  </div>
</div>
