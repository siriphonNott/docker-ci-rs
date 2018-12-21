<?php

class Users_model extends CI_Model
{
    public $table_name;
    public function __construct()
    {
        $this->table_name = 'crm_users';
    }

    public function find_users_by_user($username)
    {
        $query = $this->db->where('username', $username)->get($this->table_name);
        return $query->row();
    }

    public function update_last_login($id, $type)
    {
        $data = array(
            'uid' => $id,
            'login_type' => $type,
        );
        $this->db->insert('crm_login_logs', $data);
        return $this->db->insert_id();
    }

    public function paginate()
    {
        $query = $this->db
            ->order_by("id desc")
            ->get($this->table_name);
        return $query->result();
    }

    public function find_users_by_id($id)
    {
        $query = $this->db->select('u1.*,CONCAT (u2.firstname," ", u2.lastname) as created_by_name ')
            ->from($this->table_name . ' as u1')
            ->where('u1.id', $id)
            ->join($this->table_name . ' as u2', 'u1.id = u2.id', 'LEFT')
            ->get();
        return json_decode(json_encode($query->row()), true);
    }

    public function insert($data)
    {
        $this->db->insert($this->table_name, $data);
        try {
            return $this->db->insert_id();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table_name, $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table_name);
    }
}
