<?php
  include_once('src/models/Airtime.php');
  $airtime = new Airtime();

	set_title('Airtime Uploads');
	set_layout("dt-layout.php", array(
		'pageSubTitle' => 'Airtime Uploads',
		'pageSubTitleText' => '',
		'pageBreadcrumbs' => array (
			array ( 'url'=>'index.php', 'text'=>'Home' ),
			array ( 'text'=>'Airtime' ),
			array ( 'text'=>'Airtime Uploads' )
		)
	));

	set_css(array(
	  'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css'
	));
?>

<div class="widget">
  <div class="widget-title">
    <h4><i class="icon-file"></i> Airtime Uploads</h4>
    <div class="actions">
      <a target="_blank" download="download" href="http://oriems.com/gtel-mobile/assets/txt/airtime_upload_sample.txt" class="btn btn-small btn-info">Download Template <i class="icon-download"></i></a>
    </div>
  </div>
  <div class="widget-body form">
    <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
      <div class="row-fluid">  
        <div class="control-group">
          <label class="control-label">Upload a Text file: </label>
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
                <input type="file" class="default" name="txt" accept=".txt" />
                </span>
                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row-fluid">
        <div class="span6">
          <div class="control-group">
            <label for="denom" class="control-label">Denomination:</label>
            <div class="controls">
              <select name="denom" id="denom" class="span12 live_search" required>
                <option value="">--Select Denomination--</option>
                <?php
                  $result = $airtime->getAllDenoms();
                  while ($rows = get_row_data($result)) {
                ?>
                <option value="<?=$rows['id']; ?>"><?=$rows['value']; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
      </div>

      <!-- hidden fields -->
      <input type="hidden" name="action" value="upload_txt"/>

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
    <?php
      if (isset($_SESSION['upload_txt'])) {
        echo $_SESSION['upload_txt'];
        unset($_SESSION['upload_txt']);
      }
    ?>  
    <table id="table1" class="table table-bordered">
 <thead>
  <tr>
   <th>Upload#</th>
   <th>Upload Date</th>
   <th>Voucher Count</th>
   <th>Report</th>
   <th>Uploader</th>
  </tr>
 </thead>
 <tbody>

 <?
  $result = $airtime->getUploadHistory();
  while($row = get_row_data($result))
  {    
  ?>
  <tr>
   <td><?=$row['airtime_upload_id']; ?></td>
   <td><?=$row['upload_date']; ?></td>
   <td><?=$row['voucher_count']; ?></td>
   <td><?=$row['error_report']; ?></td>
   <td><?=$row['user_name']; ?></td>                              
  </tr>
  <? } ?>
  </tbody>
</table>
    <div class="clearfix"></div>
  </div>
</div>
