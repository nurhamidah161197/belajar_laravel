var Login = function() {

    var handleLogin = function() {
		
		toastr.options = {
			positionClass: 'toast-top-right',
			onclick: null
		};


        $('.login-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                username: {
                    required: true
                },
                password: {
                    required: true
                },
                remember: {
                    required: false
                }
            },

            messages: {
                username: {
                    required: "Username masih kosong."
                },
                password: {
                    required: "Password masih kosong."
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit   
                $('.alert-danger', $('.login-form')).show();
            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function(error, element) {
                error.insertAfter(element.closest('.input-icon'));
            },

            submitHandler: function(form, e) {
				
				e.preventDefault();
				var data = $('.login-form').serialize();
								
				$.ajax({
					type : 'POST',
					url  : BASE_URL + 'login',
					data : data,
					success :  function(response){
						if(response.error == false){
							toastr["success"](response.msg, "Notifikasi");	
							setTimeout(function(){
								window.location = BASE_URL + 'dashboard';	
							},1000)
						}else{
							$('.alert-danger', $('.login-form')).show();
							setTimeout(function(){
								$('.alert-danger', $('.login-form')).hide();	
							},3000);
						}
					}
				});	
				
            }
        });

        
    }

   return {
        //main function to initiate the module
        init: function() {

            handleLogin();

        }

    };

}();