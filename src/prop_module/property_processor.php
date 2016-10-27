<?php
include_once 'src/models/Plots.php';
$prop = new Plots();
switch($_POST['action'])
{
    case add_property:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $prop->addPlot($_POST);
        $_SESSION['warnings'] = $prop->getWarnings();
    break;

    case edit_property:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $prop->editPlot($_POST);
        $_SESSION['warnings'] = $prop->getWarnings();
        break;

    case delete_property:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $prop->deletePlot($_POST['delete_id']);
        break;
    case add_attribute:
        //var_dump($_POST);exit;
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $prop->addAttrb();
        break;

    case edit_attribute:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $prop->editAttribute();
        break;

    case delete_attribute:
        //var_dump($_POST);die;
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $prop->deleteAttribute();
        $_SESSION['warnings'] = $prop->getWarnings();
        break;


    case attch_prop_attr:
//        var_dump($_POST);die;
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $prop->attachPropertyAttribute();
        $_SESSION['warnings'] = $prop->getWarnings();
        break;
    case edit_house_prop_attr:
        extract($_POST);
//        var_dump($_POST);exit();
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $prop->editPropAttribute();
        $_SESSION['warnings'] = $prop->getWarnings();
        break;

    case delete_prop_attr:
        extract($_POST);
        //var_dump($_POST);exit();
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $prop->detachPropAttribute();
        break;
    case 'attach_property_service':
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $prop->attachServiceToProperty();
        $_SESSION['warnings'] = $prop->getWarnings();
        break;
    case 'detach_property_service':
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $prop->detachPropertyService();
        $_SESSION['warnings'] = $prop->getWarnings();
}
?>
