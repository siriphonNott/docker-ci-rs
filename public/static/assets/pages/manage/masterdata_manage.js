//Initail Global
var tableName;
var masterdataList = [];
var masterdataManage = [];
var masterdataListTable = $('#masterdataList-table').DataTable();
var masterdataManageTable = $('#masterdataManage-table').DataTable();
var __URL = {
    getMasterList: "manage/getDataMasterdataList",
    postMasterList: "manage/postMasterdataList",
    deleteMasterList: "manage/deleteMasterdataList",
    getMasterManage: "manage/getDataMasterdataManage",
    postMasterManage: "manage/postMasterdataManage",
    deleteMasterManage: "manage/deleteMasterdataManage",
}

$('.ui.dropdown').dropdown();

$('form#masterdataListForm').submit((event) => {
    event.preventDefault();
    let form = $('form#masterdataListForm');
    let json = getToken();
    json.label = $('#label').val();
    json.action = $('input[name="action"]').val() || 'insert';
    if (json.action === 'update') json.id = $('input[name="id"]').val();
    $.ajax({
            url: `${baseUrl}${__URL.postMasterList}`,
            method: "post",
            data: json,
            dataType: 'json',
        })
        .done(function (res, textStatus, jqXHR) {
            setToken(res.csrf);
            if (res.status == 'success') {
                _alerting('success', res.message);
                form[0].reset();
                $('button[data-dismiss="modal"]').click();
                loadDataTableMasterdataList();
            } else {
                _alerting('error', res.errorMessage);
            }
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            alert(`Error: ${errorThrown}`);
        })
        .always(() => {
            $('input[name="action"]').val();
        });
});

let generateTableMasterdataList = (obj) => {
    masterdataListTable.clear();
    obj.forEach((element, index) => {
        let temp = [];
        let btn = `<a  onclick="btnEditMasterdataList('${element.id}')" class="btn btn-warning" style="font-size:9px;padding: 3px 8px;"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a> `;
        temp.push(index + 1);
        temp.push(element.label);
        btn += `<a  onclick="btnDeleteMasterdataList('${element.id}')" class="btn btn-danger btn-delete icon-delete" style="font-size:9px;padding: 3px 8px;"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>`
        temp.push(btn);
        let rowNode = masterdataListTable.row.add(temp).node();
        $(rowNode).attr("id", element.no);
        masterdataListTable.draw();
    });
}

const loadDataTableMasterdataList = () => {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: `${baseUrl}${__URL.getMasterList}`,
            method: "GET",
            dataType: 'json',
            contentType: false,
            processData: false,
        }).done(function (res) {
            setToken(res.csrf);
            if (res.status == 'success') {
                masterdataList = res.message;
                generateTableMasterdataList(res.message)
                generateDropdown();
                resolve();
            } else {
                _alerting('error', res.message);
                reject();
            }
        });

    })
}

const btnEditMasterdataList = (id) => {
    let data = masterdataList.find((element) => element.id == id);
    $('input[name="action"]').val('update');
    $('input[name="id"]').val(id);
    //Set Value
    $('input[name="label"]').val(data.label);
    //Show Modal
    $('button[data-target="#modalList"]').click();
}

const btnDeleteMasterdataList = (id) => {
    var json = getToken();
    json['id'] = id;
    alertify.confirm("Are you sure to delete?",
        function () {
            $.ajax({
                url: baseUrl + "manage/deleteMasterdataList",
                dataType: "json",
                method: "post",
                data: json
            }).done(function (res) {
                setToken(res.csrf);
                if (res.status == 'success') {
                    loadDataTableMasterdataList();
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



$('form#masterdataManageForm').submit((event) => {
    event.preventDefault();
    let form = $('form#masterdataManageForm');
    let json = getToken();
    json.labelManage = $('#labelManage').val();
    json.tableName = tableName;
    json.action = $('input[name="action"]').val() || 'insert';
    if (json.action === 'update') json.id = $('input[name="id"]').val();
    $.ajax({
            url: `${baseUrl}${__URL.postMasterManage}`,
            method: "post",
            data: json,
            dataType: 'json',
        })
        .done(function (res, textStatus, jqXHR) {
            setToken(res.csrf);
            if (res.status == 'success') {
                _alerting('success', res.message);
                form[0].reset();
                $('button[data-dismiss="modal"]').click();
                loadDataTableMasterdataManage();
            } else {
                _alerting('error', res.errorMessage);
            }
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            alert(`Error: ${errorThrown}`);
        })
        .always(() => {
            $('input[name="action"]').val();
        });

});

let generateTableMasterdataManage = (obj) => {
    masterdataManageTable.clear();
    obj.forEach((element, index) => {
        let columnName = element.label;
        if (element.label == undefined) columnName = element.name;
        let temp = [];
        let btn = `<a  onclick="btnEditMasterdataManage('${element.id}')" class="btn btn-warning" style="font-size:9px;padding: 3px 8px;"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a> `;
        temp.push(index + 1);
        temp.push(columnName);
        btn += `<a  onclick="btnDeleteMasterdataManage('${element.id}')" class="btn btn-danger btn-delete icon-delete" style="font-size:9px;padding: 3px 8px;"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>`
        temp.push(btn);
        let rowNode = masterdataManageTable.row.add(temp).node();
        $(rowNode).attr("id", element.no);
        masterdataManageTable.draw();
    });
}

const loadDataTableMasterdataManage = () => {
    return new Promise((resolve, reject) => {
        let json = getToken();
        json.tableName = tableName;
        $.ajax({
            url: `${baseUrl}${__URL.getMasterManage}`,
            method: "get",
            dataType: 'json',
            data: json,
        }).done(function (res) {
            setToken(res.csrf);
            if (res.status == 'success') {
                masterdataManage = res.message;
                generateTableMasterdataManage(res.message)
                resolve();
            } else {
                _alerting('error', res.message);
                reject();
            }
        });

    })
}

const generateDropdown = () => {
    let select = $('select[name="masterdataList"]');
    select.empty();
    let initailSelect = ['<option value="">--Select--</option>'];
    let selectLists = masterdataList.map((element) => {
        return `<option value="${element.label}">${element.label}</option>`;
    });
    select.append(initailSelect.concat(selectLists).join(''));
}

$('.modal').on('hidden.bs.modal', function () {
    $('input[name="action"]').val('');
    $('input[name="id"]').val('');
    $('#label').val('');
    $('#labelManage').val('');
});

$('select[name="masterdataList"]').on('change', (event) => {
    tableName = event.target.value
    $('button[data-target="#modalManage"]').attr('disabled', false)
    loadDataTableMasterdataManage();
});

const btnEditMasterdataManage = (id) => {
    let data = masterdataManage.find((element) => element.id == id);
    //Set Value
    $('input[name="action"]').val('update');
    $('input[name="id"]').val(id);
    $('input[name="labelManage"]').val(data.label);
    //Show Modal
    $('button[data-target="#modalManage"]').click();
}

const btnDeleteMasterdataManage = (id) => {
    var json = getToken();
    json['id'] = id;
    json.tableName = tableName;
    alertify.confirm("Are you sure to delete?",
        function () {
            $.ajax({
                url: `${baseUrl}${__URL.deleteMasterManage}`,
                dataType: "json",
                method: "post",
                data: json
            }).done(function (res) {
                setToken(res.csrf);
                if (res.status == 'success') {
                    loadDataTableMasterdataManage();
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
    await loadDataTableMasterdataList();
    await loadDataTableMasterdataManage();
}

loadData();