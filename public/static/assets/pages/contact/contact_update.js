var validator = $("#form_edit_contact").validate({
  submitHandler: function (form) {
    var id_xss = false;
    var serializedData = $("#form_edit_contact").serialize();

    var data_json = queryStringToJSON(serializedData);
    for (key in data_json) {
      if (hasHtmlTags(data_json[key])) {
        alertify.error('<i class="fa fa-info-circle" aria-hidden="true"></i> Field ' + key + ' have script.');
        id_xss = true;
      }
    }

    if (!id_xss) {
      $.ajax({
        url: baseUrl + "contact/update",
        dataType: "json",
        method: "post",
        data: serializedData,
      }).done(function (res) {
        $(":input[type=submit]").attr('disabled', true);
        setToken(res.csrf);
        if (res.status == 'success') {
          alertify.success('<i class="fa fa-check-circle" aria-hidden="true"></i> Updated Successfully!');
        } else {
          alertify.error('<i class="fa fa-info-circle" aria-hidden="true"></i> ' + res.message);
        }
        setTimeout(() => {
          $(":input[type=submit]").attr('disabled', false);
        }, 3000);
      }).fail(function (jqXHR, textStatus) {
        if (jqXHR.status == 403) {
          alertify.error('<i class="fa fa-info-circle" aria-hidden="true"></i> ' + 'Your permission expired .Please reload this page again.');
        } else {
          alertify.error('<i class="fa fa-info-circle" aria-hidden="true"></i> ' + 'The system is temporarily unavailable.');
        }
      });
    }
  },
  highlight: function (element) {
    $(element).parent().addClass("has-error");
  },
  unhighlight: function (element) {
    $(element).parent().removeClass("has-error");
  },
  rules: {
    firstname: {
      required: true,
      lettersonlys: true
    },
    lastname: {
      required: true,
      lettersonlys: true
    },
    email: {
      required: false,
      email: true
    },
    Fax: {
      required: false,
      digits: true,
      maxlength: 10,
    },
    tel1: {
      required: true,
      digits: true,
      maxlength: 10,
    },
    tel2: {
      required: false,
      digits: true,
      maxlength: 10,
    },
    company: {
      required: false,
      lettersonly: true
    },
    position: {
      required: false,
      lettersonly: true
    },
    province: {
      required: false,
      lettersonlys: true
    }
  },
  messages: {
    firstname: {
      required: "Enter your First Name",
    },
    lastname: "Enter your Last Name",
    email: {
      required: "Enter your Email",
      email: "Please enter a valid email address.",
    },
    fax: {
      required: "Enter your Fax",
      email: "Please enter a valid Fax Number.",
    }

  }
});

jQuery.validator.addMethod("lettersonlys", function (value, element) {
  // return this.optional(element) || /^[a-z\s]+$/i.test(value);
  return this.optional(element) || /^[\u0E00-\u0E7Fa-zA-Z \s]+$/i.test(value);
}, "Only alphabetical characters");

jQuery.validator.addMethod("lettersonly", function (value, element) {
  return this.optional(element) || /^[\u0E00-\u0E7Fa-zA-Z0-9 .,\s]+$/i.test(value);
}, "Only alphabetical characters");

$('input[name=tel1]').on('blur', function () {
  var json = getToken();
  json['tel'] = this.value;
  $.ajax({
    url: baseUrl + "contact/check_telephone",
    dataType: "json",
    method: "post",
    data: json
  }).done(function (res) {
    setToken(res.csrf);
    if (res.status == 'success') {
      alertify.success('<i class="fa fa-info-circle" aria-hidden="true"></i> ' + res.message);
      $('input[name=tel1]').parent().addClass("has-success");
    } else if (res.status == 'error') {
      alertify.error('<i class="fa fa-info-circle" aria-hidden="true"></i> ' + res.message);
    } else if (res.status == 'warning') {
      validator.showErrors({
        "tel1": "" + res.message
      });
    }
  }).fail(function (jqXHR, textStatus) {
    if (jqXHR.status == 403) {
      alertify.error('<i class="fa fa-info-circle" aria-hidden="true"></i> ' + 'Your permission expired .Please reload this page again.');
    } else {
      alertify.error('<i class="fa fa-info-circle" aria-hidden="true"></i> ' + 'The system is temporarily unavailable.');
    }
  });
});

function clear_form(id) {
  $("#" + id)[0].reset();
  $('input[name=tel1]').parent().removeClass("has-success");
  $('input[name=tel1]').parent().removeClass("has-error");
  $('input[name=tel1]').parent().removeClass("has-warning");
}