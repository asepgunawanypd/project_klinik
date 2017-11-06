<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends AUTH_Controller  {

	public function __construct() {
		parent::__construct();
        $this->load->model('M_user', 'user');
        $this->load->model('M_clinic', 'clinic');
        
	}

	public function index(){
		$data['page'] = "User";
        $data['access'] = $this->is_access;
		$data['userdata'] = $this->userdata;
		$data['dataKlinik'] = $this->clinic->select_all();
		$data['modal_view'] = show_my_modal('user/view', 'modal_view', $data);
		$data['modal_crud'] = show_my_modal('user/crud', 'modal_crud', $data);
		$this->template->views('user/main_user', $data);
	}

    public function view(){
        $id = $this->input->post('id');
        $data = $this->user->view($id);
        echo json_encode($data);
    }

    public function dataTable(){
	  	$post = $this->input->post();
	  	$data = $this->user->dataTable($post);
	  	$results = array(
			"draw" => $this->input->post("draw"),
			"iTotalDisplayRecords" => $data["total"],
			"aaData"=>$data["rows"]);
	   	echo json_encode($results);	
	} 

	public function filename_exists(){
        $username = $this->input->post('username');
        $data = $this->user->filename_exists($username);
        if ($data == TRUE) {
            echo 'error';
        }
    }

    public function add(){
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|max_length[15]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[15]');
        $this->form_validation->set_rules('nama', 'Full Name', 'trim|required');
        $this->form_validation->set_rules('klinik_id', 'Clinic', 'trim|required');
        if ($this->form_validation->run() == TRUE){
            if($_FILES['photo']['name']){
                $config['upload_path']="./assets/img/user/";
                $config['allowed_types']='gif|jpg|png';
                $this->load->library('upload',$config);
                $this->upload->do_upload("photo");
                $nama_photo = $_FILES['photo']['name'];    
            }else{
                $nama_photo = 'noimage.png';
            }            
            $data = array(
                    'username' => $this->input->post('username'),
                    'password' => md5($this->input->post('password')),
                    'nama' => $this->input->post('nama'),
                    'id_klinik' => $this->input->post('klinik_id'),
                    'foto' => $nama_photo,
                    'status' => 'Active',
                    'created_by' => $this->userdata->nama,
                    'created_at' => date('Y-m-d H:i:s')
                );
            $insert = $this->user->add($data);            
            echo json_encode($insert);
        }else{
           
            $this->session->set_flashdata('msg', show_err_msg(validation_errors()));
        }
    }

    public function update(){
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|max_length[15]');
        $this->form_validation->set_rules('nama', 'Full Name', 'trim|required');
        $this->form_validation->set_rules('klinik_id', 'Clinic', 'trim|required');
        if ($this->form_validation->run() == TRUE){
            if (!empty($this->input->post('photo'))) {
                $nama_photo = $this->input->post('photo');
            }else{
                $config['upload_path']="./assets/img/user/";
                $config['allowed_types']='gif|jpg|png';
                $this->load->library('upload',$config);
                $this->upload->do_upload("photo");
                $nama_photo = $_FILES['photo']['name'];    
            }
            if(empty($this->input->post('password'))){ 
                $pass = $this->userdata->password; 
            }else{
                $pass = md5($this->input->post('password'));
            }
            $data = array(
                    'password' => $pass,
                    'nama' => $this->input->post('nama'),
                    'id_klinik' => $this->input->post('klinik_id'),
                    'foto' => $nama_photo,
                    'status' => $this->input->post('status'),
                    'created_by' => $this->input->post('created_by'),
                    'created_at' => $this->input->post('created_at'),
                    'update_by' => $this->userdata->nama,
                    'update_at' => date('Y-m-d H:i:s')
                );

            $edit = $this->user->edit(array('username' => $this->input->post('username')), $data);
            echo json_encode($edit);
        }else{
            $this->session->set_flashdata('msg', show_err_msg(validation_errors()));   
        }
    }

    public function delete($id){
        $del = $this->user->delete_by_id($id); 
        if($del){
            echo json_encode(array("status" => TRUE));            
        }else{
            echo json_encode(array("status" => FALSE));
        }     
    }

    public function edit_view(){
        $id = $this->input->post('id');
        $data = $this->user->get_by_id($id);
        echo json_encode($data);
    }

    public function remove_photo(){
        $id = $post = $this->input->post("id");
        $img = array();
        $dir = 'assets/img/user/';
        $file = $this->db->query("select foto from tbl_user where id='$id' ")->row();
        $delImg = $file->foto;
        echo $delImg;
        @unlink($dir.$delImg);
        echo $this->db->update("tbl_user",array("foto"=>" "), array("id"=>$id));
    }

    public function printpdf() {
        $data['data_list'] = $this->user->select_all_print();
        $data['judul'] = 'User List';
        $html = $this->load->view('user/print', $data, true);
        $pdfFilePath = "User list.pdf";
        $this->load->library('m_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }

    public function export() {
        error_reporting(E_ALL);    
        include_once './assets/phpexcel/Classes/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $data = $this->user->select_all();
        $objPHPExcel = new PHPExcel(); 
        $objPHPExcel->setActiveSheetIndex(0); 
        $rowCount = 1; 
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "ID"); 
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "Username");
        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, "Full Name");
        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, "status");
        $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, "Clinic Name");
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "Address");
        $rowCount++;
        foreach($data as $value){
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $value->id); 
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $value->username); 
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $value->nama); 
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $value->status); 
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $value->nama_klinik); 
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $value->alamat); 
            $rowCount++; 
        } 
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
        $objWriter->save('./assets/excel/Data User.xlsx'); 
        $this->load->helper('download');
        force_download('./assets/excel/Data User.xlsx', NULL);
    }

}
