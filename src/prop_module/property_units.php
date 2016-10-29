<a href="#add_house" class="btn btn-primary" data-toggle="modal"><i class="icon-plus"></i> Add</a>
<a href="#edit_house_details" class=" btn btn-default edit-house"><i class="icon-edit"></i> Edit</a>
<a href="#delete-house" class="btn btn-danger delete-house"><i class="icon-trash"></i> Delete</a>
<br><br>
    <?php
    $House->splash('p_units');
    (isset($_SESSION['warnings'])) ? $House->displayWarnings('warnings') : '';
    if(isset($_SESSION['p_units'])){
        echo $_SESSION['p_units'];
        unset($_SESSION['p_units']);
    }
    ?>
<table class="live_table table table-bordered profile_table">
    <thead>
        <tr>
            <th>ID#</th>
            <th>House Number</th>
            <th>Rent</th>
            <th>Profile</th>
        </tr>
    </thead>
<tbody>
    <?php

    $rows =$prop->getAllPropertyUnits($_GET['prop_id']);
   // $rows = $house->selectQuery('property_unit_details','*',"plot_id ='". $_GET['prop_id']."' ");
    //  $rows= $prop->getAllAttributes($_GET['prop_id']);
    if($rows){
        foreach($rows as $row){
            ?>
            <tr>
                <td><?=$row['house_id']; ?></td>
                <td><?=$row['house_number']; ?></td>
                <td><?=$row['rent_amount']; ?></td>
                <td><a href="?num=900&&house_id=<?php echo $row['house_id'];?>" class="btn btn-mini"><i class="icon-eye-open"></i> Profile</a></td>
            </tr>

        <?php }}?>
    </tbody>
</table>
        <div class="clearfix"></div>
<!-- modal for add -->
<form action="" method="post">
    <div id="add_house" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel1">Add A Unit</h3>
        </div>
        <div class="modal-body">
            <div class="row-fluid">
                <label for="group_name">Unit Number:</label>
                <input type="text" name="house_number" value="" class="span12" required>
            </div>
            <div class="row-fluid">

                    <label for="">Rent Rate</label>
                        <label class="radio line">
                            <div class="radio" ><span id="default-rent-rate"><input type="radio" class="rent-r rent_r_default" value="per-sqr-ft" name="rent_rate"></span></div>
                            Per square Feet
                        </label>
                        <label class="radio">
                            <div class="radio" ><input type="radio" class="rent-r" value="flat-rate" name="rent_rate"></span></div>
                            Flat Rate
                        </label>

            </div>
            <div class="row-fluid rnt-rate" id="" style="display: none">
                <label for="sqr-feet">square Feet</label>
                <input type="text" name="sqr_feet" id=""  class="span12 chris sqr-feet">
                <label for="rate">Rate per square feet</label>
                <input type="text" name="rate" id="rate"  class="span12 chris">
            </div>
            <div class="row-fluid" id="amount" style="display: none">
                <label for="group_name">Rent Amount:</label>
                <input type="text" name="rent_amount" id="" value="" class="span12 rent_a">
            </div>

            <div class="row-fluid">

                <label for="">Service Charge</label>
                <label class="radio line">
                    <div class="hide-s">
                    <div class="radio" ><span><input type="radio" class="s_charge s_charge_check" name="service_charge" value="charge_per_sqr_feet"></span></div>
                     Service Charge Per Square Footage
                    </div>
                </label>
                <label class="radio">
                    <div class="radio" ><input type="radio"  class="s_charge" name="service_charge" value="percentage_of_rent"></span></div>
                    Percentage of Rent
                </label>
                <label class="radio">
                    <div class="radio"><input type="radio"  class="s_charge" name="service_charge" value="none"></span></div>
                    None
                </label>

            </div>
            <div class="row-fluid s-charge-rate" style="display: none">
                <label for="rate_per-sqr">Rate Per SQrF:</label>
                <input type="text" id="" name="rate_sqrf" class="span12 rate-ps">
            </div>
            <div class="row-fluid percentage-rate" id="" style="display: none;">
                <label for="rate_per-sqr">Percentage of rent:</label>
                <input type="text" id="" name="percent_rent" class="span12 p-r">
            </div>
            <div class="row-fluid t-s-charge"  style="display: none">
                <label for="service-charge-amount">Total service charge</label>
                <input type="text" name="service_charge_amount" class="span12 service-charge-amount" id="" readonly>
            </div>

        </div>
        <!-- the hidden fields -->
        <input type="hidden" name="action" value="add_house"/>
            <input type="hidden" value="<?php echo $_GET['prop_id']?>" name="plot">
            <input type="hidden" name="tab-three">
        <div class="modal-footer">
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo739'); ?>
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav729'); ?>
        </div>
    </div>
</form>

<!--modal for edit-->
<form action="" method="post">
    <div id="edit_house_details" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel1">Edit Unit</h3>
        </div>
        <div class="modal-body">
            <div class="row-fluid">
                <label for="group_name">Unit Number:</label>
                <input type="text" name="house_number" id="unit-number" class="span12" required>
            </div>
            <div class="row-fluid">

                <label for="">Rent Rate</label>
                <label class="radio line">
                    <div class="radio" ><span><input type="radio" class="rent-r psqf" id="per-ft" value="per-sqr-ft" name="rent_rate"></span></div>
                    Per square Feet
                </label>
                <label class="radio">
                    <div class="radio" ><input type="radio" class="rent-r ftrt" id="flt-rt" value="flat-rate" name="rent_rate"></span></div>
                    Flat Rate
                </label>

            </div>
            <div class="row-fluid rnt-rate" id="" style="display: none">
                <label for="sqr-feet">square Feet</label>
                <input type="text" name="sqr_feet" id="sqr-feet-e"  class="span12 chris">
                <label for="rate">Rate per square feet</label>
                <input type="text" name="rate" id="rate-e"  class="span12 chris">
            </div>
            <div class="row-fluid amount" id="" >
                <label for="group_name">Rent Amount:</label>
                <input type="text" name="rent_amount" id="rent_amnt" value="" class="span12">
            </div>

            <div class="row-fluid">

                <label for="">Service Charge</label>
                <label class="radio line">
                    <div class="hide-s">
                    <div class="radio"><span><input type="radio" class="service_charge scpsqf" name="service_charge" value="charge_per_sqr_feet"></span></div>
                    Service Charge Per Square Footage
                        </div>
                </label>
                <label class="radio">
                    <div class="radio" ><input type="radio"  class="service_charge scharge" name="service_charge" value="percentage_of_rent"></span></div>
                    Percentage of Rent
                </label>
                <label class="radio">
                    <div class="radio"><input type="radio"  class="service_charge none" name="service_charge" value="none"></span></div>
                    None
                </label>

            </div>
            <div class="row-fluid s-charge-rate" id=""   style="display: none">
                <label for="rate_per-sqr">Rate Per SQrF:</label>
                <input type="text" id="rate-ps-e" name="rate_sqrf" class="span12">
            </div>
            <div class="row-fluid percentage-rate"  style="display: none;">
                <label for="rate_per-sqr">Percentage of rent:</label>
                <input type="text" id="p-r-e" name="percent_rent" class="span12">
            </div>
            <div class="row-fluid t-s-charge" id="" style="display: none">
                <label for="service-charge-amount">Total service charge</label>
                <input type="text" name="service_charge_amount" class="span12" id="service-charge-amount-e" readonly>
            </div>

        </div>
        <!-- the hidden fields -->
        <input type="hidden" name="action" value="edit_house"/>
        <input type="hidden" id="edit">
        <input type="hidden" name="edit_id" id="edit_ho">
        <div class="modal-footer">
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo741'); ?>
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav740'); ?>
        </div>
    </div>
</form>
<!--modal for delete-->
<form action=""  method="post">
    <div id="delete-house" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel1">Delete House</h3>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete this house?</p>
        </div>
        <!-- hidden fields -->
        <input type="hidden" name="action" value="delete_house"/>
        <input type="hidden" name="delete_id" id="del_id">
        <div class="modal-footer">
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'No743'); ?>
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Yes742'); ?>
        </div>
    </div>
</form>

