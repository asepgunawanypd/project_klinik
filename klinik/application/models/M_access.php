<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_access extends CI_Model {

	var $table = 'tbl_access';
    var $v_table = 'v_access';

	public function __construct(){
		parent::__construct();
	}

	public function dataTable($post=''){
        $sql = "SELECT tbl_access.*, tbl_user.username 
                FROM tbl_access 
                LEFT JOIN tbl_user ON tbl_user.id = tbl_access.user_id  WHERE 1 = 1 ";        
        if(  isset($post['search']) && ! empty($post['search']["value"])  ){
            $search = $this->db->escape_str($post['search']["value"]);            
            $sql .= " AND user_id LIKE '%". $search ."%' ";
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
            $sql .= "ORDER BY id ASC";
        }        
        $sql .= " LIMIT ".$post['start'].",".$post['length'];        
        $rows = $this->db->query($sql)->result_array(); 
        return array("total" => $total, "rows" => $rows );          
    }

    public function select($id=""){
        $sql = "SELECT tbl_access.*, tbl_user.username 
                FROM tbl_access 
                LEFT JOIN tbl_user ON tbl_user.id = tbl_access.user_id 
                WHERE tbl_user.id = '$id' ";
        $rows = $this->db->query($sql)->row(); 
        return $rows;
    }

    public function view($id){
        $this->db->from($this->v_table);
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }

    public function add($data){
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

     public function filename_exists($id){
        $this->db->from($this->table);
        $this->db->where('user_id', $id);
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}