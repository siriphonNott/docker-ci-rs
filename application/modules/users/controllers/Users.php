<?php

class Users extends MY_Controller
{
    public $data;
    public function __construct()
    {

        parent::__construct();
        $this->load->library('users_library');
        $this->load->model('users_model');
        $this->load->library('main_library', null, 'main_lib');
        $this->users_library->check_login();
        $this->data['baseConfig'] = array(
            'pageTitle' => 'Users',
        );
        $this->data['csrf'] = $this->csrf;
    }

    public function login()
    {
        // $salt = $this->users_library->salt();
        // $pass = '123456';
        // echo 'salt: ' . $salt . '<br>';
        // echo 'password: ' . $this->users_library->hash_password($pass, $salt);
        $this->load->view('login_page', array('csrf' => $this->csrf));
    }



    public function authen()
    {

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

        if ($this->form_validation->run() === true) {

            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $remember = (bool) $this->input->post('remember_me');
            $user = $this->users_library->login($username, $password, $remember);
            if ($user['status'] == 'success') {
                echo $this->main_lib->responeJson('success', 'Authentication Successfully!');
            } else {
                echo $this->main_lib->responeJson('error', $user['message']);
            }

        } else {
            echo $this->main_lib->responeJson('error', validation_errors());
        }

    }

    //edit by nut
	public function change_password()
    {
        // $this->users_library->is_permission(array(1));
        $this->data['baseConfig']['subTitle'] = 'Change Password';
        $this->layout_library
        ->setTitle('Change Password')
        ->setJavascript($this->config->item('assets') . 'dist/js/jquery.validate.min.js')
        ->setJavascript($this->config->item('assets') . 'dist/js/additional-methods.min.js')
        ->setJavascript($this->config->item('assets') . 'pages/users/change_password.js')
        ->view('change_password',$this->data);
    }

    public function updatePassword()
    {
        // $this->users_library->is_permission(array(2));
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required');

        $data = array();
        $input = $this->input->post(null, true);

        if (!isset($input['password'])) {
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
        } else {
            if ($input['password'] !== '') {
                if (!isset($input['confirm_password'])) {
                    $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required');
                } else {
                    if ($input['confirm_password'] != $input['password']) {
                        echo $this->main_lib->responeJson('warning', 'Password not match');
                        exit();
                    } else {
                        $salt = $this->users_library->salt();
                        $data['password'] = $this->users_library->hash_password($input['password'], $salt);
                        $data['salt'] = $salt;
                    }
                }
            }
        }
        $id = $this->session->UID;
        $res = $this->users_model->update($id, $data);

        if ($res) {
            echo $this->main_lib->responeJson('success', 'Update Successfully!');
            $this->session->sess_destroy();
        } else {
            echo $this->main_lib->responeJson('warning', $res);
        }

    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login', 'refresh');
    }

    public function register()
    {
        $this->load->view('register_page');
    }

    public function create()
    {
        $this->users_library->is_permission(array(1));
        $this->data['options'] = $this->main_lib->array_to_kv($this->users_library->get_roles());
        $this->data['baseConfig']['subTitle'] = 'Create';
        $this->layout_library
            ->setTitle('Users Create')
            ->setJavascript($this->config->item('assets') . 'dist/js/jquery.validate.min.js')
            ->setJavascript($this->config->item('assets') . 'dist/js/additional-methods.min.js')
            ->setJavascript($this->config->item('assets') . 'pages/users/users_create.js')
            ->view('create', $this->data);
    }
    public function dataTable()
    {
        $this->users_library->is_permission(array(1));
        $this->data['baseConfig']['subTitle'] = 'List';
        $this->layout_library
            ->setTitle('Manage Users')
            ->setJavascript($this->config->item('assets') . 'bower_components/datatables.net/js/jquery.dataTables.min.js')
            ->setJavascript($this->config->item('assets') . 'bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')
            ->setJavascript($this->config->item('assets') . 'bower_components/datatables.net-bs/js/dataTables.buttons.min.js')
            ->setJavascript($this->config->item('assets') . 'bower_components/datatables.net-bs/js/buttons.flash.min.js')
            ->setJavascript($this->config->item('assets') . 'bower_components/datatables.net-bs/js/jszip.min.js')

            ->setJavascript($this->config->item('vendor') . 'pdfmake-master/build/pdfmake.min.js')
            ->setJavascript($this->config->item('vendor') . 'pdfmake-master/build/vfs_fonts.js')

            ->setJavascript($this->config->item('assets') . 'bower_components/datatables.net-bs/js/buttons.html5.min.js')
            ->setJavascript($this->config->item('assets') . 'bower_components/datatables.net-bs/js/buttons.print.min.js')

            ->setStyleSheet($this->config->item('assets') . 'bower_components/datatables.net/css/jquery.dataTables.min.css')
            ->setStyleSheet($this->config->item('assets') . 'bower_components/datatables.net/css/buttons.dataTables.min.css')
            ->setJavascript($this->config->item('assets') . 'pages/users/users_datatable.js')
            ->view('dataTable', $this->data);
    }

    public function edit()
    {
        $this->users_library->is_permission(array(1));
        $id = $this->uri->segment(4);
        $row = $this->users_model->find_users_by_id($id);
        $this->data['options'] = $this->main_lib->array_to_kv($this->users_library->get_roles());
        if (empty($row)) {

            $this->data['baseConfig']['subTitle'] = 'Edit';
            $this->layout_library
                ->setTitle('Blank Page')
                ->view('blank', $this->data);

        } else {

            foreach ($row as $key => $value) {
                $this->data[$key] = $value;
            }
 

            $this->data['baseConfig']['subTitle'] = 'Edit';
            $this->layout_library
                ->setTitle('Contact Edit')
                ->setJavascript($this->config->item('assets') . 'dist/js/jquery.validate.min.js')
                ->setJavascript($this->config->item('assets') . 'dist/js/additional-methods.min.js')
                ->setJavascript($this->config->item('assets') . 'pages/users/users_update.js')
                ->view('edit', $this->data);
        }
    }

    public function update()
    {
        $this->users_library->is_permission(array(1));
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('firstname', 'Firstname', 'trim|required');
        $this->form_validation->set_rules('lastname', 'Lastname', 'trim|required');
        $this->form_validation->set_rules('role', 'Role', 'trim|required');

        //XSS(Cross-site scripting) filter
        $data = array();
        $input = $this->input->post(null, true);

        if (!isset($input['password'])) {
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
        } else {
            if ($input['password'] !== '') {
                if (!isset($input['confirm_password'])) {
                    $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required');
                } else {
                    if ($input['confirm_password'] != $input['password']) {
                        echo $this->main_lib->responeJson('warning', 'Password not match');
                        exit();
                    } else {
                        $salt = $this->users_library->salt();
                        $data['password'] = $this->users_library->hash_password($input['password'], $salt);
                        $data['salt'] = $salt;
                    }
                }
            }
        }

        if ($this->form_validation->run() === true) {

            foreach ($input as $key => $value) {
                if (in_array($key, array('password', 'confirm_password'))) {
                    continue;
                }
                $data[$key] = str_replace("[removed]", "", $value);
            }

            if ($this->input->post('id') === null) {
                $res = $this->users_model->insert($data);
                $session_users = $this->session->users;
                $data['created_by'] = $session_users['UID'];
            } else {
                $id = $this->input->post('id');
                $data['updated_at'] = date('Y-m-d H:i:s');
                $res = $this->users_model->update($id, $data);
            }

            if ($res) {
                echo $this->main_lib->responeJson('success', 'Update Successfully!');
            } else {
                echo $this->main_lib->responeJson('warning', $res);
            }

        } else {
            echo $this->main_lib->responeJson('error', validation_errors());
        }
    }

    public function insert()
    {
        $this->users_library->is_permission(array(1));
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required');
        $this->form_validation->set_rules('firstname', 'Firstname', 'trim|required');
        $this->form_validation->set_rules('lastname', 'Lastname', 'trim|required');
        $this->form_validation->set_rules('role', 'Role', 'trim|required');

        if ($this->input->post('password') !== $this->input->post('confirm_password')) {
            echo $this->main_lib->responeJson('warning', 'Password Not match');
            exit();
        }
        //XSS(Cross-site scripting) filter
        $data = array();
        $input = $this->input->post(null, true);
        foreach ($input as $key => $value) {
            if ($key == 'confirm_password') {
                continue;
            }

            if ($key == 'password') {
                $salt = $this->users_library->salt();
                $data['password'] = $this->users_library->hash_password($input['password'], $salt);
                $data['salt'] = $salt;
                continue;
            }
            $data[$key] = str_replace("[removed]", "", $value);
        }

        if ($this->form_validation->run() === true) {

            $id = $this->input->post('id');
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = $this->session->UID;
            $res = $this->users_model->insert($data);

            if ($res) {
                echo $this->main_lib->responeJson('success', 'Insert Successfully!');
            } else {
                echo $this->main_lib->responeJson('warning', $res);
            }

        } else {
            echo $this->main_lib->responeJson('error', validation_errors());
        }
    }

    public function delete()
    {
        $this->users_library->is_permission(array(1));
        $this->form_validation->set_rules('id', 'Id', 'required');
        if ($this->form_validation->run() === true) {
            $hasQuery = $this->users_model->delete($this->input->post('id'));
            if ($hasQuery) {
                echo $this->main_lib->responeJson('success', 'Deleted Successfully!');
            } else {
                echo $this->main_lib->responeJson('error', 'System Error!');
            }
        } else {
            echo $this->main_lib->responeJson('warning', 'Try again');
        }
    }
}
