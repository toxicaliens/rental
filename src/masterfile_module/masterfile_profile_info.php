
<div class="span2"><img src="<?php echo $profile_pic; ?>" alt="" /> <!-- <a target="_blank" href="?num=802&mf_id=<?php echo $mf_id; ?>" class="profile-edit">edit</a> --></div>
<?php
    /**
     * Created by PhpStorm.
     * User: JOEL
     * Date: 7/13/2016
     * Time: 11:50 AM
     */
?>
<ul class="unstyled span10">
    <li><span>Full Name: </span><?php echo $row['surname'].' '.$row['firstname'].' '.$row['middlename']; ?></li>
    <li><span>Masterfile Type: </span><?php echo $row['customer_type_name']; ?></li>
    <li><span>Gender: </span><?php echo $row['gender']; ?></li>
    <li><span>Start Date: </span><?php echo (date('Y-m-d', $row['time_stamp'])); ?></li>
    <li><span>Business Role: </span><?php echo $row['b_role']; ?></li>
    <li><span>Email address: </span><?php echo $row['email']; ?></li>
    <li><span>ID No/Passport: </span><?php echo $row['id_passport']; ?></li>
    <li><span>Phone No: </span><?php echo $phone; ?></li>
</ul>
