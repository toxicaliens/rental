<?php
require_once 'src/models/Masterfile.php';
/**
 * Created by PhpStorm.
 * User: erick.murimi
 * Date: 7/14/2016
 * Time: 11:45 AM
 */
class Plots extends Masterfile{
    private $_column = null;

    public function getAllPlots(){
        $data = $this->selectQuery('plots', '*' );
        return $data;
    }

    public function addPlot($post){
        extract($_POST);
        $pm = $_SESSION['mf_id'];
        if(isset($post['property_manager'])){
            if(!empty($post['property_manager'])){
                $pm = $post['property_manager'];
            }
        }
        $lld = $_SESSION['mf_id'];
        if(isset($post['landlord'])){
            if(!empty($post['landlord'])){
                $lld = $post['landlord'];
            }
        }
        //var_dump($_POST);exit;
        $this->validate($post, array(
            'plot_name' => array(
                'name' => 'Name',
                'required' => true,
                'unique' => 'plots'
            ),
            'lr_no' => array(
                'name' => 'Land Reg. No',
                'required' => true,
                'unique' => 'plots'
            ),
            'units' => array(
                'name' => 'Units',
                'required' => true
            ),
            'property_type' => array(
                'name' => 'Property Type',
                'required' => true
            ),
            'county'=>array(
                'name'=>'County',
                'required'=>true
            ),
            'town_city'=>array(
                'name'=>'Town/City',
                'required'=>true
            ),
            'region'=>array(
                'name'=>'Region',
                'required'=>true
            ),
            'longitude_latitude'=>array(
                'name'=>'Longitude and Latitude',
                'required'=>true
            )

        ));
        if(!isset($_POST['option_type'])){
            $option_type = '';
        }else{
            $option_type = $_POST['option_type'];
        }

        if($this->getValidationStatus()) {
            $result = $this->insertQuery('plots',
                array(
                    'plot_name' => $post['plot_name'],
                    'pm_mfid' => $pm,
                    'date_created' => date('Y-m-d'),
                    'units' => $post['units'],
                    'landlord_mf_id' => $lld,
                    'lr_no' => $post['lr_no'],
                    'prop_type'=> $post['property_type'],
                    'option_type'=> $option_type,
                    'created_by'=> $_SESSION['mf_id'],
                    'county'=>$_POST['county'],
                    'town_city'=>$_POST['town_city'],
                    'street'=>$_POST['street'],
                    'building_number'=>$_POST['building_number'],
                    'region'=>$_POST['region'],
                    'longitude_latitude'=>$_POST['longitude_latitude']
                )
            );
            if($result){
                $this->flashMessage('plots', 'success', 'A new Plot has been added!');
            }else{
                $this->flashMessage('plots', 'error', 'Encountered an error!');
            }
        }
    }

    public function editPlot($post){
//        var_dump($post);exit;
        $this->validate($post, array(
            'ed_plot_name' => array(
                'name' => 'Name',
                'required' => true,
                'unique2' => array(
                    'table' => 'plots',
                    'skip_column' => 'plot_id',
                    'skip_value' => $post['edit_id'],
                )
            ),
            'payment_code' => array(
                'name' => 'Payment Code',
                'unique2' => array(
                    'table' => 'plots',
                    'skip_column' => 'plot_id',
                    'skip_value' => $post['edit_id']
                )
            ),
            'lr_no' => array(
                'name' => 'Land Reg. No',
                'required' => true,
                'unique2' => array(
                    'table' => 'plots',
                    'skip_column' => 'plot_id',
                    'skip_value' => $post['edit_id']
                )
            ),
            'ed_units' => array(
                'name' => 'Units',
                'required' => true
            ),
        ));

        if($this->getValidationStatus()) {
            $result = $this->updateQuery2('plots',
                array(
                    'plot_name' => $post['ed_plot_name'],
                    'payment_code' => $post['payment_code'],
                    'pm_mfid' => $post['ed_property_manager'],
                    'paybill_number' => $post['ed_paybill_number'],
                    'units' => $post['ed_units'],
                    'landlord_mfid' => $post['ed_landlord'],
                    'prop_type'=> $post['property_type'],
                    'option_type'=> $post['option_type'],
                    'location' => $post['location']
                ),
                array(
                    'plot_id' => $post['edit_id']
                )
            );
            
            if($result){
                $this->flashMessage('plots', 'success', 'A new Plot has been added!');
            }else{
                $this->flashMessage('plots', 'error', 'Encountered an error!');
            }
        }
    }

    public function deletePlot($id){
        if($this->deleteQuery2('plots', array(
            'plot_id' => $id
        ))){
            $this->flashMessage('plots', 'success', 'Plot has been deleted');
        }else{
            $this->flashMessage('plots', 'warning', 'The Plot is being used somewhere else in the system!');
        }
    }

    public function getPlotByPlotId($id){
        $data = $this->selectQuery('plots', '*', "plot_id = '".sanitizeVariable($id)."' ");
        echo json_encode($data[0]);
    }

    //function to fetch for the property type either commercial or residentioal
    public function getPlotType(){
        $result = $this->selectQuery('property_type','*');
        return $result;
    }

    //function to call ajax for option data
    public function getOptionDataById($id){
        $results = $this->selectQuery('plot_type_options','*',"plot_type_id = '".sanitizeVariable($id)."' ");
        echo json_encode($results);
    }
    //function to return an option name given the id
    public function getOptionName($id){
        $result = $this->selectQuery('plot_type_options','option_name',"option_id = '".sanitizeVariable($id)."' ");
        return $result[0][0];
    }
    //function to return the name of the propert
    public function getName($id){
        $result = $this->selectQuery('property_type','plot_type_name',"plot_type_id = '".sanitizeVariable($id)."' ");
        return $result[0][0];
    }
    //method to get all attributes
    public function getAllAttributes(){
        $rows = $this-> selectQuery('property_attributes', '*');
        return $rows;
    }

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
        $result = $this->insertQuery('property_attributes',
            array(
                'prop_attr_name' => $attrib_name
            ));
        return $result;
    }

    public function editAttribute(){
        extract($_POST);
        //update the attribute name
        $edit_id = $_POST['edit_id'];
        $validate = array(
            'name'=>array(
                'prop_attr_name'=> 'Attribute Name',
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
        $result = $this->updateQuery2('property_attributes',
            array(
                'prop_attr_name' => $name
            ),
            array('prop_attr_id' => $edit_id)
        );
        return $result;
    }

    public function deleteAttribute(){
        extract($_POST);
        //var_dump($_POST);die;
        $result = $this->deleteQuery('property_attributes', "prop_attr_id = '".$delete_id."'");
        if($result)
            $this->flashMessage('attributes', 'success', 'The Attribute has been Deleted.');
        else
            $this->flashMessage('attributes', 'error', 'Encountered an error! '.get_last_error());
    }
    public function getAllocDetails($id){
        $id;
        $results = $this->selectQuery('property_attr_alloc','*'," plot_id = '".$id."' ");
        //var_dump($results);die;
        return $results;
    }

    public function listAllAttributes(){
        $rows = $this->selectQuery('property_attributes', '*');
        return $rows;
    }
    public function checkIfHouseAttributeisAttached($house,$attribute){
        $query = "SELECT * FROM property_attr_alloc 
		WHERE house_id = '".sanitizeVariable($house)."' AND attribute_id = '".sanitizeVariable($attribute)."' 
		";
        $result = run_query($query);
        $num_rows = get_num_rows($result);
        if($num_rows == 1){
            return true;
        }
    }

    public function attachPropertyAttribute(){
        extract($_POST);
        //var_dump($_POST);die();
        $validate = array(
            'prop_id'=>array(
                'name'=> 'Property Name ',
                'required'=>true
            ),
            'attribute_id'=>array(
                'name'=> 'Attribute name',
                'required'=>true
                //'unique'=>'house_attr_allocations'
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
            if($this->addHousattrd($prop_id,$attribute_id,$attribute_value)){
                $this->flashMessage('prop_attr', 'success', 'The Property Attribute has been Attached.');
            }else{
                $this->flashMessage('prop_attr', 'error', 'Failed to Attach Property Attribute! ' . get_last_error());
            }
        }

    }
    public function addHousattrd($prop_id,$attribute_id,$attribute_value ){
        $result = $this->insertQuery('property_attr_alloc',
            array(
                'plot_id' => $prop_id,
                'prop_attr_id' => $attribute_id,
                'value' => $attribute_value
            )
        );
        return $result;
    }

    public function editPropAttribute(){
        extract($_POST);
       // var_dump($_POST);exit;
        $validate = array(
                    'attribute_value'=>array(
                    'name'=> 'Attribute Value',
                    'required'=>true
                )
            );

        $this->validate($_POST, $validate);
        if ($this->getValidationStatus()){
            //if the validation has passed, run a query to insert the details
            //into the database
            $result = $this->updateQuery2(
                'property_attr_alloc',
                array('value' => $attribute_value
                ),
                array(
                    'unit_alloc_id' => $edit_id
                )
            );
            if($result){
                $this->flashMessage('prop_attr', 'success', 'Property Attribute has been Updated.');
            }else{
                $this->flashMessage('prop_attr', 'error', 'Failed to update Property Attribute! ' . get_last_error());
            }
        }
    }

    //function to detach a property attribute
    public function detachPropAttribute($delete_id){
        extract($_POST);
        $result= $this->deleteQuery('property_attr_alloc', "unit_alloc_id = '".$delete_id."'");
        if($result)
            $this->flashMessage('prop_attr', 'success', 'The Property Attribute has been Detached.');
        else
            $this->flashMessage('prop_attr', 'error', 'Encountered an error! '.get_last_error());
    }

    //function to get property name
    public function getAttrNameByID($id){
        $result = $this->selectQuery('property_attributes','prop_attr_name',"prop_attr_id = '".$id."'");
        return $result[0][0];
    }

    //function to get properties for the property manager who created them

    public function getPropertiesByRole($table, $id){
        $results = $this->selectQuery( $table ,'*'," created_by = '".$id."' ");
        return $results;
    }
    //method to check the user role
    public function checkRole($mf){
        $result = $this->selectQuery('user_login2', '*', "mf_id =  '" . $mf . "'");

        return $result[0]['user_role'];
    }

    public function getPropertyDataByRole(){
        //check whether user is a property manager or a tenant

        $role = $this->checkRole($_SESSION['mf_id']);
        if ($role == 66) {
            //user is a property manager
            $result =  $this->selectQuery('plots','*', " pm_mfid=  '" . $_SESSION['mf_id']. "' ");
        } else if ($role == 68) {
            //user is a landlord
            $result =  $this->selectQuery('plots','*', " landlord_mf_id=  '" . $_SESSION['mf_id']. "' ");
        } else if ($role == 3){
            $result = $this->selectQuery('plots', '*');
        }
        //var_dump($result);die;

        return $result;
    }
    //function to attach services to a house when checkbox is clicked
    public function attachPropertyServices($service_id, $prop_id){
        $return  = array();
        $rows = $this->selectQuery('property_services', 'COUNT(*) AS count',
            "plot_id = '".sanitizeVariable($prop_id)."' AND service_channel_id = '".sanitizeVariable($service_id)."'");
        $count = $rows[0]['count'];

        if($count > 0){
            $this->setWarning('House is already attached to the selected service!');
        }
        if(count($this->getWarnings()) == 0){
            $this->setPassed(true);
        }
        $valid = $this->getValidationStatus();
        if($valid) {
            $result = $this->insertQuery('property_services', array(
                'service_channel_id' => $service_id,
                'plot_id' => $prop_id
            ));
            if ($result) {
                $return = array(
                    'success' => true
                );
                $_SESSION['attached'] = true;
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
    //function to detach a house service on un check
    public function detachPropertyService(){
        extract($_POST);
//        var_dump($_POST);die;
        $result = $this->deleteQuery('property_services',"plot_id = '".$property_id."' AND property_service_id = '".$service_id."'");
//        $query = "delete from property_services where plot_id = '$property_id' and service_channel_id = '$service_id'";
//        $result = run_query($query);
//        $result =$this->deleteQuery2('house_services',array(
//            'house_service_id' => $s_id,
//            'house_id' => $h_id
//        ));
        if($result){
           $this->flashMessage('p_services','success','The service has been detached');
        }else{
            $this->flashMessage('p_services','error','Failed to detach service'. get_last_error());
        }

    }

    public function getAllPropertyUnits($id){
        $result = $this->selectQuery('unit_details_by_prop', '*',"plot_id = '".$id."'");
//        $role = $_SESSION['role_name'];
//        if ($role == PM) {
//
//        }elseif ($role == LandLord){
//            $this->_column = 'landlord_mf_id';
//        }else{
//            $result = $this->selectQuery('property_unit_details', '*',"plot_id = '".$id."'");
//        }
////        if($role !== SystemAdmin){
////            $result = $this->selectQuery('property_unit_details', '*', " '" . $this->_column . "' = '" . $_SESSION['mf_id'] . "' ");
////        }
        return $result;
//        var_dump($result);die;
    }

    //function to  return services that are not attached
    public function unAttachedServices($prop_id){
        $house_services = $this->selectQuery('property_services', '*', "plot_id = '" .$prop_id."'");
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

    //function to attach property services
    public function attachServiceToProperty(){
        extract($_POST);
//        var_dump($_POST);die;
        $validate = array(
//            'service_id'=> array(
//                'name'=>'Service name',
//                'required'=>true
//            ),
            'property_id'=>array(
               'name'=>'Property Name',
                'required'=>true
            )
        );
//        var_dump($validate);die;
        $this->validate($_POST, $validate);
//        $valid = $this->getValidationStatus();
//        var_dump($valid);die;
        if($this->getValidationStatus()){
           // var_dump(count($service_id));die;
            if(count($_POST['service_id']) ) {
                $this->beginTranc();
                foreach ($service_id as $id) {
                    $result = $this->insertQuery('property_services', array(
                        'service_channel_id' => $id,
                        'plot_id' => $property_id
                    ));
                    $this->endTranc();
                    if ($result) {
                        $this->flashMessage('p_services', 'success', 'Services have been attached!');
                    } else {
                        $this->flashMessage('p_services', 'error', 'Failed to attach services!' . get_last_error());
                    }

                }
            }
        }
    }



}