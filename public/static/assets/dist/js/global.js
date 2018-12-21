var baseUrl = $('meta[name=baseUrl]').attr('content');

var pattern = /<(.*)>/;
//check tag html return true
function hasHtmlTags(string) {
  return pattern.test(string);
};

function queryStringToJSON(qs) {
  qs = qs || location.search.slice(1);

  var pairs = qs.split('&');
  var result = {};
  pairs.forEach(function (p) {
    var pair = p.split('=');
    var key = pair[0];
    var value = decodeURIComponent(pair[1] || '');

    if (result[key]) {
      if (Object.prototype.toString.call(result[key]) === '[object Array]') {
        result[key].push(value);
      } else {
        result[key] = [result[key], value];
      }
    } else {
      result[key] = value;
    }
  });

  return JSON.parse(JSON.stringify(result));
};


function getToken() {
  var token_name = $('#token')[0].name;
  var token_hash = $("input[name=" + token_name + "]").val();
  var str = '{"' + token_name + '":"' + token_hash + '"}';
  return JSON.parse(str);
}

function setToken(csrf) {
  $('#token')[0].name = csrf.name;
  $("input[name=" + csrf.name + "]").val(csrf.hash);
}

//---------Loading page----------
function show_loading() {
  $('#loading-div').show();
  // $("#loading-spin-nott").show();
  // $(".content-wrapper").css("opacity", 0.2);
}

function close_loading() {
  $('#loading-div').fadeOut(1500);
  // $("#loading-spin-nott").fadeOut();
  // $(".content-wrapper").css("opacity", 1);
}
//---------/Loading page----------

//--------- Alert Popup ----------
const _alerting = (type = '', message = '') => {
  let title = ``;
  let icon = ``;
  switch (type.toLowerCase()) {
      case 'notify':
          title = `<b class="alerting-title ">Notify</b>`
          icon = `<i class="fa fa-bullhorn" aria-hidden="true"></i>`
          break;
      case 'warning':
          title = `<b class="alerting-title ">Warning</b>`
          icon = `<i class="fa fa-bell-o" aria-hidden="true"></i>`
          break;
          case 'error':
          title = `<b class="alerting-title ">Error</b>`
          icon = `<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>`
          break;
      default:
          break;
  }
  alertify.alert(`${icon} ${title}`, `${message}`, function(){ 
  });
}
//---------- /Alert Popup --------

// Get Date
const getDateNow = (type = 'show') => {
  let d = new Date();
  let today = '';
  let dd = d.getDate();
  let mm = d.getMonth()+1; //January is 0!
  let yyyy = d.getFullYear();
  if(type == 'db') {
    today = `${ yyyy }-${('0'+mm).slice(-2) }-${ ('0'+dd).slice(-2)}`;
  } else if(type == 'clear'){
    today = `${yyyy}-${ ('0'+mm).slice(-2)}-${ ('0'+dd).slice(-2)}`;
  }else{
    today = `${ ('0'+dd).slice(-2)}/${ ('0'+mm).slice(-2)}/${yyyy}`;
  }
  return today;
}

// Accept only  numerics
$('.clsNumber').keypress(function (e) {  
  var regex = new RegExp("^[0-9]+$");
  var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
  if (regex.test(str)) {
      return true;
  }

  e.preventDefault();
  return false;
});

// Accept only email
$('.clsEmail').keypress(function (e) {  
  var regex = new RegExp("^[a-zA-Z0-9_.@]+$");
  var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
  if (regex.test(str)) {
      return true;
  }
  e.preventDefault();
  return false;
});