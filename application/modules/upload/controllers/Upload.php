<?php

class Upload extends MY_Controller {

    public $data;
    public static $pathLeadFile;
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('main_library', null, 'main_lib');
        $this->load->library('upload/upload_library');
        $this->load->model('lead/leads_model');
        $this->data['csrf'] = $this->csrf;
        self::$pathLeadFile = FCPATH."public/uploads/";
    }

    public function index()
    {
        $this->load->view('upload_form', array('error' => ' ' ));
    }

    public function do_upload()
    {
        $config['upload_path']          = self::$pathLeadFile;
        $config['allowed_types']        = 'gif|jpg|png|csv';
        // $config['max_size']             = 100;
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;
        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('fileUpload'))
        {
            $error = array('error' => $this->upload->display_errors());
            echo $this->main_lib->responeJson('error', $error['error']);
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            $fileName = $data['upload_data']['file_name'];
            $response = $this->upload_library->readFile($fileName);
            if($response['leadStatus'] || isset($response['leadInvalid'])) {
                echo $this->main_lib->responeJson('success', $response);
            } else {
                echo $this->main_lib->responeJson('error', $response['errorMessage']);
            }
        }
    }

}
?>