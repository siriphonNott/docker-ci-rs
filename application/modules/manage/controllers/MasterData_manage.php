<?php
class MasterData_manage extends MY_Controller
{
    public $data;
    public function __construct()
    {
        parent::__construct();
        $this->load->library('users/users_library');
        $this->load->model('manage/manage_model');
        $this->load->model('lead/leads_model');
        $this->users_library->check_login();
        $this->users_library->check_permission($this->session->role, 'MM_MASTER', true);
        $this->data['baseConfig'] = array(
            'pageTitle' => 'Master Data Manage',
        );
        $this->data['csrf'] = $this->csrf;
        $this->layout_library->setTitle("Master Data Manage");
    }

    public function index()
    {

        $rolePermissionList = $this->manage_model->getRolePermission();
        $permissionList = $this->manage_model->getPermissionList();
        $roleList = $this->manage_model->getRoleList();


        $headerList = array();
        foreach ($permissionList as $key => $value) {
            $code = $key;
            $fullname =  $value['label'];
           if(strpos($code ,"_") === false) {
               $headerList[$code][] = $code;
            } else {
                $tmp = explode("_",$code);
                $headerList[  $tmp[0] ][] = $tmp[1];
           }
        }

        // echo "<pre>";
        // print_r($headerList);
        // print_r($rolePermissionList);
        // print_r($permissionList);
        // print_r($roleList);
        // die();

      
        $this->data['headerList'] = $headerList;
        $this->data['permissionList'] = $permissionList;
        $this->data['rolePermissionList'] = $rolePermissionList;
        $this->data['roleList'] = $roleList;

        $this->data['baseConfig']['subTitle'] = 'List';
        $this->data['masterDataLists'] = $this->manage_model->getMasterDataLists();

        $this->layout_library
            ->setTitle('Master Data Manage')
            ->setJavascript($this->config->item('assets') . 'bower_components/datatables.net/js/jquery.dataTables.min.js')
            ->setJavascript($this->config->item('assets') . 'bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')
            ->setJavascript($this->config->item('assets') . 'bower_components/datatables.net-bs/js/dataTables.buttons.min.js')
            ->setJavascript($this->config->item('assets') . 'bower_components/datatables.net-bs/js/buttons.flash.min.js')
            ->setJavascript($this->config->item('assets') . 'bower_components/datatables.net-bs/js/jszip.min.js')

            ->setJavascript($this->config->item('vendor') . 'pdfmake-master/build/pdfmake.min.js')
            ->setJavascript($this->config->item('vendor') . 'pdfmake-master/build/vfs_fonts.js')

            ->setJavascript($this->config->item('assets') . 'bower_components/datatables.net-bs/js/buttons.html5.min.js')
            ->setJavascript($this->config->item('assets') . 'bower_components/datatables.net-bs/js/buttons.print.min.js')

            ->setStyleSheet($this->config->item('assets') . 'bower_components/datatables.net-bs/css/jquery.dataTables.min.css')
            ->setStyleSheet($this->config->item('assets') . 'bower_components/datatables.net-bs/css/buttons.dataTables.min.css')
            ->setJavascript($this->config->item('assets') . 'pages/manage/masterdata_manage.js')
            ->view('masterdata', $this->data);
    }

    public function setpermission()
    {
        $this->form_validation->set_rules('role_id', 'Role ID', 'trim|required');
        $this->form_validation->set_rules('permission_id', 'Permission ID', 'trim|required');
        $this->form_validation->set_rules('action', 'action', 'trim|required');

        if ($this->form_validation->run() === true) {

            $data['role_id'] = $this->input->post('role_id');
            $data['permission_id'] = $this->input->post('permission_id');
            $action = $this->input->post('action');

            if($action == 'add') {
                $res = $this->manage_model->addRolePermission($data);
            } elseif($action == 'remove') {
                $res = $this->manage_model->removeRolePermission($data);
            }

            if ($res) {
                echo $this->main_lib->responeJson('success', 'success', $res);
            } else {
                echo $this->main_lib->responeJson('warning', $res);
            }

        } else {
            echo $this->main_lib->responeJson('error', validation_errors());
        }
    }

    public function getDataMasterdataList()
    {
        $res = $this->manage_model->getMasterdataLists();
        echo $this->main_lib->responeJson('success', $res);
    }

    public function getDataMasterdataManage()
    {   
        $tableName = $this->input->get('tableName');
        $res = $this->manage_model->getMasterdataManage($tableName);
        echo $this->main_lib->responeJson('success', $res);
    }

    public function postMasterdataList()
    {
        $this->form_validation->set_rules('label', 'Name', 'trim|required');
        //XSS(Cross-site scripting) filter    
        if ($this->form_validation->run() === true) {
            $data['label'] = $this->input->post('label');
            $action = $this->input->post('action');
            $checkDup = $this->manage_model->getMasterDataLists($data);
            if(!empty($checkDup)) {
                echo $this->main_lib->responeJson('warning', 'Duplicate Name List');
                exit();
            } 
            switch ($action) {
                case 'insert':
                    $query = $this->manage_model->insertMasterdataList($data);
                    if(empty($query)) {
                        $status = 'error';
                        $res = "Query Error: $query";
                    } else {
                        $status = 'success';
                        $res = 'Insert Successfully!';
                    }
                    echo $this->main_lib->responeJson($status , $res);
                    break;
                case 'update':
                    $id = $this->input->post('id');
                    $query = $this->manage_model->updateMasterdataList($id, $data);
                    if($query) {
                        $status = 'success';
                        $res = 'Update Successfully!';
                    } else {
                        $status = 'error';
                        $res = "Query Error: $query";
                    }
                    echo $this->main_lib->responeJson($status , $res);
                    break;
                default:
                    break;
            }
        }else{
            echo $this->main_lib->responeJson('warning', 'required field');
        }
    }

    public function postMasterdataManage()
    {
        $this->form_validation->set_rules('labelManage', 'Name', 'trim|required');
        //XSS(Cross-site scripting) filter    
        if ($this->form_validation->run() === true) {
            $tableName = $this->input->post('tableName'); 
            $data['label'] = $this->input->post('labelManage');
            $action = $this->input->post('action');
            $checkDup = $this->manage_model->getMasterdataManageForChkDup($data, $tableName);
            if(!empty($checkDup)) {
                echo $this->main_lib->responeJson('warning', 'Duplicate Name List');
                exit();
            } 
            switch ($action) {
                case 'insert':
                    $query = $this->manage_model->insertMasterdataManage($data, $tableName);
                    if(empty($query)) {
                        $status = 'error';
                        $res = "Query Error: $query";
                    } else {
                        $status = 'success';
                        $res = 'Insert Successfully!';
                    }
                    echo $this->main_lib->responeJson($status , $res);
                    break;
                case 'update':
                    $id = $this->input->post('id');
                    $query = $this->manage_model->updateMasterdataManage($id, $data, $tableName);
                    if($query) {
                        $status = 'success';
                        $res = 'Update Successfully!';
                    } else {
                        $status = 'error';
                        $res = "Query Error: $query";
                    }
                    echo $this->main_lib->responeJson($status , $res);
                    break;
                default:
                    break;
            }
        } else {
            echo $this->main_lib->responeJson('warning', 'required field');
        }
    }

    public function deleteMasterdataList()
    {
        $this->form_validation->set_rules('id', 'id', 'trim|required');
        if ($this->form_validation->run() === true) {
            $id = $this->input->post('id');
            $res = $this->manage_model->deleteMasterdataList($id);
            if($res) {
                echo $this->main_lib->responeJson('success', 'Delete Successfully!');
            } else {
                echo $this->main_lib->responeJson('warning', "Query Error: $res");
            }
        } else {
            echo $this->main_lib->responeJson('warning', 'required field');
        }
    }

    public function deleteMasterdataManage()
    {
        $this->form_validation->set_rules('id', 'id', 'trim|required');
        if ($this->form_validation->run() === true) {
            $id = $this->input->post('id');
            $tableName = $this->input->post('tableName'); 
            $res = $this->manage_model->deleteMasterdataManage($id, $tableName);
            if($res) {
                echo $this->main_lib->responeJson('success', 'Delete Successfully!');
            } else {
                echo $this->main_lib->responeJson('warning', "Query Error: $res");
            }
        } else {
            echo $this->main_lib->responeJson('warning', 'required field');
        }
    }
}
