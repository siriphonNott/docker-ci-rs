//Initial Global variables
var $form =  $('#form_lead'); 
var $btnSubmit =  $('button[value="submit"]'); 
var $btnCancel =  $('button[value="cancel"]'); 
var $tablePreview =  $('#preview-table').DataTable();

    $(document).ready(function() {
    //Initial element
    $('.ui.dropdown').dropdown();
    
    let generateTable = (obj) => {
        $tablePreview.clear();
        obj.rows.forEach( (element, index) => {
            let temp = [];
            temp.push(element.no);
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
            let rowNode = $tablePreview.row.add(temp).node();
            $(rowNode).attr("id", element.no);
            if(!element.leadStatus) {
                $(rowNode).addClass('bg-warning');
            }
            $tablePreview.draw();
        });
    }

    $form.submit(function(event){
        event.preventDefault();
        let json = {};
        let arrObj = $(this).serializeArray();
        for(let item in arrObj) {
            if(arrObj[item].value == '') {
                $(`#${arrObj[item].name}`).dropdown('show');
                return;
            }
            json[arrObj[item].name] = arrObj[item].value;
        }
        $.ajax({
            url: `${baseUrl}lead_submit`,
            method: "post",
            data: json,
            dataType: 'json',
        })
        .done(function(res, textStatus, jqXHR){
            console.log(res);
            console.log(res.csrf);
            setToken(res.csrf);
            _alerting('notify', getContentLoadleadResult(res.message, true))
            // _alerting('notify','Upload Lead Successfully!')
            $btnSubmit.prop('disabled', true);
            close_loading();
        })
        .fail(function(jqXHR, textStatus, errorThrown){
            alert(`Error: ${errorThrown}`);
            console.log(jqXHR);
        })
        .always();
    });
    
    $('input[name="fileUpload"]').on('change', function(){
        var formData = new FormData(); 
        var json = getToken();
        let file = $("#fileUpload")[0].files[0]
        
        if(file !== undefined) {
            show_loading();
            formData.append('fileUpload', file);
            formData.append('type', 'upload');
            formData.append('token', json.token);
            $btnSubmit.prop('disabled', true);
            $tablePreview.clear().draw();
            console.log(json);
            $.ajax({
                url: `${baseUrl}upload/do_upload`,
                method: "post",
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
            }).done(function (res) {
                console.log(res);
                setToken(res.csrf);
                if (res.status == 'success') {
                    moveBar('go',20);
                    generateTable(res.message)
                    if(res.message.leadStatus) {
                        $btnSubmit.prop('disabled', false);
                        $('input[name="fileName"]').val(res.message.fileName);
                        _alerting('notify', getContentLoadleadResult(res.message))
                        // _alerting('notify','Upload Lead Successfully!')
                    } else {
                        if(res.message.leadInvalid !== undefined && res.message.leadInvalid.length > 0) {
                            _alerting('warning',`Lead No. ${res.message.leadInvalid.toString()} must have required field (Tel1).<br><br>Please check lead again.`)
                        }
                    }
                } else {
                    $("#fileUpload").val('');
                    _alerting('warning',res.errorMessage)
                }
            }).fail(function (jqXHR, textStatus) {
                $("#fileUpload").val('');
                if (jqXHR.status == 403) {
                alertify.error('<i class="fa fa-info-circle" aria-hidden="true"></i> ' + 'Your permission expired .Please reload this page again.');
                } else {
                alertify.error('<i class="fa fa-info-circle" aria-hidden="true"></i> ' + 'The system is temporarily unavailable.');
                }
            }).always(()=>{
                close_loading();
            });      
        }
    });

    let  moveBar = (type = "back", progress = 1) => {
        var elem = document.getElementById("progressbar"); 
        var width = (type == "go")?progress:100;
        
        var id = setInterval(frame, 5);
        function frame() {
            if(type == 'go') {
                console.log('go');
                
                if (width >= 100) {
                    clearInterval(id);
                } else {
                    width++; 
                    elem.style.width = width + '%'; 
                }
            } else {
                console.log('back');
                if (width <= 0) {
                    clearInterval(id);
                } else {
                    width--; 
                    elem.style.width = width + '%'; 
                }
            }
        }
    }

    $btnCancel.on('click',function(){
        $('.ui.modal').modal('show');
        moveBar();
        $("#fileUpload").val('');
        $btnSubmit.prop('disabled', true);
        $tablePreview.clear().draw();
    });
   
});