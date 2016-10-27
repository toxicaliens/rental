<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 11/08/2016
 * Time: 17:48

 */
?>
<div class="span2"><img src="" alt="" />  </div>
<?php
    if (isset($_GET['prop_id'])&& !empty($_GET['prop_id'])){
        $results = $prop->selectQuery('plots','*', "plot_id = '".$_GET['prop_id']."'");

?>
<ul class="unstyled span5">
    <li><span>Property ID: </span> <?php echo $results[0]['plot_id']; ?></li>
    <li><span>Property Name: </span> <?php echo $results[0]['plot_name']; ?></li>
    <li><span>Property Category: </span><?php if(!empty($results[0]['option_type'])){echo $prop->getOptionName($results[0]['option_type']);}?></li>
    <li><span>Property Type: </span><?php if(!empty($results[0]['prop_type'])){echo $prop->getName($results[0]['prop_type']);}?></li>
    <li><span>Location: </span><?php echo $results[0]['location']; ?></li>
    <li><span>Land Reg. No: </span><?php echo $results[0]['lr_no']; ?></li>
    <li><span>Units/Houses: </span><?php echo $results[0]['units']; ?></li>
    <li><span>Payment Code: </span><?php echo $results[0]['payment_code']; ?></li>
</ul>

<ul class="unstyled span5">
    <li><span>Payment Code: </span><?php echo $results[0]['payment_code']; ?></li>
    <li><span>Paybill Number: </span><?php echo $results[0]['paybill_number']; ?></li>
    <li><span>Property Manager: </span><?php echo $prop->getFullName($results[0]['pm_mfid']); ?></li>
    <li><span>Landlord: </span><?php echo $prop->getFullName($results[0]['landlord_mf_id']); ?></li>
</ul>
<?php  }?>


