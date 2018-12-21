<?php

class LeadReport extends MY_Controller
{
    public $data;
    public function __construct()
    {
        parent::__construct();
        $this->load->library('users/users_library');
        $this->load->model('lead/leads_model');
        $this->load->library('main_library', null, 'main_lib');
        $this->users_library->check_login();
        $this->users_library->check_permission($this->session->role, 'LM_REPORT', true);
        $this->data['baseConfig'] = array(
            'pageTitle' => 'Lead Report',
        );
        $this->data['csrf'] = $this->csrf;
    }

    public function index()
    {
        $this->data['baseConfig']['subTitle'] = 'List';
        $this->data['agent'] = $this->leads_model->getAll('crm_users');
        $this->data['callResult'] = $this->leads_model->getAll('lead_call_result');
        $this->data['campaigns'] = $this->leads_model->getAll('lead_campaigns');
        $this->data['channels'] = $this->leads_model->getAll('lead_channels');
        $this->data['leadTypes'] = $this->leads_model->getAll('lead_types');

        $this->layout_library
            ->setTitle('Lead Report')
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

            ->setJavascript($this->config->item('assets') . 'bower_components/moment/min/moment.min.js')
            ->setJavascript($this->config->item('assets') . 'bower_components/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')

            ->setStyleSheet($this->config->item('assets') . 'bower_components/bootstrap-daterangepicker/daterangepicker.css')
            ->setStyleSheet($this->config->item('assets') . 'bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')



            ->setJavascript($this->config->item('assets') . 'pages/leads/leadsReport.js')
            ->view('leadReport', $this->data);
    }

    public function getDataReport()
    {  
            //XSS(Cross-site scripting) filter
        $data = array();
        $data = $this->input->get(null, true);
        foreach ($data as $key => $value) {
            $data[$key] = str_replace("[removed]", "", $value);
        }

        $dateFrom = $this->input->get('datefrom');
        $dateTo = $this->input->get('dateto');
        $params = array();
        foreach ($this->input->get() as $key => $value) {
            if (!in_array($key, array('datefrom', 'dateto'))) {
                $params[$key] = $value;
            }
        }
        $res = $this->leads_model->searchData($dateFrom, $dateTo, $params);
        echo $this->main_lib->responeJson('success', array("rows" => $res));
    }
}