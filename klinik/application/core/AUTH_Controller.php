<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AUTH_Controller extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('M_access', 'access');
		$this->load->model('M_user', 'user');
		$this->userdata = $this->session->userdata('userdata');
		$this->session->set_flashdata('segment', explode('/', $this->uri->uri_string()));
		if ($this->session->userdata('status') == '') {
			redirect('Auth');
		}
		$this->is_access = $this->access->select($this->userdata->id);
	}

	public function updateProfil() {
		if ($this->userdata != '') {
			$data = $this->user->select($this->userdata->id);
			$this->session->set_userdata('userdata', $data);
			$this->userdata = $this->session->userdata('userdata');
		}
	}





}

/* End of file MY_Auth.php */
/* Location: ./application/core/MY_Auth.php */