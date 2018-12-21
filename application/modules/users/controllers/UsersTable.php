<?php
defined('BASEPATH') || exit('No direct script access allowed');
class UsersTable extends MY_Controller
{
    public $CI;
    public $table_name;
    public function __construct()
    {
        parent::__construct();
        $this->CI = &get_instance();
        $this->table_name = 'crm_users';
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
            1 => 'username',
            2 => 'password',
            3 => 'firstname',
            4 => 'lastname',
            5 => 'created_at',
            6 => 'created_by',
            7 => 'role',
        );

        $where = "";
        if (!empty($params['search']['value'])) {
            $where .= " firstname LIKE '%" . $params['search']['value'] . "%'  ";
            $where .= " OR lastname LIKE '%" . $params['search']['value'] . "%'  ";
            $where .= " OR tel1 LIKE '%" . $params['search']['value'] . "%'  ";
            $where .= " OR tel2 LIKE '%" . $params['search']['value'] . "%'  ";
        }

        if (!empty($where)) {
            $this->CI->db->where($where);
        }

        $query = $this->CI->db->select(" u1.id,  u1.username,  u1.firstname,  u1.lastname,  u1.created_at,  u1.role, CONCAT (u2.firstname,' ', u2.lastname) as created_by_name, r.name as role_name")
            ->from($this->table_name . ' as u1')
            ->join($this->table_name . ' as u2', 'u1.created_by = u2.id', 'LEFT')
            ->join('crm_roles' . ' as r', 'u1.role = r.id', 'LEFT')
            ->order_by($columns[$params['order'][0]['column']], $params['order'][0]['dir'])
            ->limit($params['length'], $params['start'])
            ->get();

        $this->CI->db->select('count(id) as total');
        $this->CI->db->from($this->table_name);
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
            $nestedData[] = $value['username'];
            $nestedData[] = '****************';
            $nestedData[] = $value['firstname'];
            $nestedData[] = $value['lastname'];
            $nestedData[] = $value['created_at'];
            $nestedData[] = $value['created_by_name'];
            $nestedData[] = $value['role_name'];
            $btn = '<a href="' . base_url("manage/users") . '\edit/' . $value['id'] . '" class="btn btn-warning" style="font-size:9px;padding: 3px 8px;"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
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
