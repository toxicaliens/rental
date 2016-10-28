<?php session_start();?>
<?php include('session_check.php');?>
<?php
	include('xmlReader.php');
	$css=$_GET['css'];
	$id=$_GET['id'];
	$val=$_GET['val'];
	$plate_no=$_GET['plate_no'];
	$optionCode=$_GET['optionCode'];
	$price=$_GET['price'];
	$inputId=$_GET['inputId'];

	//secret key
	$key="isaac";

		//price key
	$pk=$_GET['pk'];

	//option code key
	$ok=$_GET['ok'];

	//input id key
	$ik=$_GET['ik'];
	//url security - comparing the harsh keys
	if(isset($price) && $pk != md5($key.$price) || isset($optionCode) && $ok != md5($key.$optionCode)|| isset($inputId) && $ik != md5($key.$inputId)){
		echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\"/>";
		echo "<div id=\"tampering\">"."You are tampering with this application! <br />
				If you tamper once again you will give us explicit rights to track you down!"."</div>";
		exit;
	}

?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10-flat.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru">
<head>
<link rel="stylesheet" type="text/css" href="style.css"/>
<title>City Council of Nairobi: -e-Payment</title>
</head>
<body><div id="content">
<div class="<?=$css;?>"><?php if($rows_no > 1){?><a href="login.php?logout=1">Logout</a><?php }?>-</div>
<div class="razdelm" align=centre>
 <?php include('header.php');?>
 <table width="90%" align="center"><tr><td>

  <?php
$menu= new menu();
$services=$menu->getOptions($val);

$counter=0;

while($counter <= $lengthOptions){
$services2= $services[$counter];

//explodes
$exploded_services1=explode("#", $services2);
$exploded_services2=explode("*", $exploded_services1[0]);


		if($exploded_services2[6]==""){
						if($exploded_services2[0]==$val){ ?>


<h3><a href="subOptions.php?val=<?=$exploded_services2[1];?>&plate_no=<?=$plate_no;?>&indentifier=<?=$exploded_services2[7];?>&optionCode=<?=$exploded_services2[5];?>&ok=<?=md5($key.$exploded_services2[5]);?>&price=<?=$exploded_services2[3];?>&pk=<?=md5($key.$exploded_services2[3]);?>&id=<?=$id;?>&service=<?=$exploded_services2[4];?>&css=<?=$css;?>"><?=$exploded_services2[2];?></a></h3><?=$exploded_services2[4];?><br>---------------------<br>
		<?php }
		}
		else { ?>
			<h3><a href="inputs.php?inputId=<?=$exploded_services2[6];?>&ik=<?=md5($key.$exploded_services2[6]);?>&plate_no=<?=$plate_no;?>&indentifier=<?=$exploded_services2[7];?>&service=<?=$exploded_services2[4];?>&price=<?=$exploded_services2[3];?>&pk=<?=md5($key.$exploded_services2[3]);?>&val=<?=$exploded_services2[1];?>&optionCode=<?=$exploded_services2[5];?>&pay=comfypay&ok=<?=md5($key.$exploded_services2[5]);?>&id=<?=$id;?>&css=<?=$css;?>&ipc=1"><?=$exploded_services2[2];?></a></h3><br><?=$exploded_services2[4];?><br>.......<br>
		<?php }


$counter++;
}
?>




    <?
    	if(empty($val)){
	?>
       					 <h3><a href=validate_staff.php>Validate Staff</a></h3>
        				<p>Confirm Validity of a CCN Employee</p>

  <?

		}
						?>
  </td></tr></table>
</div>
<div class="video">
<b><?php

			 $url = htmlspecialchars($_SERVER['HTTP_REFERER']);
			 if(!empty($url)){
 			 echo "<a data-role='button' class='back' href='$url'>Previous Page</a>";
			 }

 ?></b><b>
<?php if($rows_no==0){?> [<b><a href="login.php">Login/Register</a>]</b><?php }?>[</a> <a href="home.php">Services</a>]<?php if($rows_no > 0){ ?> [<a href="login.php">My Account</a>] [<a href="login.php?logout=1">Logout</a>]
<?php }?></b>

</div>
<div class="razdelv">
<center>
Powered By Comfypay
</center>
</div></div>
</body></html>