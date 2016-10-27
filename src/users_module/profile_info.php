<div class="span2"><img src="<?=$profile_pic; ?>" alt="" />
</div>
<ul class="unstyled span10">
   <li><span>Full Name:</span><?=$row['surname'].' '.$row['firstname'].' '.$row['middlename']; ?></li>
   <li><span>Email:</span><?=$row['email']; ?></li>
   <li><span>Phone No:</span><?=$row['phone']; ?></li>
   <li><span>ID No/Passport:</span><?=$row['id_passport']; ?></li>
   <li><span>User Role:</span><?=$row['role_name']; ?></li>
   <li><span>User Name:</span><?=$row['username']; ?></li>
</ul>
