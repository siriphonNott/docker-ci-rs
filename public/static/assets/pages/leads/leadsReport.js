//Initial Global variables
var d = new Date();
var $form = $('#form_report');
var $btnSubmit = $('button[type="submit"]');
var $btnClear = $('button[type="clear"]');
var table = $('#report-table').DataTable();

$(document).ready(function() {
    //Submit Event
    $form.submit(function(event) {
        event.preventDefault();
        let json = {};
        let arrObj = $(this).serializeArray();
        arrObj.splice(0, 1);

        //Convert to json
        json = arrObj.filter((element, index) => {
            return element.value !== '';
        });
        $btnSubmit.prop('disabled', true);
        $.ajax({
                url: `${baseUrl}lead/getDataReport`,
                method: "get",
                data: json,
                dataType: 'json',
            })
            .done(function(res, textStatus, jqXHR) {
                setToken(res.csrf);
                generateTable(res.message);
                $btnSubmit.prop('disabled', false);
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                alert(`Error: ${errorThrown}`);
            })
            .always();
    });

    let generateTable = (obj) => {
        table.clear().draw();
        obj.rows.forEach((element, index) => {
            let temp = [];
            temp.push(index + 1);
            temp.push(element.title);
            temp.push(element.firstname);
            temp.push(element.lastname);
            temp.push(element.birthday);
            temp.push(element.email1);
            temp.push(element.email2);
            temp.push(element.tel1);
            temp.push(element.tel2);
            temp.push(element.tel3);
            temp.push(element.address);
            let rowNode = table.row.add(temp).node();
            $(rowNode).attr("id", element.no);
            table.draw();
        });
    }

    $btnClear.on('click', function() {
        let arrObj = $('#form_report').serializeArray();
        let varDate = ['datefrom', 'dateto'];
        arrObj.splice(0, 1);
        //Convert to json
        json = arrObj.forEach((element, index) => {
            if (varDate.includes(element.name)) {
                $(`input[name="${element.name}"]`).val(getDateNow('clear'));
            } else {
                $(`select[name="${element.name}"]`).dropdown('clear');
            }
        });
    });

    //--------- Initial element -------//   
    //UI
    $('.ui.dropdown').dropdown();
    //Date picker
    let minDate = new Date(moment().subtract(1, 'day').format('YYYY-MM-DD'));
    $('#datefrom, #dateto').val(getDateNow('db'));
    $('#datefrom, #dateto').datetimepicker({
        format: 'YYYY-MM-DD',
        //minDate: minDate,
        //disabledDates: [minDate]
    })
});

//set option button for export
var buttons = new $.fn.dataTable.Buttons(table, {
    buttons: [{
            extend: 'copy',
            title: '',
            className: 'btn btn-default',
        },
        {
            extend: 'print',
            className: 'btn btn-default',
            exportOptions: {
                modifier: {
                    // DataTables core
                    order: 'index',
                    page: 'all',
                    search: 'applied',
                }
            }
        },
        {
            extend: 'excel',
            title: '',
            className: 'btn btn-default',
            filename: `Leady_Report_${getDateNow()}`,
            exportOptions: {
                modifier: {
                    // DataTables core
                    order: 'index', // 'current', 'applied','index', 'original'
                    page: 'all', // 'all', 'current'
                    search: 'applied' // 'none', 'applied', 'removed'
                }
            }
        }
    ]
}).container().appendTo($('#buttons'));