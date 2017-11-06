<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Access extends AUTH_Controller  {

	public function __construct() {
		parent::__construct();
        $this->load->model('M_access', 'access');
        $this->load->model('M_user', 'user');
	}

	public function index(){
		$data['page'] = "Access";
		$data['userdata'] = $this->userdata;
		$data['access'] = $this->is_access;
		$data['dataUser'] = $this->user->select_all();
		$data['modal_view'] = show_my_modal('access/view', 'modal_view', $data);
		$data['modal_crud'] = show_my_modal('access/crud', 'modal_crud', $data);
		$this->template->views('access/main_access', $data);
	}

	public function dataTable(){
	  	$post = $this->input->post();
	  	$data = $this->access->dataTable($post);
	  	$results = array(
			"draw" => $this->input->post("draw"),
			"iTotalDisplayRecords" => $data["total"],
			"aaData"=>$data["rows"]);
	   	echo json_encode($results);	
	} 

	public function view(){
        $id = $this->input->post('id');
        $data = $this->access->view($id);
        echo json_encode($data);
    }

    public function add(){
        $insert = $this->access->add($_POST);            
        echo json_encode($insert);
    }

    public function filename_exists(){
        $id = $this->input->post('id');
        $data = $this->access->filename_exists($id);
        if ($data == TRUE) {
            echo 'error';
        }
    }
}