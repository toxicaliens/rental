<!-- <div class="span2"><img src="assets/img/profile/profile-img.png" alt="" /> <a href="#" class="profile-edit">edit</a></div> -->
<ul class="unstyled span12">
   <li><span>User Name:</span><?=$username; ?></li>
   <li><span>Email:</span><?=$email; ?></li>
   <li><span>Status:</span><?=$status; ?></li>
   <li><span>User Role:</span>
      <?php
         $result = run_query("SELECT role_name FROM user_roles WHERE role_id = '".$user_role."'"); 
         $row = get_row_data($result);
         echo $role_name = $row['role_name'];
      ?>
   </li>
  <!--  <li><span>Birthday:</span> 18 Jan 1982</li>
   <li><span>Occupation:</span> Web Developer</li>
   <li><span>Email:</span> <a href="#">john@mywebsite.com</a></li>
   <li><span>Interests:</span> Design, Web etc.</li>
   <li><span>Website Url:</span> <a href="#">http://www.mywebsite.com</a></li>
   <li><span>Mobile Number:</span> +1 646 580 DEMO (6284)</li> -->
   <!-- <li><span>About:</span> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.</li> -->
</ul>