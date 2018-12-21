var form = $('#phoneListForm');
var table = $('#phoneList-table').DataTable();
var modal = $('#myModal');
var phoneBlockList = [];
$('[data-mask]').inputmask();

form.submit(function (event) {
    event.preventDefault();
    let json = getToken();
    json.phoneNumber = $('#phoneNumber').val().replace(/-/g, '').replace("(", '').replace(")", '');
    json.action = $('input[name="action"]').val() || 'insert';
    if(json.action === 'update') json.id = $('input[name="id"]').val();
    console.log(json);
    
    $.ajax({
            url: `${baseUrl}lead/postPhoneBlockList`,
            method: "post",
            data: json,
            dataType: 'json',
        })
        .done(function (res, textStatus, jqXHR) {
            setToken(res.csrf);
            if (res.status == 'success') {
                alert(res.message);
                form[0].reset();
                $('button[data-dismiss="modal"]').click();
                loadDataTable();
            } else {
                alert(res.errorMessage);
            }
        })
        .fail(function (jqXHR, textStatus, errorThrown) {

            alert(`Error: ${errorThrown}`);
        })
        .always(()=>{
            $('input[name="action"]').val();
        });
});

let generateTable = (obj) => {
    table.clear();
    obj.forEach((element, index) => {
        let temp = [];
        let btn = `<a  onclick="btnEditPhoneNumber('${element.id}')" class="btn btn-warning" style="font-size:9px;padding: 3px 8px;"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a> `;
        temp.push(index + 1);
        temp.push(element.phoneNumber);
        btn += `<a  onclick="btnDeleteContent('${element.id}')" class="btn btn-danger btn-delete icon-delete" style="font-size:9px;padding: 3px 8px;"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>`
        temp.push(btn);
        let rowNode = table.row.add(temp).node();
        $(rowNode).attr("id", element.no);
        table.draw();
    });
}

const loadDataTable = () => {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: `${baseUrl}lead/getDataPhoneBlockList`,
            method: "GET",
            dataType: 'json',
            contentType: false,
            processData: false,
        }).done(function (res) {
            setToken(res.csrf);
            if (res.status == 'success') {
                phoneBlockList = res.message;
                generateTable(res.message)
                resolve();
            } else {
                _alerting('error', res.message);
                reject();
            }
        });

    })
}

const btnEditPhoneNumber = (id) => {
    let data = phoneBlockList.find((element)=>element.id==id);
    //Set Value
    $('input[name="phoneNumber"]').val(data.phoneNumber);
    $('input[name="action"]').val('update');
    $('input[name="id"]').val(id);
    //Show Modal
    $('button[data-target="#myModal"]').click();
}

const btnDeleteContent = (id)  => {
    var json = getToken();
    json['id'] = id;
    alertify.confirm("Are you sure to delete this phone number ?",
        function() {
            $.ajax({
                url: baseUrl + "lead/deletePhoneBlockList",
                dataType: "json",
                method: "post",
                data: json
            }).done(function(res) {
                setToken(res.csrf);
                if (res.status == 'success') {
                    loadDataTable();
                } else {
                    _alerting('error', res.message);
                }
            }).fail(function(jqXHR, textStatus) {
                if (jqXHR.status == 403) {
                    _alerting('error', "Your permission expired .Please reload this page again.");
                } else {
                    _alerting('error', "The system is temporarily unavailable.");
                }
            });
        },
        function() {
        }).setHeader('<em> Confiem Delete Content </em> ');
}

async function loadData() {
    await loadDataTable();
}

loadData();


