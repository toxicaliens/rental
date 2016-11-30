$('#b_role').on('change', function(){
	var role = $(this).val();

	if(role == 'land_lord' || role == 'property_manager' || role == 'contractor' || role == 'supplier'){
		// alert('working');
		$('#account_no').removeAttr('disabled').val('');
		$('#bank_name').removeAttr('disabled').val('');
		$('#branch_name').removeAttr('disabled').val('');
		$('#pin_no').removeAttr('disabled').val('');
	}else if(role == 'tenant'){
		$('#account_no').attr('disabled', 'disabled').val('');
		$('#bank_name').attr('disabled', 'disabled').val('');
		$('#branch_name').attr('disabled', 'disabled').val('');
		$('#pin_no').attr('disabled', 'disabled').val('');
	}
});

$('#b_role').on('change', function(){
	var role = $(this).val();

	if(role == 'tenant'){
		// alert('working');
		$('.skill_name').hide();
		$('#occupation').removeAttr('disabled').val('');
		$('#user_role').attr('readonly', 'readonly').val('72');
	}else if(role == 'land_lord'){
		$('.skill_name').hide();
		$('#occupation').attr('disabled', 'disabled').val('');
		$('#user_role').attr('readonly', 'readonly').val('68');
	}else if(role == 'contractor'){
		$('.skill_name').show();
		$('#occupation').attr('disabled', 'disabled').val('');
		$('#user_role').attr('readonly', 'readonly').val('69');
	}else if(role == 'property_manager'){
		$('.skill_name').hide();
		$('#occupation').attr('disabled', 'disabled').val('');
		$('#user_role').attr('readonly', 'readonly').val('66');
	}else if (role == 'supplier'){
		$('.skill_name').hide();
		$('#occupation').attr('disabled', 'disabled').val('');
		$('#user_role').attr('disabled', 'disabled').val('');
	}
});

$('#b_role').on('change', function() {
	var role = $(this).val();
	if(role == 'contractor' || role== 'supplier'){
		$('.surname').text('Title').val('');
		$('.id_passport').text('Business No.').val('');
		$('.gender').hide();
		$('.firstname').hide();
		$('.middlename').hide();
	}else if('land_lord' || 'property_manager' || 'tenant'){
		$('.surname').text('Surname').val('');
		$('.id_passport').text('Id/Passport').val('');
		$('.gender').show();
		$('.firstname').show();
		$('.middlename').show();
	}
});


$('#bank_name').on('change', function(){
	var bank_id = $(this).val();
	var data = { 'bank_id': bank_id };

	if(bank_id != ''){
		$.ajax({
			url: '?num=722',
			type: 'POST',
			data: data,
			dataType: 'json',
			success: function(data){
				var branches = '<option value="">--Choose Branch--</option>';
				for(var i = 0; i < data.length; i++){
					branches += '<option value="'+data[i].branch_id+'">'+data[i].branch_name+'</option>';
				}
				$('#branch_name').html(branches);
			}
		});
	}
});

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
				//alert('Finished! Hope you like it :)');
			}).hide();
		}
	};
}();

//on tab next validations
var Masterfile = {
	validateMyWizard: function(){
		if($('#b_role').val() == ''){
			alert('You must provide a Business Role!');
			$('#b_role').focus();
			return false;
		}

		var b_role = $('#b_role').val();
		switch(b_role){
			case 'tenant':
				// validation
				if($('#surname').val() == ''){
					alert('You Must Provide Surname!');
					$('#surname').focus();
					return false;
				}else if($('#firstname').val() == ''){
					alert('You Must Provide First Name!');
					$('#firstname').focus();
					return false;
				}else if($('#email').val() == ''){
					alert('You Must Provide Email!');
					$('#email').focus();
					return false;
				}else if($('#id_passport').val() == ''){
					alert('You Must Provide Id/Passport!');
					$('#id_passport').focus();
					return false;
				}else if($('#gender').val() == ''){
					alert('You Must Provide Gender!');
					$('#gender').focus();
					return false;
				}else if($('#occupation').val() == ''){
					alert('You Must Provide Tenant Occupation!');
					$('#occupation').focus();
					return false;
				}else if($('#customer_type_id').val() == ''){
					alert('You Must Provide Masterfile Type!');
					$('#customer_type_id').focus();
					return false;
				}else{
					return true;
				}
			break;

			case 'land_lord':
				if($('#surname').val() == ''){
					alert('You Must Provide Surname!');
					$('#surname').focus();
					return false;
				}else if($('#firstname').val() == ''){
					alert('You Must Provide First Name!');
					$('#firstname').focus();
					return false;
				}else if($('#email').val() == ''){
					alert('You Must Provide Email!');
					$('#email').focus();
					return false;
				}else if($('#id_passport').val() == ''){
					alert('You Must Provide Id/Passport!');
					$('#id_passport').focus();
					return false;
				}else if($('#gender').val() == ''){
					alert('You Must Provide Gender!');
					$('#gender').focus();
					return false;
				}else if($('#customer_type_id').val() == ''){
					alert('You Must Provide Masterfile Type!');
					$('#customer_type_id').focus();
					return false;
				}else{
					return true;
				}
			break;

			case 'supplier':
				if($('#surname').val() == ''){
					alert('You Must Provide the Title!');
					$('#surname').focus();
					return false;
				}else if($('#email').val() == ''){
					alert('You Must Provide Email!');
					$('#email').focus();
					return false;
				}else if($('#id_passport').val() == ''){
					alert('You Must Provide business Number!');
					$('#id_passport').focus();
					return false;
				}else if($('#customer_type_id').val() == ''){
					alert('You Must Provide Masterfile Type!');
					$('#customer_type_id').focus();
					return false;
				}else{
					return true;
				}
			break;
			case 'contractor':
				if($('#surname').val() == ''){
					alert('You Must Provide the Title!');
					$('#surname').focus();
					return false;
				}else if($('#email').val() == ''){
					alert('You Must Provide Email!');
					$('#email').focus();
					return false;
				}else if($('#id_passport').val() == ''){
					alert('You Must Provide business Number!');
					$('#id_passport').focus();
					return false;
				}else if($('#customer_type_id').val() == ''){
					alert('You Must Provide Masterfile Type!');
					$('#customer_type_id').focus();
					return false;
				}else if($('#skill_id').val() == ''){
					alert('You Must Provide Core Activity for the Contractor!');
					$('#skill_id').focus();
					return false;
				}else{
					return true;
				}
				break;

			case 'property_manager':
				if($('#surname').val() == ''){
					alert('You Must Provide Surname of th Property Manager!');
					$('#surname').focus();
					return false;
				}else if($('#firstname').val() == ''){
					alert('You Must Provide First Name!');
					$('#firstname').focus();
					return false;
				}else if($('#email').val() == ''){
					alert('You Must Provide Email!');
					$('#email').focus();
					return false;
				}else if($('#id_passport').val() == ''){
					alert('You Must Provide Id/Passport!');
					$('#id_passport').focus();
					return false;
				}else if($('#gender').val() == ''){
					alert('You Must Provide Gender!');
					$('#gender').focus();
					return false;
				}else if($('#customer_type_id').val() == ''){
					alert('You Must Provide Masterfile Type!');
					$('#customer_type_id').focus();
					return false;
				}else{
					return true;
				}
			break;
		}
	},
}

// masterfile address details validation
var Masterfile2 = {
	validateMyWizard2: function(){
		if($('#select2_sample79').val() == ''){
			alert('You must provide County Name!');
			$('#select2_sample79').focus();
			return false;
		}else if($('#town').val() == ''){
			alert('You must provide Town/City for the selected County!');
			$('#town').focus();
			return false;
		}else if($('#phone').val() == ''){
			alert('You must provide Provide Phone Number!');
			$('#phone').focus();
			return false;
		}else if($('#box').val() == ''){
			alert('You must provide Box Number!');
			$('#box').focus();
			return false;
		}else if($('#postal_code').val() == ''){
			alert('You must provide Postal Code!');
			$('#postal_code').focus();
			return false;
		}else if($('#address_type_id').val() == ''){
			alert('You must provide Address Type!');
			$('#address_type_id').focus();
			return false;
		}else{
			return true;
		}
	},
}

//end of wizard validation