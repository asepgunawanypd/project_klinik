<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_obat extends CI_Model {

	var $table = 'tbl_master_obat';

	public function __construct(){
		parent::__construct();
	}

    public function dataTable($post=''){
        $sql = "SELECT * FROM tbl_master_obat WHERE 1 = 1 ";        
        if(  isset($post['search']) && ! empty($post['search']["value"])  ){
            $search = $this->db->escape_str($post['search']["value"]);            
            $sql .= " AND id LIKE '%". $search ."%' ";
            $sql .= " OR obat LIKE '%". $search ."%' ";
            $sql .= " OR kd_obat_val LIKE '%". $search ."%' ";
            $sql .= " OR golongan_obat_id LIKE '%". $search ."%' ";
            $sql .= " OR jenis_imunisasi_id LIKE '%". $search ."%' ";
            $sql .= " OR satuan_kecil_id LIKE '%". $search ."%' ";
            $sql .= " OR satuan_besar_id LIKE '%". $search ."%' ";
            $sql .= " OR terapi_obat_id LIKE '%". $search ."%' ";
            $sql .= " OR generik LIKE '%". $search ."%' ";
            $sql .= " OR fraction LIKE '%". $search ."%' ";
            $sql .= " OR singkatan LIKE '%". $search ."%' ";
            $sql .= " OR is_default LIKE '%". $search ."%' ";
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
            $sql .= "ORDER BY obat ASC";
        }        
        $sql .= " LIMIT ".$post['start'].",".$post['length'];        
        $rows = $this->db->query($sql)->result_array(); 
        return array("total" => $total, "rows" => $rows );          
    }

    public function view($id){
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }

    public function filename_exists($id){
        $this->db->from($this->table);
        $this->db->where('kd_obat_val', $id);
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

    public function edit($where, $data){
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }

    public function delete_by_id($id){
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    public function select_all() {
        $data = $this->db->get($this->table);
        return $data->result();
    }

}