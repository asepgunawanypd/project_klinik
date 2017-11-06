<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends AUTH_Controller  {

	/**
	 * Index Page for this controller.
	 *
	 */
	public function index()
	{
		$data['page'] = "Home";
		$data['userdata'] = $this->userdata;
		$data['access'] = $this->is_access;
		$this->template->views('welcome_message', $data);
	}
}
