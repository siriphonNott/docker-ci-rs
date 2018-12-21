<?php
class Contact_library
{
    public $CI;
    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->model('contact/contact_model');
        $this->CI->load->library('main_library', null, 'main_lib');
    }

    public function insert($data)
    {
        $res = array();
        if (empty($data['firstname']) && empty($data['lastname']) && empty($data['tel1'])) {
            $res['status'] = 'error';
            $res['message'] = 'กรุรณาใส่ข้อมูลให้ครบ';
        } else {
            $id = $this->CI->contact_model->insert($data);
            if ($id) {
                return $this->CI->main_lib->respone('success');
            } else {
                return $this->CI->main_lib->respone('error', $id);
            }
        }
    }

    public function update($id, $data)
    {
        $res = array();
        if (empty($data['firstname']) && empty($data['lastname']) && empty($data['tel1'])) {
            $res['status'] = 'error';
            $res['message'] = 'กรุรณาใส่ข้อมูลให้ครบ';
        } else {
            $id = $this->CI->contact_model->update($id, $data);
            if ($id) {
                return $this->CI->main_lib->respone('success');
            } else {
                return $this->CI->main_lib->respone('error', $id);
            }
        }
    }

    public function delete($id)
    {
        $res = array();
        if (empty($id)) {
            $res['status'] = 'error';
            $res['message'] = 'ไม่พบ id ';
        } else {
            $id = $this->CI->contact_model->delete($id);
            if ($id) {
                return $this->CI->main_lib->respone('success');
            } else {
                return $this->CI->main_lib->respone('error', $id);
            }
        }
    }

    public function paginate()
    {
        return $this->CI->contact_model->paginate();
    }
}
