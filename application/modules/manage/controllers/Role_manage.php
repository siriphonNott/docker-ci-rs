<?php
class Role_manage extends MY_Controller
{
    public $data;
    public function __construct()
    {
        parent::__construct();
        $this->load->library('users/users_library');
        $this->load->model('manage_model');
        $this->users_library->check_login();
        $this->users_library->check_permission($this->session->role, 'MM_ROLE', true);
        $this->data['baseConfig'] = array(
            'pageTitle' => 'Role Manage',
        );
        $this->data['csrf'] = $this->csrf;
        $this->layout_library->setTitle("Agent Manage");
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
            ->setTitle('Role Manage')
            ->setJavascript($this->config->item('assets') . 'pages/manage/role_manage.js')
            ->view('dataTable_role', $this->data);
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
}
