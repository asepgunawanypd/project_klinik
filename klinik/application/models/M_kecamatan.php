<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Kecamatan extends CI_Model {

	var $table = 'tbl_master_kecamatan';
    var $v_table = 'v_location';

	public function __construct(){
		parent::__construct();
	}

    public function dataTable($post=''){
        $sql = "SELECT
                tbl_master_kecamatan.id,
                tbl_master_kecamatan.kabupaten_id,
                tbl_master_kecamatan.kecamatan,
                tbl_master_kabupaten.kabupaten
                FROM
                tbl_master_kecamatan
                INNER JOIN tbl_master_kabupaten ON tbl_master_kecamatan.kabupaten_id = tbl_master_kabupaten.id WHERE 1 = 1 ";        
        if(  isset($post['search']) && ! empty($post['search']["value"])  ){
            $search = $this->db->escape_str($post['search']["value"]);            
            $sql .= " AND tbl_master_kecamatan.id LIKE '%". $search ."%' ";
            $sql .= " OR tbl_master_kecamatan.kabupaten_id LIKE '%". $search ."%' ";
            $sql .= " OR tbl_master_kecamatan.kecamatan LIKE '%". $search ."%' ";
            $sql .= " OR tbl_master_kabupaten.kabupaten LIKE '%". $search ."%' ";
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
            $sql .= "ORDER BY tbl_master_kecamatan.id ASC";
        }        
        $sql .= " LIMIT ".$post['start'].",".$post['length'];        
        $rows = $this->db->query($sql)->result_array(); 
        return array("total" => $total, "rows" => $rows );          
    }
}