//Initail Global
var tableName;
var agentdata = [];
var form = $('#agentdataForm');
var agentdataTable = $('#agent-table').DataTable();

var __URL = {
    getAgentdata: "manage/getAgentdataList",
    postAgentdata: "manage/postAgentdata",
    deleteAgentdata: "manage/deleteAgentdata",
}

$('.ui.dropdown').dropdown();

form.submit((event) => {
    event.preventDefault();
    let json = getToken();
    json = form.serializeArray();
    json[1].value = $('input[name="action"]').val() || 'insert';
    $.ajax({
            url: `${baseUrl}${__URL.postAgentdata}`,
            method: "post",
            data: json,
            dataType: 'json',
        })
        .done(function (res, textStatus, jqXHR) {
            setToken(res.csrf);
            if (res.status == 'success') {
                _alerting('success',res.message);
                $('button[data-dismiss="modal"]').click();
                loadDataTableAgentdata();
            } else {
                _alerting('error',res.errorMessage);
            }
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            _alerting('error', errorThrown);
        })
        .always(() => {
            $('input[name="action"]').val();
        });
});

$('.modal').on('hidden.bs.modal',function(){
    $('input[name="action"]').val('');
    $('input[name="id"]').val('');
    form[0].reset();
});

let generateTableAgentdata = (obj) => {
    agentdataTable.clear();
    obj.forEach((element, index) => {
        let temp = [];
        let btn = `<a  onclick="btnEditAgentdata ('${element.user_id}')" class="btn btn-warning" style="font-size:9px;padding: 3px 8px;"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a> `;
        temp.push(index + 1);
        temp.push(element.user_id);
        temp.push(element.userUsername);
        temp.push(element.userName + " " + element.userSurname);
        temp.push(element.userRole);
        temp.push(element.userSurvey);
        temp.push(element.userSection);
        temp.push(element.userTeam);
        temp.push(element.userPosition);
        temp.push(element.userDetail1);
        temp.push(element.userDetail2);
        temp.push(element.userDetail3);
        btn += `<a  onclick="btnDeleteAgentdata('${element.user_id}')" class="btn btn-danger btn-delete icon-delete" style="font-size:9px;padding: 3px 8px;"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>`
        temp.push(btn);
        let rowNode = agentdataTable.row.add(temp).node();
        $(rowNode).attr("user_id", element.no);
        agentdataTable.draw();
    });
}

const loadDataTableAgentdata = () => {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: `${baseUrl}${__URL.getAgentdata}`,
            method: "GET",
            dataType: 'json',
            contentType: false,
            processData: false,
        }).done(function (res) {
            setToken(res.csrf);
            if (res.status == 'success') {
                agentdata = res.message;
                generateTableAgentdata(res.message)
                resolve();
            } else {
                _alerting('error', res.message);
                reject();
            }
        });

    })
}

const btnEditAgentdata = (idBeforeEdit) => {
    let data = agentdata.find((element) => element.user_id == idBeforeEdit);
    //Set Value
    $('input[name="action"]').val('update');
    $('input[name="idBeforeEdit"]').val(idBeforeEdit);
    $('input[name="user_id"]').val(idBeforeEdit);
    $('input[name="userUsername"]').val(data.userUsername);
    $('input[name="userName"]').val(data.userName);
    $('input[name="userSurname"]').val(data.userSurname);
    $('input[name="userPosition"]').val(data.userPosition);
    $('input[name="userDetail1"]').val(data.userDetail1);
    $('input[name="userDetail2"]').val(data.userDetail2);
    $('input[name="userDetail3"]').val(data.userDetail3);

    $('select[name="userRole"]').dropdown('set selected', data.userRole);
    $('select[name="userSurvey"]').dropdown('set selected', data.userSurvey);
    $('select[name="userSection"]').dropdown('set selected', data.userSection);
    $('select[name="userTeam"]').dropdown('set selected', data.userTeam);
    //Show Modal
    $('button[data-target="#myModal"]').click();
}

const btnDeleteAgentdata = (id) => {
    var json = getToken();
    json['user_id'] = id;
    alertify.confirm("Are you sure to delete?",
        function () {
            $.ajax({
                url: `${baseUrl}${__URL.deleteAgentdata}`,
                dataType: "json",
                method: "post",
                data: json
            }).done(function (res) {
                setToken(res.csrf);
                if (res.status == 'success') {
                    loadDataTableAgentdata();
                } else {
                    _alerting('error', res.message);
                }
            }).fail(function (jqXHR, textStatus) {
                if (jqXHR.status == 403) {
                    _alerting('error', "Your permission expired .Please reload this page again.");
                } else {
                    _alerting('error', "The system is temporarily unavailable.");
                }
            });
        },
        function () {}).setHeader('<em> Confiem Delete Content </em> ');
}

async function loadData() {
    await loadDataTableAgentdata();
}

loadData();