<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_bayar extends CI_Model {

	var $table = 'tbl_master_bayar';

	public function __construct(){
		parent::__construct();
	}

    public function dataTable($post=''){
        $sql = "SELECT
                tbl_master_bayar.id,
                tbl_master_bayar.bayar,
                tbl_master_bayar.rekanan_id,
                tbl_master_rekanan.rekanan
                FROM
                tbl_master_bayar
                INNER JOIN tbl_master_rekanan ON tbl_master_bayar.rekanan_id = tbl_master_rekanan.id WHERE 1 = 1 ";        
        if(  isset($post['search']) && ! empty($post['search']["value"])  ){
            $search = $this->db->escape_str($post['search']["value"]);            
            $sql .= " AND tbl_master_bayar.id LIKE '%". $search ."%' ";
            $sql .= " OR tbl_master_bayar.bayar LIKE '%". $search ."%' ";
            $sql .= " OR tbl_master_bayar.rekanan_id LIKE '%". $search ."%' ";
            $sql .= " OR tbl_master_rekanan.rekanan LIKE '%". $search ."%' ";
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
            $sql .= "ORDER BY tbl_master_bayar.bayar ASC";
        }        
        $sql .= " LIMIT ".$post['start'].",".$post['length'];        
        $rows = $this->db->query($sql)->result_array(); 
        return array("total" => $total, "rows" => $rows );          
    }

    public function view($id){
        $this->db->select('tbl_master_bayar.id,tbl_master_bayar.bayar,tbl_master_bayar.rekanan_id,tbl_master_rekanan.rekanan');
        $this->db->from($this->table);
        $this->db->join('tbl_master_rekanan','tbl_master_bayar.rekanan_id = tbl_master_rekanan.id','inner');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }

    public function filename_exists($id){
        $this->db->from($this->table);
        $this->db->where('bayar', $id);
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
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    public function select_all() {
        $data = $this->db->get($this->table);
        return $data->result();
    }

}