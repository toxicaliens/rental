<?php
 include_once('src/models/pgBackupRestore.php');
 $back = new pgBackupRestore;

  if(isset($_SESSION['backup_restore'])){
    echo $_SESSION['backup_restore'];
    unset($_SESSION['backup_restore']);
  }
?>
<form action="" method="POST" id="maintenance" enctype="multipart/form-data">
  <h3 class="form-section">Backup/Restore</h3>
  <input type="hidden" name="action" value="backup" />
  <?php
    // For Backup
    createSectionButton($_SESSION['role_id'], $_GET['num'], 'Bac633');
    echo '&nbsp;';
  ?>
  <a href="#myModal1" data-toggle="modal" class="btn btn-primary"><i class="icon-refresh"></i> Restore</a>
</form>
<table id="table1" class="table table-bordered">
  <thead>
    <tr>
      <th>Backup#</th>
      <th>File Name</th>
      <th>Backed Up By</th>
      <th>Created On</th>
      <th>Download</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $query = "SELECT * FROM backup_log";
      $result = run_query($query);
      while($rows = get_row_data($result)){
        $bc = $rows['backup_user'];
        $user = $back->getBackupUser($bc);
    ?>
    <tr>
      <td><?=$rows['backup_id']; ?></td>
      <td><?=$rows['filename']; ?></td>
      <td><?=$user; ?></td>
      <td><?=date('Y-m-d H:i:s', $rows['stamp']); ?></td>
      <td><a href="<?=$rows['file_path']; ?>" class="btn btn-mini" download/><i class="icon-download"></i> Download File</a></td>
    </tr>
    <?php } ?>
  </tbody>
</table>

<form action="" method="POST" enctype="multipart/form-data">
  <div id="myModal1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h3 id="myModalLabel1">Restore Database</h3>
    </div>
    <div class="modal-body">
      <div class="row-fluid">
        <label class="control-label">Select Restoration File</label>
        <div class="fileupload fileupload-new" data-provides="fileupload">
           <div class="input-append">
              <div class="uneditable-input">
                 <i class="icon-file fileupload-exists"></i> 
                 <span class="fileupload-preview"></span>
              </div>
              <span class="btn btn-file">
              <span class="fileupload-new">Select file</span>
              <span class="fileupload-exists">Change</span>
              <input type="file" class="default" name="restoration_file" accept=".sql" />
              </span>
              <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
           </div>
        </div>
      </div>
    </div>
    <input type="hidden" name="action" value="restore">
    <div class="modal-footer">
      <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo635'); ?>
      <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Res634'); ?>
    </div>
  </div>
</form>
<?php set_js(array("src/js/manage_db.js")); ?>