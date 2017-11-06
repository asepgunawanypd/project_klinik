<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_user extends CI_Model {

	var $table = 'tbl_user';
    var $v_table = 'v_user';

	public function __construct(){
		parent::__construct();
	}

    public function dataTable($post=''){
        $sql = "SELECT * FROM v_user WHERE 1 = 1 ";        
        if(  isset($post['search']) && ! empty($post['search']["value"])  ){
            $search = $this->db->escape_str($post['search']["value"]);            
            $sql .= " AND username LIKE '%". $search ."%' ";
            $sql .= " OR nama LIKE '%". $search ."%' ";
            $sql .= " OR status LIKE '%". $search ."%' ";
            $sql .= " OR nama_klinik LIKE '%". $search ."%' ";
        }   
        $total = $this->db->query("SELECT COUNT(*) jml FROM ( $sql ) AS jumlah")->row("jml");        
        if( empty($post['length'])){ $post['length'] = 10; }
        if( empty($post['start'])){ $post['start'] = 0; }
        if( isset($post['order']) && isset($post['order'][0]) ){
            $i = $post['order'][0]["column"];
            $field =  $post['columns'][$i]["data"];
            $dir = $post['order'][0]["dir"];
            $sql .= " ORDER BY ". $field  ." ".$dir;
            
        }else{
            $sql .= "ORDER BY username ASC";
        }        
        $sql .= " LIMIT ".$post['start'].",".$post['length'];        
        $rows = $this->db->query($sql)->result_array(); 
        return array("total" => $total, "rows" => $rows );          
    }

    public function view($id){
        $this->db->from($this->v_table);
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }

    public function filename_exists($id){
        $this->db->from($this->table);
        $this->db->where('username', $id);
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function add($data){
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    public function delete_by_id($id){
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    public function get_by_id($id){
        $this->db->from($this->v_table);
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }

    public function edit($where, $data){
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }

    public function select_all_print() {
        $data = $this->db->get($this->v_table);
        return $data->result();
    }

    public function select_all() {
        $data = $this->db->get($this->v_table);
        return $data->result();
    }

    public function update($data, $id) {
        $this->db->where("id", $id);
        $this->db->update("tbl_user", $data);

        return $this->db->affected_rows();
    }

    public function select($id = '') {
        if ($id != '') {
            $this->db->where('id', $id);
        }
        $data = $this->db->get($this->v_table);
        return $data->row();
    }

}