<?php
  include_once("src/models/pgBackupRestore.php");

  function timer()
   {
      $time = microtime();
      $time = explode(" ", $time);
      $time = $time[1] + $time[0];
      return($time);
   }

  //date of backup
  $stamp = array('Y'=>date('Y'), 'm'=>date('m'), 'd'=>date('d'), 'H'=>date('H'), 'i'=>date('i'), 's'=>date('s'));
  $stamp = $stamp['Y'].'_'.$stamp['m'].'_'.$stamp['d'].'_'.$stamp['H'].'_'.$stamp['i'].'_'.$stamp['s'];

  // SOURCE DATABASE (Backup)
  // (isset($_POST['database'])) ? $source_db=$_POST['database']:$source_db="gpay";
  $source_db = 'gpay';

  $file_name = 'Backup_'.$stamp.'_'.$source_db.'.sql';

  // SQL FILE TO BE CREATED
  $sql_file='assets/db_backups/'.$file_name;

  $pgBackup = new pgBackupRestore();

  
  // DESTINATION DATABASE (Restore)
  $dest_db='gpay';

  $Restore = '';
  switch( strtolower($_POST['action']) )
     {
        case backup:
           $Backup = true;
           $Restore = false;
        break;
      
        case restore:
           $Backup = false;
           $Restore = true;
        break;

        default:
           $Backup = false;
           $Restore = false;
        break;
     }

     // printf ("--[ Current Memory Limit: %s\n\n", ini_get('memory_limit'));
   
     if ($Backup){
        // printf ("[+] Backup of database '$source_db' in progress\n");
        $s = timer();
        
        $pgBackup->UseDropTable = false;
        if($result = $pgBackup->Backup($sql_file)){
          $e = timer();
          if($pgBackup->recordBackup($sql_file, $file_name)){
            $_SESSION['backup_restore'] = '<div class="alert alert-success">
              <button class="close" data-dismiss="alert">×</button>
              <strong>Success!</strong> Backup was successful!
            </div>';
          }
        }else{
          $_SESSION['backup_restore'] = '<div class="alert alert-warning">
            <button class="close" data-dismiss="alert">×</button>
            <strong>Warning!</strong> Encountered an error!
          </div>';
        }
      }

     if ($Restore)
     {
        // var_dump($_FILES['restoration_file']['name']);exit;
        if($_FILES['restoration_file']['name'] != ''){
          $file_name = $pgBackup->getRestoreFile();
          $sql_file = 'assets/db_backups/'.$file_name;
        }

        // var_dump($sql_file);exit;
        // printf ("[+] Restore to database '$dest_db' in progress\n");
        $s = timer();
        $pgRestore = new pgBackupRestore('localhost', 'obulex', 'root', 'gpay');
        // var_dump($sql_file);exit;
        if($pgRestore->Restore($sql_file)){
          $_SESSION['backup_restore'] = '<div class="alert alert-success">
              <button class="close" data-dismiss="alert">×</button>
              <strong>Success!</strong> Restore was successful!
            </div>';
        }
     }