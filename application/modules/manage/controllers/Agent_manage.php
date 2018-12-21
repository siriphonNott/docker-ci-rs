<?php
class Agent_manage extends MY_Controller
{
    public $data;
    public function __construct()
    {
        parent::__construct();
        $this->load->library('users/users_library');
        $this->load->model('manage_model');
        $this->users_library->check_login();
        $this->users_library->check_permission($this->session->role, 'MM_AGENT', true);
        $this->data['baseConfig'] = array(
            'pageTitle' => 'Agent Management',
        );
        $this->data['csrf'] = $this->csrf;
        $this->layout_library->setTitle("Agent Management");
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
        $this->layout_library
        ->setTitle('Agent Data Manage')
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
        ->setJavascript($this->config->item('assets') . 'pages/manage/agent_manage.js')
        ->view('agent_manage', $this->data);
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

    public function getAgentdataList()
    {
        $res = $this->manage_model->getAgentdata();
        echo $this->main_lib->responeJson('success', $res);
    }

    public function postAgentdata()
    {
        $this->form_validation->set_rules('user_id', 'id', 'trim|required');
        $this->form_validation->set_rules('userUsername', 'Username', 'trim|required');
        $this->form_validation->set_rules('userPassword', 'Password', 'trim|required');
        $this->form_validation->set_rules('userName', 'Name', 'trim|required');
        $this->form_validation->set_rules('userPosition', 'Position', 'trim|required');
        $this->form_validation->set_rules('userDetail1', 'Detail1', 'trim|required');
        $this->form_validation->set_rules('userDetail2', 'Detail2', 'trim|required');
        $this->form_validation->set_rules('userDetail3', 'Detail3', 'trim|required');
        //XSS(Cross-site scripting) filter
        $input = $this->input->post(null, true);
        if ($this->form_validation->run() === true) {
            $action = $this->input->post('action');
            $data['user_id'] = $this->input->post('user_id');
            $oldUser_id = $this->input->post('idBeforeEdit');
            $checkDup = $this->manage_model->getAgentdataForChkDup($data);
            switch ($action) {
                case 'insert':
                    if(!empty($checkDup)) {
                        echo $this->main_lib->responeJson('warning', 'Duplicate Name List');
                        exit();
                    }
                    else{
                        $query = $this->manage_model->insertAgentManage($input);
                        if($query === true) {
                            $status = 'success';
                            $res = 'Insert Successfully!';
                        } else {
                            $status = 'error';
                            $res = "Query Error: $query";
                        }
                        echo $this->main_lib->responeJson($status , $res);
                    }
                    break;
                case 'update':
                    if($oldUser_id == $data['user_id']){
                        $query = $this->manage_model->updateAgentdata($oldUser_id, $input);       
                        if($query) {
                            $status = 'success';
                            $res = 'Update Successfully!';
                        } else {
                            $status = 'error';
                            $res = "Query Error: $query";
                        }
                        echo $this->main_lib->responeJson($status , $res);
                    }
                    else{
                        if(!empty($checkDup)) {
                            echo $this->main_lib->responeJson('warning', 'Duplicate Name List');
                            exit();
                        }
                        else{
                            $query = $this->manage_model->updateAgentdata($oldUser_id, $input);       
                            if($res) {
                                $status = 'success';
                                $res = 'Update Successfully!';
                            } else {
                                $status = 'error';
                                $res = "Query Error: $res";
                            }
                            echo $this->main_lib->responeJson($status , $res);
                        } 
                    }
                    break;
                default:
                    break;
            }
        } else {
            echo $this->main_lib->responeJson('warning', validation_errors());
        }
    }
    
    public function deleteAgentdata()
    {
        $this->form_validation->set_rules('user_id', 'user_id', 'trim|required');
        if ($this->form_validation->run() === true) {
            $id = $this->input->post('user_id');
            $res = $this->manage_model->deleteAgentdata($id);
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
