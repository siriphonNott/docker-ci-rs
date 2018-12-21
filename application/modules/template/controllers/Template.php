<?php
class Template extends MY_Controller
{
    public $data;
    public function __construct()
    {
        parent::__construct();
        $this->load->library('users/users_library');
        $this->users_library->check_login();
        $this->data['baseConfig'] = array(
            'pageTitle' => 'Page Not Found',
        );
    }

    public function pageNotFound()
    {
        $this->data['baseConfig']['subTitle'] = '404';
        $this->layout_library
            ->setTitle('Page Not Found')
            ->view('error/404', $this->data);
    }

}
