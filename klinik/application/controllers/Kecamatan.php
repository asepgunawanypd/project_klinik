<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kecamatan extends AUTH_Controller  {

	public function __construct() {
		parent::__construct();
        $this->load->model('M_kecamatan', 'mkec');
	}

	public function index(){
		$data['page'] = "Kecamatan";
		$data['userdata'] = $this->userdata;
        $data['access'] = $this->is_access;
		//$data['modal_view'] = show_my_modal('clinic/view', 'modal_view', $data);
		//$data['modal_crud'] = show_my_modal('clinic/crud', 'modal_crud', $data);
		$this->template->views('location/Kecamatan/main_kecamatan', $data);
	}

	public function dataTable(){
	  	$post = $this->input->post();
	  	$data = $this->mkec->dataTable($post);
	  	$results = array(
			"draw" => $this->input->post("draw"),
			"iTotalDisplayRecords" => $data["total"],
			"aaData"=>$data["rows"]);
	   	echo json_encode($results);	
	}
}