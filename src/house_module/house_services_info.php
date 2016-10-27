<button data-target="#attach_services_to_house"  data-toggle="modal" class="btn btn-small btn-success attach_service_to_plot"><i class="icon-paper-clip"></i> Attach a service</button>
<button data-target="#detach_services_from_house"  class="btn btn-small btn-danger detach_service_from_house"><i class="icon-paper-clip"></i> Detach a service</button>
<br><br>

<?php //$house->unAttachedServices($_GET['house_id']);
    if(isset($_SESSION['h_services'])){
        echo $_SESSION['h_services'];
        unset ($_SESSION['h_services']);
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
    if (isset($_GET['house_id'])) {
        $id = $_GET['house_id'];
        $services = $house->selectQuery('house_services_view', '*', "house_id = '" .$_GET['house_id']."'");
        if (count($services)){
            foreach ($services as $service){
                ?>
                <tr>
                    <td><?php echo $service['house_service_id']; ?></td>
                    <td><?php echo $service['service_option']; ?></td>
                    <td><?php echo $service['price']; ?></td>
                </tr>
            <?php }}} ?>
    </tbody>
</table>
<div class="clearfix"></div>

<!--    modal for attaching services-->
<form action="" method="post" id="house_service_form1">
    <div id="attach_services_to_house" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel1">Attach a service to a unit</h3>
        </div>
        <div class="modal-body">
            <label class="" for="service-id">Unit services</label>
            <div class="row-fluid">
                <select class="span12 live_search" name="service_id[]" id="service-id" required="required" multiple>
                    <?php $services = $house->unAttachedServices($_GET['house_id']);
                    if(count($services)){
                        foreach ($services as $service){
                            ?>
                            <option value="<?php echo $service['service_channel_id'] ?>"><?php echo $service['service_option_name'].'     <strong>Code: </strong>'.$service['code'].'       ('.$service['price'].')'  ?></option>
                        <?php }} ?>
                </select>
            </div>
        </div>
        <input type="hidden" name="house_id" value="<?php echo $_GET['house_id']?>" >
        <input type="hidden" value="attach_house_service" name="action">
        <div class="modal-footer">
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo753'); ?>
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav752'); ?>
        </div>
    </div>
</form>
<!-- modal for dettaching a property service-->
<form action="" method="post" id="property_service_form1">
    <div id="detach_services_from_house" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel1">Detach unit services</h3>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to detach this service?</p>
        </div>
        <input type="hidden" name="service_id" id="h_detach-id" value="">
        <input type="hidden" name="house_id" value="<?php echo $_GET['house_id']?>" >
        <input type="hidden" value="detach_house_service" name="action">
        <div class="modal-footer">
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo753'); ?>
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav752'); ?>
        </div>
    </div>
</form>