<?php
class Manage_model extends CI_Model
{   
    public $qstat;
    public $table_name;
    public function __construct()
    {
        $this->qstat = $this->load->database('qstats', TRUE);
    }

    // ----------------------- Role Management ----------------------------
    public function addRolePermission($data)
    {
        $res = $this->db->insert('role_permission', $data);
        try {
            // return $this->db->insert_id();
            return $res;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function removeRolePermission($data)
    {
        $this->db->where($data);
        return $this->db->delete('role_permission');
    }

    public function getPermissionList()
    {
        $query = $this->db->select('id,permission_code, label')->get('permissions');
        $arr = array();
        foreach ($query->result_array() as $key => $value) {
            $tmp['label'] = $value['label'];
            $tmp['id'] = $value['id'];
            $arr[$value['permission_code']] = $tmp;
        }
        return $arr;
    }

    public function getRoleList()
    {
        $query = $this->db->get('crm_roles');
        $arr = array();
        foreach ($query->result_array() as $key => $value) {
            $arr[$value['id']] = $value['name'];
        }
        return $arr;
    }

    public function getRolePermission()
    {
        $query = $this->db->from('role_permission rp')
        ->join('crm_roles r', 'r.id = rp.role_id' , 'left')
        ->join('permissions p', 'p.id = rp.permission_id' , 'left')
        ->get();
     
        $result =  $query->result_array();
        $permission = array();
        foreach ($result as $key => $value) {
             $role_id =  $value['role_id'];
             $permission_id =  $value['permission_id'];
             $code =  $value['permission_code'];

            if (array_key_exists( $role_id ,$permission)) {
                $permission[$role_id]['permissions'][] = $permission_id;
                $permission[$role_id]['permissions_code'][] = $code;
            } else {
                $permission[$role_id] = array();
                $permission[$role_id]['name'] = $value['name'];
                $permission[$role_id]['permissions'][] = $permission_id;
                $permission[$role_id]['permissions_code'][] = $code;
            }
        }
        return $permission;
    }

    // ----------------------- Master Data Management ----------------------------
    public function getMasterDataLists($data = '')
    {
        if(!empty($data)) {
            $this->db->where($data);
        }
        $query = $this->db->get('masterdata_lists');
        return $query->result_array();
    }
    
    public function getMasterdataManage($tableName = '')
    {
        if(empty($tableName)) return array();
        $query = $this->db->get($tableName);
        return $query->result_array();
    }

    public function getMasterdataManageForChkDup($data = '', $tableName = '')
    {
        if(!empty($data)) {
            $this->db->where($data);
        }
        $query = $this->db->get($tableName);
        return $query->result_array();
    }


    public function insertMasterdataList($data)
    {
        $this->db->insert('masterdata_lists', $data);
        try {
            return $this->db->insert_id();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function insertMasterdataManage($data, $tableName)
    {
        $this->db->insert($tableName, $data);
        try {
            return $this->db->insert_id();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateMasterdataList($id, $data)
    {
        $this->db->where('id', $id);
        $query = $this->db->update('masterdata_lists', $data);
        try {
            return $query;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateMasterdataManage($id, $data, $tableName)
    {
        $this->db->where('id', $id);
        $query = $this->db->update($tableName, $data);
        try {
            return $query;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function deleteMasterdataList($id)
    {
        $this->db->where('id', $id);
        try {
            return $this->db->delete('masterdata_lists');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    
    }

    public function deleteMasterdataManage($id, $tableName)
    {   
        $this->db->where('id', $id);
        try {
            return $this->db->delete($tableName);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    // ----------------------- /Role Management ----------------------------

    // ----------------------- Agent Management ----------------------------
    public function getAgentdata()
    {
        $query = $this->qstat->get('cc_user_info');
        return $query->result_array();
    }

    public function getAgentdataForChkDup($data = '')
    {
        if(!empty($data)) {
            $this->qstat->where($data);
        }
        $query = $this->qstat->get('cc_user_info');
        return $query->result_array();
    }

    public function insertAgentManage($data)
    {   
        unset($data['idBeforeEdit']);
        unset($data['action']);
        $this->qstat->insert('cc_user_info', $data);
        try {
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateAgentdata($id, $data)
    {
        unset($data['idBeforeEdit']);
        unset($data['action']);
        $this->qstat->where('user_id', $id);
        $query = $this->qstat->update('cc_user_info', $data);
        try {
            return $query;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function deleteAgentdata($id)
    {   
        $this->qstat->where('user_id', $id);
        try {
            return $this->qstat->delete('cc_user_info');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    
    }

    /*public function find_users_by_id($id)
    {
        $query = $this->qstat->where('user_id', $id)->get('cc_user_info');
        return $query->row();
    }

    public function insert($data)
    {
        $res = $this->qstat->insert('cc_user_info', $data);
        try {
            return $res;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function update($id, $data)
    {
        $this->qstat->where('user_id', $id);
        if($data['userPosition'] == '' || $data['userPosition'] == null){
            unset($data['userPosition']);
        }
        return $this->qstat->update('cc_user_info', $data);
    }

    public function delete($id)
    {
        $this->qstat->where('user_id', $id);
        return $this->qstat->delete('cc_user_info');
    }*/


}


