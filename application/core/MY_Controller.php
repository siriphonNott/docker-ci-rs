<?php
class MY_Controller extends MX_Controller
{
    public $method;
    public $class;
    protected $csrf;
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Bangkok');
        $this->class = $this->router->fetch_class();
        $this->method = $this->router->fetch_method();
        $this->load->library('layout_library');
        $this->load->library('main_library', null, 'main_lib');
        $this->csrf = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash(),
        );
    }

}
