<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 13/08/16
 * Time: 19:56
 */
    require_once 'src/models/LeaseAgreement.php';
    $lease = new LeaseAgreement();
    if(App::isAjaxRequest()) {
        if(isset($_POST['edit_id'])) {
            $lease->getLeaseByLeaseId($_POST['edit_id']);
        }
        if (isset($_POST['action'])&& !empty($_POST['action'])){
            $action = $_POST['action'];
            switch ($action){
                case 'terminate_lease':
                    logAction($action,$_SESSION['sess_id'], $_SESSION['mf_id']);
                    $lease_id = $_POST['terminate_id'];
                    $json = $lease->terminateLease($lease_id);
                    echo json_encode($json);
                    break;
                case 'get_houses':
                    logAction($action,$_SESSION['sess_id'], $_SESSION['mf_id']);
                    if (!empty($_POST['plot_id'])){
                        $plot_id = $_POST['plot_id'];
                        $houses = $lease->getAllEmptyHouses($plot_id);
                        echo json_encode($houses);
                    }
                    break;
            }
        }
    }else{
    set_title('All Leases');
    set_layout("dt-layout.php", array(
        'pageSubTitle' => 'Leases',
        'pageSubTitleText' => '',
        'pageBreadcrumbs' => array (
            array ( 'url'=>'#', 'text'=>'Home' ),
            array ( 'text'=>'All leases' )
        ),
        'pageWidgetTitle'=>'<i class="icon-reorder"></i>View leases'
    ));

    set_css(array(
        'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css'
    ));

    set_js(array(
        'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js',
    ));

?>

<div class="widget" xmlns="http://www.w3.org/1999/html">
    <div class="widget-title"><h4><i class="icon-reorder"></i> All Leases</h4>
        <span class="actions">
            <a href="#add_lease" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-plus"></i> Add Lease</a>
            <input type="hidden" id="terminate_id">
    </span>

    </div>
    <div class="widget-body form">
        <?php
        $lease->splash('lease');
        (isset($_SESSION['warnings'])) ? $lease->displayWarnings('warnings'): '';
        ?>
        <table id="table1" class="table table-bordered">
            <thead>
            <tr>
                <th>ID#</th>
                <th>House Number</th>
                <th>Tenant</th>
                <th>Landlord</th>
                <th>Property Manager</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Lease Details</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>

            <?php $results = $lease->getAllLeasesByRole();
            if(count($results)){
                foreach ($results as $result ){
                    ?>
                    <tr>
                        <td><?php echo $result['lease_id'] ?></td>
                        <td><?php echo $result['house_number']?></td>
                        <td><?php echo (!empty($result['tenant']))? $lease->getNameByMfId($result['tenant']):"" ?></td>
                        <td><?php echo $lease->getNameByMfId($result['landlord_mf_id'])?></td>
                        <td><?php echo $lease->getNameByMfId($result['pm_mfid'])?></td>
                        <td><?php echo $result['start_date']?> </td>
                        <td><?php echo $result['end_date']?></td>
                        <td><?php echo ($result['status'] == 't' )? 'Active':'Inactive' ?></td>
                        <td><a href="index.php?num=6012&lease_id=<?php echo $result['lease_id']; ?>&unit=<?php echo $result['house_number']?> "
                               class="btn btn-mini"><i class="icon-eye-open"></i> View Lease</a></td>
                        <td><?php echo ($result['status'] == 't' )? '<button data-toggle="modal" terminate-id="'.$result['lease_id'].'" data-target="#terminate_lease1" class="btn btn-mini btn-danger terminate_lease"><i class="icon-remove icon-white"></i> Terminate</button>':'' ?></td>
                    </tr>
                <?php }} ?>
            </tbody>
        </table>
        <div class="clearfix"></div>
    </div>
</div>

<!-- add lease modal  -->
<form action="" method="post" enctype="multipart/form-data">
    <div id="add_lease" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel1">Add Lease Agreement </h3>
        </div>
        <div class="modal-body">
            <div class="row-fluid" style="margin-bottom: 10px;">
                <div class="controls">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <span class="btn btn-file">
                            <span class="fileupload-new">Attach file</span>
                            <span class="fileupload-exists">Change</span>
                            <input type="file" class="default" name="lease_doc"/>
                        </span>
                        <span class="fileupload-preview"></span>
                        <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none"></a>
                    </div>
                </div>
            </div>
            <label for="plot_id">Property Name:</label>
            <div class="row-fluid" style="margin-bottom: 20px;">
                <select name="plot_id" class="span12 live_search" id="select_plot" required/>
                <option value="">--Choose property--</option>
                <?php
                $plots = $lease->getAllProperties();
                if(count($plots)){
                    foreach ($plots as $plot) {
                        ?>
                        <option value="<?php echo $plot['plot_id']; ?>"><?php echo $plot['plot_name']; ?></option>
                    <?php }} ?>
                </select>
            </div>
            <label for="houses">Unit:</label>
            <div class="row-fluid" style="margin-bottom: 20px;">
                <select name="house_id" class="span12 live_search" id="select_house" required></select>
            </div>

            <label for="tenant" class="control-label">Tenant:*</label>
            <div class="row-fluid" style="margin-bottom: 20px;">
                <select name="tenant" class="span12 live_search" required>
                    <option value="">--select a tenant--</option>
                    <?php
                    $tenants = $lease->selectQuery('tenants_records','*',"created_by = '".$_SESSION['mf_id']."'");
                    if(count($tenants)){
                        foreach($tenants as $tenant){
                            ?>
                            <option value="<?php echo $tenant['mf_id']?>"><?php echo $tenant['full_name'] ?></option>
                        <?php }} ?>
                </select>
            </div>
            <label for="lease_type">Lease Type:</label>
            <div class="row-fluid" style="margin-bottom: 20px;">
                <select name="lease_type" class="span12 live_search" required>
                    <option>-- Choose Lease Type --</option>
                    <option value="fixed">Fixed</option>
                    <option value="autoRenewal">Auto Renewal</option>
                </select>
            </div>
            <div class="row-fluid" style="margin-bottom: 10px;">
                <label for="start_date" class="control-label">Start Date:<span class="required">*</span> </label>
                <div class="controls">
                    <input type="date" name="start_date" value="<?php echo $lease->get('start_date'); ?>"  class="span12" required/>
                </div>
            </div>

            <div class="row-fluid" style="margin-bottom: 10px;">
                <label for="end_date" class="control-label">End Date:<span class="required">*</span> </label>
                <div class="controls">
                    <input type="date" name="end_date" value="<?php echo $lease->get('end_date'); ?>" class="span12" required/>
                </div>
            </div>
        </div>
        <!-- the hidden fields -->
        <input type="hidden" name="action" value="add_lease_agreement"/>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            <button class="btn btn-primary">Add</button>
        </div>
    </div>
</form>

<!-- terminate lease modal -->
<form action="" method="post">
    <div id="terminate_lease1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel1">Terminate Lease Agreement </h3>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to terminate the lease agreement?</p>
        </div>
        <!-- the hidden fields -->
        <input type="hidden" name="action" value="terminate_lease"/>
        <input type="hidden"  name="edit_id" id="trminate_id"/>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">No</button>
            <button class="btn btn-primary">Yes</button>
        </div>
    </div>
</form>
<?php set_js(array('src/js/lease.js')); } ?>
