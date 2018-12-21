<?php

class Upload_library
{
    public $CI;
    public static $pathLeadFile;
    public function __construct()
    {
        $this->CI = &get_instance();
        self::$pathLeadFile = FCPATH."public/uploads/";
        $this->CI->load->model('lead/leads_model');
    }

    public function readFile($fileName)
    {
        $pathFile = self::$pathLeadFile.$fileName;
        
        //Initail
        $rows = array();
        $leadInvalid = array();
        $phoneInBlockList  = array();
        $dupTel = array();
        $isValid = true;
        
        //Open the file.
        if (($fileHandle = fopen($pathFile, "r")) !== FALSE) {
            // Loop through the CSV rows.
            $count = 0;
            $telAllList = $this->CI->leads_model->getTelAll();
            $phoneBlockList = $this->CI->leads_model->getphoneBlockListArr();
            while (($row = fgetcsv($fileHandle, 0, ",")) !== FALSE) {
                //Check Lead Template
                if(count($row) != 10) {
                    $isValid = false;
                    $res['errorMessage'] = "CSV file is incorrect format. Please check number of column.";
                    break;
                }
                if(($count==0)){
                    $count++;
                    continue;
                }
                $item = array();
                $item['tel1'] = $row[6];
                $item['no'] = $count++;
                $item['title'] = $row[0];
                $item['firstname'] = $row[1];
                $item['lastname'] = $row[2];
                $item['birthday'] = $row[3];
                $item['email1'] = $row[4];
                $item['email2'] = $row[5];
                $item['tel1'] = $row[6];
                $item['tel2'] = $row[7];
                $item['tel3'] = $row[8];
                $item['address'] = $row[9];
                $item['leadStatus'] = true;
                
                //Check required field
                if($item['tel1'] == '') {
                    $isValid = false;
                    $item['leadStatus'] = false;
                    $leadInvalid[] = $item['no'];
                }
                //Check phone block list
                if( in_array($item['tel1'], $phoneBlockList)  ) {
                    $blockListTemp['no'] = $item['no'];
                    $blockListTemp['name'] = $item['firstname'].' '.$item['lastname'];
                    $blockListTemp['tel1'] = $item['tel1'];
                    $phoneInBlockList[] = $blockListTemp;
                } else if( in_array($item['tel1'], $telAllList) ) { 
                    $dupItem['no'] = $item['no'];
                    $dupItem['name'] = $item['firstname'].' '.$item['lastname'];
                    $dupItem['tel1'] = $item['tel1'];
                    $dupTel[] = $dupItem;
                }
                $rows[] = $item;
            }
        } else {
            $isValid = false;
            $res['errorMessage'] = "can't open csv file.";
        }

        //Upload Log
        $_data['userId'] = $this->CI->session->UID;
        $_data['fileName'] = $fileName;
        $this->CI->leads_model->uploadLog($_data);
        //----------

        $res['fileName'] = $fileName;
        // $res['pathFile'] = $pathFile;
        $count--;
        $res['rows'] = $rows;
        $res['duplicateTelList'] = $dupTel;
        $res['phoneBlockList'] = $phoneInBlockList;
        $res['successNum'] =  $count - count($dupTel) - count($phoneInBlockList);
        $res['totalNum'] =  $count;
        $res['duplicateTelNum'] =  count($dupTel);
        $res['phoneBlockListNum'] =  count($phoneInBlockList);
        if(count($leadInvalid) > 0) {
            $res['errorMessage'] = "Require field must not empty!";
            $res['leadInvalid'] = $leadInvalid;
        }
        $res['leadStatus'] = $isValid;
        return $res;
    }


}
