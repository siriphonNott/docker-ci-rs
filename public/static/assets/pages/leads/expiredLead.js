var $tableReallocate = $('#leadExpire-table').DataTable({
    //"scrollX": true,
    //"scrollY": true,
    //"scrollCollapse": true,
    // "columnDefs": [
    //     { "width": "50%", "targets": 4 },
    //     { "width": "30%", "targets": 5 },
    // ],
    lengthMenu: [
        [10, 25, 50, 100],
        [10, 25, 50, 100]
    ],
    pageLength: 50
});
$(document).ready(function() {

    let date = moment();
    let dateNow = date.format("YYYY-MM-DD");

    let generateTable = (obj) => {
        $tableReallocate.clear();
        obj.forEach((element, index) => {
            let temp = [];
            let btn = `<a href="${baseUrl}lead/edit/${element.id}" class="btn btn-warning" style="font-size:9px;padding: 3px 8px;"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a> `;
            btn += `<a onclick="btnDeleteContent(${element.id},${index})" class="btn btn-danger btn-delete icon-delete" style="font-size:9px;padding: 3px 8px;"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>`
            temp.push(index + 1);
            temp.push(element.title);
            temp.push(element.firstname);
            temp.push(element.lastname);
            temp.push((element.callResult) == null ? 'Lead New' : element.callResultName);
            temp.push(element.expiredDate);
            temp.push(element.birthday);
            temp.push(element.email1);
            temp.push(element.email2);
            temp.push(element.tel1);
            temp.push(element.tel2);
            temp.push(element.tel3);
            temp.push(element.address);
            temp.push(btn);
            let rowNode = $tableReallocate.row.add(temp).node();
            $(rowNode).attr("id", element.no);
            // if(!element.leadStatus) {
            //     $(rowNode).addClass('bg-warning');
            // }
            $tableReallocate.draw();
        });
    }

    function loadDataTable() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${baseUrl}lead/getDataTableLeadExpire`,
                method: "GET",
                dataType: 'json',
                contentType: false,
                processData: false,
            }).done(function(res) {
                setToken(res.csrf);
                if (res.status == 'success') {
                    if (res.message.length > 0) {
                        generateTable(res.message)
                    } else {
                        $tableReallocate.clear().draw();
                    }
                    resolve();
                } else {
                    _alerting('error', res.message);
                    reject();
                }
            });

        })
    }

    $('#reallocate').on('click', async function(event) {
        event.preventDefault();
        let leadReallocate = await getLeadExpire()
        let sizeLeadReallowcate = leadReallocate.message.data.length;

        if (sizeLeadReallowcate < 1) {
            _alerting('warning', 'No Expired Lead List')
            return;
        } else {

            alertify.confirm('กรุณากรอกจำนานรายการที่ต้องการจะ Allocate', genHtml(sizeLeadReallowcate),
                function(e) {

                    let value_limit = $('#limitLeadList').val();
                    let expiredDate = $('#dateExpire').val();
                    if (parseInt(value_limit) > sizeLeadReallowcate) {
                        e.cancel = true;
                        $(`#warning_limitLeadList`).empty();
                        $(`#warning_limitLeadList`).append('<p style="color:red;">**รายการ Lead New มีไม่พอ</p>')
                        return;
                    } else {
                        if (value_limit == '') {
                            e.cancel = true;
                            $(`#warning_limitLeadList`).empty();
                            $(`#warning_limitLeadList`).append('<p style="color:red;">**กรุณากรอกข้อมูล</p>')
                            return;
                        } else if (expiredDate < dateNow) {
                            e.cancel = true;
                            $(`#warning_dateExpire`).empty();
                            $(`#warning_dateExpire`).append('<p style="color:red;">**ไม่สามารถตั้ง Expire Date ย้อนหลังได้</p>');
                            return;
                        }

                        var json = getToken();
                        json.limitLeadList = value_limit;
                        json.expiredDate = expiredDate;
                        $('#reallocate').prop('disabled', true);
                        $.ajax({
                            url: baseUrl + "lead/reallocate",
                            method: "POST",
                            data: json,
                            dataType: "json",
                        }).done(async function(res) {
                            //let res = JSON.parse(data);
                            setToken(res.csrf);
                            if (res.status == 'success') {
                                _alerting('notify', res.message);
                                await loadDataTable();
                                $('#reallocate').prop('disabled', false);
                            } else {
                                _alerting('error', res.errorMessage);
                                setTimeout(function() {
                                    $('#reallocate').prop('disabled', false);
                                }, 2000);
                            }

                        }).fail(function() {
                            console.err("error");

                        });

                    }

                },
                function() {

                });
            let blockDate = moment().subtract(1, 'd').format("YYYY-MM-DD HH:mm:ss");
            var dateAddOneMonth = moment().add(1, 'M').format('YYYY-MM-DD');
            $(".datepicker").datetimepicker({
                format: 'YYYY-MM-DD',
                minDate: new Date(blockDate),
                disabledDates: [new Date(blockDate)],
                defaultDate: dateAddOneMonth
            });
            return;
        }

    })

    //{ loadData 
    async function loadData() {
        await loadDataTable();
    }
    loadData();


});

let getLeadExpire = () => {
    return new Promise((resolve, reject) => {
        var info = {
            type: "getLeadExpire"
                //table:"activitys"
        }
        $.ajax({
            url: baseUrl + "lead/api",
            method: "GET",
            data: info,
        }).done(function(res) {
            let data = JSON.parse(res)
            setToken(data.csrf)
            resolve(data);
        }).fail(function() {
            reject();
        });
    });
}

function genHtml(total_leads) {
    let html = `
    <div class='col-lg-6'>
        <label id="total_leadNew"><p style="color:black;">Total lead new [${total_leads} lead] </p></label>
        <input type='text' id='limitLeadList' class='form-control' placeholder='Number only' onkeypress="CheckNum(${total_leads})" value="${total_leads}">
        <span id="warning_limitLeadList"></span><br>
    </div>
    <div class='col-lg-6'>
        <label id="total_leadNew"><p style="color:black;">Leads Expire Date </p></label>
        <input type='text' id='dateExpire' class='form-control datepicker' placeholder='yyyy-mm-dd' >
        <span id="warning_dateExpire"></span><br>
    </div>
    
    `;
    return html;
}

function CheckNum(totalLeads) {
    if (event.keyCode < 48 || event.keyCode > 57 || event.keyCode == 107) {
        $(`#warning_limitLeadList`).empty();
        $(`#warning_limitLeadList`).append('<p style="color:red;">กรุณากรอกข้อมูลเป็นตัวเลขเท่านั้น</p>')
        event.returnValue = false;

    }
    $("#limitLeadList").keyup(function(event) {
        var value = $(this).val();
        if (+value > +totalLeads) {
            $(this).val(totalLeads);
        }

    });
}

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
                    $tableReallocate.row(index).remove().draw();
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
            alertify.error('Cancel');
        }).setHeader('<em> Confiem Delete Content </em> ');
}