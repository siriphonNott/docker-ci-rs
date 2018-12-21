<?php

class Lead_library extends MY_Controller
{
    public $CI;
    public $table_lead;
    public $csrf;

    public function __construct()
    {
        parent::__construct();
        $this->CI = &get_instance();
        $this->table_lead = 'lead_lists';
    }

    public function getDataNotAllocate($REQUEST)
    {
        $params = "";
        $columns = "";
        $totalRecords = "";
        $data = array();

        $params = $REQUEST;

        //$defaultTime = "0000-00-00 00:00:00";
        $order_by = "createdAt DESC";

        $where = "(assignedTo = '' OR assignedTo is null) AND used = '1' AND expiredDate is null";
        if (!empty($params['search']['value'])) {
            $where .= " AND (title LIKE '%" . $params['search']['value'] . "%'  ";
            $where .= " OR email1 LIKE '%" . $params['search']['value'] . "%'  ";
            $where .= " OR email2 LIKE '%" . $params['search']['value'] . "%'  ";
            $where .= " OR tel1 LIKE '%" . $params['search']['value'] . "%'  ";
            $where .= " OR tel2 LIKE '%" . $params['search']['value'] . "%'  ";
            $where .= " OR tel3 LIKE '%" . $params['search']['value'] . "%'  ";
            $where .= " OR address LIKE '%" . $params['search']['value'] . "%'  ";
            $where .= " OR firstname LIKE '%" . $params['search']['value'] . "%'  ";
            $where .= " OR lastname LIKE '%" . $params['search']['value'] . "%'  )";
        }

        if (!empty($where)) {
            $this->CI->db->where($where);
        }

        $query = $this->CI->db->select("*")
            ->from($this->table_lead)
            //->where($where)
            ->order_by($order_by)
            //->order_by($columns[$params['order'][0]['column']], $params['order'][0]['dir'])
            ->limit($params['length'], $params['start'])
            ->get();



        $this->CI->db->select('count(id) as total');
        $this->CI->db->from($this->table_lead);
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
            $nestedData[] = $value['title'];
            $nestedData[] = $value['firstname'];
            $nestedData[] = $value['lastname'];
            $nestedData[] = $value['birthday'];
            $nestedData[] = $value['email1'];
            $nestedData[] = $value['email2'];
            $nestedData[] = $value['tel1'];
            $nestedData[] = $value['tel2'];
            $nestedData[] = $value['tel3'];
            $nestedData[] = $value['address'];
            $btn = '<a href="' . base_url("lead") . '\edit/' . $value['id'] . '" class="btn btn-warning" style="font-size:9px;padding: 3px 8px;"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
            $btn .= '&nbsp;<a onclick="btnDeleteContent(\'' . $value['id'] . '\',\'' . $params['table_reload'] . '\')" class="btn btn-danger btn-delete icon-delete" style="font-size:9px;padding: 3px 8px;"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>';
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