<?
/**************************************************************************
*    CONNECTION DETAILS
***************************************************************************/
$dbh = mysql_connect("localhost","wadifoun","wadiadmin");
mysql_select_db("wadifoun_bukura",$dbh) or die("Connection temporarily unavailable - Contact the System Administrator !!");


//$dbh = mysql_connect("localhost","root","");
//mysql_select_db("db_bukura",$dbh) or die("Connection temporarily unavailable - Contact the System Administrator !!");

$conn = $dbh;		
if (mysql_errno() == 1203) 
{
	session_destroy();
	header("Location: http://bukuraserver/");
	exit;
}


$query = "SELECT setting FROM tbl_settings WHERE item like 'Fees' LIMIT 0,1";
$data = run_query($query);
$rows = mysql_fetch_array($data);
$set = trim($rows['setting']);	
$_SESSION['fees_votehead'] = $set;
/**************************************************************************/	

function show_action_message($message)
{
	$content = "<div style='width:340px;'>
    	<div style='float:left'>
  			<img align='left' src='done.png' width='51' height='54' />
        </div>
        
        <div align='left' style='float:right; padding-top:20px; color: #F28914; font-weight: bold; font-size: 14px;'>
        	".$message."
        </div>
    </div>";
	
	echo $content;
}


function getnextID($table, $col, $default) 
{
	 $fit = "SELECT max($col) as amax FROM $table";
	 $fitter = run_query($fit);
     $mobett = mysql_fetch_array($fitter);
	 $top = $mobett['amax']; 
	 if($top == "")
	 	$thenum = $default;
	else
		$thenum = ($top + 1); 
	 return $thenum;  
}	

function getnextCode($table, $col, $cond1, $cond2, $default) 
{
	 $fit = "SELECT max($col) as amax FROM $table where $cond1 like '$cond2'";
	 $fitter = run_query($fit);
     $mobett = mysql_fetch_array($fitter);
	 $top = $mobett['amax']; 
	 if($top == "")
	 	$thenum = $default;
	else
		$thenum = ($top + 1); 
	 return $thenum;  
}

function getTransactRange($one)
{
	$query = "SELECT trans FROM tbl_feepayments WHERE date like '$one' order by trans ASC";
	$data = run_query($query);
	$rows = mysql_fetch_array($data);
	$lower = trim($rows['trans']);	
	
	$query2 = "SELECT trans FROM tbl_feepayments WHERE date like '$one' order by trans DESC";
	$data2 = run_query($query2);
	$rows2 = mysql_fetch_array($data2);
	$upper = trim($rows2['trans']);		
	if(($upper != "") || ($upper == $lower))
		$combine = ($lower ." - ". $upper);
	else
		$combine = $lower;
	return $combine;
}

function getModeAmt($one)
{
	$query = "SELECT sum(amt) as total FROM tbl_feepayments WHERE pay_mode like '$one'";
	$data = run_query($query);
	$rows = mysql_fetch_array($data);
	$amt = trim($rows['total']);	
	return $amt;
}


function getModeAmt2($one)
{
	$query = "SELECT sum(amt) as total FROM tbl_feepayments WHERE pay_mode not like '$one'";
	$data = run_query($query);
	$rows = mysql_fetch_array($data);
	$amt = trim($rows['total']);	
	return $amt;
}

function getVoteAmtCollect($one)
{
	$query = "SELECT sum(amt) as total FROM tbl_fee_breakdown WHERE votehead like '$one'";
	$data = run_query($query);
	$rows = mysql_fetch_array($data);
	$amt = trim($rows['total']);	
	return $amt;
}

function getVoteAuthorised($one,$year)
{
	$query = "SELECT amt FROM tbl_authorize WHERE votehead like '$one' and year like '$year'";
	$data = run_query($query);
	$rows = mysql_fetch_array($data);
	$amt = trim($rows['amt']);	
	return $amt;
}

function getBankName($one)
{
	$query = "SELECT name FROM tbl_banks WHERE bcode like '$one'";
	$data = run_query($query);
	$rows = mysql_fetch_array($data);
	$name = trim($rows['name']);	
	return $name;
}

function getBranchName($one)
{
	$query = "SELECT branch FROM tbl_branches WHERE b_code like '$one'";
	$data = run_query($query);
	$rows = mysql_fetch_array($data);
	$name = trim($rows['branch']);	
	return $name;
}

// =========================================================
function getVoteGroupName($one)
{
	$query = "SELECT title FROM tbl_votegroups WHERE code like '$one'";
	$data = run_query($query);
	$rows = mysql_fetch_array($data);
	$name = trim($rows['title']);	
	return $name;
}

function getVoteName($one)
{
	$query = "SELECT title FROM tbl_voteheads WHERE code like '$one'";
	$data = run_query($query);
	$rows = mysql_fetch_array($data);
	$name = trim($rows['title']);	
	return $name;
}

function getSchoolAccName($one)
{
	$query = "SELECT accname FROM tbl_saccounts WHERE acode like '$one'";
	$data = run_query($query);
	$rows = mysql_fetch_array($data);
	$name = trim($rows['accname']);	
	return $name;
}

function getAccname($one)
{
	$query = "SELECT accname FROM tbl_accounts WHERE accno like '$one'";
	$data = run_query($query);
	$rows = mysql_fetch_array($data);
	$name = trim($rows['accname']);	
	return $name;
}

function getVoteOtherTotal($from, $to, $vote)
{
	$dist = "SELECT sum(amt) as total FROM tbl_otherincome where DATE(slip_date) BETWEEN '$from' AND '$to' and votehead like '$vote'";
	$resultId = run_query($dist);
	$row = @mysql_fetch_array($resultId);
	$total = trim($row['total']);
	return $total;
} 

function getBillVote($from, $pass)
{
	$dist = "SELECT votehead FROM $from where trans like '$pass'";
	$resultId = run_query($dist);
	$row = @mysql_fetch_array($resultId);
	$total = trim($row['votehead']);
	return $total;
} 

function getBillInvoice($from, $pass)
{
	$dist = "SELECT invoice FROM $from where trans like '$pass'";
	$resultId = run_query($dist);
	$row = @mysql_fetch_array($resultId);
	$total = trim($row['invoice']);
	return $total;
} 

function getVoteBillAmt($table, $from, $to, $vote)
{
	$dist = "SELECT sum(amount) as total FROM $table where DATE(bill_date) BETWEEN '$from' AND '$to' and votehead like '$vote'";
	$resultId = run_query($dist);	
	$row = mysql_fetch_array($resultId);
	$total = trim($row['total']);
	return $total;
} 

function getPaidYearFees($pass1, $pass2, $pass3, $pass4)
{
	$paid = 0;
	$inr = "select * from tbl_feepayments where year like '$pass1' and sid like '$pass2' and frm like '$pass3'";
	$inre = run_query($inr); 		
	while($tra = mysql_fetch_array($inre)) // a number of transactions .......
	{
		$tr = trim($tra['trans']);	
		$iner = "select * from tbl_fee_breakdown where trans like '$tr' and votehead like '$pass4'";
		$quo = run_query($iner); 
		$arr = mysql_fetch_array($quo);
		$tota = trim($arr['amt']);
		$paid += $tota;
	}
	return $paid;
}

function getPaidTermFees($pass1, $pass2, $pass3, $pass4, $pass5)
{
	$paid = 0;
	$inr = "select * from tbl_feepayments where year like '$pass1' and sid like '$pass2' and frm like '$pass3' and term like '$pass5'";
	$inre = run_query($inr); 		
	while($tra = mysql_fetch_array($inre)) // a number of transactions .......
	{
		$tr = trim($tra['trans']);	
		$iner = "select * from tbl_fee_breakdown where trans like '$tr' and votehead like '$pass4'";
		$quo = run_query($iner); 
		$arr = mysql_fetch_array($quo);
		$tota = trim($arr['amt']);
		$paid += $tota;
	}
	return $paid;
}

function getVotePaid($one, $two)
{
	$query = "SELECT amt FROM tbl_fee_breakdown WHERE trans like '$one' and votehead like '$two'";
	$data = run_query($query);
	$rows = mysql_fetch_array($data);
	$amt = trim($rows['amt']);	
	return $amt;
}

function getVoteTotal($from, $to, $vote)
{
	$dist = "SELECT * FROM tbl_feepayments where DATE(date) BETWEEN '$from' AND '$to' order by trans DESC";
	$resultId = run_query($dist);	
	$total = 0;
	while($row = @mysql_fetch_array($resultId))
	{
		$trans = trim($row['trans']);
		$amt = getVotePaid($trans, $vote);
		$total += $amt;
	} // end of the loop ....
	return $total;
} 

function getVoteExpendAmt($table, $data, $from, $to, $vote)
{
	$dist = "SELECT sum(amt) as total FROM $table where DATE($data) BETWEEN '$from' AND '$to' and vote like '$vote'";
	$resultId = run_query($dist);	
	$row = mysql_fetch_array($resultId);
	$total = trim($row['total']);
	return $total;
}

function getVotePays($from, $to, $vote)
{
	$dist = "SELECT sum(amt) as total FROM tbl_supplypays where DATE(date) BETWEEN '$from' AND '$to' and bill like '$vote'";
	$resultId = run_query($dist);
	$row = @mysql_fetch_array($resultId);
	$total = trim($row['total']);
	return $total;
}

function getVoteExpenditure($from, $to, $vote)
{
	$dist = "SELECT * FROM tbl_supplybills where DATE(bill_date) BETWEEN '$from' AND '$to' and votehead like '$vote'";
	$resultId = run_query($dist);	
	$total = 0;
	while($row = @mysql_fetch_array($resultId))
	{
		$trans = trim($row['trans']);
		$ddd = getVotePays($from, $to, $trans);
		$total += $ddd;
	} // end of the loop ....
	return $total;
} 

function getFeesToPay($form, $term, $year)
{
	$sum = 0;
	if($term != "All")
	{
		$dist = "SELECT sum($term) as total FROM tbl_fee_struct where year like '$year' and frm like '$form'";
		$resultId = run_query($dist);	
		$row = mysql_fetch_array($resultId);
		$sum = trim($row['total']);
	}
	else
	{
		$dist = "SELECT * FROM tbl_fee_struct where year like '$year' and frm like '$form'";
		$resultId = run_query($dist);	
		while($row = mysql_fetch_array($resultId))
		{
			$trm1 = trim($row['sem1']);	
			$trm2 = trim($row['sem2']);
			$total = ($trm1 + $trm2);
			$sum += $total;				
		} // end loop	
	}
	return $sum;
} 

function getStudFeesPaid($std, $form, $term, $year)
{
	$sum = 0;
	if($term != "All")
		$dist = "SELECT sum(amt) as total FROM tbl_feepayments where user_id like '$std' and year like '$year' and semester like '$term'";	
	else
		$dist = "SELECT sum(amt) as total FROM tbl_feepayments where user_id like '$std' and year like '$year'";
	
	$resultId = run_query($dist);	
	$row = mysql_fetch_array($resultId);
	$sum = trim($row['total']);
	return $sum;
} 

function number_words($number) 
{ 
    if (($number < 0) || ($number > 9999999999)) 
    { 
    throw new Exception("Number is out of range");
    } 

    $Bn = floor($number / 1000000000);  /* Millions (giga) */ 
	$number -= $Bn * 1000000000; 
	$Gn = floor($number / 1000000);  /* Millions (giga) */ 
    $number -= $Gn * 1000000; 
    $kn = floor($number / 1000);     /* Thousands (kilo) */ 
    $number -= $kn * 1000; 
    $Hn = floor($number / 100);      /* Hundreds (hecto) */ 
    $number -= $Hn * 100; 
    $Dn = floor($number / 10);       /* Tens (deca) */ 
    $n = $number % 10;               /* Ones */ 

    $res = ""; 

    if ($Bn) 
    { 
        $res .= number_words($Bn) . " Billion, "; 
    } 

	
	if ($Gn) 
    { 
        $res .= number_words($Gn) . " Million, "; 
    } 

    if ($kn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
            number_words($kn) . " Thousand"; 
    } 

    if ($Hn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
            number_words($Hn) . " Hundred"; 
    } 

    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six","Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen","Nineteen"); 
    $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty","Seventy", "Eighty", "Ninety"); 

    if ($Dn || $n) 
    { 
        if (!empty($res)) 
        { 
            $res .= " and "; 
        } 

        if ($Dn < 2) 
        { 
            $res .= $ones[$Dn * 10 + $n]; 
        } 
        else 
        { 
            $res .= $tens[$Dn]; 

            if ($n) 
            { 
                $res .= "-" . $ones[$n]; 
            } 
        } 
    } 

    if (empty($res)) 
    { 
        $res = "zero"; 
    } 

    return $res; 
} 

// formats date from sql representation to dd-mm-yyyy 
function formatDate($date)
{
	$rec = explode("-",$date);
	$newd = ($rec[2].'-'.$rec[1].'-'.$rec[0]);
	return $newd;
}
// formatting the output of a string 
function formatStr($passed)
{
	$newstr = "";
	$arr = explode(" ",$passed);
	foreach($arr as $pass)
	{
		if($pass != '') // if not a null string ....
		{
			$ind = (strlen($pass) - 1); // the length of the string .......
			$first = strtoupper(substr($pass,0,1)); // the first letter 
			$rem = strtolower(substr($pass,1,$ind)); // the remaining part of the string  
			$comm = ($first.$rem);
			$newstr.=($comm." "); // join up the string .......			
		}
	} // end of the loop .....
	return $newstr; // the new string ........ 
} // end of the function .......



function getStudentName($one)
{
	$query = "SELECT firstname, lastname FROM tbl_studlist WHERE adm_no like '$one'";
	$data = run_query($query);
	$rows = mysql_fetch_array($data);
	$name = trim($rows['lastname']).' '.trim($rows['middlename']).' '.trim($rows['firstname']);	
	return $name;
}

function getStudentName2($one)
{
	$query = "SELECT firstname, lastname FROM tbl_studlist WHERE user_id like '$one'";
	$data = run_query($query);
	$rows = mysql_fetch_array($data);
	$name = trim($rows['lastname']).' '.trim($rows['middlename']).' '.trim($rows['firstname']);	
	return $name;
}

function getStudentCourse($one)
{
	$query = "SELECT course FROM tbl_studlist WHERE user_id like '$one'";
	$data = run_query($query);
	$rows = mysql_fetch_array($data);
	$name = trim($rows['course']);	
	return $name;
}

function getStudUserID($one)
{
	$query = "SELECT user_id FROM tbl_studlist WHERE adm_no like '$one'";
	$data = run_query($query);
	$rows = mysql_fetch_array($data);
	$name = trim($rows['user_id']);	
	return $name;
}

function getCourseName($code)
{
	$query_tutor = "select * from tbl_courses where code like '$code' or num like '$code'";
	$result_tutor = run_query($query_tutor);
	while($tutor_arr = mysql_fetch_array($result_tutor))
	{
		$tutor_name = $tutor_arr['title'];
		return $tutor_name;
	}
	return $code;
}

function getModuleName($code)
{
	$query_module = "select * from tbl_modules where code like '$code' or num like '$code'";
	$result_module = run_query($query_module);
	while($module_arr = mysql_fetch_array($result_module))
	{
		$module_name = $module_arr['title'];
	}
	return $module_name;
}
function getModuleCode($code)
{
	$query_module = "select * from tbl_modules where num like '$code'";
	$result_module = run_query($query_module);
	while($module_arr = mysql_fetch_array($result_module))
	{
		$module_name = $module_arr['code'];
	}
	return $module_name;
}

function getModulePoints($code)
{
	$query_module = "select * from tbl_modules where code like '$code'";
	$result_module = run_query($query_module);
	while($module_arr = mysql_fetch_array($result_module))
	{
		$points = $module_arr['cr_points'];
	}
	return $points;
}

function computeGrade($smark)
{
	if($smark >=0 && $smark <=39)
		$grade = "E";
	else if($smark >=40 && $smark <=49)
		$grade = "D";
	else if($smark >=50 && $smark <=59)
		$grade = "C";
	else if($smark >=60 && $smark <=69)
		$grade = "B";			
	else if($smark >=70 && $smark <=100)
		$grade = "A";
	return $grade;				
}

function computeGradepoint($grade)
{
	if($grade == "A")
		$gpoint = 4;		
	else if($grade == "B")
		$gpoint = 3;
	else if($grade == "C")
		$gpoint = 2;	
	else if($grade == "D")
		$gpoint = 1;
	else if($grade == "E")
		$gpoint = 0;
	return $gpoint;				
}
	
function computeOverallGrade($gpa)
{
	if($gpa >=3.5 && $gpa <=4)
		$grade = "Distinction";
	else if($gpa >=3 && $gpa <=3.49)
		$grade = "Merit";
	else if($gpa >=2 && $gpa <=2.99)
		$grade = "Pass";
	return $grade;				
}
	
function getStudentID($one)
{
	$query = "SELECT adm_no FROM tbl_studlist WHERE user_id like '$one'";
	$data = run_query($query);
	$rows = mysql_fetch_array($data);
	$name = trim($rows['adm_no']);	
	return $name;
}



		
function message($msg)
{

	?><table width="592" border="0" align="center" bgcolor="#E8E8E8">
  <tr>
    <th  scope="col" bgcolor="#CCCCCC"><div align="left"><span style="font-family: 'Trebuchet MS';color: #000099">Notice:</span></div></th>
  </tr>
  <tr>
    <td><blockquote>
      <p><span style="font-family: 'Trebuchet MS';
	color: #000000;
	font-weight: bold;
	font-size: 12px;"><?=$msg; ?></span></p>
    </blockquote></td>
  </tr>
</table>
<?
}

function error($msg) 
{ 
   ?> 
   <html> 
   <head> 
   <script language="JavaScript"> 
   <!-- 
       alert("<?php print"{$msg}"; ?>"); 
       history.back(); 
   //--> 
   </script> 
   </head> 
   <body> 
   </body> 
   </html> 
   <?  
   exit; 
} 

function confirm_action($msg) 
{ 
   ?> 
   <html> 
   <head> 
   <script language="JavaScript"> 
   <!-- 
       var verdict = confirm("<?php print"{$msg}"; ?>"); 
	   
	   if(verdict)
	   {
	   		
	   }
	   else
	   {
       		history.back(); 
	   }
   //--> 
   </script> 
   </head> 
   <body> 
   </body> 
   </html> 
   <?  
   
} 

function direct($msg) 
{ 
   ?> 
   <html> 
   <head> 
   <script language="JavaScript"> 
   <!-- 
       alert("<?php print"{$msg}"; ?>"); 
   //--> 
   </script> 
   </head> 
   <body> 
   </body> 
   </html> 
   <? 
   return; 
} 

function windup($msg) 
{ 
   ?> 
   <html> 
   <head> 
   <script language="JavaScript"> 
   <!-- 
       alert("<?php print"{$msg}"; ?>"); 
	   window.opener ='x';
	   window.close();// return false;
   //--> 
   </script> 
   </head> 
   <body> 
   </body> 
   </html> 
   <? 
   return; 
} 


function showerror()
{
    die("Error " . mysql_errno() . " . " . mysql_error());
}


	//if(!($conn = mysql_connect("localhost","dalceduc","dalcbegin24")))
	   // die("COULD NOT CREATE CONNECTION TO DATABASE");
	
	//if(!(mysql_select_db("dalceduc_dk",$conn)))
	//    die ("COULD NOT SELECT the DATABASE");
	
	/*if(!($subconn = mysql_connect("localhost","dalceduc","dalcbegin24")))
	    die("COULD NOT CREATE CONNECTION TO DATABASE");
	
	if(!(mysql_select_db("dalceduc_subcenter",$subconn)))
	    die ("COULD NOT SELECT the DATABASE");*/
		
		
/*=================================================================================================================
==================================================================================================================*/		
		
		

	function selectCourses($connection, $tableName, $attributeName, $pulldownName, $defaultValue)
	{
	   $defaultWithinResultSet = FALSE;
	   
	   //query to find distinct values of $attributeName in $tableName
	   $distinctQuery = "SELECT DISTINCT {$attributeName} FROM {$tableName}";
	       //die("you are wasted");
	   
	   $distinctQuery2 = "SELECT DISTINCT code FROM {tableName}";
	   
	   //run the distinctQuery on the database
	   if(!($resultId = mysql_query($distinctQuery, $connection)))
	      showerror();
		  
	   $resultId2 = mysql_query($distinctQuery2, $connection);
		
	   //start the select  widget
	   print "\n<select name=\"{$pulldownName}\">";

	   
	   //Retrieve each row from the query
	   while($row = @mysql_fetch_array($resultId) && $row2 = @mysql_fetch_array($resultId2))
	   {
	      //Get the value of the attribute to be displayed
		  $result = $row[$attributeName];
		  $result2 = $row2["code"];
		  
		  //Check if a default value is set, and if so...
		  //is it the current Database name?
		  if(isset($defaultValue) && $result == $defaultValue)
		      //yes show as selected
			  print "\n\t<option selected value=\"{$result2}\">{$result}";
		  else
		      //No just show as an option
			  print "\n\t<option value=\"{$result2}\">{$result}";
	   }
	   print "\n</select>";
	}
	
	
	
/*=================================================================================================================
==================================================================================================================*/			
	
	
	
	function selectCourseCodes($connection, $tableName, $defaultValue)
	{
	   $defaultWithinResultSet = FALSE;
	   $pulldownName = "course_code";
	   //$defaultValue = "Select Course";
	   
	   $unwanted = " where code not like 'ADM' and code not like 'COSYLLB' and code not like 'CAL5EADD' and code not like 'PGDADD' and code not like 'ADD' and code not like 'CAL4EADD' and code not like 'CAL4COPT' and code not like 'CAL4CADD' and code not like 'CAL5MOP' and code not like 'CAL4MOPT' and code not like 'CAL5CADD' Order By title ASC";
	   
	   //query to find distinct values of $attributeName in $tableName
	   if(!($distinctQuery = "SELECT code, title FROM {$tableName}"))
	       die("you are wasted");
	   
	  // $distinctQuery2 = "SELECT DISTINCT code FROM {tableName}";
	   $distinctQuery .= $unwanted;
	   //run the distinctQuery on the database
	   if(!($resultId = mysql_query($distinctQuery, $connection)))
	      showerror();
		  
	   //$resultId2 = mysql_query($distinctQuery2, $connection);
		
	   //start the select  widget
	   print "\n<select style=\"font-size:11px;\"name=\"{$pulldownName}\">";

	   $count = 0;
	   //Retrieve each row from the query
	   while($row = @mysql_fetch_row($resultId))
	   {
	      //Get the value of the attribute to be displayed
			foreach($row as $datas)
			{	
			    if($count == 0)
				    $result2 = $datas;
				else
				    $result = $datas;	
				
				$count++;
				if($count > 1)
				   break;
			}		  
		  //Check if a default value is set, and if so...
		  //is it the current Database name?
		  if(isset($defaultValue) && $result == $defaultValue)
		      //yes show as selected
			  print "\n\t<option selected value=\"{$result}\">{$result}";
		  else
		      //No just show as an option
			  print "\n\t<option value=\"{$result}\">{$result}";
			  
		   $count = 0;
	   }
	   print "\n\t<option value=\"Other\">Other";
	   print "\n\t<option value=\"Professional\">Professional Assessment";
	   print "\n</select>";
	}
	
	
	
	
/*=================================================================================================================
==================================================================================================================*/			
	
	
	function selectDistOrdered($connection, $tableName, $attributeName, $pulldownName, $defaultValue)
	{
	   $defaultWithinResultSet = FALSE;
	   
	   //query to find distinct values of $attributeName in $tableName
	   $distinctQuery = "SELECT DISTINCT {$attributeName} FROM {$tableName} ORDER BY {$attributeName}";
	      
	   
	   //run the distinctQuery on the database
	   if(!($resultId = mysql_query($distinctQuery, $connection)))
	      showerror();
		
	   //start the select  widget
	   print "\n<select name=\"{$pulldownName}\">";

	   
	   //Retrieve each row from the query
	   while($row = @mysql_fetch_array($resultId))
	   {
	      //Get the value of the attribute to be displayed
		  $result = $row[$attributeName];
		  
		  //Check if a default value is set, and if so...
		  //is it the current Database name?
		  if(isset($defaultValue) && $result == $defaultValue)
		      //yes show as selected
			  print "\n\t<option selected value=\"{$result}\">{$result}";
		  else
		      //No just show as an option
			  print "\n\t<option value=\"{$result}\">{$result}";
	   }
	   print "\n</select>";
	}
	
	
	
	
	
	function selectDistOrderedTarget($connection, $tableName, $attributeName, $pulldownName, $defaultValue)
	{
	   $defaultWithinResultSet = FALSE;
	   
	   //query to find distinct values of $attributeName in $tableName
	   $distinctQuery = "SELECT DISTINCT {$attributeName} FROM {$tableName} ORDER BY {$attributeName}";
	      
	   
	   //run the distinctQuery on the database
	   if(!($resultId = mysql_query($distinctQuery, $connection)))
	      showerror();
		
	   //start the select  widget
	   print "\n<select name=\"{$pulldownName}\">";
	   print "\n\t<option selected value='All'>All</option>";
	   
	   //Retrieve each row from the query
	   while($row = @mysql_fetch_array($resultId))
	   {
	      //Get the value of the attribute to be displayed
		  $result = $row[$attributeName];
		  
		  //Check if a default value is set, and if so...
		  //is it the current Database name?
		  if(isset($defaultValue) && $result == $defaultValue)
		      //yes show as selected
			  print "\n\t<option selected value=\"{$result}\">{$result}";
		  else
		      //No just show as an option
			  print "\n\t<option value=\"{$result}\">{$result}";
	   }
	   print "\n</select>";
	}
	
	
/*=================================================================================================================
==================================================================================================================*/			
	
	
	
	function selectDistOrderedUncommented($connection, $tableName, $attributeName, $pulldownName, $defaultValue)
	{
	   $defaultWithinResultSet = FALSE;
	   
	   //query to find distinct values of $attributeName in $tableName
	   $distinctQuery = "SELECT DISTINCT {$attributeName} FROM {$tableName} Where admin_comm like 'none' ORDER BY {$attributeName}";
	      
	   
	   //run the distinctQuery on the database
	   if(!($resultId = mysql_query($distinctQuery, $connection)))
	      showerror();
		
	   //start the select  widget
	   print "\n<select name=\"{$pulldownName}\">";

	   
	   //Retrieve each row from the query
	   while($row = @mysql_fetch_array($resultId))
	   {
	      //Get the value of the attribute to be displayed
		  $result = $row[$attributeName];
		  
		  //Check if a default value is set, and if so...
		  //is it the current Database name?
		  if(isset($defaultValue) && $result == $defaultValue)
		      //yes show as selected
			  print "\n\t<option selected value=\"{$result}\">{$result}";
		  else
		      //No just show as an option
			  print "\n\t<option value=\"{$result}\">{$result}";
	   }
	   print "\n</select>";
	}
	


/*=================================================================================================================
==================================================================================================================*/		

	
	function selectDistOrderedApproved($connection, $tableName, $attributeName, $pulldownName, $defaultValue)
	{
	   $defaultWithinResultSet = FALSE;
	   
	   //query to find distinct values of $attributeName in $tableName
	   $distinctQuery = "SELECT DISTINCT {$attributeName} FROM {$tableName} Where admin_comm not like 'none' ORDER BY {$attributeName}";
	      
	   
	   //run the distinctQuery on the database
	   if(!($resultId = mysql_query($distinctQuery, $connection)))
	      showerror();
		
	   //start the select  widget
	   print "\n<select name=\"{$pulldownName}\">";
	   print "\n<option selected value=\"none\">Approved Enquiries";

	   
	   //Retrieve each row from the query
	   while($row = @mysql_fetch_array($resultId))
	   {
	      //Get the value of the attribute to be displayed
		  $result = $row[$attributeName];
		  
		  //Check if a default value is set, and if so...
		  //is it the current Database name?
		  if(isset($defaultValue) && $result == $defaultValue)
		      //yes show as selected
			  print "\n\t<option selected value=\"{$result}\">{$result}";
		  else
		      //No just show as an option
			  print "\n\t<option value=\"{$result}\">{$result}";
	   }
	   print "\n</select>";
	}


/**************************************************************************************
*
***************************************************************************************/
	function selectList($connection, $tableName, $attributeName, $valueName, $pulldownName, $defaultValue)
	{
	   $defaultWithinResultSet = FALSE;
	   $distinctQuery = "SELECT DISTINCT {$attributeName},$valueName FROM {$tableName}";
	   if(!($resultId = mysql_query($distinctQuery, $connection)))
	      showerror();
	   print "\n<select class=components name=\"{$pulldownName}\">";
     
	   while($row = @mysql_fetch_array($resultId))
	   {
		  $valued = $row[$valueName];
		  $result = $row[$attributeName];
		  
		  //$result2 = $row2["code"];
		  if(isset($defaultValue) && $valued == $defaultValue)
			  print "\n\t<option selected value={$valued}>{$result}</option>";
		  else
			  print "\n\t<option value={$valued}>{$result}</option>";
	   }
	   
	   print "\n</select>";
	}



    // added this one .....................
	function selectListexe($connection, $tableName, $attributeName, $valueName, $pulldownName, $defaultValue)
	{
	   $defaultWithinResultSet = FALSE;
	   $distinctQuery = "SELECT DISTINCT {$attributeName},$valueName FROM {$tableName} where Active='Yes'";
	   if(!($resultId = mysql_query($distinctQuery, $connection)))
	      showerror();
	   print "\n<select class=components name=\"{$pulldownName}\">";
     
	   while($row = @mysql_fetch_array($resultId))
	   {
		  $valued = $row[$valueName];
		  $result = $row[$attributeName];
		  
		  //$result2 = $row2["code"];
		  if(isset($defaultValue) && $valued == $defaultValue)
			  print "\n\t<option selected value={$valued}>{$result}</option>";
		  else
			  print "\n\t<option value={$valued}>{$result}</option>";
	   }
	   
	   print "\n</select>";
	}









	function selectConditionList($connection, $tableName, $attributeName, $valueName, $pulldownName, $defaultValue, $testValue, $target)
	{
	   $defaultWithinResultSet = FALSE;
	   $distinctQuery = "SELECT DISTINCT {$attributeName},$valueName FROM {$tableName} where $testValue like '$target'";
	   if(!($resultId = mysql_query($distinctQuery, $connection)))
	      showerror();
	   print "\n<select class=components name=\"{$pulldownName}\">";
     
	   while($row = @mysql_fetch_array($resultId))
	   {
		  $valued = $row[$valueName];
		  $result = $row[$attributeName];
		  
		  //$result2 = $row2["code"];
		  if(isset($defaultValue) && $valued == $defaultValue)
			  print "\n\t<option selected value='{$valued}'>{$result}</option>";
		  else
			  print "\n\t<option value='{$valued}'>{$result}</option>";
	   }
	   
	   print "\n</select>";
	}
	
	function select3ConditionList($connection, $tableName, $attributeName, $valueName, $pulldownName, $defaultValue, $testValue, $target)
	{
	   $defaultWithinResultSet = FALSE;
	   $distinctQuery = "SELECT DISTINCT {$attributeName},$valueName FROM {$tableName} where ($testValue like '%$target%' 
	   or course2 like '%$target%' or course3 like '%$target%' or course4 like '%$target%' or course5 like '%$target%' 
	   or course6 like '%$target%' or course7 like '%$target%' or course8 like '%$target%' or course9 like '%$target%' 
	   or course10 like '%$target%' or course11 like '%$target%' or course12 like '%$target%' or course13 like '%$target%') 
	   AND (Active like 'Yes')";
	   if(!($resultId = mysql_query($distinctQuery, $connection)))
	      showerror();
	   print "\n<select class=components name=\"{$pulldownName}\">";
     
	   while($row = @mysql_fetch_array($resultId))
	   {
		  $valued = $row[$valueName];
		  $result = $row[$attributeName];
		  
		  //$result2 = $row2["code"];
		  if(isset($defaultValue) && $valued == $defaultValue)
			  print "\n\t<option selected value={$valued}>{$result}</option>";
		  else
			  print "\n\t<option value={$valued}>{$result}</option>";
	   }
	   
	   print "\n</select>";
	}

	
	function selectCampusNumber($connection, $select_name, $defaultValue = '')
	{
	   $defaultWithinResultSet = FALSE;
	   $distinctQuery = "Select DISTINCT code_num FROM a_campus where code_num not like '0' and code not like 'CH' 
	   and code not like 'HeadQtrs' order by code_num ASC";
	   if(!($resultId = mysql_query($distinctQuery, $connection)))
	      showerror();
	   print "\n<select class=components name=\"{$select_name}\">";
     
	   while($row = @mysql_fetch_array($resultId))
	   {
		  $valued = $row['code_num'];
		    
		  if(isset($defaultValue) && $valued == $defaultValue)
			  print "\n\t<option selected value={$valued}>{$valued}</option>";
		  else
			  print "\n\t<option value={$valued}>{$valued}</option>";
	   }
	   
	   print "\n</select>";
	}
	
	function selectCampus($connection, $select_name, $defaultValue = 'CC')
	{
	   $defaultWithinResultSet = FALSE;
	   $distinctQuery = "SELECT DISTINCT name,code,code_num FROM a_campus";
	   if(!($resultId = mysql_query($distinctQuery, $connection)))
	      showerror();
	   print "\n<select class=components name=\"{$select_name}\">";
     
	   while($row = @mysql_fetch_array($resultId))
	   {
		  $num = $row['code_num'];
		  $code = $row['code'];
		  $name = $row['name'];
		    
		  if(isset($defaultValue) && $code == $defaultValue)
			  print "\n\t<option selected value='{$code}'>{$name}</option>";
		  else
			  print "\n\t<option value='{$code}'>{$name}</option>";
	   }
	   
	   print "\n</select>";
	}
	
	
    function selectCampusAll($connection, $select_name, $defaultValue = 'CC')
	{
	   $defaultWithinResultSet = FALSE;
	   $distinctQuery = "SELECT DISTINCT name,code,code_num FROM a_campus";
	   if(!($resultId = mysql_query($distinctQuery, $connection)))
	      showerror();
	   print "\n<select class=components name=\"{$select_name}\">";
       print "\n\t<option value='All'>All Campuses</option>";
		 
	   while($row = @mysql_fetch_array($resultId))
	   {
		  $num = $row['code_num'];
		  $code = $row['code'];
		  $name = $row['name'];
		    
		  if(isset($defaultValue) && $code == $defaultValue)
			  print "\n\t<option selected='selected' value='{$code}'>{$name}</option>";
		  else
			  print "\n\t<option value='{$code}'>{$name}</option>";
	   }
	   
	   print "\n</select>";
	}
	
	
	
	
	
	
	
	
	function selectCampusCodes($connection, $select_name, $defaultValue = 'CC')
	{
	   $defaultWithinResultSet = FALSE;
	   $distinctQuery = "SELECT DISTINCT name,code,code_num FROM a_campus";
	   if(!($resultId = mysql_query($distinctQuery, $connection)))
	      showerror();
	   print "\n<select class=components name=\"{$select_name}\">";
     
	   while($row = @mysql_fetch_array($resultId))
	   {
		  $num = $row['code_num'];
		  $code = $row['code'];
		  $name = $row['name'];
		    
		  if(isset($defaultValue) && $code == $defaultValue)
			  print "\n\t<option selected value='{$num}'>{$num}</option>";
		  else
			  print "\n\t<option value='{$num}'>{$num}</option>";
	   }
	   
	   print "\n</select>";
	}



/*******************************************************************************************/
/********************************************************************************************/

		
		function getTutorName($conn, $t_id)
		{
			$query_tutor = "select * from tutor where t_id like '$t_id'";
			$result_tutor = mysql_query($query_tutor, $conn);
			while($tutor_arr = mysql_fetch_array($result_tutor))
			{
				$tutor_name = $tutor_arr['Name'];
			}
			return $tutor_name;
		}
		
		function getTutorEmail($conn, $t_id)
		{
			$query_tutor = "select * from a_login where t_id like '$t_id'";
			$result_tutor = mysql_query($query_tutor, $conn);
			while($tutor_arr = mysql_fetch_array($result_tutor))
			{
				$tutor_name = $tutor_arr['email'];
			}
			return $tutor_name;
		}
		

		
		
		function getCourseCode($conn, $name)
		{
			$query_tutor = "select * from course where title like '$name'";
			$result_tutor = mysql_query($query_tutor, $conn);
			while($tutor_arr = mysql_fetch_array($result_tutor))
			{
				$code = $tutor_arr['code'];
				return $code;
			}
			return $name;
		}
		
		function getCampusName($conn, $code)
		{
			$query_tutor = "select * from a_campus where code like '$code' or code_num like '$code'";
			//echo $query_tutor;
			$result_tutor = mysql_query($query_tutor, $conn);
			while($tutor_arr = mysql_fetch_array($result_tutor))
			{
				$tutor_name = $tutor_arr['name'];
			}
			return $tutor_name;
		}
		
		function getCampusNum($conn, $code)
		{
			$query_tutor = "select * from a_campus where code like '$code' or code_num like '$code'";
			//echo $query_tutor;
			$result_tutor = mysql_query($query_tutor, $conn);
			while($tutor_arr = mysql_fetch_array($result_tutor))
			{
				$tutor_name = $tutor_arr['code_num'];
			}
			return $tutor_name;
		}
		
		function getCampusEmail($conn, $code)
		{
			$query_tutor = "select * from a_campus where code like '$code' or code_num like '$code'";
			//echo $query_tutor;
			$result_tutor = mysql_query($query_tutor, $conn);
			while($tutor_arr = mysql_fetch_array($result_tutor))
			{
				$tutor_name = $tutor_arr['email'];
			}
			return $tutor_name;
		}
		
		function getStudentUser_id($adm, $link2)
		{
			$check_validity = "select count(*) as found from a_center_studlist where DALCADMIN like '{$adm}'";
			$validity = mysql_query($check_validity, $link2);
			$valid = mysql_fetch_array($validity);
			if($valid['found'] == 0)
			{
				error("This Admission Number Does not Exist in the Database: Update Database if An existing Student.");

			}
			else
			{
				$query2 = "Select user_id from a_center_studlist where DALCADMIN like '{$adm}'";
				$result2 = mysql_query($query2, $link2);
				$result_array2 = mysql_fetch_array($result2);
				$userid = $result_array2['user_id'];
	
				return $userid;
			}
	
		}
		
		function getStudentUseID($adm, $link2)
		{
			$check_validity = "select count(*) as found from a_center_studlist where DALCADMIN like '{$adm}'";
			$validity = mysql_query($check_validity, $link2);
			$valid = mysql_fetch_array($validity);
			if($valid['found'] == 0)
			{
				//error("This Admission Number Does not Exist in the Database: Update Database if An existing Student.");

			}
			else
			{
				$query2 = "Select user_id from a_center_studlist where DALCADMIN like '{$adm}'";
				$result2 = mysql_query($query2, $link2);
				$result_array2 = mysql_fetch_array($result2);
				$userid = $result_array2['user_id'];
	
				return $userid;
			}
		}
		
		function getNextNumber($attrib, $table, $link)
		{
			$getLast = "select $attrib from $table Order By $attrib DESC";
			$lastRes = mysql_query($getLast, $link);
			
			$attrList = mysql_fetch_array($lastRes);
			$last = $attrList[$attrib];
			$new = $last +1;
			return $new;
		}
		
		function getDalcAdmin($user_id, $link2)
		{
			$check_validity = "select count(*) as found from a_center_studlist where user_id like '{$user_id}'";
			$validity = mysql_query($check_validity, $link2);
			$valid = mysql_fetch_array($validity);
			if($valid['found'] == 0)
			{
				error("This Admission Number Does not Exist in the Database: Update Database if An existing Student.");

			}
			else
			{
				$query2 = "Select DALCADMIN from a_center_studlist where user_id like '{$user_id}'";
				$result2 = mysql_query($query2, $link2);
				$result_array2 = mysql_fetch_array($result2);
				$userid = $result_array2['DALCADMIN'];
				return $userid;
			}
		}
		
		function getIntAdmin($user_id, $link2)
		{
			$check_validity = "select count(*) as found from a_center_studlist where user_id like '{$user_id}' or DALCADMIN like '{$user_id}'";
			$validity = mysql_query($check_validity, $link2);
			$valid = mysql_fetch_array($validity);
			if($valid['found'] == 0)
			{
				error("This Admission Number Does not Exist in the Database: Update Database if An existing Student.");

			}
			else
			{
				$query2 = "Select CAMOXADMIN from a_center_studlist where user_id like '{$user_id}' or DALCADMIN like '{$user_id}'";
				$result2 = mysql_query($query2, $link2);
				$result_array2 = mysql_fetch_array($result2);
				$userid = $result_array2['CAMOXADMIN'];
				return $userid;
			}
		}
		

		
		function getStudentCampus($user_id, $link2)
		{
			$check_validity = "select count(*) as found from a_center_studlist where user_id like '{$user_id}' or DALCADMIN like '{$user_id}'";
			$validity = mysql_query($check_validity, $link2);
			$valid = mysql_fetch_array($validity);
			if($valid['found'] == 0)
			{
				error("This Admission Number Does not Exist in the Database: Update Database if An existing Student.");

			}
			else
			{
				$query2 = "Select CENTER from a_center_studlist where user_id like '{$user_id}' or DALCADMIN like '{$user_id}'";
				$result2 = mysql_query($query2, $link2);
				$result_array2 = mysql_fetch_array($result2);
				$userid = $result_array2['CENTER'];
				return $userid;
			}
		}
		
	
	function getUsername($user_id)
	{
		$getuser = "select username from tbl_login where user_id like '$user_id'";
		$result = run_query($getuser);
		if($arr = mysql_fetch_array($result))
		{
			$username = $arr['username'];
		}
		else
		    $username = "none";
		return $username;
	}
		
/**********************************************************************************************************************/
/*TABLE STUDENTS FUNCTIONS
/**********************************************************************************************************************/
		
		
		function addFirst($conn, $table, $adm)
		{
			$query_tutor = "select * from table_students where table_students.table like '$table'";
			//echo $query_tutor;
			$result_tutor = mysql_query($query_tutor, $conn);
			while($tutor_arr = mysql_fetch_array($result_tutor))
			{
				$students_info = $tutor_arr['students'];
			}
			
			$chunks = explode(":",$students_info);
			
			if(count($chunks) > 0)
			   $total = $chunks[0];
			else $total = 0;
			$total = 1;
			$new_info = $total . ":" . $adm;
			
			$update_query = "update table_students set students = '$new_info' where table_students.table like '$table'";
			mysql_query($update_query, $conn);
		}
		
		function addAnother($conn, $table, $adm)
		{
			$query_tutor = "select * from table_students where table_students.table like '$table'";
			//echo $query_tutor;
			$result_tutor = mysql_query($query_tutor, $conn);
			while($tutor_arr = mysql_fetch_array($result_tutor))
			{
				$students_info = $tutor_arr['students'];
			}
			
			$chunks = explode(":",$students_info);
			
			$total = $chunks[0];
			$students = $chunks[1];
			
			$total = $total + 1;
			
			$new_info = $total . ":" . $students . "," . $adm;
			
			$update_query = "update table_students set students = '$new_info' where table_students.table like '$table'";
			mysql_query($update_query, $conn);
		}
		
		function getTotalTableStudents($conn, $table)
		{
			$query_tutor = "select * from table_students where table_students.table like '$table'";
			//echo $query_tutor;
			$result_tutor = mysql_query($query_tutor, $conn);
			while($tutor_arr = mysql_fetch_array($result_tutor))
			{
				$students_info = $tutor_arr['students'];
			}
			$chunks = explode(":",$students_info);
			
			if(count($chunks) > 0)
			   $total = $chunks[0];
			else 
				$total = 0;
			
			return $total;
		}
		
/**********************************************************************************************************************************/	
/*OTHER UTILITY FUNCTIONS
/**********************************************************************************************************************************/	
		function getMonthName($a)
		{
			$month[1] = "January";
			$month[2] = "February";
			$month[3] = "March";
			$month[4] = "April";
			$month[5] = "May";
			$month[6] = "June";
			$month[7] = "July";
			$month[8] = "August";
			$month[9] = "September";
			$month[10] = "October";
			$month[11] = "November";
			$month[12] = "December";
			
			return $month[$a];
		}

		function run_query($query)
		{
			global $conn;
			$result = mysql_query($query, $conn);
			return $result;
		}


		function add_email($target, $subject, $message, $headers,$link)
		{
				$emailbody_stripd = str_replace("</","++-",$message);
				$emailbody_stripd = str_replace("<","--+",$emailbody_stripd);
				$emailbody_stripd = str_replace(">","===",$emailbody_stripd);
				$emailbody_stripd = str_replace("'","???",$emailbody_stripd);
				
				$subject = str_replace("'","z+c",$subject);
				$subject = str_replace('"',"c+z",$subject);
				
				$next = getNextNumber("num","emailer",$link);
				
				$insert_query = "insert into emailer values($next,'$target','$subject','$emailbody_stripd','$headers')";
				mysql_query($insert_query);
				
				
		}

		function getUserTypeName($type_id)
		{
			$getuser = "select usertype_name from tbl_usertype where usertype_id like '$type_id'";
			$result = run_query($getuser);
			if($arr = mysql_fetch_array($result))
			{
				$typename = $arr['usertype_name'];
			}
			else
				$username = "none";
			return $typename;
		}

/***********************************************************************************************************************/

/***********************************************************************************************************************/
function get_assignment_mark($ass_no)
{
	$query = "select mark from a_assingments where ass_no = $ass_no";
	$result = run_query($query);
	if($data_arr = mysql_fetch_array($result))
	{
		$mark = $data_arr['mark'];
		return $mark;
	}
	else
	{
		return 0;
	}
}




function getBudgetDept($code)
{
	$query = "select name from budget_dept where code like '$code'";
	$result = run_query($query);
	$data_arr = mysql_fetch_array($result);
	$posted = trim($data_arr['name']);
	return $posted;
}

function getBudItemName($code)
{
	$query = "select name from bud_item where num like '$code'";
	$result = run_query($query);
	$data_arr = mysql_fetch_array($result);
	$posted = trim($data_arr['name']);
	return $posted;
}

function getTransactUser($conn, $campus) // identify an individual 
{
	$query = "select name from a_login where t_id='$campus'";	
	$result = run_query($query);
	$setts1 = mysql_fetch_array($result);
	$cume = trim($setts1['name']);
	if($cume == '') // null set
		$cume = 'All Centres';
	return $cume;
}


// formats date from sql representation to dd-mm-yyyy 
function formatedDate($date)
{
	$rec = explode("-",$date);
	$newd = ($rec[2].'-'.$rec[1].'-'.$rec[0]);
	return $newd;
}
// formatting the output of a string 
function formatString($passed)
{
	$newstr = "";
	$arr = explode(" ",$passed);
	foreach($arr as $pass)
	{
		if($pass != '') // if not a null string ....
		{
			$ind = (strlen($pass) - 1); // the length of the string .......
			$first = strtoupper(substr($pass,0,1)); // the first letter 
			$rem = strtolower(substr($pass,1,$ind)); // the remaining part of the string  
			$comm = ($first.$rem);
			$newstr.=($comm." "); // join up the string .......			
		}
	} // end of the loop .....
	return $newstr; // the new string ........ 
} // end of the function .......

function getDateDiffdisp($date)
{
	// split the fisrt date ............
	$dpart = explode("-",$date); // lower bound
	$yy = $dpart[0];
	$mm = $dpart[1];
	$dd = $dpart[2];
	// get current time ............  
	$date1 = time(); // upper bound
	$dmake = mktime(0,0,0,$mm,$dd,$yy);
	$dateDiff = ($date1 - $dmake); 
	$days = floor($dateDiff/(60*60*24));  
	return $days;
}

function getDateDiff($date1 , $date2)
{
	// split the fisrt date ............
	$dpart = explode("-",$date1); // lower bound
	$yy = $dpart[0];
	$mm = $dpart[1];
	$dd = $dpart[2];
	// split the second date ..............
	$dpart2 = explode("-",$date2); // upper bound
	$yy2 = $dpart2[0];
	$mm2 = $dpart2[1];
	$dd2 = $dpart2[2];
	// format dates based on the unix timestamp
	$datemake1 = mktime(0,0,0,$mm,$dd,$yy);
	$datemake2 = mktime(0,0,0,$mm2,$dd2,$yy2);	
	$dateDiff = ($datemake2 - $datemake1); 
	$days = floor($dateDiff/(60*60*24));  
	return $days;
}

function addDates($date, $days)
{
	$timeStamp = strtotime($date);
	$timeStamp += 24 * 60 * 60 * $days; // (add days)
	$newdate = date("Y-m-d", $timeStamp);
	return $newdate;
} // end of function .......


function subtractDates($date, $days)
{
	$timeStamp = strtotime($date);
	$timeStamp += (24 * 60 * 60 * -$days); // (subtract days)
	$newdate = date("Y-m-d", $timeStamp);
	return $newdate;
} // end of function .......








?>