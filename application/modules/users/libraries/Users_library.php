<?php

class Users_library
{
    public $CI;
    public $method;
    public $class;
    public $res_status;
    public $res_message;
    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->model('users/users_model');
        $this->class = strtolower($this->CI->router->fetch_class());
        $this->method = strtolower($this->CI->router->fetch_method());
        $this->CI->load->library('main_library', null, 'main_lib');
    }

    public function login($username, $password, $remember = false)
    {
        $resp = array();
        if (empty($username) && empty($password)) {
            return $this->CI->main_lib->respone('error', 'กรุณาใส่ข้อมูลให้ครบ');
        }

        $users = $this->CI->users_model->find_users_by_user($username);

        if ($users) {
            if ($this->hash_password($password, $users->salt) != $users->password) {
                return $this->CI->main_lib->respone('error', 'รหัสผ่านของท่านผิด');
            }

            $set_session = array(
                'UID' => $users->id,
                'firstname' => $users->firstname,
                'lastname' => $users->lastname,
                'role' => $users->role,
                'name' => $users->firstname . ' ' . $users->lastname,
            );

            $this->CI->session->set_userdata($set_session);

            //Update last login
            $hasUpdate = $this->CI->users_model->update_last_login($users->id, 'LoginPage');

            if ($hasUpdate) {
                return $this->CI->main_lib->respone('success', 'ยืนยันตัวตนถูกต้อง');
            } else {
                return $this->CI->main_lib->respone('error', 'รหัสผ่านของท่านผิด');
            }

        } else {
            return $this->CI->main_lib->respone('error', 'ไม่พบข้อมูลของท่าน');
        }
    }

    public function salt()
    {
        $raw_salt_len = 16;
        $buffer = '';

        $bl = strlen($buffer);
        for ($i = 0; $i < $raw_salt_len; $i++) {
            if ($i < $bl) {
                $buffer[$i] = $buffer[$i] ^ chr(mt_rand(0, 255));
            } else {
                $buffer .= chr(mt_rand(0, 255));
            }
        }

        $salt = $buffer;

        $base64_digits = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
        $bcrypt64_digits = './ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $base64_string = base64_encode($salt);
        $salt = strtr(rtrim($base64_string, '='), $base64_digits, $bcrypt64_digits);

        return substr($salt, 0, 31);

    }

    public function get_roles()
    {
        $query = $this->CI->db
            ->order_by('id desc')
            ->get('crm_roles');
        return json_decode(json_encode($query->result()), true);
    }

    public function hash_password($password, $salt)
    {
        if (empty($password)) {
            return false;
        }

        return sha1($password . $salt);
    }

    public function is_logged_in()
    {
        return (bool) $this->CI->session->userdata('UID');
    }

    public function is_permission($role_list = array())
    {
        $role = $this->CI->session->role;
        if (!in_array($role, $role_list)) {
            redirect('error/404');
        }
    }

    public function _is_permission($role_list = array())
    {
        $role = $this->CI->session->role;
        if (!in_array($role, $role_list)) {
            return false;
        }
        return true;
    }

    public function check_login()
    {
        if ($this->is_logged_in()) {
            if (($this->class == 'users' && $this->method == 'login')) {
                redirect(base_url('lead/loadLead'), 'refresh');
            }
        } else {
            if (!($this->class == 'users') && !($this->method == 'login')) {
                redirect(base_url('login'), 'refresh');
            } 
        }
    }

    public function check_permission($role_id = null, $permission_code = null, $redirectTo404 = false)
    {
        if ($role_id != null && $permission_code != null) {
            if (!is_array($permission_code)) {
                $permission_code = array($permission_code);
            } 
            $query = $this->CI->db->where_in('permission_code', $permission_code)->get('permissions');
            $permission_arr = $query->result_array();
            if (count($permission_arr) > 0) {
                $permission_id = $permission_arr[0]['id'];
                $query_ = $this->CI->db
                    ->from('role_permission')
                    ->where('role_id', $role_id)
                    ->where('permission_id', $permission_id)
                    ->get();
                $role_permission = $query_->result_array();
                if (count($role_permission) > 0) {
                    return true;
                }
            }
        }
        if($redirectTo404)
            redirect(base_url('404'), 'refresh');
        else
            return false;
    }


}
