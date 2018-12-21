<?php

class LoadLead extends MY_Controller
{
    public $data;
    public function __construct()
    {
        parent::__construct();
        $this->load->library('users/users_library');
        $this->load->model('lead/leads_model');
        $this->load->library('main_library', null, 'main_lib');
        $this->users_library->check_login();
        $this->users_library->check_permission($this->session->role, 'LM_LOAD', true);
        $this->data['baseConfig'] = array(
            'pageTitle' => 'Load Lead',
        );
        $this->data['csrf'] = $this->csrf;
    }

    public function index()
    {
        $this->data['baseConfig']['subTitle'] = 'View';
        $this->data['channels'] = $this->leads_model->getDataDropdrow('lead_channels');
        $this->data['leadTypes'] = $this->leads_model->getDataDropdrow('lead_types');
        $this->data['campaigns'] = $this->leads_model->getDataDropdrow('lead_campaigns');
        $this->layout_library
            ->setTitle('Load Lead')
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

            ->setJavascript($this->config->item('assets') . 'bower_components/moment/min/moment.min.js')

            ->setJavascript($this->config->item('assets') . 'pages/leads/loadleadResult.js')
            ->setJavascript($this->config->item('assets') . 'pages/leads/loadlead.js')
            ->view('loadLead', $this->data);
    }

    public function lead_submit()
    {
        $this->load->library('upload/upload_library');
        $this->form_validation->set_rules('campaign', 'campaign', 'trim|required');
        $this->form_validation->set_rules('leadType', 'LeadType', 'trim|required');
        $this->form_validation->set_rules('fileName', 'FileName', 'trim|required');
        $this->form_validation->set_rules('channel', 'channel', 'trim|required');

        if ($this->form_validation->run() === true) {

            //XSS(Cross-site scripting) filter
            $data = array();
            $data = $this->input->post(null, true);
            foreach ($data as $key => $value) {
                $data[$key] = str_replace("[removed]", "", $value);
            }
            $fileName = $this->input->post('fileName');
            $CSVFileData =  $this->upload_library->readFile($fileName);
            if($CSVFileData['leadStatus']) {
                $telAllList = $this->leads_model->getTelAll();
                $phoneBlockList = $this->leads_model->getphoneBlockListArr();
                
                //Initial
                $count = 0;
                $query = false;
                $dupTel = array();
                $isDupTel = false;
                $status = 'success';
                $response = array();
                $phoneInBlockList  = array();

                foreach ($CSVFileData['rows'] as $key => $item) {
                    //Condition Insert--------
                    //Check duplication tel1
                    $count ++;
                    if( in_array($item['tel1'], $telAllList) ) {
                        $dupItem['no'] = $item['no'];
                        $dupItem['name'] = $item['firstname'] . ' ' . $item['lastname'];
                        $dupItem['tel1'] = $item['tel1'];
                        $dupTel[] = $dupItem;
                        $isDupTel = true;
                        continue;
                    } elseif( in_array($item['tel1'], $phoneBlockList)  ) {
                        $blockListTemp['no'] = $item['no'];
                        $blockListTemp['name'] = $item['firstname'].' '.$item['lastname'];
                        $blockListTemp['tel1'] = $item['tel1'];
                        $phoneInBlockList[] = $blockListTemp;
                        continue;
                    } 
                    unset($item['leadStatus']);
                    unset($item['no']);
                    $item['campaignId'] = $data['campaign'];
                    $item['leadTypeId'] = $data['leadType'];
                    $item['channelId'] = $data['channel'];
                    $item['birthday'] = self::convertDate($item['birthday']);
                    $query = $this->leads_model->insert($item);
                }

                $result['duplicateTelList'] = $dupTel;
                $result['phoneBlockList'] = $phoneInBlockList;
                $result['successNum'] =  $count - count($dupTel) - count($phoneInBlockList);
                $result['totalNum'] =  $count;
                $result['duplicateTelNum'] =  count($dupTel);
                $result['phoneBlockListNum'] =  count($phoneInBlockList);
                echo $this->main_lib->responeJson($status,  $result);

            } else {
                echo $this->main_lib->responeJson('warning', "data is empty! can't load CSV ile", $CSVFileData);
            }
        } else {
            echo $this->main_lib->responeJson('error', validation_errors());
        }
    }

    public static function convertDate($date = '')
    {
        if ($date != '') {
            $temp = explode("/", $date);
            $date = ($temp[2]) . '-' . $temp[1] . '-' . $temp[0];
        }
        return $date;
    }
}