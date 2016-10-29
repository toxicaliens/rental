<?php
/**
 * Created by PhpStorm.
 * User: JOEL
 * Date: 7/8/2016
 * Time: 4:19 PM
 */
include_once('src/models/Library.php');
class House extends Library
{
    public function getAllHouses($condition = null){
        $condition = (!is_null($condition)) ? $condition : '';
        $rows = $this->selectQuery('houses_and_plots', '*', $condition);
        return array(
            'all' => $rows,
            'specific' => $rows[0]
        );
    }

    public function attachHouseToTenant($tenant_mf_id, $house_id){
        $result = $this->updateQuery(
            'houses',
            "tenant_mf_id = '".sanitizeVariable($tenant_mf_id)."'",
            "house_id = '".sanitizeVariable($house_id)."'"
        );
        if($result)
            return true;
        else
            return false;
    }

    public function attachPlotToLandlord($landlord_mf_id, $plot_id){
        $result = $this->updateQuery(
            'plots',
            "landlord_mf_id = '".sanitizeVariable($landlord_mf_id)."'",
            "plot_id = '".sanitizeVariable($plot_id)."'"
        );
        if($result)
            return true;
        else
            return false;
    }

    public function attachPlotToPmManager($pm_mf_id, $plot_id){
        $result = $this->updateQuery(
            'plots',
            "pm_mf_id = '".sanitizeVariable($pm_mf_id)."'",
            "plot_id = '".sanitizeVariable($plot_id)."'"
        );
        if($result)
            return true;
        else
            return false;
    }

    public function getHouseModelDetails($id){
        $rows = $this->selectQuery('houses', '*'," house_id = '".$id."' ");
        return $rows[0];
    }

    public function getHouseAttributeDetails($id){
        $rows = $this->selectQuery('houses_attributes', '*'," house_id = '".$id."' ");
        return $rows;
    }

    public function listAllAttributes(){
        $rows = $this->selectQuery('attributes', '*');
        return $rows;
    }

    public function checkIfHouseAttributeisAttached($house,$attribute){
        $query = "SELECT * FROM house_attr_allocations 
		WHERE house_id = '".sanitizeVariable($house)."' AND attribute_id = '".sanitizeVariable($attribute)."' 
		";
        $result = run_query($query);
        $num_rows = get_num_rows($result);
        if($num_rows == 1){
            return true;
        }
    }

    public function getAllPlots(){
        $rows = $this->selectQuery('plots', '*');
        return $rows;
    }
    public function getAllAttributes(){
        $rows = $this-> selectQuery('attributes', '*');
        return $rows;
    }

    //function to validate and to call for insert query
    public function addAttrb(){
       
        $validate = array(
            'name'=>array(
                'attribute_name'=> 'Attribute Name',
                'required'=>true)
           
        );
        // var_dump($validate);
        $this->validate($_POST, $validate);
        if ($this->getValidationStatus()){
            //if the validation has passed, run a query to insert the details
            //into the database
            $name = $_POST['name'];
            if($this-> addAttrbDetails($name)){
                $this->flashMessage('attributes', 'success', 'The attribute has been added.');
            }else{
                $this->flashMessage('attributes', 'error', 'Failed to add attribute! ' . get_last_error());
            }
        }
    }
    // function to insert attribute details

    public function addAttrbDetails($attrib_name){
        $result = $this->insertQuery('attributes',
            array(
                'attribute_name' => $attrib_name
                ));
            return $result;
    }

    public function editAttribute(){
        extract($_POST);
        //update the attribute name
        $edit_id = $_POST['edit_id'];
         $validate = array(
            'name'=>array(
                'attribute_name'=> 'Attribute Name',
                'required'=>true)
           
        );


        $this->validate($_POST, $validate);
        if ($this->getValidationStatus()){
            //if the validation has passed, run a query to insert the details
            //into the database
            if($this-> editAttributeDetails($name, $edit_id)){
                $this->flashMessage('attributes', 'success', 'The Attribute has been edited.');
            }else{
                $this->flashMessage('attributes', 'error', 'Failed to edit Attribute! ' . get_last_error());
            }
        }
    }

    public function editAttributeDetails($name, $edit_id){
        $result = $this->updateQuery2('attributes',
            array(
                'attribute_name' => $name
            ),
            array('attribute_id' => $edit_id)
            );
        return $result;
    }

    public function deleteAttribute(){
        extract($_POST);
        $result = $this->deleteQuery('attributes', "attribute_id = '".$delete_id."'");
        if($result)
            $this->flashMessage('attributes', 'success', 'The Attribute has been Deleted.');
        else
            $this->flashMessage('attributes', 'error', 'Encountered an error! '.get_last_error());
    }


    //method to draw data from the database

    public function getHouseData(){
        $role = $_SESSION['role_name'];
        if($role == SystemAdmin) {
            $rows = $this->selectQuery('my_houses', '*', "pm_mfid = '".$_SESSION['mf_id']."' ");
        }elseif ($role == PM){
            $rows = $this->selectQuery('my_houses', '*',"pm_mfid = '".$_SESSION['mf_id']."'" );
        }elseif($role == LandLord){
            $rows = $this->selectQuery('house_details', '*',"landlord_mf_id= '".$_SESSION['mf_id']."'" );
        }
            return $rows;
    }

    
    public function attachHouseAttribute(){
        extract($_POST);
        //var_dump($_POST);die();
        $validate = array(
            'house_id'=>array(
                'name'=> 'House Name ',
                'required'=>true
            ),
            'attribute_id'=>array(
                'name'=> 'Attributes',
                'required'=>true
            ),
            'attribute_value'=>array(
                'name'=> 'Specifications Value',
                'required'=>true
            )
        );
        //var_dump($validate);die();
        $this->validate($_POST, $validate);
        if ($this->getValidationStatus()){
            //var_dump($this->getValidationStatus());exit;
            //if the validation has passed, run a query to insert the details
            //into the database
            if($this-> addHousattrd($house_id,$attribute_id,$attribute_value )){
                //var_dump($this->addHousattrd());exit();
                $_SESSION[''] = true;
                $this->flashMessage('house_attr', 'success', 'The House Attribute has been Attached.');
            }else{
                $this->flashMessage('house_attr', 'error', 'Failed to Attach House Attribute! ' . get_last_error());
            }
        }

    }

    public function addHousattrd($house_id,$attribute_id,$attribute_value ){
        $result = $this->insertQuery('house_attr_allocations',
            array(
                'house_id' => $house_id,
                'attribute_id' => $attribute_id,
                'attr_value' => $attribute_value
            )
        );
        return $result;
    }

    public function editHouseAttribute(){
        extract($_POST);
        //var_dump($_POST);exit;
        $validate = array(
            'attribute_value'=>array(
                'name'=> 'Specifications Value',
                'required'=>true
            )
        );

        $this->validate($_POST, $validate);
        if ($this->getValidationStatus()){
            //if the validation has passed, run a query to insert the details
            //into the database
            $result = $this->updateQuery2(
                'house_attr_allocations',
                array('attr_value' => $attribute_value
                ),
                array(
                    'house_attr_id' => $edit_id
                )
            );
            if($result){
                $this->flashMessage('house_attr', 'success', 'House Attribute has been Updated.');
            }else{
                $this->flashMessage('house_attr', 'error', 'Failed to update House Attribute! ' . get_last_error());
            }
        }
    }

    public function detachHouseAttribute($delete_id){
        extract($_POST);
        $result= $this->deleteQuery('house_attr_allocations', "house_attr_id = '".$delete_id."'");
        if($result)
            $this->flashMessage('house_attr', 'success', 'The House Attribute has been Detached.');
        else
            $this->flashMessage('house_attr', 'error', 'Encountered an error! '.get_last_error());
    }
    //method to prepare data to be inserted to the db
    private
        $_square_footage ='',
        $_rent_rate='',
        $_rate_per_sqrft = 0,
        $_rent_amount,
        $_service_charge ='',
        $_charge_rate = 0,
        $_total_service_charge= 0;

    public function addHouse(){
        extract($_POST);
//        var_dump($_POST);die();
        $validate = array(
            'house_number' => array(
                'name' => 'House No',
                'required' => true),
            'rent_rate'=>array(
                'name'=>'Rent rate',
                'required'=>true
            ),
//            'service_charge'=>array(
//                'name'=> 'Service charge',
//                'required'=>true
//            ),
            'plot' => array(
                'name' => 'Plot',
                'required' => true
            ),
            'rent_amount'=>array(
                'name'=>'Rent Amount',
                'required'=>true
            )

        );
        $this->_rent_amount = $_POST['rent_amount'];
        $this->validate($_POST, $validate);
        if ($this->getValidationStatus()) {
            //check for existing entry
            $results = $this->selectQuery('houses','house_number',"house_number = '".$house_number."' AND plot_id = '".$plot."'");
//            var_dump($results);die;
            if(count($results)> 0){
                $this->setWarning('Unit Number ('.$_POST['house_number'].') already exists in this property');
            }
            //if the validation has passed, run a query to insert the details
            //into the database
            if($rent_rate == 'per-sqr-ft'){
                $this->_rent_rate =$rent_rate;
                (!empty($sqr_feet))? $this->_square_footage = $sqr_feet : $this->setWarning('Square footage is required');
                (!empty($rate))? $this->_rate_per_sqrft = $rate : $this->setWarning('Rate per square footage is required');
            }else{
                $this->_rent_rate =$_POST['rent_rate'];
                $data =0;
                $this->_square_footage = $data;
                $this->_rate_per_sqrft = $data;
            }
            if($service_charge == 'charge_per_sqr_feet'){
                $this->_service_charge =$service_charge;
                (!empty($rate_sqrf))? $this->_charge_rate = $rate_sqrf : $this->setWarning('Rate per squre foot is required');
                (!empty($service_charge_amount))? $this->_total_service_charge = $service_charge_amount : $this->setWarning('Total service charge is requred');
            }elseif ($service_charge == 'percentage_of_rent'){
                $this->_service_charge = $service_charge;
                (!empty($percent_rent))? $this->_charge_rate = $percent_rent*0.01 : $this->setWarning('percentage rate is required');
                $this->_total_service_charge =$service_charge_amount;
            }elseif ($service_charge == 'none'){
                $data = 0;
                $this->_total_service_charge = $data;
                $this->_charge_rate = $data;
            }
            if(count($this->getWarnings())== '') {
                if ($this->addHouseDetails($house_number, $plot, $this->_rent_amount,$this->_square_footage, $this->_rent_rate, $this->_rate_per_sqrft,$this->_service_charge, $this->_charge_rate,$this->_total_service_charge)) {
                        $this->flashMessage('p_units', 'success', 'House has been added.');
                } else {
                        $this->flashMessage('p_units', 'error', 'Failed to add the house! ' . get_last_error());
                }
            }
        }
    }
        //method to insert house details into the db
        public function addHouseDetails($house_number, $plot_id, $rent_amount,$square_footage, $rent_rate, $rate_perft,$service_charge, $charge_rate,$total_service_charge){
            $result = $this->insertQuery('houses',array(
                'house_number' => ucfirst($house_number),
                'plot_id' => $plot_id,
                'rent_amount'=> $rent_amount,
                'square_footage'=>$square_footage,
                'rent_rate'=>$rent_rate,
                'rate_per_square_footage'=>$rate_perft,
                'service_charge'=>$service_charge,
                'service_charge_rate'=>$charge_rate,
                'total_service_charge'=>$total_service_charge
            ));
            return $result;
        }

    public function getAllplts(){
        $query = "SELECT * FROM plots";
        $results = run_query($query);
        return $results;

    }
    //function to fetch for edit data
    public function getHouseDataFromId($id){
        if(!empty($id)){
            $data = $this->selectQuery('houses', '*', "house_id = '".$id."'");
            echo json_encode($data[0]);
        }
    }

    //function to delete a house
    public function deleteHouse(){
        extract($_POST);
//        var_dump($_POST);die();
        $result= $this->deleteQuery('houses', "house_id = '".$delete_id."'");
        if($result)
            $this->flashMessage('p_units', 'success', 'House deleted.');
        else
            $this->flashMessage('p_units', 'error', 'House not deleted! '.get_last_error());

    }


    //method to edit house details
    public function editHouse(){
        extract($_POST);
//        var_dump($_POST);die();
        $validate = array(
            'house_number' => array(
                'name' => 'House No',
                'required' => true),
            'rent_amount'=>array(
                'name'=>'Rent Amount',
                'required'=>true
            )
        );
        $this->validate($_POST, $validate);
        if ($this->getValidationStatus()) {
            $this->_rent_amount = $rent_amount;
            if($rent_rate == 'per-sqr-ft'){
                $this->_rent_rate = $rent_rate;
                (!empty($sqr_feet))? $this->_square_footage = $sqr_feet : $this->setWarning('Square footage is required');
                (!empty($rate))? $this->_rate_per_sqrft = $rate : $this->setWarning('Rate per square footage is required');
            }else{
                $this->_rent_rate ='flat-rate';
                $data =0;
                $this->_square_footage = $data;
                $this->_rate_per_sqrft = $data;
            }
            if($service_charge == 'charge_per_sqr_feet'){
                $this->_service_charge = $service_charge;
                (!empty($rate_sqrf))? $this->_charge_rate = $rate_sqrf : $this->setWarning('Rate per squre foot is required');
                (!empty($service_charge_amount))? $this->_total_service_charge = $service_charge_amount : $this->setWarning('Total service charge is requred');
            }elseif ($service_charge == 'percentage_of_rent'){
                $this->_service_charge = $service_charge;
                (!empty($percent_rent))? $this->_charge_rate = $percent_rent*0.01 : $this->setWarning('percentage rate is required');
                $this->_total_service_charge = $service_charge_amount;
            }elseif ($service_charge == 'none'){
                $this->_service_charge = 'none';
                $data = 0;
                $this->_total_service_charge = $data;
                $this->_charge_rate = $data;
            }
            //if the validation has passed, run a query to insert the details
            //into the database
            if(count($this->getWarnings())== '') {


                if ($this->editHouseDetails($house_number, $this->_rent_amount, $this->_square_footage, $this->_rent_rate, $this->_rate_per_sqrft, $this->_service_charge, $this->_charge_rate, $this->_total_service_charge,$edit_id)) {
                    $this->flashMessage('p_units', 'success', 'House has been edited.');
                } else {
                    $this->flashMessage('p_units', 'error', 'Failed to edit house details! ' . get_last_error());
                }
            }
        }
    }

    public function editHouseDetails($house_number, $rent_amount,$square_footage, $rent_rate, $rate_perft,$service_charge, $charge_rate,$total_service_charge,$edit_id){
        $result = $this->updateQuery2('houses',array(
            'house_number' => ucfirst($house_number),
            'rent_amount'=> $rent_amount,
            'square_footage'=>$square_footage,
            'rent_rate'=>$rent_rate,
            'rate_per_square_footage'=>$rate_perft,
            'service_charge'=>$service_charge,
            'service_charge_rate'=>$charge_rate,
            'total_service_charge'=>$total_service_charge
        ),
            array(
                'house_id'=>$edit_id
            ));
        return $result;
    }

    //function to get the name of the plot given the plot id
    public function getPlotName($p_id){
        $rows= $this->selectQuery('plots', 'plot_name'," plot_id = '".$p_id."' ");

        //$pname = $rows['plot_name'];
       // var_dump($rows);die();
        return $rows[0]['plot_name'];

    }

    //method to get all allocation details of a house
    public function getAllocDetails($id){
        $results = $this->selectQuery('house_attributes','*'," house_id = '".$id."' ");
        return $results;
    }

    public function getAllMyTenants(){
        $data = $this->selectQuery('pm_tenants', '*', "created_by = '".$_SESSION['mf_id']."'");
        return $data;
    }

    public function getAllMyLandlords(){
        $data = $this->selectQuery('my_landlords', '*', "created_by = '".$_SESSION['mf_id']."'");
        return $data;
    }

    public function getAllMyPm(){
        $data = $this->selectQuery('my_property_managers', '*', "landlord_mf_id = '".$_SESSION['mf_id']."'");
        return $data;
    }

    public function getAllPlotsUnderLandlord(){
        $data = $this->selectQuery('landlords_plots', '*', "pm_mfid = '".$_SESSION['mf_id']."'");
        return $data;
    }

    public function getAllContractorsUnderPM(){
        $data = $this->selectQuery('pm_contractors', '*', "pm_mfid = '".$_SESSION['mf_id']."'");
        return $data;
    }

    public function getAllMyHouses(){
        $data = $this->selectQuery('my_houses', '*', "landlord_mf_id = '".$_SESSION['mf_id']."'");
        return $data;
    }
    //function to get house allocation details
    public function getDetails($id){
        $results = $this->selectQuery('house_attr_allocations','attr_value'," house_attr_id = '".$id."' ");
        echo json_encode($results[0]);
    }
    //function to get all services attachd to a house
    public function getAllServices($type){
        $results = $this->selectQuery('service_channels','*'," service_option_type ='".$type."'");
        return $results;

    }
    //function to attach services to a house when checkbox is clicked
    public function attachService($service_id, $house_id){
        $return  = array();
        $rows = $this->selectQuery('house_services', 'COUNT(*) AS count',
            "house_id = '".sanitizeVariable($house_id)."' AND service_channel_id = '".sanitizeVariable($service_id)."'");
        $count = $rows[0]['count'];

        if($count > 0){
            $this->setWarning('House is already attached to the selected service!');
        }
        if(count($this->getWarnings()) == 0){
            $this->setPassed(true);
        }
        $valid = $this->getValidationStatus();
        if($valid) {
            $result = $this->insertQuery('house_services', array(
                'service_channel_id' => $service_id,
                'house_id' => $house_id
            ));
            if ($result) {
                $return = array(
                    'success' => true
                );
            } else {
                $return = array(
                    'success' => false
                );
            }
        }else{
            $return = array(
                'success' => false,
                'warnings' => $this->getWarnings()
            );
        }
        return $return;
    }
    //function to detach a house service on uncheck
    public function detachService($s_id,$h_id){
        $query = "delete from house_services where house_id = '$h_id' and service_channel_id = '$s_id'";
        $result = run_query($query);
//        $result =$this->deleteQuery2('house_services',array(
//            'house_service_id' => $s_id,
//            'house_id' => $h_id
//        ));
        if($result){
            $return = array(
                'success' => true
            );
        }else{
            $return = array(
                'success' => false
            );
        }
        return $return;
    }
    //function to get either house name or propertynname
    public function getAppropriateName(){
        if (isset($_GET['house_id'])&&!empty($_GET['house_id'])){
            $id = $_GET['house_id'];
            $result = $this->selectQuery('houses','house_number', "house_id = '".$id."'");
            echo 'Unit: '. $result[0][0];
        }else{
            if (isset($_GET['prop_id'])&&!empty($_GET['prop_id'])){
                $id = $_GET['prop_id'];
                $result = $this->selectQuery('plots','plot_name', "plot_id = '".$id."'");
                //var_dump($result);
                echo 'Property Name : '. $result[0][0];
            }
        }
    }
    //function to detach services from a house/unit
    public function unAttachedServices($house_id){
        $house_services = $this->selectQuery('house_services', '*', " house_id = '".$house_id."'");
//        var_dump($house_services);die;
        // collect all the service ids attached to the selected property
        $hs_service_ids = array();
        if(count($house_services)){
            foreach ($house_services as $house_service){
                $hs_service_ids[] = $house_service['service_channel_id'];
            }
        }
        //print_r($hs_service_ids);
        $return = array();
        $role = $_SESSION['role_name'];
        if($role != SystemAdmin) {
            $leaf_services = $this->selectQuery('service_channels', 'service_option, option_code, service_channel_id, price',
                "service_option_type = '" .leaf. "' AND status IS TRUE AND created_by = '" .$_SESSION['mf_id']. "' ");
        }else{
            $leaf_services = $this->selectQuery('service_channels', 'service_option, option_code, service_channel_id, price',
                "service_option_type = '" .leaf. "' AND status IS TRUE ");
        }
        if(count($leaf_services)){
            foreach ($leaf_services as $leaf_service){
                if(!in_array($leaf_service['service_channel_id'], $hs_service_ids)){
                    $return[] = array('service_channel_id' => $leaf_service['service_channel_id'],
                        'service_option_name'=> $leaf_service['service_option'],
                        'code'=>$leaf_service['option_code'],
                        'price'=> $leaf_service['price']
                    );
                }
            }
        }

        return $return;

    }
    public function attachHouseService(){
        extract($_POST);
//        var_dump($_POST);die;
        if(count($_POST['service_id']) ) {
            $this->beginTranc();
            foreach ($service_id as $id) {
                $result = $this->insertQuery('house_services', array(
                    'service_channel_id' => $id,
                    'house_id' => $house_id
                ));
                $this->endTranc();
                if ($result) {
                    $this->flashMessage('h_services', 'success', 'Services have been attached!');
                } else {
                    $this->flashMessage('h_services', 'error', 'Failed to attach services!' . get_last_error());
                }

            }
        }
    }
    public function detachHouseService(){
        extract($_POST);
//        var_dump($_POST);die;
        $result = $this->deleteQuery('house_services',"house_id = '".$house_id."' AND house_service_id = '".$service_id."'");
        if($result){
            $this->flashMessage('h_services','success','The service has been detached');
        }else{
            $this->flashMessage('h_services','error','Failed to dettach service'. get_last_error());
        }
    }
}
    

