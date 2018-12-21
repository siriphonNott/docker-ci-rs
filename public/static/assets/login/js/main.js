
(function ($) {
    "use strict";

    
    /*==================================================================
    [ Validate ]*/
    var input = $('.validate-input .input100');

    $('.validate-form').on('submit',function(evt){
        evt.preventDefault();
        clear_error_message();
        var check = true;
    
        for (var i = 0; i < input.length; i++) {
          if (validate(input[i]) == false) {
            showValidate(input[i]);
            check = false;
          }
        }
        //return check;
        if (check) {
            var id_xss = false;
            var serializedData = $("#login-form").serialize();
            var data_json = queryStringToJSON(serializedData);
            
            if (hasHtmlTags(data_json.username)) {
              $('#error_message').fadeIn().html('Do not include script in Username');
              showValidate($('input[name=username]')[0]);
              id_xss = true;
            } else if (hasHtmlTags(data_json.password)) {
              $('#error_message').fadeIn().html('Do not include script in Password');
              showValidate($('input[name=password]')[0]);
              id_xss = true;
            }
            
            if (!id_xss) {
              $.ajax({
                url: baseUrl + "users/authen",
                dataType: "json",
                method: "post",
                data: serializedData,
              }).done(function (res) {
                setToken(res.csrf);
                if (res.status == 'success') {
                  window.open(baseUrl, '_self');
                } else {
                  $('#error_message').fadeIn().html(res.errorMessage);
                }
              });
            }
          }
  
    });


    
    

    
    function clear_error_message() {
        $('#error_message').fadeOut().text('');
    }
    

    $('.validate-form .input100').each(function(){
        $(this).focus(function(){
           hideValidate(this);
        });
    });

    function validate (input) {
        if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
            if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                return false;
            }
        }
        else {
            if($(input).val().trim() == ''){
                return false;
            }
        }
    }

    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
    }
    
    

})(jQuery);