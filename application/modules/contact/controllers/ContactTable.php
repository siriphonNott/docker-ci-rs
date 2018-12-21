<?php
defined('BASEPATH') || exit('No direct script access allowed');
class ContactTable extends MY_Controller
{
    public $CI;
    public function __construct()
    {
        parent::__construct();
        $this->CI = &get_instance();
    }

    public function getDataTable()
    {
        $params = "";
        $columns = "";
        $totalRecords = "";
        $data = array();

        $params = $_REQUEST;

        // Define Colums
        $columns = array(
            0 => 'id',
            1 => 'firstname',
            2 => 'lastname',
            3 => 'email',
            4 => 'fax',
            5 => 'tel1',
            6 => 'tel2',
            7 => 'company',
            8 => 'position',
            9 => 'province',
        );

        $where = "";
        if (!empty($params['search']['value'])) {
            $where .= " used = '1' AND ";
            $where .= " (firstname LIKE '%" . $params['search']['value'] . "%' ";
            $where .= " OR lastname LIKE '%" . $params['search']['value'] . "%'  ";
            $where .= " OR tel1 LIKE '%" . $params['search']['value'] . "%'  ";
            $where .= " OR tel2 LIKE '%" . $params['search']['value'] . "%')  ";
            
        }

        if (!empty($where)) {
            $this->CI->db->where($where);
        }

        $query = $this->CI->db->select("id,firstname,lastname,email,fax,tel1,tel2,company,position,province")
            ->where('used', '1')
            ->order_by($columns[$params['order'][0]['column']], $params['order'][0]['dir'])
            ->limit($params['length'], $params['start'])
            ->get('crm_contacts');

        $this->CI->db->select('count(id) as total')->where('used','1');
        $this->CI->db->from('crm_contacts');
        if (!empty($where)) {
            $this->CI->db->where($where);
        }
        $queryTotal = $this->CI->db->get();

        $row = $queryTotal->row_array();
        $totalFiltered = $row['total'];

        $result = $query->result_array();
        $results = array();
        $count = $params['start'] + 1;
        foreach ($result as $key => $value) {

            $nestedData = array();
            $nestedData[] = $count;
            $nestedData[] = $value['firstname'];
            $nestedData[] = $value['lastname'];
            $nestedData[] = $value['email'];
            $nestedData[] = $value['fax'];
            $nestedData[] = $value['tel1'];
            $nestedData[] = $value['tel2'];
            $nestedData[] = $value['company'];
            $nestedData[] = $value['position'];
            $nestedData[] = $value['province'];

            $btn = '<a href="' . base_url("contact") . '\edit/' . $value['id'] . '" class="btn btn-warning" style="font-size:9px;padding: 3px 8px;"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
            $btn .= '&nbsp;<a onclick="btnDelete(\'' . $value['id'] . '\')" class="btn btn-danger btn-delete icon-delete" style="font-size:9px;padding: 3px 8px;"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>';
            $nestedData[] = $btn;
            $results[] = $nestedData;
            $count++;
        }

        $data = array(
            'draw' => intval($params['draw']),
            'recordsTotal' => intval($query->num_rows()),
            'recordsFiltered' => intval($totalFiltered),
            'data' => $results,
            'csrf' => $this->csrf,
        );
        echo json_encode($data);
        exit();
    }

}
