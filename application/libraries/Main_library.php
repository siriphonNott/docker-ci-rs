<?php
class Main_library
{
    protected $csrf;
    public function __construct()
    {
        $this->CI = &get_instance();
        $this->csrf = array(
            'name' => $this->CI->security->get_csrf_token_name(),
            'hash' => $this->CI->security->get_csrf_hash(),
        );
    }
    
    public function respone($status, $message = '')
    {
        return (array('status' => $status, 'message' => $message));
    }

    public function responeJson($status, $message = '', $debug = null)
    {
        $data['status'] = $status;
        if($status === 'success') {
            $data['message'] = $message;
        } else {
            $data['errorMessage'] = $message;
        }
        $data['csrf'] = $this->csrf;
        if (!empty($debug)) {
            $data['debug'] = $debug;
        }
        return json_encode($data);
    }

    public function token()
    {
        $token = md5(uniqid(rand(), true));
        $this->CI->session->set_userdata('token', $token);
        return $token;
    }

    public function array_to_kv($array)
    {
        $result = array();
        $data = $array;
        if ((gettype($array) !== 'object') && (gettype($array) !== 'array')) {
            return null;
        } elseif (gettype($array) === 'object') {
            $data = json_decode(json_encode($array), true);
        }

        foreach ($data as $key => $value) {
          $result[$value['id']] = $value['name'];
        }
        return $result;
    }

    public function converDate($date = '')
    {
        if($date == '') {
            return '';
        } else {
            $tmp = explode('/',$date);
            return $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
        }
    }
}
