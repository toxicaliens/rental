<?php

/* * ************************************************************************
  DATABASE LAYER FUNCTIONS
 * ************************************************************************ */

//include("markets_module/market_library.php");
include("staff_module/staff_library.php");
include("crm_module/crm_library.php");
//include('dashboard_module/dashboard_library.php');
include('users_module/users_library.php');
include('RMC_module/rmc_library.php');

function getColumnValueByColumnId($tablename,$reqcol,$pri,$value)
{
	$query = "SELECT $reqcol FROM ".DATABASE.".$tablename WHERE $pri = $value";
	$data = run_query($query);
	$rows = get_row_data($data);
	$name = trim($rows[$reqcol]);
	return $name;
}

function getColumnValByColumnId($tablename,$reqcol,$pri,$value)
{
	$query = "SELECT $reqcol FROM ".DATABASE.".$tablename WHERE $pri = '$value'";
	$data = run_query($query);
	$rows = get_row_data($data);
	$name = trim($rows[$reqcol]);
	return $name;
}

function get_select_with_selected($table,$id,$name,$selected_id)
{
    $query = run_query("select * from ". $table);
    $select = '';

    while($row =get_row_data($query)){
            if($row[$id]==$selected_id){
                    $selected = 'selected="selected"';
            }else{
                    $selected = '';
            }
            $select.='<option '.$selected.' value="'.$row[$id].'">'.$row[$name].'</option>';
    }
    return $select;
}

function getBillServiceOption($service_id){
    if(!empty($service_id)){
        $query = "SELECT service_option FROM service_channels WHERE service_channel_id = '".$service_id."'";
        $result = run_query($query);
        $rows = get_row_data($result);
        return $rows['service_option'];
    }
}

function sanitizeVariable($var){
    return $var = pg_escape_string(trim($var));
}

function get_last_error(){
    return pg_last_error();
}

 // A function to get column ID  given column name
function getColumnIdByColumnValue($tablename,$id,$col,$colvalue)
{
	$query = "SELECT $id FROM ".DATABASE.".$tablename WHERE $col = '$colvalue'";
	$data = run_query($query);
	$rows = get_row_data($data);
	$idvalue = trim($rows[$id]);
	return $idvalue;
}
function run_query($query) {
    global $conn;
    //$query = "database ori_ebppp; " .  $query;
    $result = pg_query($conn, $query);
    return $result;
}

function get_num_rows($result_set) {
    $result = pg_num_rows($result_set);
    return $result;
}

function get_row_data($result_set) {
    $result = pg_fetch_array($result_set);
    return $result;
}

//to trace activity in a file
function traceActivity($text, $filename) {
    $today = time();
    $today = $today . " | " . date("Y-m-d H:i:s");

    $myFile = 'logs/log'.date('Y-m-d').'.txt';
//    $fh = fopen($myFile, 'a');
//
//    fwrite($fh, $today . "==" . $text . "\n");
//    fclose($fh);
}

function getPricipalName($afyapoa_id){
    $query = "SELECT CONCAT(c.surname,' ',c.firstname,' ',c.middlename) AS pricipal_name FROM afyapoa_file af
    LEFT JOIN customers c ON c.customer_id = af.customer_id 
    WHERE afyapoa_id = '".$afyapoa_id."'";
    $result = run_query($query);
    $rows = get_row_data($result);
    return $rows['pricipal_name'];
}

function selectDistinct($tableName, $attributeName, $pulldownName, $defaultValue, $displayValue='none') {
    $defaultWithinResultSet = FALSE;

    //query to find distinct values of $attributeName in $tableName
    if (!($distinctQuery = "SELECT * FROM " . DATABASE . ".{$tableName} ORDER BY {$attributeName} ASC"))
        die("you are wasted");

    //run the distinctQuery on the database
    //$resultId = run_query($distinctQuery);
    if (!($resultId = run_query($distinctQuery)))
        showerror();

    //start the select  widget
    print "\n<select style='background:#0000FF; color:#FFFFFF; font-size:11px; border:solid' name=\"{$pulldownName}\">";


    //Retrieve each row from the query
    while ($row = get_row_data($resultId)) {
        //Get the value of the attribute to be displayed
        $result = $row[$attributeName];
        if ($displayValue != 'none')
            $label = $result . " - " . $row[$displayValue];
        else
            $label = $result;
        //Check if a default value is set, and if so...
        //is it the current Database name?
        if (isset($defaultValue) && $result == $defaultValue)
        //yes show as selected
            print "\n\t<option selected value=\"{$result}\">{$label}";
        else
        //No just show as an option
            print "\n\t<option value=\"{$result}\">{$label}";
    }
    print "\n</select>";
}

//to get the values from look ups
//Query the table with input return output/value
function getlabel($input, $tablename, $identifyingfield, $diplayingfield) {
    if ($input == NULL) {
        $result = "Undefined";
    } else {
        $query = "select * from " . $tablename . " where " . $identifyingfield . " = '" . $input . "' ";
        $rs = run_query($query);
        $rslt = get_num_rows($rs);
        if ($rslt1 != 0) {
            $result = "Undefined";
        } else {
            $value = get_row_data($rs);
            $result = $value[$diplayingfield];
        }
    }
    return $result;
}

function showerror() {
    //die("Error " . mysql_errno() . " . " . mysql_error());
}

/* * *********************************************************************** */

function formatMoney($number, $fractional=false) {
    if ($fractional) {
        $number = sprintf('%.2f', $number);
    }
    while (true) {
        $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
        if ($replaced != $number) {
            $number = $replaced;
        } else {
            break;
        }
    }
    return $number;
}

function show_action_message($message) {
    $content = "<div style='background-color:#E6E6E6; height:50px;'>

					<div style='float:left;padding:1px;'>
						<img align='left' src='done.png' width='45' height='47' />
					</div>

					<div align='left' style='float:left; margin-left:5px;
											 padding-top:20px; color: #F28914; font-weight: bold; font-size: 14px;'>
						" . $message . "
					</div>
    			</div>";

    echo $content;
}

function getnextID($table, $col, $default) {
    $fit = "SELECT max($col) as amax FROM $table";
    $fitter = run_query($fit);
    $mobett = get_row_data($fitter);
    $top = $mobett['amax'];
    if ($top == "")
        $thenum = $default;
    else
        $thenum = ($top + 1);
    return $thenum;
}

function getnextCode($table, $col, $cond1, $cond2, $default) {
    $fit = "SELECT max($col) as amax FROM $table where $cond1 like '$cond2'";
    $fitter = run_query($fit);
    $mobett = get_row_data($fitter);
    $top = $mobett['amax'];
    if ($top == "")
        $thenum = $default;
    else
        $thenum = ($top + 1);
    return $thenum;
}

function logActivity($user, $activity, $module) {
    date_default_timezone_set('Africa/Nairobi');
    $today = date("Y-m-d");
    $now = time() . "*" . date('H:i:s');

    $fit = "INSERT INTO ori_ebppp.activitylog (userid,module,activity,date,time)
				VALUES ('$user','$module','$activity','$today','$now')";
    run_query($fit);
}

function ShortenText($text, $size="100") {
    // Change to the number of characters you want to display
    $chars = $size;
    $text = $text . " ";
    $text = substr($text, 0, $chars);
    $text = substr($text, 0, strrpos($text, ' '));
    $text = $text . "...";
    return $text;
}

/* function to get a system setting from the settings table */

function getAPISetting($item) {
    $sql = "select setting from tbl_settings where item like '$item'";
    $result = run_query($sql);
    $arr = get_row_data($result);
    return $arr['setting'];
}

/* function to update a setting on the settings table */

function updateAPISetting($item, $setting) {
    $sql = "update tbl_settings set setting = '$setting' where item like '$item'";
    $result = run_query($sql);
}

/* function to add a notice */

function addAPINotice($title, $notice) {
    $today = date("Y-m-d");
    $sql = "insert into tbl_notices (title,notice,creation_date) values('$title','$notice','$today')";
    $result = run_query($sql);
}

/* * ****************************************************************************************** */

function getTransactionTypeName($one) {
    $query = "SELECT title FROM ori_ebppp.transaction_types WHERE id = '$one'";
    $data = run_query($query);
    $rows = get_row_data($data);
    $name = trim($rows['title']);
    return $name;
}

function number_words($number) {
    if (($number < 0) || ($number > 9999999999)) {
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

    if ($Bn) {
        $res .= number_words($Bn) . " Billion, ";
    }


    if ($Gn) {
        $res .= number_words($Gn) . " Million, ";
    }

    if ($kn) {
        $res .= (empty($res) ? "" : " ") .
                number_words($kn) . " Thousand";
    }

    if ($Hn) {
        $res .= (empty($res) ? "" : " ") .
                number_words($Hn) . " Hundred";
    }

    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen",
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen", "Nineteen");
    $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", "Seventy", "Eighty", "Ninety");

    if ($Dn || $n) {
        if (!empty($res)) {
            $res .= " and ";
        }

        if ($Dn < 2) {
            $res .= $ones[$Dn * 10 + $n];
        } else {
            $res .= $tens[$Dn];

            if ($n) {
                $res .= "-" . $ones[$n];
            }
        }
    }

    if (empty($res)) {
        $res = "zero";
    }

    return $res;
}

// formats date from sql representation to dd-mm-yyyy
function formatDate($date) {
    $rec = explode("-", $date);
    $newd = ($rec[2] . '-' . $rec[1] . '-' . $rec[0]);
    return $newd;
}

// formatting the output of a string
function formatStr($passed) {
    $newstr = "";
    $arr = explode(" ", $passed);
    foreach ($arr as $pass) {
        if ($pass != '') { // if not a null string ....
            $ind = (strlen($pass) - 1); // the length of the string .......
            $first = strtoupper(substr($pass, 0, 1)); // the first letter
            $rem = strtolower(substr($pass, 1, $ind)); // the remaining part of the string
            $comm = ($first . $rem);
            $newstr.=($comm . " "); // join up the string .......
        }
    } // end of the loop .....
    return $newstr; // the new string ........
}

// end of the function .......

function WriteContactsXML() {
    $myFile = "contacts_list.xml";
    $fh = fopen($myFile, 'w');
    $dataline = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n\n<contacts>\n";
    fwrite($fh, $dataline);
    $all_prods = run_query("Select firstname,middlename,lastname,user_id,adm_no from tbl_studlist Order By firstname ASC");
    while ($array = get_row_data($all_prods)) {
        $name = $array['firstname'] . " " . $array['middlename'];
        $lastname = $array['lastname'];
        $all_names = $name . " " . $lastname;
        $code = $array['adm_no'];
        $dataline = "<contact>\n" .
                "<name>" . $name . "</name>\n" .
                "<number>" . $lastname . "</number>\n" .
                "<code>" . $code . "</code>\n" .
                "<string>" . $code . " " . $all_names . "</string>\n" .
                "</contact>\n";
        fwrite($fh, $dataline);
    }
    fwrite($fh, "</contacts>");
    fclose($fh);
}

function getStudentParent($one) {
    //echo("getting parent");
    $query = "SELECT * FROM tbl_studlist WHERE adm_no = '$one'";
    //echo($query);
    logActivity($_SESSION['user_id'], "QUERY:" . $query, "MEMBERSHIP");
    $data = run_query($query);
    $rows = get_row_data($data);


    return $rows['parent'];
}

function getStudentParentByID($one) {
    //echo("getting parent");
    $query = "SELECT * FROM tbl_studlist WHERE user_id = '$one'";
    //echo($query);
    logActivity($_SESSION['user_id'], "QUERY:" . $query, "MEMBERSHIP");
    $data = run_query($query);
    $rows = get_row_data($data);


    return $rows['parent'];
}

function getStudentGrandParent($one) {
    $query = "SELECT grandparent FROM ori_ebppp.tbl_studlist WHERE adm_no like '$one'";
    $data = run_query($query);
    $rows = get_row_data($data);
    return $rows['grandparent'];
}

function getStudentGrandParentByID($one) {
    $query = "SELECT grandparent FROM ori_ebppp.tbl_studlist WHERE user_id like '$one'";
    $data = run_query($query);
    $rows = get_row_data($data);
    return $rows['grandparent'];
}

function getStudentFirstName($one) {
    $query = "SELECT firstname FROM ori_ebppp.tbl_studlist WHERE adm_no like '$one'";
    $data = run_query($query);
    $rows = get_row_data($data);
    $name = $rows['firstname'];
    return $name;
}

function getStudentLastName($one) {
    $query = "SELECT lastname FROM ori_ebppp.tbl_studlist WHERE adm_no like '$one'";
    $data = run_query($query);
    $rows = get_row_data($data);
    $name = $rows['lastname'];
    return $name;
}

function viewAllocatedActions($view_id, $action_id, $role_id){     
    $query = "SELECT * FROM sys_role_view_actions_allocations WHERE      
    sys_role_views_id = '$view_id' and sys_action_id = '$action_id' and sys_role_id = '$role_id'";     
    $data = run_query($query);     
    $num_row = get_num_rows($data);     
    if($num_row){         
        return true;    
    }else{
        return false;     
    } 
}

//enforce roles
function getCurrentUserRoleId($user_name){

    $result = run_query("SELECT * FROM user_login WHERE username = '".$user_name."'");
    while($row = get_row_data($result)){

        return $row['user_role'];

    }

}

function getStudentName($one) {
    $query = "SELECT firstname, lastname FROM ori_ebppp.tbl_studlist WHERE adm_no like '$one' or user_id like '$one'";
    $data = run_query($query);
    $rows = get_row_data($data);
    $name = trim($rows['lastname']) . ' ' . trim($rows['middlename']) . ' ' . trim($rows['firstname']);
    return $name;
}

function getStudentName2($one) {
    $query = "SELECT firstname, lastname FROM ori_ebppp.tbl_studlist WHERE user_id like '$one'";
    $data = run_query($query);
    $rows = get_row_data($data);
    $name = trim($rows['lastname']) . ' ' . trim($rows['middlename']) . ' ' . trim($rows['firstname']);
    return $name;
}

function getStudentCourse($one) {
    $query = "SELECT course FROM tbl_studlist WHERE user_id like '$one'";
    $data = run_query($query);
    $rows = get_row_data($data);
    $name = trim($rows['course']);
    return $name;
}

function getStudUserID($one) {
    $query = "SELECT user_id FROM tbl_studlist WHERE adm_no like '$one'";
    $data = run_query($query);
    $rows = get_row_data($data);
    $name = trim($rows['user_id']);
    return $name;
}

function getCourseName($code) {
    $query_tutor = "select * from tbl_courses where code like '$code' or num like '$code'";
    $result_tutor = run_query($query_tutor);
    while ($tutor_arr = get_row_data($result_tutor)) {
        $tutor_name = $tutor_arr['title'];
        return $tutor_name;
    }
    return $code;
}

function getModuleName($code) {
    $query_module = "select * from tbl_modules where code like '$code' or num like '$code'";
    $result_module = run_query($query_module);
    while ($module_arr = get_row_data($result_module)) {
        $module_name = $module_arr['title'];
    }
    return $module_name;
}

function getModuleCode($code) {
    $query_module = "select * from tbl_modules where num like '$code'";
    $result_module = run_query($query_module);
    while ($module_arr = get_row_data($result_module)) {
        $module_name = $module_arr['code'];
    }
    return $module_name;
}

function getModulePoints($code) {
    $query_module = "select * from tbl_modules where code like '$code'";
    $result_module = run_query($query_module);
    while ($module_arr = get_row_data($result_module)) {
        $points = $module_arr['cr_points'];
    }
    return $points;
}

function computeGrade($smark) {
    if ($smark >= 0 && $smark <= 39)
        $grade = "E";
    else if ($smark >= 40 && $smark <= 49)
        $grade = "D";
    else if ($smark >= 50 && $smark <= 59)
        $grade = "C";
    else if ($smark >= 60 && $smark <= 69)
        $grade = "B";
    else if ($smark >= 70 && $smark <= 100)
        $grade = "A";
    return $grade;
}

function computeGradepoint($grade) {
    if ($grade == "A")
        $gpoint = 4;
    else if ($grade == "B")
        $gpoint = 3;
    else if ($grade == "C")
        $gpoint = 2;
    else if ($grade == "D")
        $gpoint = 1;
    else if ($grade == "E")
        $gpoint = 0;
    return $gpoint;
}

function computeOverallGrade($gpa) {
    if ($gpa >= 3.5 && $gpa <= 4)
        $grade = "Distinction";
    else if ($gpa >= 3 && $gpa <= 3.49)
        $grade = "Merit";
    else if ($gpa >= 2 && $gpa <= 2.99)
        $grade = "Pass";
    return $grade;
}

function getStudentID($one) {
    $query = "SELECT adm_no FROM tbl_studlist WHERE user_id like '$one'";
    $data = run_query($query);
    $rows = get_row_data($data);
    $name = trim($rows['adm_no']);
    return $name;
}

/* =================================================================================================================
  ================================================================================================================== */

function selectCourses($connection, $tableName, $attributeName, $pulldownName, $defaultValue) {
    $defaultWithinResultSet = FALSE;

    //query to find distinct values of $attributeName in $tableName
    $distinctQuery = "SELECT DISTINCT {$attributeName} FROM {$tableName}";
    //die("you are wasted");

    $distinctQuery2 = "SELECT DISTINCT code FROM {tableName}";

    //run the distinctQuery on the database
    if (!($resultId = pg_query($distinctQuery, $connection)))
        showerror();

    $resultId2 = pg_query($distinctQuery2, $connection);

    //start the select  widget
    print "\n<select name=\"{$pulldownName}\">";


    //Retrieve each row from the query
    while ($row = @get_row_data($resultId) && $row2 = @get_row_data($resultId2)) {
        //Get the value of the attribute to be displayed
        $result = $row[$attributeName];
        $result2 = $row2["code"];

        //Check if a default value is set, and if so...
        //is it the current Database name?
        if (isset($defaultValue) && $result == $defaultValue)
        //yes show as selected
            print "\n\t<option selected value=\"{$result2}\">{$result}";
        else
        //No just show as an option
            print "\n\t<option value=\"{$result2}\">{$result}";
    }
    print "\n</select>";
}

/* =================================================================================================================
  ================================================================================================================== */

function selectCourseCodes($connection, $tableName, $defaultValue) {
    $defaultWithinResultSet = FALSE;
    $pulldownName = "course_code";
    //$defaultValue = "Select Course";

    $unwanted = " where code not like 'ADM' and code not like 'COSYLLB' and code not like 'CAL5EADD' and code not like 'PGDADD' and code not like 'ADD' and code not like 'CAL4EADD' and code not like 'CAL4COPT' and code not like 'CAL4CADD' and code not like 'CAL5MOP' and code not like 'CAL4MOPT' and code not like 'CAL5CADD' Order By title ASC";

    //query to find distinct values of $attributeName in $tableName
    if (!($distinctQuery = "SELECT code, title FROM {$tableName}"))
        die("you are wasted");

    // $distinctQuery2 = "SELECT DISTINCT code FROM {tableName}";
    $distinctQuery .= $unwanted;
    //run the distinctQuery on the database
    if (!($resultId = pg_query($distinctQuery, $connection)))
        showerror();

    //$resultId2 = pg_query($distinctQuery2, $connection);
    //start the select  widget
    print "\n<select style=\"font-size:11px;\"name=\"{$pulldownName}\">";

    $count = 0;
    //Retrieve each row from the query
    while ($row = @pg_fetch_row($resultId)) {
        //Get the value of the attribute to be displayed
        foreach ($row as $datas) {
            if ($count == 0)
                $result2 = $datas;
            else
                $result = $datas;

            $count++;
            if ($count > 1)
                break;
        }
        //Check if a default value is set, and if so...
        //is it the current Database name?
        if (isset($defaultValue) && $result == $defaultValue)
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

/* =================================================================================================================
  ================================================================================================================== */

function selectDistOrdered($connection, $tableName, $attributeName, $pulldownName, $defaultValue) {
    $defaultWithinResultSet = FALSE;

    //query to find distinct values of $attributeName in $tableName
    $distinctQuery = "SELECT DISTINCT {$attributeName} FROM {$tableName} ORDER BY {$attributeName}";


    //run the distinctQuery on the database
    if (!($resultId = pg_query($distinctQuery, $connection)))
        showerror();

    //start the select  widget
    print "\n<select name=\"{$pulldownName}\">";


    //Retrieve each row from the query
    while ($row = @get_row_data($resultId)) {
        //Get the value of the attribute to be displayed
        $result = $row[$attributeName];

        //Check if a default value is set, and if so...
        //is it the current Database name?
        if (isset($defaultValue) && $result == $defaultValue)
        //yes show as selected
            print "\n\t<option selected value=\"{$result}\">{$result}";
        else
        //No just show as an option
            print "\n\t<option value=\"{$result}\">{$result}";
    }
    print "\n</select>";
}

function selectDistOrderedTarget($connection, $tableName, $attributeName, $pulldownName, $defaultValue) {
    $defaultWithinResultSet = FALSE;

    //query to find distinct values of $attributeName in $tableName
    $distinctQuery = "SELECT DISTINCT {$attributeName} FROM {$tableName} ORDER BY {$attributeName}";


    //run the distinctQuery on the database
    if (!($resultId = pg_query($distinctQuery, $connection)))
        showerror();

    //start the select  widget
    print "\n<select name=\"{$pulldownName}\">";
    print "\n\t<option selected value='All'>All</option>";

    //Retrieve each row from the query
    while ($row = @get_row_data($resultId)) {
        //Get the value of the attribute to be displayed
        $result = $row[$attributeName];

        //Check if a default value is set, and if so...
        //is it the current Database name?
        if (isset($defaultValue) && $result == $defaultValue)
        //yes show as selected
            print "\n\t<option selected value=\"{$result}\">{$result}";
        else
        //No just show as an option
            print "\n\t<option value=\"{$result}\">{$result}";
    }
    print "\n</select>";
}

/* =================================================================================================================
  ================================================================================================================== */

function selectDistOrderedUncommented($connection, $tableName, $attributeName, $pulldownName, $defaultValue) {
    $defaultWithinResultSet = FALSE;

    //query to find distinct values of $attributeName in $tableName
    $distinctQuery = "SELECT DISTINCT {$attributeName} FROM {$tableName} Where admin_comm like 'none' ORDER BY {$attributeName}";


    //run the distinctQuery on the database
    if (!($resultId = pg_query($distinctQuery, $connection)))
        showerror();

    //start the select  widget
    print "\n<select name=\"{$pulldownName}\">";


    //Retrieve each row from the query
    while ($row = @get_row_data($resultId)) {
        //Get the value of the attribute to be displayed
        $result = $row[$attributeName];

        //Check if a default value is set, and if so...
        //is it the current Database name?
        if (isset($defaultValue) && $result == $defaultValue)
        //yes show as selected
            print "\n\t<option selected value=\"{$result}\">{$result}";
        else
        //No just show as an option
            print "\n\t<option value=\"{$result}\">{$result}";
    }
    print "\n</select>";
}

/* =================================================================================================================
  ================================================================================================================== */

function selectDistOrderedApproved($connection, $tableName, $attributeName, $pulldownName, $defaultValue) {
    $defaultWithinResultSet = FALSE;

    //query to find distinct values of $attributeName in $tableName
    $distinctQuery = "SELECT DISTINCT {$attributeName} FROM {$tableName} Where admin_comm not like 'none' ORDER BY {$attributeName}";


    //run the distinctQuery on the database
    if (!($resultId = pg_query($distinctQuery, $connection)))
        showerror();

    //start the select  widget
    print "\n<select name=\"{$pulldownName}\">";
    print "\n<option selected value=\"none\">Approved Enquiries";


    //Retrieve each row from the query
    while ($row = @get_row_data($resultId)) {
        //Get the value of the attribute to be displayed
        $result = $row[$attributeName];

        //Check if a default value is set, and if so...
        //is it the current Database name?
        if (isset($defaultValue) && $result == $defaultValue)
        //yes show as selected
            print "\n\t<option selected value=\"{$result}\">{$result}";
        else
        //No just show as an option
            print "\n\t<option value=\"{$result}\">{$result}";
    }
    print "\n</select>";
}

/* * ************************************************************************************
 *
 * ************************************************************************************* */

function selectList($connection, $tableName, $attributeName, $valueName, $pulldownName, $defaultValue) {
    $defaultWithinResultSet = FALSE;
    $distinctQuery = "SELECT DISTINCT {$attributeName},$valueName FROM {$tableName}";
    if (!($resultId = pg_query($distinctQuery, $connection)))
        showerror();
    print "\n<select class=components name=\"{$pulldownName}\">";

    while ($row = @get_row_data($resultId)) {
        $valued = $row[$valueName];
        $result = $row[$attributeName];

        //$result2 = $row2["code"];
        if (isset($defaultValue) && $valued == $defaultValue)
            print "\n\t<option selected value={$valued}>{$result}</option>";
        else
            print "\n\t<option value={$valued}>{$result}</option>";
    }

    print "\n</select>";
}

// added this one .....................
function selectListexe($connection, $tableName, $attributeName, $valueName, $pulldownName, $defaultValue) {
    $defaultWithinResultSet = FALSE;
    $distinctQuery = "SELECT DISTINCT {$attributeName},$valueName FROM {$tableName} where Active='Yes'";
    if (!($resultId = pg_query($distinctQuery, $connection)))
        showerror();
    print "\n<select class=components name=\"{$pulldownName}\">";

    while ($row = @get_row_data($resultId)) {
        $valued = $row[$valueName];
        $result = $row[$attributeName];

        //$result2 = $row2["code"];
        if (isset($defaultValue) && $valued == $defaultValue)
            print "\n\t<option selected value={$valued}>{$result}</option>";
        else
            print "\n\t<option value={$valued}>{$result}</option>";
    }

    print "\n</select>";
}

function selectConditionList($connection, $tableName, $attributeName, $valueName, $pulldownName, $defaultValue, $testValue, $target) {
    $defaultWithinResultSet = FALSE;
    $distinctQuery = "SELECT DISTINCT {$attributeName},$valueName FROM {$tableName} where $testValue like '$target'";
    if (!($resultId = pg_query($distinctQuery, $connection)))
        showerror();
    print "\n<select class=components name=\"{$pulldownName}\">";

    while ($row = @get_row_data($resultId)) {
        $valued = $row[$valueName];
        $result = $row[$attributeName];

        //$result2 = $row2["code"];
        if (isset($defaultValue) && $valued == $defaultValue)
            print "\n\t<option selected value='{$valued}'>{$result}</option>";
        else
            print "\n\t<option value='{$valued}'>{$result}</option>";
    }

    print "\n</select>";
}

function select3ConditionList($connection, $tableName, $attributeName, $valueName, $pulldownName, $defaultValue, $testValue, $target) {
    $defaultWithinResultSet = FALSE;
    $distinctQuery = "SELECT DISTINCT {$attributeName},$valueName FROM {$tableName} where ($testValue like '%$target%'
	   or course2 like '%$target%' or course3 like '%$target%' or course4 like '%$target%' or course5 like '%$target%'
	   or course6 like '%$target%' or course7 like '%$target%' or course8 like '%$target%' or course9 like '%$target%'
	   or course10 like '%$target%' or course11 like '%$target%' or course12 like '%$target%' or course13 like '%$target%')
	   AND (Active like 'Yes')";
    if (!($resultId = pg_query($distinctQuery, $connection)))
        showerror();
    print "\n<select class=components name=\"{$pulldownName}\">";

    while ($row = @get_row_data($resultId)) {
        $valued = $row[$valueName];
        $result = $row[$attributeName];

        //$result2 = $row2["code"];
        if (isset($defaultValue) && $valued == $defaultValue)
            print "\n\t<option selected value={$valued}>{$result}</option>";
        else
            print "\n\t<option value={$valued}>{$result}</option>";
    }

    print "\n</select>";
}

function getStudentUser_id($adm, $link2) {
    $check_validity = "select count(*) as found from a_center_studlist where DALCADMIN like '{$adm}'";
    $validity = pg_query($check_validity, $link2);
    $valid = get_row_data($validity);
    if ($valid['found'] == 0) {
        error("This Admission Number Does not Exist in the Database: Update Database if An existing Student.");
    } else {
        $query2 = "Select user_id from a_center_studlist where DALCADMIN like '{$adm}'";
        $result2 = pg_query($query2, $link2);
        $result_array2 = get_row_data($result2);
        $userid = $result_array2['user_id'];

        return $userid;
    }
}

function getNextNumber($attrib, $table, $link) {
    $getLast = "select $attrib from $table Order By $attrib DESC";
    $lastRes = pg_query($getLast, $link);

    $attrList = get_row_data($lastRes);
    $last = $attrList[$attrib];
    $new = $last + 1;
    return $new;
}

function getUsername($user_id) {
    $getuser = "select username from tbl_login where user_id like '$user_id'";
    $result = run_query($getuser);
    if ($arr = get_row_data($result)) {
        $username = $arr['username'];
    }
    else
        $username = "none";
    return $username;
}

/* * ******************************************************************************************************************* */
/* TABLE STUDENTS FUNCTIONS
  /********************************************************************************************************************* */

function addFirst($conn, $table, $adm) {
    $query_tutor = "select * from table_students where table_students.table like '$table'";
    //echo $query_tutor;
    $result_tutor = pg_query($query_tutor, $conn);
    while ($tutor_arr = get_row_data($result_tutor)) {
        $students_info = $tutor_arr['students'];
    }

    $chunks = explode(":", $students_info);

    if (count($chunks) > 0)
        $total = $chunks[0];
    else
        $total = 0;
    $total = 1;
    $new_info = $total . ":" . $adm;

    $update_query = "update table_students set students = '$new_info' where table_students.table like '$table'";
    pg_query($update_query, $conn);
}

function addAnother($conn, $table, $adm) {
    $query_tutor = "select * from table_students where table_students.table like '$table'";
    //echo $query_tutor;
    $result_tutor = pg_query($query_tutor, $conn);
    while ($tutor_arr = get_row_data($result_tutor)) {
        $students_info = $tutor_arr['students'];
    }

    $chunks = explode(":", $students_info);

    $total = $chunks[0];
    $students = $chunks[1];

    $total = $total + 1;

    $new_info = $total . ":" . $students . "," . $adm;

    $update_query = "update table_students set students = '$new_info' where table_students.table like '$table'";
    pg_query($update_query, $conn);
}

function getTotalTableStudents($conn, $table) {
    $query_tutor = "select * from table_students where table_students.table like '$table'";
    //echo $query_tutor;
    $result_tutor = pg_query($query_tutor, $conn);
    while ($tutor_arr = get_row_data($result_tutor)) {
        $students_info = $tutor_arr['students'];
    }
    $chunks = explode(":", $students_info);

    if (count($chunks) > 0)
        $total = $chunks[0];
    else
        $total = 0;

    return $total;
}

/* * ******************************************************************************************************************************* */
/* OTHER UTILITY FUNCTIONS
  /********************************************************************************************************************************* */

function getMonthName($a) {
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

function add_email($target, $subject, $message, $headers, $link) {
    $emailbody_stripd = str_replace("</", "++-", $message);
    $emailbody_stripd = str_replace("<", "--+", $emailbody_stripd);
    $emailbody_stripd = str_replace(">", "===", $emailbody_stripd);
    $emailbody_stripd = str_replace("'", "???", $emailbody_stripd);

    $subject = str_replace("'", "z+c", $subject);
    $subject = str_replace('"', "c+z", $subject);

    $next = getNextNumber("num", "emailer", $link);

    $insert_query = "insert into emailer values($next,'$target','$subject','$emailbody_stripd','$headers')";
    pg_query($insert_query);
}

function getUserTypeName($type_id) {
    $getuser = "select usertype_name from tbl_usertype where usertype_id like '$type_id'";
    $result = run_query($getuser);
    if ($arr = get_row_data($result)) {
        $typename = $arr['usertype_name'];
    }
    else
        $username = "none";
    return $typename;
}

function getSysUserName($id) {
    $getuser = "select username from tbl_login where user_id like '$id'";
    $result = run_query($getuser);
    if ($arr = get_row_data($result)) {
        $typename = $arr['username'];
    }
    else
        $typename = "none";
    return $typename;
}

/* * ******************************************************************************************************************** */

/* * ******************************************************************************************************************** */

function get_assignment_mark($ass_no) {
    $query = "select mark from a_assingments where ass_no = $ass_no";
    $result = run_query($query);
    if ($data_arr = get_row_data($result)) {
        $mark = $data_arr['mark'];
        return $mark;
    } else {
        return 0;
    }
}

function getBudgetDept($code) {
    $query = "select name from budget_dept where code like '$code'";
    $result = run_query($query);
    $data_arr = get_row_data($result);
    $posted = trim($data_arr['name']);
    return $posted;
}

function getBudItemName($code) {
    $query = "select name from bud_item where num like '$code'";
    $result = run_query($query);
    $data_arr = get_row_data($result);
    $posted = trim($data_arr['name']);
    return $posted;
}

function getTransactUser($conn, $campus) { // identify an individual
    $query = "select name from a_login where t_id='$campus'";
    $result = run_query($query);
    $setts1 = get_row_data($result);
    $cume = trim($setts1['name']);
    if ($cume == '') // null set
        $cume = 'All Centres';
    return $cume;
}

// formats date from sql representation to dd-mm-yyyy
function formatedDate($date) {
    $rec = explode("-", $date);
    $newd = ($rec[2] . '-' . $rec[1] . '-' . $rec[0]);
    return $newd;
}

// formatting the output of a string
function formatString($passed) {
    $newstr = "";
    $arr = explode(" ", $passed);
    foreach ($arr as $pass) {
        if ($pass != '') { // if not a null string ....
            $ind = (strlen($pass) - 1); // the length of the string .......
            $first = strtoupper(substr($pass, 0, 1)); // the first letter
            $rem = strtolower(substr($pass, 1, $ind)); // the remaining part of the string
            $comm = ($first . $rem);
            $newstr.=($comm . " "); // join up the string .......
        }
    } // end of the loop .....
    return $newstr; // the new string ........
}

// end of the function .......

function getDateDiffdisp($date) {
    // split the fisrt date ............
    $dpart = explode("-", $date); // lower bound
    $yy = $dpart[0];
    $mm = $dpart[1];
    $dd = $dpart[2];
    // get current time ............
    $date1 = time(); // upper bound
    $dmake = mktime(0, 0, 0, $mm, $dd, $yy);
    $dateDiff = ($date1 - $dmake);
    $days = floor($dateDiff / (60 * 60 * 24));
    return $days;
}

function getDateDiff($date1, $date2) {
    // split the fisrt date ............
    $dpart = explode("-", $date1); // lower bound
    $yy = $dpart[0];
    $mm = $dpart[1];
    $dd = $dpart[2];
    // split the second date ..............
    $dpart2 = explode("-", $date2); // upper bound
    $yy2 = $dpart2[0];
    $mm2 = $dpart2[1];
    $dd2 = $dpart2[2];
    // format dates based on the unix timestamp
    $datemake1 = mktime(0, 0, 0, $mm, $dd, $yy);
    $datemake2 = mktime(0, 0, 0, $mm2, $dd2, $yy2);
    $dateDiff = ($datemake2 - $datemake1);
    $days = floor($dateDiff / (60 * 60 * 24));
    return $days;
}

function addDates($date, $days) {
    $timeStamp = strtotime($date);
    $timeStamp += 24 * 60 * 60 * $days; // (add days)
    $newdate = date("Y-m-d", $timeStamp);
    return $newdate;
}

// end of function .......

function subtractDates($date, $days) {
    $timeStamp = strtotime($date);
    $timeStamp += (24 * 60 * 60 * -$days); // (subtract days)
    $newdate = date("Y-m-d", $timeStamp);
    return $newdate;
}

// end of function .......

function time_duration($seconds, $use = null, $zeros = false) {
    // Define time periods
    $periods = array(
        'yrs' => 31556926,
        'Months' => 2629743,
        'wks' => 604800,
        'days' => 86400,
        'hrs' => 3600,
        'mins' => 60,
        'secs' => 1
    );

    // Break into periods
    $seconds = (float) $seconds;
    foreach ($periods as $period => $value) {
        if ($use && strpos($use, $period[0]) === false) {
            continue;
        }
        $count = floor($seconds / $value);
        if ($count == 0 && !$zeros) {
            continue;
        }
        $segments[strtolower($period)] = $count;
        $seconds = $seconds % $value;
    }

    // Build the string
    foreach ($segments as $key => $value) {
        $segment_name = substr($key, 0, -1);
        $segment = $value . ' ' . $segment_name;
        if ($value != 1) {
            $segment .= 's';
        }
        $array[] = $segment;
    }

    $str = implode(', ', $array);
    return $str;
}

//FUNCTIONS TO GET ORDER DETAILS...
function getTotalItemsInOrder($orderid) {
    $query = "SELECT SUM(products_quantity) as total
				FROM orders_products
				WHERE orders_id = '$orderid'";
    $result = pg_query($query);
    if ($arrar = get_row_data($result)) {
        $total = $arrar['total'];
    }
    return $total;
}

function getOrderEntries($orderid) {
    $query = "SELECT *
				 FROM orders_products
				 WHERE orders_id = '$orderid'";
    $result = pg_query($query);
    return $result;
}

function getOrderDate($orderid) {
    $query = "SELECT date_purchased
				 FROM orders
				 WHERE orders_id = '$orderid'";
    $result = pg_query($query);
    $arr = get_row_data($result);
    $date = $arr["date_purchased"];
    return $date;
}

function getOrderCompletionDate($orderid) {
    $query = "SELECT stamp_completedate
				 FROM orders
				 WHERE orders_id = '$orderid'";
    $result = pg_query($query);
    $arr = get_row_data($result);
    $stamp = $arr["stamp_completedate"];

    $date = date("Y-m-d", $stamp);
    return $date;
}

function isExempt($id) {
    $query = "select * from tbl_studlist where user_id= '$id'";
    $res = run_query($query);
    $array = get_row_data($res);
    $exempt = $array['exempt'];

    if ($exempt == "1") {
        $ex = true;
    } else {
        $ex = false;
    }
    return $ex;
}

function isOnProbation($id) {
    $query = "select * from tbl_studlist where user_id= '$id'";
    $res = run_query($query);
    $array = get_row_data($res);
    $probation = $array['probation'];

    if ($probation == "1") {
        $ex = true;
    } else {
        $ex = false;
    }
    return $ex;
}

function getJoinDate($id) {
    $query = "select * from tbl_studlist where user_id= '$id'";
    $res = run_query($query);
    $array = get_row_data($res);
    $admitted = $array['admitted'];
    return $admitted;
}

function remove_probation($id) {
    $query = "update tbl_studlist set probation ='0'  where user_id= '$id'";
    run_query($query);
}

//Parking Rates XML Auto-discovery function...
function generateParkingRatesXML() {
    $today = time();

    $myFile = "parking_rates.xml";
    $fh = fopen($myFile, 'w');
    $dataline = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n\n<contacts>\n";
    fwrite($fh, $dataline);

    $all_prods = run_query("Select * FROM " . DATABASE . ".parking_rates where (start_date < '$today' and end_date > '$today')");
    while ($array = get_row_data($all_prods)) {
        $name = $array['firstname'] . " " . $array['middlename'];
        $lastname = $array['lastname'];
        $all_names = $name . " " . $lastname;
        $code = $array['adm_no'];
        $dataline = "<contact>\n" .
                "<name>" . $name . "</name>\n" .
                "<number>" . $lastname . "</number>\n" .
                "<code>" . $code . "</code>\n" .
                "<string>" . $code . " " . $all_names . "</string>\n" .
                "</contact>\n";
        fwrite($fh, $dataline);
    }
    fwrite($fh, "</contacts>");
    fclose($fh);
}

//All Services XML Auto-discovery function...
function generateServicesXML() {
    $today = time();

    $myFile = "ccn_services.xml";
    $fh = fopen($myFile, 'w');

    $dataline = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n\n<ccnservices>\n";

    $all_prods = getServiceTypes($today);
    while ($array = get_row_data($all_prods)) {
        $name = $array['service_type_name'];
        $code = $array['service_type_id'];

        $dataline .= "<servicetype>\n" .
                "<servicetypename>" . $name . "</servicetypename>\n" .
                "<servicetypecode>" . $code . "</servicetypecode>\n";

        $services = getServices($code);
        while ($service_array = get_row_data($services)) {
            $service_name = $service_array['service_name'];
            $service_code = $service_array['service_id'];

            $dataline .="<service>\n" .
                    "<servicename>" . $service_name . "</servicename>\n" .
                    "<servicecode>" . $service_code . "</servicecode>\n";
            $dataline .="</service>\n";
        }

        $dataline .="</servicetype>\n";
        //fwrite($fh,$dataline);

        $rates = getParkingRates();
        while ($rate_array = get_row_data($rates)) {
            $vehicle_type = $rate_array['vehicle_type_id'];
            $parking_rate_id = $rate_array['parking_rate_id'];
            $zone_id = $rate_array['region_id'];
            $hour_rate = $rate_array['hour_rate'];
            $day_rate = $rate_array['day_rate'];
            $season_rate = $rate_array['season_rate'];

            $dataline .="<RATE>\n" .
                    "<RATE-CODE>" . $parking_rate_id . "</RATE-CODE>\n" .
                    "<REGION-CODE>" . $zone_id . "</REGION-CODE>\n" .
                    "<REGION-NAME>" . getRegionName($zone_id) . "</REGION-NAME>\n" .
                    "<VEHICLETYPE>" . $vehicle_type . "</VEHICLETYPE>\n" .
                    "<VEHICLETYPE-NAME>" . getVehicleTypeName($vehicle_type) . "</VEHICLETYPE-NAME>\n" .
                    "<HOUR-RATE>" . $hour_rate . "</HOUR-RATE>\n" .
                    "<DAY-RATE>" . $day_rate . "</DAY-RATE>\n" .
                    "<SEASON-RATE>" . $season_rate . "</SEASON-RATE>\n";
            $dataline .="</RATE>\n";
        }
    }
    $dataline .="</ccnservices>\n";
    fwrite($fh, $dataline);
    fclose($fh);
}

//All Services XML Auto-discovery function...
function generateParkingServicesXML() {
    $today = time();

    $myFile = "ccn_services.xml";
    $fh = fopen($myFile, 'w');

    $dataline = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n\n<ccnservices>\n";

    $all_prods = getServiceTypes($today);
    while ($array = get_row_data($all_prods)) {
        $name = $array['service_type_name'];
        $code = $array['service_type_id'];

        $dataline .= "<servicetype>\n" .
                "<servicetypename>" . $name . "</servicetypename>\n" .
                "<servicetypecode>" . $code . "</servicetypecode>\n";

        $services = getServices($code);
        while ($service_array = get_row_data($services)) {
            $service_name = $service_array['service_name'];
            $service_code = $service_array['service_id'];

            $dataline .="<service>\n" .
                    "<servicename>" . $service_name . "</servicename>\n" .
                    "<servicecode>" . $service_code . "</servicecode>\n";

            if ($service_code == DAY_PARKING) {
                $dataline .="<servicerates>" .
                        $rates = getParkingRates();
                while ($rate_array = get_row_data($rates)) {
                    $vehicle_type = $rate_array['vehicle_type_id'];
                    $parking_rate_id = $rate_array['parking_rate_id'];
                    $zone_id = $rate_array['region_id'];
                    $hour_rate = $rate_array['hour_rate'];
                    $day_rate = $rate_array['day_rate'];
                    $season_rate = $rate_array['season_rate'];

                    $dataline .="<RATE>\n" .
                            "<RATE-CODE>" . $parking_rate_id . "</RATE-CODE>\n" .
                            "<REGION-CODE>" . $zone_id . "</REGION-CODE>\n" .
                            "<REGION-NAME>" . getRegionName($zone_id) . "</REGION-NAME>\n" .
                            "<VEHICLETYPE>" . $vehicle_type . "</VEHICLETYPE>\n" .
                            "<VEHICLETYPE-NAME>" . getVehicleTypeName($vehicle_type) . "</VEHICLETYPE-NAME>\n" .
                            "<DAY-RATE>" . $day_rate . "</DAY-RATE>\n" .
                            "</RATE>\n";
                }

                $dataline .="</servicerates>\n";
            } elseif ($service_code == SEASON_PARKING) {
                $dataline .="<servicerates>" .
                        $rates = getParkingRates();
                while ($rate_array = get_row_data($rates)) {
                    $vehicle_type = $rate_array['vehicle_type_id'];
                    $parking_rate_id = $rate_array['parking_rate_id'];
                    $zone_id = $rate_array['region_id'];
                    $hour_rate = $rate_array['hour_rate'];
                    $day_rate = $rate_array['day_rate'];
                    $season_rate = $rate_array['season_rate'];

                    $dataline .="<RATE>\n" .
                            "<RATE-CODE>" . $parking_rate_id . "</RATE-CODE>\n" .
                            "<REGION-CODE>" . $zone_id . "</REGION-CODE>\n" .
                            "<REGION-NAME>" . getRegionName($zone_id) . "</REGION-NAME>\n" .
                            "<VEHICLETYPE>" . $vehicle_type . "</VEHICLETYPE>\n" .
                            "<VEHICLETYPE-NAME>" . getVehicleTypeName($vehicle_type) . "</VEHICLETYPE-NAME>\n" .
                            "<SEASON-RATE>" . $season_rate . "</SEASON-RATE>\n" .
                            "</RATE>\n";
                }

                $dataline .="</servicerates>\n";
            } elseif ($service_code == HOUR_PARKING) {
                $dataline .="<servicerates>" .
                        $rates = getParkingRates();
                while ($rate_array = get_row_data($rates)) {
                    $vehicle_type = $rate_array['vehicle_type_id'];
                    $parking_rate_id = $rate_array['parking_rate_id'];
                    $zone_id = $rate_array['region_id'];
                    $hour_rate = $rate_array['hour_rate'];
                    $day_rate = $rate_array['day_rate'];
                    $season_rate = $rate_array['season_rate'];

                    $dataline .="<RATE>\n" .
                            "<RATE-CODE>" . $parking_rate_id . "</RATE-CODE>\n" .
                            "<REGION-CODE>" . $zone_id . "</REGION-CODE>\n" .
                            "<REGION-NAME>" . getRegionName($zone_id) . "</REGION-NAME>\n" .
                            "<VEHICLETYPE>" . $vehicle_type . "</VEHICLETYPE>\n" .
                            "<VEHICLETYPE-NAME>" . getVehicleTypeName($vehicle_type) . "</VEHICLETYPE-NAME>\n" .
                            "<HOUR-RATE>" . $hour_rate . "</HOUR-RATE>\n" .
                            "</RATE>\n";
                }

                $dataline .="</servicerates>\n";
            }


            $dataline .="</service>\n";
        }

        $dataline .="</servicetype>\n";
        //fwrite($fh,$dataline);
    }
    $dataline .="</ccnservices>\n";
    fwrite($fh, $dataline);
    fclose($fh);
}

function getParkingRates() {
    $sql = "SELECT * FROM " . DATABASE . ".parking_rates";
    $result = run_query($sql);
    return $result;
}

function getRegionName($region) {
    $Query = "select * from " . DATABASE . ".region where region_id ='$region'";
    //echo $Query;
    $Result = run_query($Query);
    $arr = get_row_data($Result);
    $rate = $arr["region_name"];
    return $rate;
}

function getVehicleTypeName($type) {
    $Query = "select * from " . DATABASE . ".vehicle_types where vehicle_type_id ='$type'";
    //echo $Query;
    $Result = run_query($Query);
    $arr = get_row_data($Result);
    $rate = $arr["vehicle_type_name"];
    return $rate;
}

//Parking Rates XML Auto-discovery function...
function logPostsFromHenry($transaction_id, $transaction_code, $service_code, $user_account, $description, $amount, $date_logged, $reference_id, $resp_status) {
    $today = time();

    $myFile = "henryposts.log";
    $fh = fopen($myFile, 'a');

    fwrite($fh, $today . "==" . $transaction_id . "==" . $transaction_code . "==" . $service_code . "==" . $user_account . "==" .
            $description . "==" . $amount . "==" . $date_logged . "==" . $reference_id . "==" . $resp_status . "=========" .
            $headers2 . "=========" . $headers . "\n");
    fclose($fh);
}

function parseRequestHeaders() {
    $headers = array();
    foreach ($_SERVER as $key => $value) {
        if (substr($key, 0, 5) <> 'HTTP_') {
            continue;
        }
        $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
        $headers[$header] = $value;
    }
    return $headers;
}

function postToComfyPay() {
    header('Host: http://192.168.100.75/ComfyPaySwitchCGI/Comfy.ebpp');
    header('Connection: close');
    header('Content-type: application/x-www-form-urlencoded');
    header('Content-length: 0');
    header('');

    header("AGENTTYPE:aaa");
    header("AGENTID:REQACK");
    header("SWITCHID:bb");
    header("USERID:cc");
    header("PASSWD:aaa");
    header("REFERENCEID:REQACK");
    header("TRANSACTIONID:505");
    header("STATUSCODE:72");
    header("REPORT:bb");
    header("DATETIME:cc");
}

//function to do an asynchronous
function JobStartAsync($server, $url, $port=80, $conn_timeout=30, $rw_timeout=86400) {
    $errno = '';
    $errstr = '';

    set_time_limit(0);

    $fp = fsockopen($server, $port, $errno, $errstr, $conn_timeout);
    if (!$fp) {
        echo "$errstr ($errno)<br />\n";
        return false;
    }
    $out = "GET $url HTTP/1.1\r\n";
    $out .= "Host: $server\r\n";
    $out .= "Connection: Close\r\n\r\n";

    stream_set_blocking($fp, false);
    stream_set_timeout($fp, $rw_timeout);
    fwrite($fp, $out);

    return $fp;
}

function JobStartAsync2($server, $url, $port=80, $conn_timeout=30, $rw_timeout=86400) {
    $errno = '';
    $errstr = '';

    set_time_limit(0);

    $fp = fsockopen($server, $port, $errno, $errstr, $conn_timeout);
    if (!$fp) {
        echo "$errstr ($errno)<br />\n";
        return false;
    }
    $out = "GET $url HTTP/1.1\r\n";
    $out .= "Host: $server\r\n";
    $out .= "Connection: Close\r\n\r\n";

    stream_set_blocking($fp, false);
    stream_set_timeout($fp, $rw_timeout);
    fwrite($fp, $out);

    return $fp;
}

function getAgentIDByCode($code) {
    $query = "SELECT agent_id FROM " . DATABASE . ".sap_agents WHERE agent_code = '$code'";
    $data = run_query($query);
    $rows = get_row_data($data);
    $name = trim($rows['agent_id']);
    return $name;
}

function getAgentName($one) {
    $query = "SELECT agent_name FROM " . DATABASE . ".sap_agents WHERE agent_id = '$one'";
    $data = run_query($query);
    $rows = get_row_data($data);
    $name = trim($rows['agent_name']);
    return $name;
}

function getParkingTypeNameByTypeId($one) {
    $query = "SELECT parking_type_name FROM " . DATABASE . ".parking_types WHERE parking_type_id = '$one'";
    $data = run_query($query);
    $rows = get_row_data($data);
    $name = trim($rows['parking_type_name']);
    return $name;
}

function getStaffName($one) {
    $query = "SELECT first_name,surname FROM " . DATABASE . ".staff WHERE staff_id = '$one'";
    $data = run_query($query);
    $rows = get_row_data($data);
    $name = trim($rows['first_name']) . " " . trim($rows['surname']);
    return $name;
}

function getStreetName($one) {
    $query = "SELECT street_name FROM " . DATABASE . ".streets WHERE street_id = '$one'";
    $data = run_query($query);
    $rows = get_row_data($data);
    $name = trim($rows['street_name']);
    return $name;
}

/* function getRegionName($one)
  {
  $query = "SELECT region_name FROM ".DATABASE.".region WHERE region_id = '$one'";
  $data = run_query($query);
  $rows = get_row_data($data);
  $name = trim($rows['region_name']);
  return $name;
  } */

function getMarketName($one) {
    $query = "SELECT market_name FROM " . DATABASE . ".markets WHERE market_id = '$one'";
    $data = run_query($query);
    $rows = get_row_data($data);
    $name = trim($rows['market_name']);
    return $name;
}

function getServiceBillName($one) {
    $query = "SELECT service_bill_name FROM " . DATABASE . ".service_bills WHERE service_bill_id = '$one'";
    $data = run_query($query);
    $rows = get_row_data($data);
    $name = trim($rows['service_bill_name']);
    return $name;
}

function getMarketTypeNameByTypeId($one) {
    $query = "SELECT market_type_name FROM " . DATABASE . ".market_types WHERE market_type_id = '$one'";
    $data = run_query($query);
    $rows = get_row_data($data);
    $name = trim($rows['market_type_name']);
    return $name;
}

function getTotalInspectorQuerysToday($inspector) {
    $sql = "select count(parking_compliance_id) as total from public.parking_compliance
				where parking_attendant_id = '$inspector'
				and parking_date = '" . date("Y-m-d") . "'";
    $result = run_query($sql);
    $arr = get_row_data($result);
    return $arr['total'];
}

function getTotalClampingsToday($inspector) {
    $sql = "select count(clamping_transaction_id) as total from public.clamping_transactions
				where clamper_id = '$inspector'
				and clamping_date = '" . date("Y-m-d") . "'";
    $result = run_query($sql);
    $arr = get_row_data($result);
    return $arr['total'];
}

function getTotalTowsToday($inspector) {
    $sql = "select count(towing_transaction_id) as total from public.towing_transactions
				where tower_id = '$inspector'
				and towing_date = '" . date("Y-m-d") . "'";
    $result = run_query($sql);
    $arr = get_row_data($result);
    return $arr['total'];
}

function get_appstatus_value($applicant) {
    if ($applicant_status == 1) {
        return$applicant_status = 'Individual';
    } else if ($applicant_status == 0) {
        return $applicant_status = 'Company';
    }
}

function checkLogin($username, $password) {
    //pre: $username and $password must be strings. ($password is encrypted)
    //post: returns boolean based on if their login was succesfull.
    $tablename = "user_login2";
    $password = sha1($password);
    //$result = run_query ("SELECT * FROM $tablename WHERE username=\"$username\" and password=\"$password\" ");
    $psd = $password;
    $result = run_query("SELECT u.*, r.* FROM " . DATABASE . ".$tablename u
        LEFT JOIN user_roles r ON r.role_id = u.user_role
                                                              WHERE username='$username'
                                                              AND password='$psd' AND user_active IS TRUE");
    //echo $username . "==" . $password;
    $num = get_num_rows($result);
    $array = get_row_data($result);

    if ($num > 0) {
        //$_SESSION['usertype'] = $array['userlevelid'];
        $_SESSION['sys_name'] = $array['username'];
        $_SESSION['role_id'] = $array['user_role'];
        $_SESSION['email'] = $array['email'];
        // $_SESSION['user_id'] = $array['job_id'];
        $_SESSION['login_id'] = $array['user_id'];
        //$_SESSION['secure'] = $array['secure'];
        $_SESSION['logedIn'] = true;
        // $_SESSION['sessionId'] = $array['job_id'];
        $_SESSION['logged'] = true;
        $_SESSION['mf_id'] = $array['mf_id'];
        $_SESSION['client_mf_id'] = $array['client_mf_id'];
        $_SESSION['role_name'] = $array['role_name'];

        $_SESSION['sess_id'] = session_id();
        
        $_SESSION['secure'] = $_POST['secure'];
        //setLastLogin($array['number']);
        return true;      
    } else {
        return false;
    }
}
//from here
function checkEmail($email){
    //pre: check whether the email entered is in the system
    $tablename = "user_login2";

    $result = run_query("SELECT * FROM $tablename WHERE email='".$email."'");

    $num = get_num_rows($result);

    if ($num > 0) {
        return true;
    } else {
        return false;
    }
}

function saveTokens($reset){
    //pre: save access token for reset password
    $tablename = "reset_pass_tokens";
    $query = "INSERT INTO $tablename (token, email,username, expdate) 
    VALUES ('".$reset['token']."','".$reset['email']."','".$reset['username']."','".$reset['expdate']."')";
    $result = run_query($query);
    //var_dump($query);exit;
    if($result){
        return true;
    }else{
        return false;
    }
}

function checkUsername($email){
    //pre: check the username matching the entered E-mail address
    $tablename = "user_login2";

    $result = run_query("SELECT username FROM $tablename WHERE email='".$email."'");
    $row = get_row_data($result);
    $username = trim($row['username']);
    return $username;

}

function getUsernameFromToken($token){
    $query = "SELECT * FROM reset_pass_tokens WHERE token = '".$token."'";
    $result = run_query($query);
    $rows = get_row_data($result);
    $username = $rows['username'];
    return $username;
}

function resetPassword($post){
    //pre: update the reset password in the user login table
    $tablename = "user_login2";
    if($post['password'] != $post['pass_again']){
        $_SESSION['loginerror'] = 'The passwords do not match!';
    }else{
        $pass_hash = sha1($post['password']);
        $query ="UPDATE $tablename SET 
                password='".$pass_hash."',
                user_active = 't'
                WHERE  username='".$post['username']."'";
        // var_dump($query);exit;
        $result = run_query($query);
        //var_dump($query);exit;
        if($result){
            return true;
        }else{
            return false;
        }
    }
}

function verifyRoute($current_route, $role_id){

    $query = "SELECT * FROM allocated_indices WHERE sys_view_url = '".$current_route."' AND sys_role_id = '".$role_id."' AND sys_view_status IS TRUE";
    $result = run_query($query);
    $num_row = get_num_rows($result);
    if($num_row){
        return true;
    }else{
        return false;
    }

}

function viewActions($num, $role_id){
    $query = "SELECT sa.*, sv.* FROM sys_actions sa
    LEFT JOIN sys_views sv ON sv.sys_view_id = sa.sys_view_id
    WHERE sys_view_index = '".$num."' AND sys_button_type = 'form' ORDER BY sys_action_id ASC";

    $query2 = "SELECT srv.sys_action_id FROM sys_role_view_actions_allocations srv 
    LEFT JOIN sys_views sv ON srv.sys_role_views_id = sv.sys_view_id 
    WHERE sv.sys_view_index = '$num' AND srv.sys_role_id = '$role_id'";

    $result2 = run_query($query2);
    $allocated_actions = array();
    $count = 0;
    while ($allocated_actions_rows = get_row_data($result2))
    {
        $allocated_actions[$count] = $allocated_actions_rows['sys_action_id'];
        $count++;
    }

    // var_dump($allocated_actions);
    $result = run_query($query);   
    while($row = get_row_data($result)){
        createActionButton($row, $allocated_actions);
    }

}

function createActionButton($system_view_actions, $allocated_actions){
    $action_id = $system_view_actions['sys_action_id'];
    $label = $system_view_actions['sys_action_name'];
    $class = $system_view_actions['sys_action_class'];
    $type = $system_view_actions['sys_action_type'];
    $action_code = $system_view_actions['sys_action_code'];
    
    $disabled = (in_array($action_id, $allocated_actions))?"":"disabled='disabled'";
    
    switch($type){

        case 'submit': 
            echo "&nbsp;<input type=\"$type\" value=\"$label\" class=\"$class\" $disabled/>&nbsp;";
            break;

        case 'delete':
                echo "<input type=\"hidden\" id=\"action_code\" value=\"$action_code\"/>";
                echo "&nbsp;<input type=\"button\" value=\"$label\" id=\"delete_button\" class=\"$class\" $disabled/>&nbsp;";
            break;

        case 'reset':
            echo "&nbsp;<input type=\"$type\" value=\"$label\" class=\"$class\" $disabled/>&nbsp;";
            break;

        case 'back':
            echo "&nbsp;<input type=\"button\" value=\"$label\" id=\"go_back\" class=\"$class\" $disabled/>&nbsp;";
            break;

        case 'search':
            echo "&nbsp;<button class=\"$class\"><i class=\"icon-search\"></i>$label</button>&nbsp;";
            break;
    }

}

function getAllocatedViews($role_id){

    $getView = "SELECT * FROM sys_role_views_allocations WHERE sys_role_id = '$role_id'";
    $data = run_query($getView);
    $sys_view_ids_array = array();
    $count = 0;
    while($row = get_row_data($data)){
        $sys_view_id = $row['sys_view_id'];
        $sys_view_ids_array[$count] = $sys_view_id;
        $count++;
    }
    return $sys_view_ids_array;

}

//load the menu from the db
function getDbMenu($parent_id, $active_view, $view_ids){
    $condition = (is_null($parent_id)) ? "is null" : "= $parent_id";
    $query = "SELECT m.*, s.* FROM menu m 
        LEFT JOIN sys_views s ON m.view_id = s.sys_view_id
        WHERE parent_id $condition AND status IS TRUE
        ORDER BY sequence ASC";
        // var_dump($query);exit;
    $query = run_query($query);
    if(get_num_rows($query) > 0){
        echo '<ul>';

        while($row = get_row_data($query)){
            $sys_view_index = $row['sys_view_index'];
            $text = $row['text'];
            $icon = $row['icon'];
            $class = $row['class'];
            $view_id = $row['sys_view_id'];
            $parent_id = $row['parent_id'];
            
            $active_link = $active_view;
            $status = '';
            if($active_link == $sys_view_index){
                $status = 'active';
            }

            if(in_array($view_id, $view_ids))
            {
                echo "<li class=\"$class $status\">";
                if($parent_id != 0){
                    echo "<a href=\"index.php?num=$sys_view_index\"><i class=\"$icon\"> </i>";
                }else{
                    echo "<a href=\"index.php?num=$sys_view_index\" class=\"paro\"><i class=\"$icon\"> </i>";
                }
                    echo "<span class=\"title\">$text</span>";
                if($class == 'has-sub'){
                    echo '<span class="arrow"></span>';
                }
            }
            
            getDbMenu($row['menu_id'], $active_view, $view_ids);
            echo "</a>";
            echo '</li>';
        }

        echo '</ul>';

    }   
}

function viewAllocated($row_id, $view_id){
    $query = "SELECT * FROM sys_role_views_allocations WHERE 
    sys_role_id = '$row_id' and sys_view_id = '$view_id'";
    $data = run_query($query);
    $num_row = get_num_rows($data);
    if($num_row){
        return true;
    }else{
        return false;
    }
}

function displayAllViews($parent_id, $role_name, $role_id){
    //display all the views for management in an accordion
    $condition = (is_null($parent_id)) ? "is null" : "= $parent_id";
    $views = "SELECT * FROM sys_views where parent $condition ORDER BY sys_view_name ASC";
    $result = run_query($views);
    echo '<ul>';
    $count = 1;
    
    
    while($row = get_row_data($result)){
        $view_id = $row['sys_view_id'];
        $view_name = $row['sys_view_name'];
        $parent = $row['parent'];
        if(is_null($parent))
        {
            $children_views = "SELECT sys_view_id FROM sys_views where parent = '".$view_id."' ORDER BY sys_view_name ASC";
            $result2 = run_query($children_views);
            $children = "";
            while($row = get_row_data($result2)){
                $children = $children.",".$row['sys_view_id'];
            }
        }
        if(viewAllocated($_SESSION['role_id'], $view_id)) { 
            $css = '';
        }else{
            $css = "display:none;";
        }


        if(viewAllocated($role_id, $view_id)) { 
            $checked = 'checked'; 
        }else{
            $checked = '';
        }

        if($parent == 0){
            echo '<li style="line-height:200%; '.$css.'">';
                echo $view_name;
                echo "<input data-parent=\"$parent\" data-children=\"$children\" type=\"checkbox\" id=\"view_$view_id\" class=\"parent\" title=\"Select/Unselect All\" $checked name=\"view_box_$view_id\" value=\"1\"/>";
                echo "<input type=\"hidden\" name=\"view_id_$view_id\" value=\"$view_id\"/>";
        }else{
            echo '<li style="line-height:200%; '.$css.'">';
                echo $view_name;
                echo "<input data-parent=\"$parent\" data-children=\"\" type=\"checkbox\" id=\"view_$view_id\" class=\"parent_$parent child\" $checked name=\"view_box_$view_id\" value=\"1\"/>";
                echo "<input type=\"hidden\" name=\"view_id_$view_id\" value=\"$view_id\"/>";
                if($checked == 'checked'){
                    echo "<a class=\"btn btn-mini\" href=\"index.php?num=edit_action&name=$view_name&role_id=$role_id&view_id=$view_id\" target=\"_blank\"><i class=\"icon-edit\" style=\"font-size: 13px;\">Manage Actions</i></a>";
                }
        }
        displayAllViews($view_id, $role_name, $role_id);
        echo '</li>';
    $count++;   
    }
    echo '</ul>';
}

function logAction($case_name, $session_id, $staff_customer_id){
    date_default_timezone_set('Africa/Nairobi');
    $timestamp = date('Y-m-d H:i:s');
    $query = "INSERT INTO audit_trail(session_id, mf_id, case_name, datetime) VALUES ('".$session_id."', '".$staff_customer_id."', '".$case_name."', '".$timestamp."')";
    if(run_query($query)){
        return true;
    }else{
        return false;
    }
}

function checkForExistingEntry($tablename, $column_name, $id){
  $check_query = "SELECT $column_name FROM $tablename WHERE $column_name = '".sanitizeVariable($id)."'";
  $result = run_query($check_query);
  $num_rows = get_num_rows($result);
  if($num_rows >= 1){
    return true;
  }else{
    return false;
  }
}

function checkForExistingData($tablename, $column_name1, $id1, $column_name2, $id2){
  $check_query = "SELECT $column_name1 FROM $tablename WHERE $column_name1 = '".$id1."' AND $column_name2 = '".$id2."'";
  $result = run_query($check_query);
  $num_rows = get_num_rows($result);
  if($num_rows >= 1){
    return true;
  }else{
    return false;
  }
}

function onEditCheckForExistingEntry($tablename, $column_name, $id, $skip_column, $skip_id){
  $check_query = "SELECT $column_name FROM $tablename WHERE $column_name = '".$id."' AND $skip_column <> '".$skip_id."'";
  $result = run_query($check_query);
  $num_rows = get_num_rows($result);
  if($num_rows >= 1){
    return true;
  }else{
    return false;
  }
}

function getAllParents($parent_id){
    $parents =run_query("SELECT * FROM menu WHERE parent_id is null");
    
    while($row =get_row_data($parents)){
        $menu_name2 = $row['text'];
        $menu_id2 = $row['menu_id'];
        $parent_id;
        $parent_id2 =$row['parent_id'];

        echo "<option value=\"$menu_id2\"";
            if($menu_id2 == $parent_id){ echo 'selected'; }
        echo ">$menu_name2</option>";
    }
}

function manageMenu($parent_id){
    //display all the views for management in an accordion
    $condition = (is_null($parent_id)) ? "is null" : "= $parent_id";
    $views = "SELECT * FROM menu WHERE parent_id $condition ORDER BY parent_id ASC";
    $result = run_query($views);

    // $parents =run_query("SELECT * FROM menu WHERE parent_id is null");
    // $result2 =get_row_data($parents);

    $count = 1;
    while($row = get_row_data($result)){
        $menu_id = $row['menu_id'];
        $menu_name = $row['text'];
        $parent_id = $row['parent_id'];
        $sequence = $row['sequence'];

        if(is_null($parent_id))
        {
            echo '<tr>';
            echo '<td>'.$menu_id.'</td>';
            echo '<td>'.$menu_name.'</td>';
                echo "<td>$sequence<input type=\"hidden\" name=\"id$menu_id\" value=\"$menu_id\"/></td>";
                echo "<td>
                    <select name=\"parent_id$menu_id\">
                        <option value=\"$parent_id\">No Parent</option>";
                        getAllParents($parent_id);
                echo "</select>";
                echo "</td>";
            echo "<td><a href=\"index.php?num=edit_menu&id=$menu_id\" target=\"_blank\">Edit Menu Item</a></td>";
        }else{
            echo '<tr>';
            echo '<td>'.$menu_id.'</td>';
            echo '<td>'.$menu_name.'</td>';
            echo "<td>$sequence<input type=\"hidden\" name=\"id$menu_id\" value=\"$menu_id\"/></td>";
            echo "<td>
                    <select name=\"parent_id$menu_id\">";
                        echo "<option value=\"0\">No Parent</option>";
                        getAllParents($parent_id);
            echo "</select>";
            echo "</td>";
            echo "<td><a href=\"index.php?num=edit_menu&id=$menu_id\" target=\"_blank\">Edit Menu Item</a></td>";
        }
        manageMenu($menu_id);
        echo '</tr>';
    $count++;   
    }
}

function exists($row_id, $view_id){
    $query = "SELECT * FROM sys_role_views_allocations WHERE 
    sys_role_id = '".$row_id."' and sys_view_id = '".$view_id."'";
    $data = run_query($query);
    $num_row = get_num_rows($data);
    if($num_row >= 1){
        return true;
    }else{
        return false;
    }
}

function actionExists($view_id, $action_id, $role_id){
    $query = "SELECT * FROM sys_role_view_actions_allocations WHERE 
    sys_role_views_id = '".$view_id."' and sys_action_id = '".$action_id."' and sys_role_id = '".$role_id."'";
    $data = run_query($query);
    // $array = get_row_data();
    // var_dump($array);
    $num_row = get_num_rows($data);
    if($num_row >= 1){
        return true;
    }else{
        return false;
    }
}

function checkToken($token){
    //pre: check whether the token clicked is in the system
    $tablename = "reset_pass_tokens";

    $result = run_query("SELECT * FROM $tablename WHERE token='".$token."'"); 
    $num = get_num_rows($result);

    if ($num > 0) {
        return true;
    } else {
        return false;
    }
}

function checkCurrentdate($token){
    //pre: check whether the token clicked is in the system
    $tablename = "reset_pass_tokens";

    $result = run_query("SELECT currentdate FROM $tablename WHERE token='".$token."'"); 
    $row = get_row_data($result);
    $currentdate = trim($row['currentdate']);
    return $currentdate;
}

function checkExpdate($token){
    //pre: check whether the token clicked is in the system
    $tablename = "reset_pass_tokens";

    $result = run_query("SELECT expdate FROM $tablename WHERE token='".$token."'"); 
    $row = get_row_data($result);
    $expdate = trim($row['expdate']);
    return $expdate;
}

function getMspName($preffered_msp){
    if(!empty($preffered_msp)){
        $query = "SELECT msp_name FROM afyapoa_msps WHERE afyapoa_msp_id = '".$preffered_msp."'";
        // var_dump($query);exit;
        $result = run_query($query);
        $rows = get_row_data($result);
        return $rows['msp_name'];
    }
}

function createSectionButton($role_id, $view_index, $action_code){
    //get the action_id
    $query = "SELECT * FROM sys_actions WHERE sys_action_code = '".$action_code."' AND sys_button_type = 'section'";
    $result = run_query($query);
    $rows = get_row_data($result);
    $action_id = $rows['sys_action_id'];
    $action_type = $rows['sys_action_type'];
    $label = $rows['sys_action_name'];
    $others = $rows['others'];
    $class = $rows['sys_action_class'];

    //get view_id
    $query2 = "SELECT sys_view_id FROM sys_views WHERE sys_view_index = '".$view_index."'";
    // var_dump($query2);exit;
    $result2 = run_query($query2);
    $rows2 = get_row_data($result2);
    $view_id = $rows2['sys_view_id'];

    if(checkButtonAllocation($action_id, $view_id, $role_id)){
        switch($action_type){
            case 'submit': 
                echo "&nbsp;<input type=\"$type\" value=\"$label\" class=\"$class\" $disabled/>&nbsp;";
                break;

            case 'delete':
                    echo "<input type=\"hidden\" id=\"action_code\" value=\"$action_code\"/>";
                    echo "&nbsp;<input type=\"button\" value=\"$label\" id=\"delete_button\" class=\"$class\" $disabled/>&nbsp;";
                break;

            case 'reset':
                echo "&nbsp;<input type=\"$type\" value=\"$label\" class=\"$class\" $disabled/>&nbsp;";
                break;

            case 'back':
                echo "&nbsp;<input type=\"button\" value=\"$label\" id=\"go_back\" class=\"$class\" $disabled/>&nbsp;";
                break;

            case 'search':
                echo "&nbsp;<button class=\"$class\"><i class=\"icon-search\"></i>$label</button>&nbsp;";
                break;

            case 'button':
                echo "<button class=\"$class\" $others>$label</button>";
                break;
        }
    }else{
            switch($action_type){
                case 'submit': 
                    echo "&nbsp;<input type=\"$type\" value=\"$label\" class=\"$class\" disabled/>&nbsp;";
                    break;

                case 'delete':
                        echo "<input type=\"hidden\" id=\"action_code\" value=\"$action_code\"/>";
                        echo "&nbsp;<input type=\"button\" value=\"$label\" id=\"delete_button\" class=\"$class\" disabled/>&nbsp;";
                    break;

                case 'reset':
                    echo "&nbsp;<input type=\"$type\" value=\"$label\" class=\"$class\" disabled/>&nbsp;";
                    break;

                case 'back':
                    echo "&nbsp;<input type=\"button\" value=\"$label\" id=\"go_back\" class=\"$class\" disabled/>&nbsp;";
                    break;

                case 'search':
                    echo "&nbsp;<button class=\"$class\"><i class=\"icon-search\" disabled></i>$label</button>&nbsp;";
                    break;

                case 'button':
                    echo '<button class="'.$class.'" '. $others.' disabled>'.$label.'</button>';
                    break;
            }
    }
}

function checkButtonAllocation($action_id, $view_id, $role_id){
    $query = "SELECT * FROM sys_role_view_actions_allocations WHERE sys_role_id = '".$role_id."' AND sys_action_id = '".$action_id."' AND sys_role_views_id = '".$view_id."'";
    // var_dump($query);exit;
    $result = run_query($query);
    $num_rows = get_num_rows($result);
    if($num_rows){
        return true;
    }else{
        return false;
    }
}

//get the ip address
function getUserIP()
{
    $client  = getenv('HTTP_CLIENT_IP');
    $forward = getenv('HTTP_X_FORWARDED_FOR');
    $remote  = getenv('REMOTE_ADDR');

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}

//limit the login attempts
function confirmIPAddress($value, $username) { 
  $q = "SELECT attempts FROM loginattempts WHERE ip = '$value'"; 

  $result = run_query($q); 
  $data = get_row_data($result); 

  //Verify that at least one login attempt is in database 

  if (!$data) { 
    return 0; 
  } 
  if ($data["attempts"] >= 4) 
  { 
   $block = "UPDATE user_login2 SET user_active = '0' WHERE username = '".$username."'";
   $run = run_query($block);
   if($run){
        return true;
   }else{
        return false;
   }
  }  
}

function addLoginAttempt($value) {

   //Increase number of attempts. Set last login attempt if required.

   $q = "SELECT * FROM LoginAttempts WHERE ip = '$value'"; 
   $result = run_query($q);
   $data = get_row_data($result);
   
   if($data)
   {
     $attempts = $data["attempts"]+1;         

     if($attempts==3) {
       $q = "UPDATE LoginAttempts SET attempts=".$attempts.", lastlogin=NOW() WHERE ip = '$value'";
       $result = run_query($q);
     }
     else {
       $q = "UPDATE LoginAttempts SET attempts=".$attempts." WHERE ip = '$value'";
       $result = run_query($q);
     }
   }
   else {
     $q = "INSERT INTO LoginAttempts (attempts,IP,lastlogin) values (1, '$value', NOW())";
     $result = run_query($q);
   }
}

function clearLoginAttempts($value) {
  $q = "UPDATE LoginAttempts SET attempts = 1 WHERE ip = '$value'"; 
  return run_query($q);
}

function recordUnSuccessfulLoginAttempt($username, $password, $ip){
    date_default_timezone_set('Africa/Nairobi');
    $timestamp = date('Y-m-d H:i:s');
    $pass_hash = sha1($password);
    $query = "INSERT INTO unsuccessful_login_attempts(username, password, ip, datetime) VALUES ('".$username."', '".$pass_hash."', '".$ip."', '".$timestamp."')";
    $result = run_query($query);
    if($result){
        return true;
    }else{
        return false;
    }
}

function recordSuccessfulLogin($login_id, $mf_id, $session_id){
    date_default_timezone_set('Africa/Nairobi');
    $timestamp = date('Y-m-d H:i:s');
    $query = "INSERT INTO login_sessions(login_id, datetime, mf_id, session_id) VALUES ('".$login_id."', '".$timestamp."', '".$mf_id."', '".$session_id."') RETURNING login_session_id";
    $result = run_query($query);
    if($row = get_row_data($result)){
        return $row['login_session_id'];
    }
}

function allocateSysView($role_id, $view_id){
    $insert="INSERT INTO ".DATABASE.".sys_role_views_allocations(
        sys_role_id,
        sys_view_id) 
    VALUES(
        '".$role_id."', 
        '".$view_id."')";
    $result = run_query($insert);
    if($result){
        return true;
    }else{
        return false;
    }
}

function allocateViewAction($role_id, $view_id, $action_id){
    $insert="INSERT INTO sys_role_view_actions_allocations(
            sys_role_views_id, sys_action_id, sys_role_id)
    VALUES ('".$view_id."', '".$action_id."', '".$role_id."');";
    $result = run_query($insert);
    if($result){
        return true;
    }else{
        return false;
    }
}

function checkIfUserCreatedRoleExists($mf_id, $role_id){
    $query = "SELECT * FROM user_created_roles WHERE mf_id = '".$mf_id."' AND role_id = '".$role_id."'";
    $result = run_query($query);
    $num_rows = get_num_rows($result);
    if($num_rows){
        return true;
    }else{
        return false;
    }
}

function getRoleFromName($role_name){
    $query = "select * from user_roles where role_name = '".$role_name."'";
    $result = run_query($query);
    return get_row_data($result);
}

function getParentViewName($parent){
    if(!empty($parent)){    
        $query = "SELECT sys_view_name FROM sys_views WHERE sys_view_id = '".$parent."'";
        $result = run_query($query);
        $rows = get_row_data($result);
        return $rows['sys_view_name'];
    }
}

function showServiceTree($parent_id, $revenue_channel){
    $query = "SELECT * FROM service_channels WHERE parent_id = $parent_id AND revenue_channel_id = '".$revenue_channel."'";
    // var_dump($query);exit;
    $result = run_query($query);
    while($rows = get_row_data($result)){
        $service_option = $rows['service_option'];
        $ser_chan_id = $rows['service_channel_id'];
        $ser_option_type = $rows['service_option_type'];
        $request_type_id = $rows['request_type_id'];
        $rev_chan_id = $rows['revenue_channel_id'];
        $price = $rows['price'];
        if($ser_option_type == 'Root' || $ser_option_type == 'Branch'){
            echo "<ol class=\"dd-list\">
             <li class=\"dd-item dd3-item\" data-id=\"13\">
                <div class=\"dd-handle dd3-handle\"></div>
                <div class=\"dd3-content\">$service_option</div>
             </li>";
        }else{
            echo "<ol class=\"dd-list\">
             <li class=\"dd-item dd3-item\" data-id=\"13\">
                <a href=\"?num=167&serv_id=$ser_chan_id&service_name=$service_option&rev_id=$rev_chan_id&price=$price\" role=\"button\" data-toggle=\"modal\" service_name=\"$service_option\" 
                price_am=\"$price\" option_type=\"$ser_option_type\" req_type_id=\"$request_type_id\" 
                serv_id=\"$ser_chan_id\">
                    <div class=\"dd-handle dd3-handle\"></div>
                    <div class=\"dd3-content\">
                        $service_option - Price: $price
                        <span class=\"pull-right\"><i class=\"icon-money\"></i> Buy</span>
                    </div>
                </a>
             </li>";
        }
         showServiceTree($ser_chan_id, $revenue_channel);
        echo "</ol>";
    }
}

/**
    Last date of a month of a year
    
    @param[in] $month - Integer. Default = Current Month
    @param[in] $year - Integer. Default = Current Year
    
    @return Last date of the month and year in yyyy-mm-dd format
*/
function last_day($month = '', $year = '') 
{
   if (empty($month)) 
   {
      $month = date('m');
   }
   
   if (empty($year)) 
   {
      $year = date('Y');
   }
   
   $result = strtotime("{$year}-{$month}-01");
   $result = strtotime('-1 second', strtotime('+1 month', $result));

   return date('Y-m-d', $result);
}

/**
 * For executing transactions
 * use array_push to add sql(tranactions) to the tranactions array_push
 *
 * var $transactions Array
 * var $safe_point string
 */
function executeTransaction($transactions, $safe_point = null)
{
    $success = TRUE;
    run_query("BEGIN");
    try{
        foreach ($transctions as $transaction):
            $result = run_query($tranaction);
            if(!result) throw new Exception("$transaction failed");
        endforeach;
        run_query("COMMIT");
    } catch(Exception $e)
    {
        echo "Rolling back transactions\n";
        $query = "ROLLBACK";
        if(!is_null($safe_point))
            $query .= " TO $safe_point";
        run_query($query);
        $success = FALSE;
        //we could show this error on the interface....or a customer error
        echo "Caught Exception ('{$e->getMessage()}')\n{$e}\n";
    }
    return $success;
}

function resetLoginAttempts(){
    $query = "TRUNCATE loginattempts";
    $result = run_query($query);
    if($result){
        return true;
    }else{
        return false;
    }
}
