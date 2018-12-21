let setPermission = async (role_id, permission_id, item_id) => {
    let $this = $(`td[name=${item_id}]`);
    let isPermission = parseInt($this.attr('isPermission'));
    let faClass = ['fa fa-circle-o','fa fa-check-circle'];

    console.log('role_id: '+role_id);
    console.log('permission_id: '+permission_id);
    console.log('isPermission: '+ isPermission);

    if(role_id != '' && permission_id != '' ) {
        
        if(isPermission) {
            $this.attr('isPermission', 0);
            await postSetPermission(role_id,permission_id, 'remove');
            $this.find('i').removeClass(faClass[1]);
            $this.find('i').addClass(faClass[0]);
        } else {
            $this.attr('isPermission', 1);
            await postSetPermission(role_id,permission_id, 'add');
            $this.find('i').removeClass(faClass[0]);
            $this.find('i').addClass(faClass[1]);
        }
        
    } else {
        alertify.alert(`Sorry! Not found ${role_id} or ${permission_id} `).setHeader("<h4> Warning </h4>");
    }
    
}

let postSetPermission = (role_id, permission_id, action) => {
    
    return new Promise( (resolve, reject) => {
        var json = getToken();
        json['role_id'] = role_id;
        json['permission_id'] = permission_id;
        json['action'] = action;
        $.ajax({
            url: baseUrl + "manage/setpermission",
            dataType: "json",
            method: "post",
            data: json
            }).done(function (res) {
                setToken(res.csrf);
                if (res.status == 'success') {
                    resolve(res.status);
                } 
            }).fail(function (jqXHR, textStatus) {
                let errorMassage = '';
                if (jqXHR.status == 403) {
                    errorMassage = 'Your permission expired .Please reload this page again.';
                } else {
                    errorMassage = 'The system is temporarily unavailable.';
                }
                alertify.alert('<i class="fa fa-info-circle" aria-hidden="true"></i> ' + errorMassage).setHeader("<h4> Warning </h4>");
                reject(errorMassage);
        });
            
    });
    
}