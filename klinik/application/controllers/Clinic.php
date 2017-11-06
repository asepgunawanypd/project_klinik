<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clinic extends AUTH_Controller  {

	public function __construct() {
		parent::__construct();
        $this->load->model('M_clinic', 'mc');
	}

	public function index(){
		$data['page'] = "Clinic";
		$data['userdata'] = $this->userdata;
        $data['access'] = $this->is_access;
		$data['modal_view'] = show_my_modal('clinic/view', 'modal_view', $data);
		$data['modal_crud'] = show_my_modal('clinic/crud', 'modal_crud', $data);
		$this->template->views('clinic/main_clinic', $data);
	}

	public function dataTable(){
	  	$post = $this->input->post();
	  	$data = $this->mc->dataTable($post);
	  	$results = array(
			"draw" => $this->input->post("draw"),
			"iTotalDisplayRecords" => $data["total"],
			"aaData"=>$data["rows"]);
	   	echo json_encode($results);	
	}

	public function view(){
        $id = $this->input->post('id');
        $data = $this->mc->view($id);
        echo json_encode($data);
    }

    public function filename_exists(){
        $nama = $this->input->post('nama');
        $data = $this->mc->filename_exists($nama);
        if ($data == TRUE) {
            echo 'error';
        }
    }

    public function add(){
        $this->form_validation->set_rules('nama', 'Name', 'trim|required');
        $this->form_validation->set_rules('alamat', 'Address', 'trim|required');
        $this->form_validation->set_rules('up', 'Up', 'trim|required');
        if ($this->form_validation->run() == TRUE){
            if($_FILES['photo']['name']){
                $config['upload_path']="./assets/img/clinic/";
                $config['allowed_types']='gif|jpg|png';
                $this->load->library('upload',$config);
                $this->upload->do_upload("photo");
                $nama_photo = $_FILES['photo']['name'];    
            }else{
                $nama_photo = 'noimage.png';
            }            
            $data = array(
                    'nama' => $this->input->post('nama'),
                    'alamat' => $this->input->post('alamat'),
                    'up' => $this->input->post('up'),
                    'phone' => $this->input->post('phone'),
                    'email' => $this->input->post('email'),
                    'logo' => $nama_photo,
                    'created_by' => $this->userdata->nama,
                    'created_at' => date('Y-m-d H:i:s')
                );
            $insert = $this->mc->add($data);            
            echo json_encode($insert);
        }else{
            $this->session->set_flashdata('msg', show_err_msg(validation_errors()));
        }
    }

    public function delete($id){
        $del = $this->mc->delete_by_id($id); 
        if($del){
            echo json_encode(array("status" => TRUE));            
        }else{
            echo json_encode(array("status" => FALSE));
        }     
    }

    public function edit_view(){
        $id = $this->input->post('id');
        $data = $this->mc->get_by_id($id);
        echo json_encode($data);
    }

    public function remove_photo(){
        $id = $post = $this->input->post("id");
        $img = array();
        $dir = 'assets/img/clinic/';
        $file = $this->db->query("select logo from tbl_master_klinik where id='$id' ")->row();
        $delImg = $file->logo;
        echo $delImg;
        @unlink($dir.$delImg);
        echo $this->db->update("tbl_master_klinik",array("logo"=>" "), array("id"=>$id));
    }

    public function update(){
        $this->form_validation->set_rules('nama', 'Name', 'trim|required');
        $this->form_validation->set_rules('alamat', 'Address', 'trim|required');
        $this->form_validation->set_rules('up', 'Up', 'trim|required');
        if ($this->form_validation->run() == TRUE){
            if (!empty($this->input->post('photo'))) {
                $nama_photo = $this->input->post('photo');
            }else{
                $config['upload_path']="./assets/img/clinic/";
                $config['allowed_types']='gif|jpg|png';
                $this->load->library('upload',$config);
                $this->upload->do_upload("photo");
                $nama_photo = $_FILES['photo']['name'];    
            }
            $data = array(
                    'nama' => $this->input->post('nama'),
                    'alamat' => $this->input->post('alamat'),
                    'up' => $this->input->post('up'),
                    'phone' => $this->input->post('phone'),
                    'email' => $this->input->post('email'),
                    'logo' => $nama_photo,
                    'created_by' => $this->input->post('created_by'),
                    'created_at' => $this->input->post('created_at'),
                    'update_by' => $this->userdata->nama,
                    'update_at' => date('Y-m-d H:i:s')
            );
        	$edit = $this->mc->edit(array('id' => $this->input->post('id')), $data);
            echo json_encode($edit);
        }else{
            $this->session->set_flashdata('msg', show_err_msg(validation_errors()));   
        }
    }

     public function printpdf() {
        $data['data_list'] = $this->mc->select_all_print();
        $data['judul'] = 'Clinic List';
        $html = $this->load->view('clinic/print', $data, true);
        $pdfFilePath = "Clinic list.pdf";
        $this->load->library('m_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }

    public function export() {
        error_reporting(E_ALL);    
        include_once './assets/phpexcel/Classes/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $data = $this->mc->select_all_print();
        $objPHPExcel = new PHPExcel(); 
        $objPHPExcel->setActiveSheetIndex(0); 
        $rowCount = 1; 
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "ID"); 
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "Name");
        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, "Address");
        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, "Up");
        $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, "Phone");
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "Email");
        $rowCount++;
        foreach($data as $value){
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $value->id); 
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $value->nama); 
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $value->alamat); 
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $value->up); 
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $value->phone); 
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $value->email); 
            $rowCount++; 
        } 
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
        $objWriter->save('./assets/excel/Data Clinic.xlsx'); 
        $this->load->helper('download');
        force_download('./assets/excel/Data Clinic.xlsx', NULL);
    }
}