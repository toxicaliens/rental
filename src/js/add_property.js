/**
 * Created by joel on 8/31/16.
 */

// start form wizard validation
var FormWizard = function () {

    var form1 = $('#form_sample_1');
    return {
        //main function to initiate the module
        init: function () {
            if (!jQuery().bootstrapWizard) {
                return;
            }

            // default form wizard
            $('#form_wizard_1').bootstrapWizard({
                'nextSelector': '.button-next',
                'previousSelector': '.button-previous',
                onTabClick: function (tab, navigation, index) {
                    alert('on tab click disabled');
                    return false;
                },
                onNext: function (tab, navigation, index) {
                    // validate
                    var valid = Masterfile.validateMyWizard();
                    if(!valid){
                        return false;
                    }

                    var total = navigation.find('li').length;
                    var current = index + 1;

                    // validate address details
                    if(current == 3){
                        var valid2 = Masterfile2.validateMyWizard2();
                        if(!valid2){
                            return false;
                        }
                    }

                    // set wizard title
                    $('.step-title', $('#form_wizard_1')).text('Step ' + (index + 1) + ' of ' + total);
                    // set done steps
                    jQuery('li', $('#form_wizard_1')).removeClass("done");
                    var li_list = navigation.find('li');
                    for (var i = 0; i < index; i++) {
                        jQuery(li_list[i]).addClass("done");
                    }

                    if (current == 1) {
                        $('#form_wizard_1').find('.button-previous').hide();
                    } else {
                        $('#form_wizard_1').find('.button-previous').show();
                    }

                    if (current >= total) {
                        $('#form_wizard_1').find('.button-next').hide();
                        $('#form_wizard_1').find('.button-submit').show();
                    } else {
                        $('#form_wizard_1').find('.button-next').show();
                        $('#form_wizard_1').find('.button-submit').hide();
                    }
                    App.scrollTo($('.page-title'));
                },
                onPrevious: function (tab, navigation, index) {
                    var total = navigation.find('li').length;
                    var current = index + 1;
                    // set wizard title
                    $('.step-title', $('#form_wizard_1')).text('Step ' + (index + 1) + ' of ' + total);
                    // set done steps
                    jQuery('li', $('#form_wizard_1')).removeClass("done");
                    var li_list = navigation.find('li');
                    for (var i = 0; i < index; i++) {
                        jQuery(li_list[i]).addClass("done");
                    }

                    if (current == 1) {
                        $('#form_wizard_1').find('.button-previous').hide();
                    } else {
                        $('#form_wizard_1').find('.button-previous').show();
                    }

                    if (current >= total) {
                        $('#form_wizard_1').find('.button-next').hide();
                        $('#form_wizard_1').find('.button-submit').show();
                    } else {
                        $('#form_wizard_1').find('.button-next').show();
                        $('#form_wizard_1').find('.button-submit').hide();
                    }

                    App.scrollTo($('.page-title'));
                },
                onTabShow: function (tab, navigation, index) {
                    var total = navigation.find('li').length;
                    var current = index + 1;
                    var $percent = (current / total) * 100;
                    $('#form_wizard_1').find('.bar').css({
                        width: $percent + '%'
                    });
                }
            });

            $('#form_wizard_1').find('.button-previous').hide();
            $('#form_wizard_1 .button-submit').click(function () {
                // on submit validation
                var valid3 = Masterfile3.validateMyWizard3();
                if(!valid3){
                    return false;
                }
                //alert('Finished! Hope you like it :)');
            }).hide();
        }
    };
}();

//on tab next validations
var Masterfile = {
    validateMyWizard: function(){
        if($('#name').val() == ''){
            alert('You Must Provide Plot Name!');
            $('#name').focus();
            return false;
        }else if($('#option_type').val() == '') {
            alert('You Must Provide Property Type!');
            $('#option_type').focus();
            return false;
        }else if($('#pay_bill').val() == '') {
            alert('You Must Provide Pay Bill Number!');
            $('#pay_bill').focus();
            return false;
        }else if($('#payment_code').val() == '') {
            alert('You Must Provide Payment Code!');
            $('#payment_code').focus();
            return false;
        }else if($('#units').val() == '') {
            alert('You Must Provide Number of Units!');
            $('#units').focus();
            return false;
        }else{
            return true;
        }
    },
}

