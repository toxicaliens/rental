<?php
(isset($_SESSION['warnings'])) ? $profile->displayWarnings('warnings') : '';
if(isset($_SESSION['client_settings'])){
    echo $_SESSION['client_settings'];
    unset($_SESSION['client_settings']);
}
$profile_data = $profile->selectQuery('client_settings','*',"mf_id = '".$_SESSION['mf_id']."'");
//var_dump($profile_data);
if(count($profile_data)){
    $title = $profile_data[0]['title'];
    $logo_path = $profile_data[0]['logo_path'];
}
?>

<div >
    <div class="row-fluid span6">
    <form action="" method="post" enctype="multipart/form-data">
        <label for="title">Title</label>
        <input required type="text" name="title" id="title" value="<?php echo (!empty($title))? $title:'' ?>" class="span6">

        <div class="space10"></div>
        <br />
            <div class="thumbnail" style="width: 291px; height: 170px;">
                <?php echo (!empty($logo_path))? '<img src="'.$logo_path.'" alt="" style="width: 290px; height: 169px;/>' : '<img src="assets/img/no-image.png" alt="" />' ?>
            </div>
        <div class="space10"></div>
        <div class="row-fluid" style="margin-top: 12px;">
                <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="input-append">
                        <div class="uneditable-input">
                            <i class="icon-file fileupload-exists"></i>
                            <span class="fileupload-preview"></span>
                        </div>
                        <span class="btn btn-file">
                       <span class="fileupload-new">Select file</span>
                       <span class="fileupload-exists">Change</span>
                       <input type="file" name="logo_path" class="default" />
                       </span>
                        <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                    </div>
                </div>
        </div>
        <div class="space10"></div>
            <div><?php (!empty($logo_path))? '<span> Select to change the image..</span>':'<span> Select to upload a new image..</span>'?></div>
                <span> Select to change the image..</span>
            <div class="space10"></div>
            <div class="actions">
                <input type="hidden" name="action" value="update_client_settings">
                <input type="hidden" name="tab3">
                <button type="submit" class="btn success">Submit</button>
                <a href="#" class="btn">Cancel</a>

            </div>
    </form>
    </div>