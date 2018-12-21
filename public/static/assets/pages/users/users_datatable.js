var search = $("input[name=tel_popup]").val();

window.pdfMake.fonts = {
  THSarabunNew: {
    normal: 'THSarabunNew.ttf',
    bold: 'THSarabunNew.ttf',
    italics: 'THSarabunNew.ttf',
    bolditalics: 'THSarabunNew.ttf'
  }
}

$(function () {
  show_loading();
  $('#users-table').DataTable({
    dom: 'Blfrtip',
    processing: true,
    serverSide: true,
    lengthMenu: [
      [10, 25, 50, 100],
      [10, 25, 50, 100]
    ],
    pageLength: 10,
    ajax: {
      url: baseUrl + 'users/getDataTable',
      type: "POST",
      dataType: 'json',
      data: function (d) {
        var json = getToken();
        d.token = json.token;
      },
      dataSrc: function (json) {
        setToken(json.csrf);
        $('.dt-buttons').css('text-align', 'right');
        $('.dt-buttons').css('margin', '0 0 20px 0');
        $('.dataTables_length').css('position', 'absolute');
        return json.data;
      }
    },
    // jQueryUI: true,
    initComplete: function () {
      $('#users-table').fadeIn();
      close_loading();
    },
    order: [0, 'desc'],
    search: {
      "search": search
    },
    buttons: [{
        extend: 'copy',
        className: 'btn btn-default',
      },
      {
        extend: 'print',
        className: 'btn btn-default',
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'excel',
        className: 'btn btn-default',
        exportOptions: {
          columns: ':visible'
        }
      }
    ]
  });
})

function btnDelete(id) {
  var json = getToken();
  json['id'] = id;
  alertify.confirm("Are you sure to delete this record?",
    function () {
      $.ajax({
        url: baseUrl + "users/delete",
        dataType: "json",
        method: "post",
        data: json
      }).done(function (res) {
        setToken(res.csrf);
        if (res.status == 'success') {
          var table = $('#users-table').DataTable();
          table.ajax.reload();
          alertify.success('<i class="fa fa-check-circle" aria-hidden="true"></i> Deleted Successfully!');
        } else {
          alertify.error('<i class="fa fa-info-circle" aria-hidden="true"></i> ' + res.message);
        }
      }).fail(function (jqXHR, textStatus) {
        if (jqXHR.status == 403) {
          alertify.error('<i class="fa fa-info-circle" aria-hidden="true"></i> ' + 'Your permission expired .Please reload this page again.');
        } else {
          alertify.error('<i class="fa fa-info-circle" aria-hidden="true"></i> ' + 'The system is temporarily unavailable.');
        }
      });
    },
    function () {
      alertify.error('Cancel');
    }).setHeader('<em> Confiem Delete Contact </em> ');
}