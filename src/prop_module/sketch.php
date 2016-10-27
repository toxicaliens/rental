<?php
$results = $House->getAllServices('Leaf');
if(count($results)){
    foreach ($results as $result){

        ?>
        <div class="row-fluid">
            <label for="service" class="control-group"></label>
            <input type="checkbox" id="service" name="" class="service" value="<?php echo $result['service_channel_id'];?>"> <?php echo $result['service_option'].'        Amount:<strong>Ksh. </strong> '.number_format($result['price']) ;?>
        </div>
    <?php  } }?>