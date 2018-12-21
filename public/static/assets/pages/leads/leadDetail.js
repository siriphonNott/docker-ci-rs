let isCall = false;
let timeout = 5; // sec
let $tableHistorical = $("#histocal-call-table").DataTable();
$(document).ready(function() {
    let dateFollow = $("#follow_date").val();
    $('.ui.dropdown').dropdown({
        fullTextSearch: "exact",
        allowAdditions: true,
    })
    var json = getToken();
    json['id'] = $("#cus_id").val();

    let date = moment();
    let dateNow = date.format("YYYY-MM-DD HH:mm:ss");
    let blockDate = moment().subtract(1, 'd').format("YYYY-MM-DD HH:mm:ss");

    if (dateFollow == '' || dateFollow == '0000-00-00 00:00:00') {
        $(".dateFollow").hide();
    } else {
        $("#checkFollow").prop('checked', true);
    }
    $("#checkFollow").change(function() {
        if (!this.checked) {
            $(".dateFollow").hide();
            $("#follow_date").val('');
        } else {
            $(".dateFollow").fadeIn(500).show();
        }
    });

    $('#follow_date').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss',
        minDate: new Date(blockDate),
        disabledDates: [new Date(blockDate)]
    });
    $('#birthDay').datetimepicker({
        format: 'YYYY-MM-DD'
    });

    $('#updateLeadDetail').on('click', async function(event) {
        event.preventDefault();
        $('#updateLeadDetail').prop('disabled', true);
        let infoLeadDetail = {};
        let arrObj = $("#form_lead_update").serializeArray();
        for (let item in arrObj) {
            infoLeadDetail[arrObj[item].name] = arrObj[item].value;
        }
        if (infoLeadDetail.callResult == '') {
            infoLeadDetail.callResult = null;
        }
        infoLeadDetail.id = $("#cus_id").val();
        if ($("#checkFollow").is(":checked") == true && infoLeadDetail.followDate == '') {
            _alerting('notify', 'กรุณาเลือก Follow Date');
            $('#updateLeadDetail').prop('disabled', false);
            return;
        }

        //xss
        for (key in infoLeadDetail) {
            if (hasHtmlTags(infoLeadDetail[key])) {
                _alerting('error', key + ' have script');
                setTimeout(function() {
                    $('#updateLeadDetail').prop('disabled', false);
                }, 3000);
                return;
            }
        }
        console.log(infoLeadDetail)
        $.ajax({
            url: baseUrl + "lead/updateDetail",
            dataType: 'json',
            method: "POST",
            data: infoLeadDetail,
        }).done(function(data) {
            console.log(data);
            setToken(data.csrf)
            if (data.status == 'success') {
                _alerting('notify', 'Update Success');
                setTimeout(function() {
                    location.reload();
                }, 3000);
            } else {
                _alerting('warning', data.errorMessage);
                setTimeout(function() {
                    $('#updateLeadDetail').prop('disabled', false);
                }, 3000);
            }
        }).fail(function(err) {
            console.log(err);
            _alerting('error', err);
        });

    })

    //tb histotical call {
    let generateTable = (obj) => {
        obj.forEach((element, index) => {
            let temp = [];
            temp.push(index + 1);
            temp.push(element.callDate);
            temp.push(element.extension);
            temp.push(element.phoneNumber);

            let rowNode = $tableHistorical.row.add(temp).node();
            $(rowNode).attr("id", element.no);
            // if(!element.leadStatus) {
            //     $(rowNode).addClass('bg-warning');
            // }
            $tableHistorical.draw();
        });
    }

    function loadDataTable() {
        return new Promise((resolve, reject) => {
            let data = {
                leadId: $('#cus_id').val()
            }
            $.ajax({
                url: `${baseUrl}lead/historicalCall`,
                method: "GET",
                dataType: 'json',
                data: data,
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
    //reload data table
    $(".flag_call").on('click', async function() {
            $tableHistorical.clear();
            await loadDataTable();
        })
        //}

    let getDetailLead = () => {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: baseUrl + "lead/getDetailLead",
                dataType: 'json',
                method: "POST",
                data: json,
            }).done(function(data) {
                setToken(data.csrf);
                resolve(data);
            }).fail(function() {
                reject();
            });
        })
    }

    let getDropdrow = () => {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: baseUrl + "lead/getDropdrow",
                method: "GET",
                dataType: "json",
            }).done(function(data) {
                console.log(data);

                if (data.message.agents.length > 0) {
                    for (let i in data.message.agents) {
                        $('#assignTo').append(`<option value="${data.message.agents[i].id}">${data.message.agents[i].firstname} ${data.message.agents[i].lastname}</option>`);
                    }
                }
                if (data.message.callResults.length > 0) {
                    for (let c in data.message.callResults) {
                        $('#callResult').append(`<option value="${data.message.callResults[c].id}">${data.message.callResults[c].name}</option>`);
                    }
                }
                resolve();
            }).fail(function() {
                reject();
            });
        })
    }

    let campaign = () => {
        return new Promise((resolve, reject) => {
            var info = {
                type: "get_all_data",
                table: "lead_campaigns"
            }
            $.ajax({
                url: baseUrl + "lead/api",
                dataType: 'json',
                method: "GET",
                data: info,
            }).done(function(data) {
                let info = data.message.data;
                if (info.length > 0) {
                    for (let i in info) {
                        $('#campaign').append(`<option value="${info[i].id}">${info[i].label}</option>`);
                    }
                }
                resolve();
            }).fail(function() {
                reject(`can't load data.`);
            });
        })
    }

    let leadType = () => {
        return new Promise((resolve, reject) => {
            var info = {
                type: "get_all_data",
                table: "lead_types"
            }
            $.ajax({
                url: baseUrl + "lead/api",
                method: "GET",
                data: info,
                dataType: 'json',
            }).done(function(data) {
                let info = data.message.data;
                if (info.length > 0) {
                    for (let i in info) {
                        $('#leadType').append(`<option value="${info[i].id}">${info[i].label}</option>`);
                    }
                }
                resolve();
            }).fail(function() {
                reject();
            });
        })
    }

    let channel = () => {
        return new Promise((resolve, reject) => {
            var info = {
                type: "get_all_data",
                table: "lead_channels"
            }
            $.ajax({
                url: baseUrl + "lead/api",
                method: "GET",
                dataType: 'json',
                data: info,
            }).done(function(data) {
                let info = data.message.data;
                if (info.length > 0) {
                    for (let i in info) {
                        $('#channel').append(`<option value="${info[i].id}">${info[i].label}</option>`);
                    }
                }
                resolve();
            }).fail(function() {
                reject();
            });
        })
    }



    async function loadData() {
        try {
            await getDropdrow();
            await campaign();
            await leadType();
            await channel();
            await loadDataTable();
            let getDetail = await getDetailLead();
            //$('#callResult').dropdown('set selected', (getDetail.message.callResult) != null ? getDetail.message.callResult: );

            if (getDetail.message.callResult !== '' && getDetail.message.callResult != '0') {
                $('#callResult').dropdown('set selected', getDetail.message.callResult)
            } else {
                $('#callResult').dropdown('clear')
            }
            $('#assignTo').dropdown('set selected', (getDetail.message.assignedTo) != null ? getDetail.message.assignedTo : '');
            $('#campaign').dropdown('set selected', (getDetail.message.campaignId) != null ? getDetail.message.campaignId : '');
            $('#leadType').dropdown('set selected', (getDetail.message.leadTypeId) != null ? getDetail.message.leadTypeId : '');
            $('#channel').dropdown('set selected', (getDetail.message.channelId) != null ? getDetail.message.channelId : '');

        } catch (error) {
            console.log(error)
        }

    }

    loadData();

});

function call(element) {
    if (!isCall) {
        let value;
        let phoneNumber = $(element).val();
        let ext = $('#ext').val();
        let leadId = $('#cus_id').val();
        value = `M:${ext}:${phoneNumber}`
            //Upto this I am getting value
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val(value).select();
        document.execCommand("copy");
        $temp.remove();
        $('.flag_call').removeClass("btn-avail-call");
        isCall = true;
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
            //loadDataTable();
            console.log('success to insert histocal call')
        }).fail(function() {
            console.log('error insert historical')
        });
        setTimeout(() => {
            isCall = false;
            $('.flag_call').addClass("btn-avail-call");
        }, timeout * 1000);
    } else {

    }

}