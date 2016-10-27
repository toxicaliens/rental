// $(document).ready(function(){
$('#b_role').change(function(){
    var role = $(this).val();
    if(role=="tenant"){
        $('#user_role').attr('disabled','disabled');
    }else if(role=="contractor"){
        $('#user_role').attr('disabled', 'disable');
    }else if(role=="land_lord"){
        $('#user_role').removeAttr('disabled');
    }else if(role=="property_manager"){
        $('#user_role').removeAttr('disabled');
    }
});

$('#b_role').change(function(){
    var role = $(this).val();
    if(role=="land_lord"){
        $('#house').attr('disabled','disabled');
    }else if(role=="property_manager"){
        $('#house').attr('disabled', 'disable');
    }else if(role=="tenant"){
        $('#house').removeAttr('disabled');
    }else if(role=="contractor"){
        $('#house').removeAttr('disabled');
    }
});






