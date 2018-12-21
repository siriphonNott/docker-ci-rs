<?php

class LeadManage extends MY_Controller
{
    public $data;
    public function __construct()
    {
        parent::__construct();
        $this->load->library('users/users_library');
        $this->load->library('lead/lead_library');
        $this->load->model('lead/leads_model');
        $this->load->library('main_library', null, 'main_lib');
        $this->users_library->check_login();
        $this->users_library->check_permission($this->session->role, 'LM_MANAGE', true);
        $this->data['baseConfig'] = array(
            'pageTitle' => 'Lead Manage',
        );
        $this->data['csrf'] = $this->csrf;
    }

    public function index()
    {
        $this->data['baseConfig']['subTitle'] = '';
        $this->layout_library
            ->setTitle('Lead Manage')
            ->setJavascript($this->config->item('assets') . 'bower_components/moment/min/moment.min.js')
            ->setJavascript($this->config->item('assets') . 'bower_components/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')
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
            ->setJavascript($this->config->item('assets') . 'pages/leads/leadsManage.js')
            ->view('leadManage', $this->data);
    }

    public function expiredLead()
    {
        $this->data['baseConfig']['subTitle'] = '';
        $this->data['baseConfig']['pageTitle'] = 'Expired Lead';
        $this->layout_library
            ->setTitle('Expired Lead')
            ->setJavascript($this->config->item('assets') . 'bower_components/moment/min/moment.min.js')
            ->setJavascript($this->config->item('assets') . 'bower_components/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')
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
            ->setJavascript($this->config->item('assets') . 'pages/leads/expiredLead.js')
            ->view('expiredLead', $this->data);
    }

    public function getDataExpireDate()
    {
        $data = $this->leads_model->getDataExpireDate();
        echo $this->main_lib->responeJson('success', $data);
    }

    public function reAllowcation()
    {
        $limit_allowcate = intval($this->input->post('limitLeadList'));
        $expireDate = $this->input->post('expiredDate');
        // $setAssignedToIsNullforAllowcate = $this->leads_model->setAssignedToIsNullforAllowcate($limit_allowcate);
        // if ($setAssignedToIsNullforAllowcate) {
        $leads = $this->leads_model->getLeadNew();
        $getAgent = $this->leads_model->getAgent('crm_users');
        $agent = array();
        foreach ($getAgent as $key => $value) {
            $agent[]['agnet'] = $getAgent[$key]['id'];
        }
        $index = 0;
        if ($leads > 0) {
            for ($i = 0; $i < $limit_allowcate; $i++) {
                $this->leads_model->allocationLead(null, $agent[$index]['agnet'], $expireDate, 1);
                $index++;
                if ($index >= sizeof($agent)) {
                    $index = 0;
                }
            }
            echo $this->main_lib->responeJson('success', "Allocation Success");
        } else {
            echo $this->main_lib->responeJson('error', "ไม่มีรายการ Lead New");
        }

        // } else {
        //     echo $this->main_lib->responeJson('error', 'Reallowcate Fail');
        // }
    }

    public function phoneBlockList()
    {
        $this->data['baseConfig']['subTitle'] = 'List';
        $this->data['baseConfig']['pageTitle'] = 'Phone Block List';
        $this->layout_library
            ->setTitle('Phone Block List')
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
    
            ->setJavascript($this->config->item('assets') . 'plugins/input-mask/jquery.inputmask.js')
            ->setJavascript($this->config->item('assets') . 'plugins/input-mask/jquery.inputmask.date.extensions.js')
            ->setJavascript($this->config->item('assets') . 'plugins/input-mask/jquery.inputmask.extensions.js')

            ->setJavascript($this->config->item('assets') . 'pages/leads/phoneBlockList.js')
            ->view('phoneBlockList', $this->data);
    }

    public function getDataPhoneBlockList()
    {
        $res = $this->leads_model->getPhoneBlockList();
        echo $this->main_lib->responeJson('success', $res);
    }

    public function postPhoneBlockList()
    {
        $this->form_validation->set_rules('phoneNumber', 'phoneNumber', 'trim|required');
        $status = 'success';
        
        if ($this->form_validation->run() === true) {
            $data['phoneNumber'] = $this->input->post('phoneNumber');
            $action = $this->input->post('action');
            $checkDup = $this->leads_model->getPhoneBlockList($data['phoneNumber']);
            if(!empty($checkDup)) {
                echo $this->main_lib->responeJson('warning', 'Duplicate Phone Number');
                exit();
            } 
            switch ($action) {
                case 'insert':
                    $res = $this->leads_model->insertPhoneBlock($data);
                    if(empty($res)) {
                        $status = 'error';
                        $res = "Query Error: $res";
                    } else {
                        $res = 'Insert Successfully!';
                    }
                    break;
                case 'update':
                    $id = $this->input->post('id');
                    $res = $this->leads_model->updatePhoneBlock($id, $data);
                    if($res) {
                        $res = 'Update Successfully!';
                    } else {
                        $status = 'error';
                        $res = "Query Error: $res";
                    }
                    break;
                default:
                    break;
            }
    
            echo $this->main_lib->responeJson($status , $res);
        } else {
            echo $this->main_lib->responeJson('warning', 'required field');
        }
    }

    public function deletePhoneBlockList()
    {
        $this->form_validation->set_rules('id', 'id', 'trim|required');
        if ($this->form_validation->run() === true) {
            $id = $this->input->post('id');
            $res = $this->leads_model->deletePhoneBlockList($id);
            if($res) {
                echo $this->main_lib->responeJson('success', 'Delete Successfully!');
            } else {
                echo $this->main_lib->responeJson('warning', "Query Error: $res");
            }
        } else {
            echo $this->main_lib->responeJson('warning', 'required field');
        }
    }

    public function editPhoneBlockList($id, $data)
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

    public function getTableNotAllocate()
    {
        $data = array();
        $data = $this->lead_library->getDataNotAllocate($this->input->post());
        if (isset($data)) {
            $data['status'] = "SUCCESS";
            echo json_encode($data);
        } else {
            $data['status'] = "Fail";
            echo json_encode($data);
        }

    }

    public function transferToAgent()
    {

        $this->form_validation->set_rules('src', 'From', 'trim|required');
        $this->form_validation->set_rules('des', 'To', 'trim|required');

        if ($this->form_validation->run() === true) {
            //XSS(Cross-site scripting) filter
            $data = array();
            $data = $this->input->post(null, true);
            foreach ($data as $key => $value) {
                $data[$key] = str_replace("[removed]", "", $value);
            }
            $getDataSrc = $this->leads_model->getDataSrc($data['src'], $data['resultCall'], 'lead_lists');
            $getAgent = $this->leads_model->getAgent('crm_users');
            $agent = explode(",", $data['des']);
            $index = 0;
            if (sizeof($getDataSrc) > 0) {
                for ($i = 0; $i < sizeof($getDataSrc); $i++) {
                    $this->leads_model->transferLeads($getDataSrc[$i]['assignedTo'], $agent[$index]);
                    $index++;
                    if ($index >= sizeof($agent)) {
                        $index = 0;
                    }
                }
                echo $this->main_lib->responeJson('success', "Transfer Success");
            } else {
                echo $this->main_lib->responeJson('error', "Agent นี้ไม่มี leads หรือ Call Result Status นี้");
            }
        } else {
            echo $this->main_lib->responeJson('error', validation_errors());
        }
    }

    public function allocate()
    {
        $leads = $this->leads_model->getLeadNew();
        $getAgent = $this->leads_model->getAgent('crm_users');
        $agent = array();
        $limit_allowcate = intval($this->input->post('limitLeadList'));
        $expireDate = $this->input->post('expiredDate');
        foreach ($getAgent as $key => $value) {
            $agent[]['agnet'] = $getAgent[$key]['id'];
        }
        $index = 0;
        if ($leads > 0) {
            for ($i = 0; $i < $limit_allowcate; $i++) {
                $this->leads_model->allocationLead(null, $agent[$index]['agnet'], $expireDate);
                $index++;
                if ($index >= sizeof($agent)) {
                    $index = 0;
                }
            }
            echo $this->main_lib->responeJson('success', "Allocation Success");
        } else {
            echo $this->main_lib->responeJson('error', "ไม่มีรายการ Lead New");
        }


    }

    public function deleteLead()
    {
        $this->form_validation->set_rules('id', 'id', 'trim|required');

        if ($this->form_validation->run() === true) {

            $id = $this->input->post('id');
            $table_name = "lead_lists";
            $hasQuery = $this->leads_model->delete($id, $table_name);

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