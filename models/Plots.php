<?php
require_once 'src/models/Masterfile.php';
/**
 * Created by PhpStorm.
 * User: erick.murimi
 * Date: 7/14/2016
 * Time: 11:45 AM
 */
class Plots extends Masterfile{
    public function getAllPlots(){
        $data = $this->selectQuery('plots', '*');
        return $data;
    }

    public function addPlot($post){
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
            'payment_code' => array(
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
            'option_type'=> array(
                'name' => 'Option Type',
                'required' => true
            ),
            'location'=> array(
                'name'=> 'Location',
                'required'=> true
            )

        ));

        if($this->getValidationStatus()) {
            $result = $this->insertQuery('plots',
                array(
                    'plot_name' => $post['plot_name'],
                    'payment_code' => $post['payment_code'],
                    'pm_mfid' => $post['property_manager'],
                    'date_created' => date('Y-m-d'),
                    'paybill_number' => $post['paybill_number'],
                    'units' => $post['units'],
                    'landlord_mf_id' => $post['landlord'],
                    'lr_no' => $post['lr_no'],
                    'prop_type'=> $post['property_type'],
                    'option_type'=> $post['option_type'],
                    'location' => $post['location'],
                    'created_by'=>$post['created_by']
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
            if($this-> addHousattrd($prop_id,$attribute_id,$attribute_value )){
                //var_dump($this->addHousattrd());exit();
                $this->flashMessage('house', 'success', 'The Property Attribute has been Attached.');
            }else{
                $this->flashMessage('house', 'error', 'Failed to Attach Property Attribute! ' . get_last_error());
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
                $this->flashMessage('house', 'success', 'Property Attribute has been Updated.');
            }else{
                $this->flashMessage('house', 'error', 'Failed to update Property Attribute! ' . get_last_error());
            }
        }
    }

    //function to detach a property attribute
    public function detachPropAttribute($delete_id){
        extract($_POST);
        $result= $this->deleteQuery('property_attr_alloc', "unit_alloc_id = '".$delete_id."'");
        if($result)
            $this->flashMessage('house', 'success', 'The Property Attribute has been Detached.');
        else
            $this->flashMessage('house', 'error', 'Encountered an error! '.get_last_error());
    }

    //function to get property name
    public function getAttrNameByID($id){
        $result = $this->selectQuery('property_attributes','prop_attr_name',"prop_attr_id = '".$id."'");
        return $result[0][0];
    }

    //function to get properties for the property manager who created them

    public function getPropertiesByPmId($table, $id){
        $results = $this->selectQuery( $table ,'*'," created_by = '".$id."' ");
        return $results;
    }

}