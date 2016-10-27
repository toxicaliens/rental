<div class="span2"><img src="" alt="" />  </div>
<?php
if (isset($_GET['house_id'])&& !empty($_GET['house_id'])){
//    $data = $house->getAllHouses(" house_id = '".$_GET['house_id']."' ");
    $house_data = $house->selectQuery('houses','*'," house_id = '".$_GET['house_id']."' ");
    if (count($house_data)){
//        var_dump($house_data);die;
    }
}
?>
<ul class="unstyled span5">
    <li><span>House ID: </span><?php echo $house_data[0]['house_id'] ?></li>
    <li><span>House Number: </span><?php echo $house_data[0]['house_number'] ?></li>
    <li><span>Property Name: </span><?php echo $house->getPlotName($house_data[0]['plot_id']); ?></li>
    <li><span>Rent: </span><?php  if (!empty( $house_data[0]['rent_amount'])){ echo 'Ksh.    '.number_format($house_data['0']['rent_amount']);} ?> </li>
    <li><span>Rent rate: </span><?php echo ($house_data[0]['rent_rate'] == 'per-sqr-ft')? 'Per Squire Footage':'Flat Rate' ?></li>

</ul>
<ul class="unstyled span5">
    <?php echo ($house_data[0]['rent_rate'] == 'per-sqr-ft')? '<li><span>Squire feet</span>'.$house_data[0]['square_footage'].'</li>':'' ?>
    <?php echo ($house_data[0]['rent_rate'] == 'per-sqr-ft')? '<li><span>Rate per squire footage</span>'.$house_data[0]['rate_per_square_footage'].'</li>':'' ?>
    <?php  if($house_data[0]['service_charge']== 'charge_per_sqr_feet'){
        echo '<li><span>Service Charge</span> Per squire feet</li>';
        echo '<li><span>Service Charge Rate</span>'.$house_data[0]['service_charge_rate']. '</li>';
        echo '<li><span>Total Service Charge:</span>'.$house_data[0]['total_service_charge'].'</li>';
    }elseif($house_data[0]['service_charge']== 'percentage_of_rent'){
        echo '<li><span>Service Charge</span> Percentage of rent</li>';
        echo '<li><span>Service Charge Rate</span>'.$house_data[0]['service_charge_rate']*100 .'%</li>';
        echo '<li><span>Total Service Charge:</span>'.$house_data[0]['total_service_charge'].'</li>';
    }    ?>
</ul>
