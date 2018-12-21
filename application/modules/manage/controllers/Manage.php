<?php

class Manage extends MY_Controller
{
    public $data;
    public function __construct()
    {
        parent::__construct();
        $this->load->library('contact/contact_library');
        $this->load->library('users/users_library');
        $this->data['baseConfig'] = array(
            'pageTitle' => 'Manage',
        );
        $this->data['csrf'] = $this->csrf;
        $this->users_library->is_permission($this->session->role, '1');
        $this->layout_library->setTitle("Manage");
    }
}
