var validator = $("#change_password").validate({
    submitHandler: function(form) {
        var id_xss = false;
        var serializedData = $("#change_password").serialize();

        var data_json = queryStringToJSON(serializedData);
        for (key in data_json) {
            if (hasHtmlTags(data_json[key])) {
                alertify.error('<i class="fa fa-info-circle" aria-hidden="true"></i> Field ' + key + ' have script.');
                id_xss = true;
            }
        }
        console.log(baseUrl + "users/change_password");
        if (!id_xss) {
            $.ajax({
                url: baseUrl + "users/password_update",
                dataType: "json",
                method: "post",
                data: data_json,
            }).done(function(res) {
                setToken(res.csrf);
                if (res.status == 'success') {
                    clear_form('change_password');
                    alertify.success('<i class="fa fa-check-circle" aria-hidden="true"></i> Change Password Success!');
                    setTimeout(function() { location.href = baseUrl + "users/login" }, 1000);
                } else {
                    alertify.error('<i class="fa fa-info-circle" aria-hidden="true"></i> ' + res.message);
                }
            }).fail(function(jqXHR, textStatus) {
                if (jqXHR.status == 403) {
                    alertify.error('<i class="fa fa-info-circle" aria-hidden="true"></i> ' + 'Your permission expired .Please reload this page again.');
                } else {
                    alertify.error('<i class="fa fa-info-circle" aria-hidden="true"></i> ' + 'The system is temporarily unavailable.');
                }
            });
        }

    },
    highlight: function(element) {
        $(element).parent().addClass("has-error");
    },
    unhighlight: function(element) {
        $(element).parent().removeClass("has-error");
    },
    rules: {
        password: {
            required: true,
            lettersAndSpecial: true,
            minlength: 6
        },
        confirm_password: {
            required: true,
            lettersAndSpecial: true,
            equalTo: "#password"
        },
    }
});

jQuery.validator.addMethod("lettersonlys", function(value, element) {
    // return this.optional(element) || /^[a-z\s]+$/i.test(value);
    return this.optional(element) || /^[\u0E00-\u0E7Fa-zA-Z \s]+$/i.test(value);
}, "Only alphabetical characters");

jQuery.validator.addMethod("lettersAndSpecial", function(value, element) {
    return this.optional(element) || /^[\u0E00-\u0E7Fa-zA-Z0-9 !@#$%^&*()_+\=\[\]{}\\|,.\/?\s]+$/i.test(value);
}, "Only alphabetical characters");


$('input[name=password]').on('keyup', function() {

    if (this.value.length >= 6) {
        $('input[name=confirm_password]').prop('disabled', false);
    } else {
        $('input[name=confirm_password]').prop('disabled', true);
    }
});

function clear_form(id) {
    $('#' + id)[0].reset();

}