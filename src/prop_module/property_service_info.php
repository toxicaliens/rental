<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 11/08/2016
 * Time: 17:51
 */
?>
<button data-target="#attach_services_to_plot"  data-toggle="modal" class="btn btn-small btn-success attach_service_to_plot"><i class="icon-paper-clip"></i> Attach a service</button>
<button data-target="#detach_services_to_plot"  class="btn btn-small btn-danger detach_service_to_plot"><i class="icon-paper-clip"></i> Detach a service</button>
<br><br>

<?php
//(isset($_SESSION['warnings']))? :'';
if(isset($_SESSION['p_services'])){
    echo $_SESSION['p_services'];
    unset($_SESSION['p_services']);
}
?>
<table class="live_table table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Service Option</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
    <?php
    if (isset($_GET['prop_id'])) {
        $id = $_GET['prop_id'];
        $services = $prop->selectQuery('property_services_view', '*', "plot_id = '" .$_GET['prop_id']."'");
       if (count($services)){
        foreach ($services as $service){
            ?>
            <tr>
                <td><?php echo $service['property_service_id']; ?></td>
                <td><?php echo $service['service_option']; ?></td>
                <td><?php echo $service['price']; ?></td>
            </tr>
        <?php }}} ?>
        </tbody>
        </table>
        <div class="clearfix"></div>

        <!--    modal for attaching services-->
<form action="" method="post" id="property_service_form1">
    <div id="attach_services_to_plot" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel1">Attach/Detach services to property</h3>
        </div>
        <div class="modal-body">
            <label class="" for="service-id">property services</label>
            <div class="row-fluid">
                <select class="span12 live_search" name="service_id[]" id="service-id" required="required" multiple>
                    <?php $services = $prop->unAttachedServices($_GET['prop_id']);
                    if(count($services)){
                    foreach ($services as $service){
                     ?>
                    <option value="<?php echo $service['service_channel_id'] ?>"><?php echo $service['service_option_name'].'     <strong>Code: </strong>'.$service['code'].'       ('.$service['price'].')'  ?></option>
                    <?php }} ?>
                </select>
<!--                <input type="text" id="search-key" class="span12 tooltips" data-original-title="Start Typing..." data-toggle="tooltip" placeholder="Type something..."/>-->
            </div>
<!--            <div id="service-container"></div>-->
        </div>
        <input type="hidden" name="property_id" value="<?php echo $_GET['prop_id']?>" >
        <input type="hidden" value="attach_property_service" name="action">
        <div class="modal-footer">
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo739'); ?>
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav729'); ?>
        </div>
    </div>
</form>
<!-- modal for dettaching a property service-->
<form action="" method="post" id="property_service_form1">
    <div id="detach_services_to_plot" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel1">Detach property services</h3>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to detach this service?</p>
        </div>
        <input type="hidden" name="service_id" id="detach-id" value="">
        <input type="hidden" name="property_id" value="<?php echo $_GET['prop_id']?>" >
        <input type="hidden" value="detach_property_service" name="action">
        <div class="modal-footer">
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo739'); ?>
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav729'); ?>
        </div>
    </div>
</form>
