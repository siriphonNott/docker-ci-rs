$(document).ready(function() {
        $('.ui.search.fluid.dropdown').dropdown({
            fullTextSearch: "exact",
            allowAdditions: true,
        })

        let date = moment();
        let dateNow = date.format("YYYY-MM-DD");




        $('#allocate').on('click', async function(event) {
            event.preventDefault();
            let leadNew = await getLeadAll()
            let sizeLeadNew = leadNew.message.data.length;
            if (sizeLeadNew < 1) {
                _alerting('warning', 'No Lead New List')
                return;
            } else {
                alertify.confirm('กรุณากรอกจำนานรายการที่ต้องการจะ Allocate', genHtml(sizeLeadNew),
                    function(e) {

                        let value_limit = $('#limitLeadList').val();
                        let expiredDate = $('#dateExpire').val();

                        if (parseInt(value_limit) > sizeLeadNew) {
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
                            $('#allocate').prop('disabled', true);
                            $.ajax({
                                url: baseUrl + "lead/allocate",
                                method: "POST",
                                data: json,
                                dataType: "json",
                            }).done(function(res) {
                                //let res = JSON.parse(data);
                                setToken(res.csrf);
                                if (res.status == 'success') {
                                    var table = $("#leadNotAllocate-table").DataTable();
                                    _alerting('notify', res.message);
                                    table.ajax.reload();
                                    $('#allocate').prop('disabled', false);
                                } else {
                                    _alerting('error', res.errorMessage);
                                    setTimeout(function() {
                                        $('#allocate').prop('disabled', false);
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
                console.log(dateAddOneMonth);
                $(".datepicker").datetimepicker({
                    format: 'YYYY-MM-DD',
                    minDate: new Date(blockDate),
                    disabledDates: [new Date(blockDate)],
                    defaultDate: dateAddOneMonth
                });
                return;
            }

        })

        $('#tranfer').on('click', function(event) {
            event.preventDefault();
            var formData = new FormData();
            var json = getToken();
            let src = $("#srcTransfer").dropdown('get value');
            let des = $("#desTransfer").dropdown('get value');
            let resultCall = $("#resultCall").dropdown('get value')

            formData.append('token', json.token);
            formData.append('src', src)
            formData.append('des', des)
            formData.append('resultCall', resultCall)
            $('#tranfer').prop('disabled', true);

            $.ajax({
                url: baseUrl + "lead/transferToAgent",
                method: "POST",
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
            }).done(function(res) {
                //let res = JSON.parse(data);
                setToken(res.csrf);
                if (res.status == 'success') {
                    _alerting('notify', res.message);
                    $('#srcTransfer').dropdown('clear');
                    $('#desTransfer').dropdown('clear');
                    $('#resultCall').dropdown('clear');
                    $('#tranfer').prop('disabled', false);
                } else {
                    _alerting('error', res.errorMessage);
                    setTimeout(function() {
                        $('#tranfer').prop('disabled', false);
                    }, 2000);
                }

            }).fail(function() {
                console.error(error.message)
            });



            // }
        })

        $('#srcTransfer').on('change', async function() {
            $("#desTransfer").html("");
            let data = await getDropdrow();
            let agents = data.message.agents;
            let checkValue = $('#srcTransfer').dropdown('get value');
            if (checkValue.length < 1)
                return

            if (agents.length > 0) {
                for (let i in agents) {
                    if (jQuery.inArray(agents[i].id, checkValue) == -1) {
                        $('#desTransfer').append(`<option value="${agents[i].id}">${agents[i].firstname} ${agents[i].lastname}</option>`);
                    }
                }
            }
        })

        $('#selectallSrc').checkbox({
            onChecked() {
                const options = $('#srcTransfer > option').toArray().map(
                    (obj) => obj.value
                );
                $('#srcTransfer').dropdown('set exactly', options);
            },
            onUnchecked() {
                $('#srcTransfer').dropdown('clear');
            },
        });

        $('#selectallDes').checkbox({
            onChecked() {
                const options = $('#desTransfer > option').toArray().map(
                    (obj) => obj.value
                );
                $('#desTransfer').dropdown('set exactly', options);
            },
            onUnchecked() {
                $('#desTransfer').dropdown('clear');
            },
        });

        $('#selectAllResultCall').checkbox({
            onChecked() {
                const options = $('#resultCall > option').toArray().map(
                    (obj) => obj.value
                );
                $('#resultCall').dropdown('set exactly', options);
            },
            onUnchecked() {
                $('#resultCall').dropdown('clear');
            },
        });

        let getDropdrow = () => {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: baseUrl + "lead/getDropdrow",
                    method: "GET",
                    //data: json,
                }).done(function(res) {
                    let data = JSON.parse(res);
                    setToken(data.csrf);
                    resolve(data);
                }).fail(function() {
                    reject();
                });
            })
        }

        //table
        var allowcate_new = () => {
            return new Promise((resolve, reject) => {
                $('#leadNotAllocate-table').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    lengthMenu: [
                        [10, 25, 50, 100],
                        [10, 25, 50, 100]
                    ],
                    pageLength: 50,
                    ajax: {

                        url: baseUrl + 'lead/getDataNotAllocate',
                        type: "POST",
                        dataType: 'json',
                        data: function(d) {
                            var json = getToken();
                            d.token = json.token;
                            d.table_reload = 'leadNotAllocate-table';
                        },
                        dataSrc: function(json) {
                            setToken(json.csrf);
                            $('.dt-buttons').css('text-align', 'right');
                            $('.dt-buttons').css('margin', '0 0 20px 0');
                            $('.dataTables_length').css('position', 'absolute');
                            resolve();
                            return json.data;
                        }
                    },
                });
            })
        }

        async function loadData() {
            try {
                await allowcate_new();
                let data = await getDropdrow();
                let agents = data.message.agents;
                let callResults = data.message.callResults;
                // let checkFistname = $("#firstname").val();
                // let checkLastname = $("#lastname").val();
                console.log(agents);

                if (agents.length > 0) {
                    for (let i in agents) {
                        // if (agents[i].firstname != checkFistname && agents[i].lastname != checkLastname) {
                        $('#srcTransfer').append(`<option value="${agents[i].id}">${agents[i].firstname} ${agents[i].lastname}</option>`);
                        // }
                    }
                }

                if (callResults.length > 0) {
                    $('#resultCall').append(`<option value=" ">Leads New</option>`);
                    for (let c in callResults) {
                        $('#resultCall').append(`<option value="${callResults[c].id}">${callResults[c].name}</option>`);
                    }
                }



            } catch (error) {
                console.error(error.message)
            }

        }

        loadData();
    }) //document ready
let getLeadAll = () => {
    return new Promise((resolve, reject) => {
        var info = {
            type: "getLeadNew"
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

function btnDeleteContent(id, tb_reload) {
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
                    var table = $(`#${tb_reload}`).DataTable();
                    table.ajax.reload();
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

function genHtml(total_leads) {

    let html = `
    <div class='col-lg-6'>
        <label id="total_leadNew"><p style="color:black;">Total lead new [${total_leads} lead] </p></label>
        <input type='text' id='limitLeadList' class='form-control' placeholder='Number only' onkeypress="CheckNum(${total_leads})" value="${total_leads}">
        <span id="warning_limitLeadList"></span><br>
    </div>
    <div class='col-lg-6'>
        <label id="total_leadNew"><p style="color:black;">Leads Expire Date </p></label>
        <input type='text' id='dateExpire' class='form-control datepicker' placeholder='yyyy-mm-dd'>
        <span id="warning_dateExpire"></span><br>
    </div>
    
    `;

    return html;
}