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
  $('#contact-table').DataTable({
    processing: true,
    serverSide: true,
    lengthMenu: [
      [10, 25, 50, 100],
      [10, 25, 50, 100]
    ],
    pageLength: 10,
    ajax: {
      url: baseUrl + 'contact/getDataTable',
      type: "POST",
      dataType: 'json',
      data: function (d) {
        var json = getToken();
        d.token = json.token;
      },
      dataSrc: function (json) {
        setToken(json.csrf);
        if (json.recordsTotal == 1 && search !== '') {
           console.log(json.data);

         // window.open(baseUrl + 'contact/edit/' + json.data[0][0], '_self');
        }
        $('.dt-buttons').css('text-align', 'right');
        $('.dt-buttons').css('margin', '0 0 20px 0');
        $('.dataTables_length').css('position', 'absolute');
        return json.data;
      }
    },
    // jQueryUI: true,
    initComplete: function () {
      $('#contact-table').fadeIn();
      close_loading();
    },
    order: [0, 'desc'],
    search: {
      "search": search
    },
    dom: 'Blfrtip',
    buttons: [{
        extend: 'copy',
        className: 'btn btn-default',
      },
      {
        extend: 'print',
        className: 'btn btn-default',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5],
        }
      },
      {
        extend: 'excel',
        className: 'btn btn-default',
        exportOptions: {
          columns: ':visible'
        }
      },
      // {
      //   extend: 'csv',
      //   className: 'btn btn-default',
      //   exportOptions: {
      //     columns: ':visible'
      //   }
      // },
      {
        extend: 'pdf',
        className: 'btn btn-default',
        title: 'Contact List',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7],
        },
        customize: function (doc) {
          doc.defaultStyle = {
            font: 'THSarabunNew',
            fontSize: 14
          }
        },
        filename: function () {
          var date = new Date();
          var d = date.getDate();
          var month = date.getMonth();
          var y = date.getFullYear();
          var h = date.getHours();
          var m = date.getMinutes();
          var s = date.getSeconds();
          return 'Contact List : ' + y + '-' + month + '-' + d + '-' + h + m + s;
        },
      }
    ]
  })
})

function btnDelete(id) {
  var json = getToken();
  json['id'] = id;
  alertify.confirm("Are you sure to delete this record?",
    function () {
      $.ajax({
        url: baseUrl + "contact/delete",
        dataType: "json",
        method: "post",
        data: json
      }).done(function (res) {
        setToken(res.csrf);
        if (res.status == 'success') {
          var table = $('#contact-table').DataTable();
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