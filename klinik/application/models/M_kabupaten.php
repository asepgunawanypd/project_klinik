<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Kabupaten extends CI_Model {

	var $table = 'tbl_master_kabupaten';
    var $v_table = 'v_location';

	public function __construct(){
		parent::__construct();
	}

    public function dataTable($post=''){
        $sql = "SELECT
                tbl_master_kabupaten.id,
                tbl_master_kabupaten.provinsi_id,
                tbl_master_kabupaten.kabupaten,
                tbl_master_provinsi.provinsi
                FROM
                tbl_master_kabupaten
                INNER JOIN tbl_master_provinsi ON tbl_master_kabupaten.provinsi_id = tbl_master_provinsi.id WHERE 1 = 1 ";        
        if(  isset($post['search']) && ! empty($post['search']["value"])  ){
            $search = $this->db->escape_str($post['search']["value"]);            
            $sql .= " AND  tbl_master_kabupaten.id LIKE '%". $search ."%' ";
            $sql .= " OR tbl_master_kabupaten.provinsi_id LIKE '%". $search ."%' ";
            $sql .= " OR tbl_master_kabupaten.kabupaten LIKE '%". $search ."%' ";
            $sql .= " OR tbl_master_provinsi.provinsi LIKE '%". $search ."%' ";
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
            $sql .= "ORDER BY tbl_master_kabupaten.id ASC";
        }        
        $sql .= " LIMIT ".$post['start'].",".$post['length'];        
        $rows = $this->db->query($sql)->result_array(); 
        return array("total" => $total, "rows" => $rows );          
    }
}