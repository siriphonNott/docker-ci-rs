let isCall = false;
let timeout = 5; // sec
var $tableView = $('#view-table').DataTable({
    "columnDefs": [
        //{ "width": "20%", "targets": 2 },
        {
            "targets": [0],
            "visible": false,
        }
    ],
    "order": [
        [1, "asc"]
    ]
});
$(document).ready(function() {
    let date = new Date(),
        locale = "en-us",
        month = date.toLocaleString(locale, { month: "long" });
    $("#month").append(month)
    let dashBoard = () => {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${baseUrl}lead/getDashBoard`,
                method: "GET",
                dataType: 'json',
                contentType: false,
                processData: false,
            }).done(function(res) {
                setToken(res.csrf);
                let data = res.message
                    //console.log(data)
                if (res.status == 'success') {
                    if (data.totalLead == '0') {
                        $('#totalLead').append('0');
                        $('#progress-totalLead').css('width', `0%`);

                        $('#leadOpen').append('0');
                        $('#progress-open').css('width', `0%`);
                        $('#increase-open').append(`0%`);

                        $('#leadSuccess').append('0');
                        $('#progress-success').css('width', `0%`);
                        $('#increase-success').append(`0%`);

                        $('#leadFollow').append('0');
                        $('#progress-follow').css('width', `0%`);
                        $('#increase-follow').append(`0%`);

                        $('#leadDrop').append('0');
                        $('#progress-drop').css('width', `0%`);
                        $('#increase-drop').append(`0%`);

                        $('#leadCouldNotReach').append('0');
                        $('#progress-leadCouldNotReach').css('width', `0%`);
                        $('#increase-leadCouldNotReach').append(`0%`);
                    } else {
                        let percentTotalLead = (+data.totalLead / +data.totalLead) * 100;
                        let percentOpen = (+data.totalOpen / +data.totalLead) * 100;
                        let percentSuccess = (+data.totalSuccess / +data.totalLead) * 100;
                        let percentFollow = (+data.totalFollow / +data.totalLead) * 100;
                        let percentDrop = (+data.totalDrop / data.totalLead) * 100;
                        let percentCouldNotReach = (+data.totalCouldNotReach / data.totalLead) * 100;
                        // var num = parseFloat(ele.value);
                        // ele.value = num.toFixed(2);
                        // console.log(typeof percentOpen)
                        $('#totalLead').append(data.totalLead);
                        $('#progress-totalLead').css('width', `${percentTotalLead}%`);

                        $('#leadOpen').append(data.totalOpen);
                        $('#progress-open').css('width', `${percentOpen}%`);
                        $('#increase-open').append(`${percentOpen.toFixed(2)}%`);

                        $('#leadSuccess').append(data.totalSuccess);
                        $('#progress-success').css('width', `${percentSuccess}%`);
                        $('#increase-success').append(`${percentSuccess.toFixed(2)}%`);

                        $('#leadFollow').append(data.totalFollow);
                        $('#progress-follow').css('width', `${percentFollow}%`);
                        $('#increase-follow').append(`${percentFollow.toFixed(2)}%`);

                        $('#leadDrop').append(data.totalDrop);
                        $('#progress-drop').css('width', `${percentDrop}%`);
                        $('#increase-drop').append(`${percentDrop.toFixed(2)}%`);

                        $('#leadCouldNotReach').append(data.totalCouldNotReach);
                        $('#progress-leadCouldNotReach').css('width', `${percentCouldNotReach}%`);
                        $('#increase-leadCouldNotReach').append(`${percentCouldNotReach.toFixed(2)}%`);


                    }

                    resolve();
                } else {
                    _alerting('error', res.message);
                    reject();
                }
            });
        })
    }
    $('.buttonSearch').on('click', function() {
        $("#clear").prop("disabled", false);
    });

    let generateTable = (obj) => {
        //$tableView.clear();
        obj.forEach((element, index) => {
            // console.log(element);
            let temp = [];
            let btn = `<a href="${baseUrl}lead/edit/${element.id}" onclick="call('${element.tel1}','${element.ext}','${element.id}')" class="btn btn-success" style="font-size:9px;padding: 3px 8px;"><i class="fa fa-phone" aria-hidden="true"></i> Call</a> `;
            btn += `<a href="${baseUrl}lead/edit/${element.id}" class="btn btn-warning" style="font-size:9px;padding: 3px 8px;"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a> `;
            temp.push(element.callResult);
            temp.push(index + 1);
            temp.push((element.callResult) == null ? 'Lead New' : element.callResultName);
            temp.push((element.campaignName) == null ? '' : element.campaignName);
            temp.push(element.expiredDate);
            temp.push(element.title);
            temp.push(element.firstname);
            temp.push(element.lastname);
            temp.push(element.email1);
            temp.push(element.tel1);
            if (+element.isDelete) {
                btn += `<a onclick="btnDeleteContent(${element.id},${index})" class="btn btn-danger btn-delete icon-delete" style="font-size:9px;padding: 3px 8px;"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>`
            }
            temp.push(btn);
            let rowNode = $tableView.row.add(temp).node();
            $(rowNode).attr("id", element.no);
            // if(!element.leadStatus) {
            //     $(rowNode).addClass('bg-warning');
            // }
            $tableView.draw();
        });
    }

    function loadDataTable() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${baseUrl}lead/getDataTable/leadView`,
                method: "GET",
                dataType: 'json',
                contentType: false,
                processData: false,
            }).done(function(res) {
                setToken(res.csrf);
                if (res.status == 'success') {
                    generateTable(res.message)
                    resolve();
                } else {
                    _alerting('error', res.message);
                    reject();
                }
            });

        })
    }
    //{ loadData 
    async function loadData() {
        await loadDataTable();
        await dashBoard();
    }
    loadData();
    //}
});


function btnDeleteContent(id, index) {
    var json = getToken();
    json['id'] = id;
    alertify.confirm("Are you sure to delete this Lead ?",
        function() {
            $.ajax({
                url: baseUrl + "lead/delete",
                dataType: "json",
                method: "post",
                data: json
            }).done(function(res) {
                setToken(res.csrf);
                if (res.status == 'success') {
                    $tableView.row(index).remove().draw();
                    _alerting('notify', "Delete Success");
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
            //_alerting('notify', "Cancel");
        }).setHeader('<em> Confiem Delete Content </em> ');
}

function searchCallResult(type) {
    switch (type) {
        case 'success':
            $tableView.column(0).search("^1$|^2$", true, false).draw();
            break;
        case 'leadNew':
            $tableView.column(0).search('^\s*$', true, false).draw();
            break;
        case 'follow':
            $tableView.column(0).search('(110|120|130|140|150|160|170|180|190)', true, false).draw();
            break;
        case 'drop':
            $tableView.column(0).search('(210|220|230|240|250|260|270|280|290|300|310|320|410|420)', true, false).draw();
            break;
        case 'couldNotReach':
            $tableView.column(0).search('(430|440|450)', true, false).draw();
            break;
        case 'clear':
            $tableView.column(0).search('', true, false).draw();
            $("#clear").prop("disabled", true);
            break;
        default:

    }
}

function call(phoneNumber, ext, leadId) {
    let value = `M:${ext}:${phoneNumber}`
        //Upto this I am getting value
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val(value).select();
    document.execCommand("copy");
    $temp.remove();
    let token = getToken();
    let data = {
        leadId: leadId,
        extension: ext,
        phoneNumber: phoneNumber,
        token: token.token
    };
    $.ajax({
        url: `${baseUrl}lead/historicalCall`,
        method: "POST",
        data: data,
        dataType: 'json',
    }).done(function(data) {
        setToken(data.csrf);
        console.log('success to insert histocal call')
    }).fail(function() {
        console.log('error insert historical')
    });

}