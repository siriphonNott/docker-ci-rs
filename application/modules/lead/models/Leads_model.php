<?php
class Leads_model extends CI_Model
{
    public $table_name;
    public function __construct()
    {
        $this->table_name = 'lead_lists';
    }

    public function getAll($table)
    {
        $query = $this->db->get($table);
        return $query->result_array();
    }

    public function getLeadNew()
    {
        $where = array('assignedTo' => null, 'used' => '1');
        $this->db->where($where);
        $query = $this->db->get($this->table_name);
        return $query->result_array();
    }

    public function getTelAll()
    {
        $query = $this->db->select('tel1')->get($this->table_name);
        $telList = array();
        foreach ($query->result_array() as $key => $value) {
            $telList[] = $value['tel1'];
        }
        return $telList;
    }

    public function getAgent($table)
    {
        $where = array('role' => '3', 'used' => '1');
        $this->db->select('id, firstname, lastname');
        $this->db->where($where);
        $query = $this->db->get($table);
        return $query->result_array();
    }

    public function getDataSrc($src, $callResult, $table)
    {
        $this->db->where_in('assignedTo', $src);
        if ($callResult > 0) {
            $this->db->where_in('callResult', $callResult);
        }
        $query = $this->db->get($table);
        return $query->result_array();

    }

    public function transferLeads($src, $des)
    {
        $data = array(
            'assignedTo' => $des
        );
        $this->db->where('assignedTo', $src);
        $this->db->order_by('createdAt', 'DESC');
        $this->db->limit(1);
        $query = $this->db->update($this->table_name, $data);
        try {
            return $query;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function allocationLead($src, $des, $expiredDate, $type = 0)
    {
        $dateTime = new DateTime();
        $data = array(
            'assignedTo' => $des,
            'allocateDate' => $dateTime->format('Y-m-d H:i:s'),
            'expiredDate' => $expiredDate
        );
        if ($type === 0) {
            $this->db->where(array('assignedTo' => $src, 'used' => '1'));
        } else {
            $where = "expiredDate < DATE(now()) AND used = '1' AND (callResult in ('1','2','110', '120', '130', '140', '150', '160', '170', '180', '190') or callResult is null) AND assignedTo is not null";
            $this->db->where($where);
        }
        $this->db->order_by('createdAt', 'DESC');
        $this->db->limit(1);
        $query = $this->db->update($this->table_name, $data);
        try {
            return $query;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    public function getLeadById($id)
    {
        $sql = array('l.id' => $id, 'l.used' => '1');
        $this->db->select('l.*,u.username as ext');
        $this->db->from($this->table_name . ' l');
        $this->db->join('crm_users u', 'l.assignedTo = u.id', 'left');
        $this->db->where($sql);
        $query = $this->db->get();
        try {
            return $query->row();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getDataDropdrow($table, $where = null)
    {
        if (!empty($where)) {
            $this->db->where($where);
        }
        $query = $this->db->get($table);
        return $query->result_array();
    }

    public function uploadLog($data)
    {
        $this->db->insert('lead_upload_files_log', $data);
        try {
            return $this->db->insert_id();
        } catch (Exception $e) {
            return $e->getMessage();
        }
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

    public function delete($id, $table_name)
    {
        $this->db->set('used', '0');
        $this->db->where('id', $id);
        try {
            return $this->db->update($table_name);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getAgentLeads()
    {
        $this->db->select('l.*, concat(u.firstname, " ",u.lastname) AS agent_name, a.label, t.label, s.label');
        $this->db->from('lead_lists l');
        $this->db->join('crm_users u', 'u.id = l.assignedTo', 'left');
        $this->db->join('lead_campaigns a', 'a.id = l.campaignId', 'left');
        $this->db->join('lead_types t', 't.id = l.leadTypeId', 'left');
        $this->db->join('lead_channels s', 's.id = l.sourceId', 'left');
        $this->db->where('l.used = "1"');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function searchData($dateFrom, $dateTo, $params)
    {
        $this->db->select('l.*')
            ->from('lead_lists l')
            ->where(' DATE(l.allocateDate) >= ', $dateFrom)
            ->where(' DATE(l.allocateDate) <= ', $dateTo)
            ->where($params);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getTableView($id, $role)
    {
        $where = " l.used = '1' AND expiredDate >= DATE(now()) ";
        $isPermission = (in_array($role, array('1', '2'))) ? 1 : 0;

        $this->db->from($this->table_name . ' l');
        $this->db->select("l.*, $isPermission as isDelete,cr.name as callResultName, cp.label as campaignName, u.username as ext");

        if (!$isPermission) {
            $where .= " AND (l.callResult in ('110', '120', '130', '140', '150', '160', '170', '180', '190') or l.callResult is null) AND l.assignedTo = $id AND ( l.followDate is null ) ";
        }
        $this->db->join('lead_call_result cr', 'cr.id = l.callResult', 'left');
        $this->db->join('lead_campaigns cp', 'cp.id = l.campaignId', 'left');
        $this->db->join('crm_users u', 'l.assignedTo = u.id', 'left');
        $this->db->where($where);
        $this->db->order_by('l.followDate', "DESC");
        // $this->db->order_by("l.callResult", "ASC");
        $query = $this->db->get();
        try {
            return $query->result_array();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getListLeadFromFollowDate($id)
    {
        $where = "l.assignedTo = $id AND l.used = '1' AND (l.followDate is not null or l.followDate != '0000-00-00 00:00:00') AND l.callResult in ('110', '120', '130', '140', '150', '160', '170', '180', '190')";
        $this->db->select("l.*, cr.name as callResultName, cp.label as campaignName, u.username as ext");
        $this->db->from($this->table_name . ' l');
        $this->db->join('lead_call_result cr', 'cr.id = l.callResult', 'left');
        $this->db->join('lead_campaigns cp', 'cp.id = l.campaignId', 'left');
        $this->db->join('crm_users u', 'l.assignedTo = u.id', 'left');
        $this->db->where($where);
        $this->db->order_by("l.followDate", "DESC");
        $query = $this->db->get();
        try {
            return $query->result_array();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getDataDashBoard($agentId)
    {
        $year = date("Y");
        $month = date("m");
        $where = array('used' => '1', 'assignedTo' => $agentId, 'YEAR(allocateDate)' => $year, 'MONTH(allocateDate)' => $month, 'expiredDate >=' => 'DATE(now())');
        $this->db->select("COUNT(id) AS totalLead,
        SUM(CASE WHEN callResult is null THEN 1 ELSE 0 END) AS totalOpen,
        SUM(CASE WHEN callResult in ('1','2') THEN 1 ELSE 0 END) AS totalSuccess,
        SUM(CASE WHEN callResult in ('110', '120', '130','140','150','160','170','180','190') THEN 1 ELSE 0 END) AS totalFollow,
        SUM(CASE WHEN callResult in ('210','220','230','240','250','260','270','280','290','300','310','320','410','420') THEN 1 ELSE 0 END) AS totalDrop,
        SUM(CASE WHEN callResult in ('430','440','450') THEN 1 ELSE 0 END) AS totalCouldNotReach");
        $this->db->where($where);
        $query = $this->db->get($this->table_name);
        try {
            return $query->row();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateLeads($id, $data)
    {
        $this->db->where('id', $id);
        $query = $this->db->update($this->table_name, $data);
        try {
            return $query;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    //------- Block List --------
    public function getphoneBlockListArr($phoneNumber = '') {
        $query = $this->db->select('phoneNumber')->get('lead_phone_blocklist');
        $phoneBlockList = array();
        foreach ($query->result_array() as $key => $value) {
            $phoneBlockList[] = $value['phoneNumber'];
        }
        return $phoneBlockList;
    }

    public function getPhoneBlockList($phoneNumber = '')
    {
        if(!empty($phoneNumber)) {
            $this->db->where('phoneNumber', $phoneNumber);
        }
        $query = $this->db->get('lead_phone_blocklist');
        return $query->result_array();
    }

    public function insertPhoneBlock($data)
    {
        $this->db->insert('lead_phone_blocklist', $data);
        try {
            return $this->db->insert_id();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function updatePhoneBlock($id, $data)
    {
        $this->db->where('id', $id);
        $query = $this->db->update('lead_phone_blocklist', $data);
        try {
            return $query;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // ---------- leads Expire ----------------
    public function getDataExpireDate()
    {
        $where = "l.expiredDate < DATE(now()) AND l.used = '1' AND (l.callResult in ('1','2','110', '120', '130', '140', '150', '160', '170', '180', '190') or l.callResult is null) AND l.assignedTo is not null";
        $this->db->select("l.*, cr.name as callResultName");
        $this->db->from($this->table_name . ' l');
        $this->db->join('lead_call_result cr', 'cr.id = l.callResult', 'left');
        $this->db->where($where);
        $query = $this->db->get();
        try {
            return $query->result_array();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function setAssignedToIsNullforAllowcate($limitLead)
    {
        $data = array(
            'expiredDate' => null,
        );
        $where = "expiredDate < DATE(now()) AND used = '1' AND (callResult in ('1','2','110', '120', '130', '140', '150', '160', '170', '180', '190') or callResult is null) AND assignedTo is not null";
        $this->db->where($where);
        $this->db->limit($limitLead);
        $query = $this->db->update($this->table_name, $data);
        try {
            return $query;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getLeadExpire()
    {
        $where = "expiredDate < DATE(now()) AND used = '1' AND (callResult in ('1','2','110', '120', '130', '140', '150', '160', '170', '180', '190') or callResult is null) AND assignedTo is not null";
        $this->db->where($where);
        $query = $this->db->get($this->table_name);
        return $query->result_array();

    }


    public function deletePhoneBlockList($id)
    {
        $this->db->where('id', $id);
        try {
            return $this->db->delete('lead_phone_blocklist');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getPhoneListById($id)
    {
        $query = $this->db->select('*')
            ->from('lead_phone_blocklist')
            ->where('id', $id)
            ->get();
        return json_decode(json_encode($query->row()), true);
    }

    //Historical Call
    public function insertHistoricalCall($data)
    {
        $this->db->insert('lead_historical_calls', $data);
        try {
            return $this->db->insert_id();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getHistoricalCall($data = array())
    {
        //data ['userId' => '', 'leadId' => '']
        if(!empty($data)) {
            $this->db->where($data);
        }
        $query = $this->db->get('lead_historical_calls');
        return $query->result_array();
    }


}