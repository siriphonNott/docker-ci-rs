<?php
defined('BASEPATH') || exit('No direct script access allowed');

class Contact extends MY_Controller
{
    public $data;
    public function __construct()
    {
        parent::__construct();
        $this->load->library('users/users_library');
        $this->load->model('contact/contact_model');
        $this->load->library('contact/contact_library');
        $this->users_library->check_login();
        $this->data['baseConfig'] = array(
            'pageTitle' => 'Contact',
        );
        $this->data['csrf'] = $this->csrf;
        $this->layout_library->setTitle("Contact");
    }

    public function index()
    {
        $this->data['baseConfig']['subTitle'] = 'List';
        // $this->data['contacts'] = $this->contact_library->paginate();
        $this->layout_library
            ->setTitle('Contact List')
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
            ->setJavascript($this->config->item('assets') . 'pages/contact/contact_datatable.js')
            ->view('dataTable', $this->data);

    }

    public function create()
    {
        $this->data['baseConfig']['subTitle'] = 'Create';
        $this->layout_library
            ->setTitle('Contact Create')
            ->setJavascript($this->config->item('assets') . 'dist/js/jquery.validate.min.js')
            ->setJavascript($this->config->item('assets') . 'dist/js/additional-methods.min.js')
            ->setJavascript($this->config->item('assets') . 'pages/contact/contact_create.js')
            ->view('create', $this->data);
    }

    public function delete()
    {

        $this->form_validation->set_rules('id', 'Id', 'required');
        if ($this->form_validation->run() === true) {
            $hasQuery = $this->contact_model->delete($this->input->post('id'));
            if ($hasQuery) {
                echo $this->main_lib->responeJson('success', 'Deleted Successfully!');
            } else {
                echo $this->main_lib->responeJson('error', 'System Error!');
            }
        } else {
            echo $this->main_lib->responeJson('warning', 'Try again');
        }
    }

    public function edit()
    {

        $id = $this->uri->segment(3);

        $row = $this->contact_model->find_contact_by_id($id);

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
                ->setJavascript($this->config->item('assets') . 'pages/contact/contact_update.js')
                ->view('edit', $this->data);
        }
    }

    public function stampData()
    {

        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('gender', 'Gender', 'trim|required');
        $this->form_validation->set_rules('firstname', 'Firstname', 'trim|required');
        $this->form_validation->set_rules('lastname', 'Lastname', 'trim|required');
        // $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

        if ($this->form_validation->run() === true) {

            //XSS(Cross-site scripting) filter
            $data = array();
            $data = $this->input->post(null, true);
            foreach ($data as $key => $value) {
                $data[$key] = str_replace("[removed]", "", $value);
            }

            if ($this->input->post('id') === null) {
                $res = $this->contact_library->insert($data);
                $session_users = $this->session->users;
                $data['created_by'] = $session_users['UID'];
            } else {
                $id = $this->input->post('id');
                $data['updated_at'] = date('Y-m-d H:i:s');
                $res = $this->contact_library->update($id, $data);
            }

            if ($res['status'] == 'success') {
                echo $this->main_lib->responeJson('success', validation_errors());
            } else {
                echo $this->main_lib->responeJson('warning', $res['message']);
            }

        } else {
            echo $this->main_lib->responeJson('error', validation_errors());
        }
    }

    public function check_telephone()
    {
        $this->form_validation->set_rules('tel', 'Telephone', 'required');
        if ($this->form_validation->run() === true) {
            $tel = $this->input->post('tel');
            $result = $this->contact_model->find_contact_by_tel($tel);

            if (empty($result)) {
                echo $this->main_lib->responeJson('success', 'This telephone number is avalible.');
            } else {
                echo $this->main_lib->responeJson('warning', 'This telephone is already in the system!');
            }
        } else {
            echo $this->main_lib->responeJson('error', 'Requires Telephone!');
        }
    }

    public function popup()
    {
        $tel = $this->uri->segment(3);
        $view = 'dataTable';
        $js = 'contact_datatable.js';
        $title = 'Contact List';
        $this->data['baseConfig']['subTitle'] = 'List';
        $this->data['tel_popup'] = $tel;
        if (empty($tel)) {
            $this->layout_library
                ->setTitle('Contact List')->view('blank', $this->data);
        } else {

            $data = json_decode(json_encode($this->contact_model->find_contact_by_check_tel($tel)), true);

            if (count($data) < 1) {
                $view = 'create';
                $js = 'contact_create.js';
                $this->data['baseConfig']['subTitle'] = 'Create';
                //  redirect( base_url('contact/create'), 'refresh');
            } else {
                redirect(base_url('contact/edit/' . $data[0]['id']), 'refresh');
            }

            $this->layout_library
                ->setTitle($title)
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
                ->setJavascript($this->config->item('assets') . 'dist/js/jquery.validate.min.js')
                ->setJavascript($this->config->item('assets') . 'dist/js/additional-methods.min.js')
                ->setJavascript($this->config->item('assets') . 'pages/contact/' . $js)
                ->view($view, $this->data);

        }
    }
}
