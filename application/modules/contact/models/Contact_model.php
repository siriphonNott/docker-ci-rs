<?php
class Contact_model extends CI_Model
{public $table_name;
    public function __construct()
    {
        $this->table_name = 'crm_contacts';
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
        $this->db->set('used', '0');
        $this->db->where('id', $id);
        return $this->db->update($this->table_name);
    }

    public function find_contact_by_tel($tel)
    {
        try {
            $sql = array('tel1' => $tel, 'used' => '1');
            $query = $this->db->where($sql)->get($this->table_name);
            return $query->row();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function find_contact_by_check_tel($tel)
    {
        try {
            $where = " (tel1 LIKE '$tel%' OR tel2 LIKE '$tel%')";
            $query = $this->db
                ->where($where)
                ->where('used', '1')
                ->get($this->table_name);
            // return $this->db->last_query();
            return $query->result();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function find_contact_by_id($id)
    {
        $sql = array('id' => $id, 'used' => '1');
        $query = $this->db->where($sql)->get($this->table_name);
        return $query->row();
    }

    public function getAll()
    {
        $query = $this->db->where('used', '1')->get($this->table_name);
        return $query;
    }

    public function paginate()
    {
        $query = $this->db
            ->order_by("id desc")
            ->get($this->table_name);
        return $query->result();
    }

}
