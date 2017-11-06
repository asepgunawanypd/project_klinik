<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kabupaten extends AUTH_Controller  {

	public function __construct() {
		parent::__construct();
        $this->load->model('M_kabupaten', 'mkab');
	}

	public function index(){
		$data['page'] = "Kabupaten";
		$data['userdata'] = $this->userdata;
        $data['access'] = $this->is_access;
		//$data['modal_view'] = show_my_modal('clinic/view', 'modal_view', $data);
		//$data['modal_crud'] = show_my_modal('clinic/crud', 'modal_crud', $data);
		$this->template->views('location/kabupaten/main_kabupaten', $data);
	}

	public function dataTable(){
	  	$post = $this->input->post();
	  	$data = $this->mkab->dataTable($post);
	  	$results = array(
			"draw" => $this->input->post("draw"),
			"iTotalDisplayRecords" => $data["total"],
			"aaData"=>$data["rows"]);
	   	echo json_encode($results);	
	}
}