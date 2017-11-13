<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_icd extends CI_Model {

	var $table = 'tbl_master_icd';

	public function __construct(){
		parent::__construct();
	}

    public function dataTable($post=''){
        $sql = "SELECT
                tbl_master_icd.kd,
                tbl_master_icd.icd_induk_id,
                tbl_master_icd.penyakit,
                tbl_master_icd.includes,
                tbl_master_icd.excludes,
                tbl_master_icd.notes,
                tbl_master_icd.status_app,
                tbl_master_icd.description,
                tbl_master_icd.is_default,
                tbl_master_icd.is_odontogram,
                tbl_master_icd_induk.icd_induk
                FROM
                tbl_master_icd
                INNER JOIN tbl_master_icd_induk ON tbl_master_icd.icd_induk_id = tbl_master_icd_induk.kd WHERE 1 = 1 ";        
        if(  isset($post['search']) && ! empty($post['search']["value"])  ){
            $search = $this->db->escape_str($post['search']["value"]);            
            $sql .= " AND tbl_master_icd.kd LIKE '%". $search ."%' ";
            $sql .= " OR tbl_master_icd.icd_induk_id LIKE '%". $search ."%' ";
            $sql .= " OR tbl_master_icd.penyakit LIKE '%". $search ."%' ";
            $sql .= " OR tbl_master_icd.includes LIKE '%". $search ."%' ";
            $sql .= " OR tbl_master_icd.excludes LIKE '%". $search ."%' ";
            $sql .= " OR tbl_master_icd.notes LIKE '%". $search ."%' ";
            $sql .= " OR tbl_master_icd.status_app LIKE '%". $search ."%' ";
            $sql .= " OR tbl_master_icd.description LIKE '%". $search ."%' ";
            $sql .= " OR tbl_master_icd.is_default LIKE '%". $search ."%' ";
            $sql .= " OR tbl_master_icd.is_odontogram LIKE '%". $search ."%' ";
            $sql .= " OR tbl_master_icd_induk.icd_induk LIKE '%". $search ."%' ";
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
            $sql .= "ORDER BY tbl_master_icd.kd ASC";
        }        
        $sql .= " LIMIT ".$post['start'].",".$post['length'];        
        $rows = $this->db->query($sql)->result_array(); 
        return array("total" => $total, "rows" => $rows );          
    }
	
	public function filename_exists($id){
        $this->db->from($this->table);
        $this->db->where('kd', $id);
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
	
	public function add($data){
        return $this->db->insert($this->table, $data);
    }
	
	public function edit($where, $data){
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }
	
	public function delete_by_id($id){
        $this->db->where('kd', $id);
        return $this->db->delete($this->table);
    }
	
	public function get_by_id($id){
        $this->db->from($this->table);
        $this->db->where('kd',$id);
        $query = $this->db->get();
        return $query->row();
    }

    public function view($id){
        $this->db->select('tbl_master_icd.kd,tbl_master_icd.icd_induk_id,tbl_master_icd.penyakit,tbl_master_icd.includes,tbl_master_icd.excludes,tbl_master_icd.notes,tbl_master_icd.status_app,tbl_master_icd.description,tbl_master_icd.is_default,tbl_master_icd.is_odontogram,tbl_master_icd_induk.icd_induk');
        $this->db->from($this->table);
        $this->db->join('tbl_master_icd_induk','tbl_master_icd.icd_induk_id = tbl_master_icd_induk.kd','inner');
        $this->db->where('tbl_master_icd.kd',$id);
        $query = $this->db->get();
        return $query->row();
    }
	
	public function select_all() {
        $data = $this->db->get($this->table);
        return $data->result();
    }
}