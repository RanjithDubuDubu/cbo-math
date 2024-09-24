$(document).ready(function() {

    // Form  validation
    $.validate({
        modules: 'file,sanitize',
        validateOnBlur : false,
        form: '.login_form',
        inputParentClassOnError: 'has-danger',        
        errorMessageClass: 'alert-danger',
        onError : function($form) {
          return false;
        },
        onSuccess: function($form) {
            $('.submit_button').attr('disabled','disabled');
            login();
           
            return false;
        }
    });  
   
    // submit form
    function login() {
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Content-Type": "application/json",
                "x-api-key": "abcSTpmREb2QsTvZuh12i3Jl9EhQI37w5wDFm45k"
            }
        });        

         var values = $('.login_form').serializeArray();
         var username = $("#email").val();
         var mpin = $("#password").val();  
         var data = {
            username: username,
            mpin: mpin
        };
         $.ajax({
                url: `https:inspection.proz.in/api/shg-login?username=${username}&mpin=${mpin}`,
                type: "post",
                data: JSON.stringify(data),
                contentType: "application/json",
                success: function (response) { 
                    console.log(response);
                    
                    sessionStorage.setItem('user_details', JSON.stringify(response));
                    getstore(response.id,response);
                    $(".submit_button").removeClass("active");
                    // window.location.href= 'dashboard';
                },
                error: function(response) { 
                    console.log(response.responseJSON.error);
                    printErrorMsg(response.responseJSON.error);

                }


        }); 
    }
    function getstore(id,response){
        // console.log(response)
        $.ajax({
            url: 'save-session-data',
        type: 'POST',
        data: JSON.stringify({ user_details: response }),
        dataType:'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
            contentType: "application/json",
            success: function (response) { 
                console.log(response);  
                window.location.href= 'dashboard';
            },
            error: function(response) { 
                console.log(response.responseJSON.error);
                printErrorMsg(response.responseJSON.error);

            }


    }); 
    }
    function printErrorMsg (msg) {
        
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display','block');
        $(".print-error-msg").find("ul").append('<li>'+msg+'</li>');
        $('.submit_button').removeAttr('disabled');
        
        $(".submit_button").removeClass("active");
    }


});
