<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Provinsi extends AUTH_Controller  {

	public function __construct() {
		parent::__construct();
        $this->load->model('M_provinsi', 'mprov');
	}

	public function index(){
		$data['page'] = "Provinsi";
		$data['userdata'] = $this->userdata;
        $data['access'] = $this->is_access;
		$data['modal_view'] = show_my_modal('location/provinsi/view', 'modal_view', $data);
		//$data['modal_crud'] = show_my_modal('clinic/crud', 'modal_crud', $data);
		$this->template->views('location/provinsi/main_provinsi', $data);
	}

	public function dataTable(){
	  	$post = $this->input->post();
	  	$data = $this->mprov->dataTable($post);
	  	$results = array(
			"draw" => $this->input->post("draw"),
			"iTotalDisplayRecords" => $data["total"],
			"aaData"=>$data["rows"]);
	   	echo json_encode($results);	
	}

	public function view(){
        $id = $this->input->post('id');
        $data = $this->mprov->view($id);
        echo json_encode($data);
    }
}