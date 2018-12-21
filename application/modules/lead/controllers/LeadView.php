<?php

class LeadView extends MY_Controller
{
    public $data;
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('users/users_library');
        $this->load->library('lead/lead_library');
        $this->load->model('lead/leads_model');
        $this->load->library('main_library', null, 'main_lib');
        $this->users_library->check_login();
        $this->users_library->check_permission($this->session->role, 'LM_VIEW', true);
        $this->data['baseConfig'] = array(
            'pageTitle' => 'Lead View',
        );
        $this->data['csrf'] = $this->csrf;
    }

    public function index()
    {
        //$this->users_library->is_permission(array(1));
        $this->data['baseConfig']['subTitle'] = 'List';
        $this->layout_library
            ->setTitle('Lead View')
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
            ->setJavascript($this->config->item('assets') . 'pages/leads/leadView.js')
            ->view('leadView', $this->data);
    }

    public function getDataTable()
    {
        $data = array();
        $result = $this->leads_model->getTableView($this->session->UID, $this->session->role);
        if ($this->session->role == '3') {
            $firstResult = $this->leads_model->getListLeadFromFollowDate($this->session->UID);
        } else {
            $firstResult = array();
        }
        // echo "<pre>";
        // print_r($firstResult);
        // exit();
        if (sizeof($firstResult) > 0) {
            foreach ($firstResult as $key => $value) {
                array_unshift($result, $firstResult[$key]);
            }
        }
        echo $this->main_lib->responeJson('success', $result);
    }

    public function getDashBoard()
    {
        $result = $this->leads_model->getDataDashBoard($this->session->UID);
        echo $this->main_lib->responeJson('success', $result);
    }

    public function edit()
    {
        $this->data['cusId'] = $this->uri->segment(3);
        $row = $this->leads_model->getLeadById($this->data['cusId']);
        if (empty($row)) {

            $this->data['baseConfig']['subTitle'] = 'Edit Lead';
            $this->layout_library
                ->setTitle('Blank Page')
                ->view('blank', $this->data);

        } else {
            foreach ($row as $key => $value) {
                $this->data[$key] = str_replace("[removed]", "", $value);
            }
            $this->data['baseConfig']['subTitle'] = 'Edit Lead';
            $this->layout_library
                ->setJavascript($this->config->item('assets') . 'bower_components/datatables.net/js/jquery.dataTables.min.js')
                ->setJavascript($this->config->item('assets') . 'bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')
                ->setJavascript($this->config->item('assets') . 'bower_components/datatables.net-bs/js/dataTables.buttons.min.js')
                ->setJavascript($this->config->item('assets') . 'bower_components/datatables.net-bs/js/buttons.flash.min.js')
                ->setJavascript($this->config->item('assets') . 'bower_components/datatables.net-bs/js/jszip.min.js')

                ->setJavascript($this->config->item('assets') . 'bower_components/datatables.net-bs/js/buttons.html5.min.js')
                ->setJavascript($this->config->item('assets') . 'bower_components/datatables.net-bs/js/buttons.print.min.js')
                ->setStyleSheet($this->config->item('assets') . 'bower_components/datatables.net/css/jquery.dataTables.min.css')
                ->setStyleSheet($this->config->item('assets') . 'bower_components/datatables.net/css/buttons.dataTables.min.css')

                ->setJavascript($this->config->item('assets') . 'bower_components/moment/min/moment.min.js')
                ->setJavascript($this->config->item('assets') . 'bower_components/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')
                ->setStyleSheet($this->config->item('assets') . 'dist/css/crm.css')
                ->setJavascript($this->config->item('assets') . 'pages/leads/leadDetail.js')
                ->view('leadDetail', $this->data);
        }
    }

    public function updateDetail()
    {
        // print_r($this->input->post());
        $this->form_validation->set_rules('firstname', 'firstname', 'trim|required');
        $this->form_validation->set_rules('lastname', 'lastname', 'trim|required');
        $this->form_validation->set_rules('tel1', 'Tel.1', 'trim|required');
        $this->form_validation->set_rules('callResult', 'Call Result', 'trim|required');
        if ($this->form_validation->run() === true) {
            //XSS(Cross-site scripting) filter
            $data = array();
            $data = $this->input->post(null, true);

            foreach ($data as $key => $value) {
                $data[$key] = str_replace("[removed]", "", $value);
            }

            $updateLeadDetail = $this->leads_model->updateLeads($data['id'], $data);
            if ($updateLeadDetail) {
                echo $this->main_lib->responeJson('success', "Update Success");
            } else {
                echo $this->main_lib->responeJson('error', "Transfer Success");
            }

        } else {
            echo $this->main_lib->responeJson('error', validation_errors());
        }
    }

    public function getDetailLead()
    {
        $id = $this->input->post('id');
        $data = $this->leads_model->getLeadById($id);
        if (!empty($data)) {
            echo $this->main_lib->responeJson('success', $data);
        } else {
            echo $this->main_lib->responeJson('error', 'Lead is null');
        }

    }

    public function getDataDropdrow()
    {
        $data = array();
        $__callResult = array();
        $__agent = array();
        $agent = $this->leads_model->getAgent("crm_users");
        $resultCall = $this->leads_model->getDataDropdrow("lead_call_result", array('used' => '1'));
        $channels = $this->leads_model->getDataDropdrow("lead_channels");
        $campaigns = $this->leads_model->getDataDropdrow("lead_campaigns");
        $types = $this->leads_model->getDataDropdrow("lead_types");

        $data['types'] = $types;
        $data['campaigns'] = $campaigns;
        $data['channels'] = $channels;
        $data['callResults'] = $resultCall;
        $data['agents'] = $agent;
        echo $this->main_lib->responeJson('success', $data);

    }

    public function api($type = '')
    {
        $type = $this->input->get('type');
        $table = $this->input->get('table');
        switch ($type) {
            case 'get_all_data':
                $data = $this->leads_model->getAll($table);
                echo $this->main_lib->responeJson('success', array('data' => $data));
                break;
            case 'getLeadNew':
                $data = $this->leads_model->getLeadNew();
                echo $this->main_lib->responeJson('success', array('data' => $data));
                break;
            case 'getLeadExpire':
                $data = $this->leads_model->getLeadExpire();
                echo $this->main_lib->responeJson('success', array('data' => $data));
                break;
            default:
                break;
        }
    }

    public function historicalCall()
    {
        $httpMethod = $this->input->method(TRUE);
        $httpStatus = 200;
        $status = 'success';
        $res = true;
        switch ($httpMethod) {
            case 'GET':
                $params['userId'] = $this->session->UID;
                $params['leadId'] = $this->input->get('leadId');
                if(!empty($params['leadId'])) {
                    $res = $this->leads_model->getHistoricalCall($params);
                } else {
                    $status = 'warning';
                    $res = 'require field leadId';
                }
                break;
            case 'POST':
                $this->form_validation->set_rules('extension', 'extension', 'trim|required');
                $this->form_validation->set_rules('phoneNumber', 'phoneNumber', 'trim|required');
                $this->form_validation->set_rules('leadId', 'leadId', 'trim|required');
                if ($this->form_validation->run() === true) {
                    $params['userId'] = $this->session->UID;
                    $params['extension'] = $this->input->post('extension');
                    $params['phoneNumber'] = $this->input->post('phoneNumber');
                    $params['leadId'] = $this->input->post('leadId');
                    $res = $this->leads_model->insertHistoricalCall($params);
                    if(empty($res)) {
                        $status = 'error';
                        $res = 'Error query';
                    } else {
                        $res = 'insert successfully!';
                    }
                } else {
                    $status = 'warning';
                    $res = 'required field!';
                }
                break;
            case 'PUT':
                break;
            case 'DELETE':
                break;
            default:
                break;
        }
        echo $this->main_lib->responeJson($status, $res);
    }

}