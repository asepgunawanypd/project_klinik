<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_kelamin extends AUTH_Controller  {

	public function __construct() {
		parent::__construct();
        $this->load->model('M_jenis_kelamin', 'mjenis');
	}

	public function index(){
		$data['page'] = "Jenis_kelamin";
		$data['userdata'] = $this->userdata;
        $data['access'] = $this->is_access;
		$data['modal_view'] = show_my_modal('ref_pasien/jenis_kelamin/view', 'modal_view', $data);
		$data['modal_crud'] = show_my_modal('ref_pasien/jenis_kelamin/crud', 'modal_crud', $data);
		$this->template->views('ref_pasien/jenis_kelamin/main_jenis_kelamin', $data);
	}

	public function dataTable(){
	  	$post = $this->input->post();
	  	$data = $this->mjenis->dataTable($post);
	  	$results = array(
			"draw" => $this->input->post("draw"),
			"iTotalDisplayRecords" => $data["total"],
			"aaData"=>$data["rows"]);
	   	echo json_encode($results);	
	}

	public function view(){
        $id = $this->input->post('id');
        $data = $this->mjenis->view($id);
        echo json_encode($data);
    }

    public function filename_exists(){
        $id = $this->input->post('id');
        $data = $this->mjenis->filename_exists($id);
        if ($data == TRUE) {
            echo 'error';
        }
    }

    public function add() {
		$data = array(
				'kd_jenis_kelamin' => $this->input->post('kd_jenis_kelamin'),
				'jenis_kelamin' => $this->input->post('jenis_kelamin'),
				'created_by' => $this->userdata->nama,
				'created_at' => date('Y-m-d H:i:s')
			);
		$insert = $this->mjenis->add($data);            
		echo json_encode($insert);
	}

	public function update() {
		$data = array(
				'jenis_kelamin' => $this->input->post('jenis_kelamin'),
				'created_by' => $this->input->post('created_by'),
                'created_at' => $this->input->post('created_at'),
                'update_by' => $this->userdata->nama,
                'update_at' => date('Y-m-d H:i:s')
			);
		$edit = $this->mjenis->edit(array('kd_jenis_kelamin' => $this->input->post('kd_jenis_kelamin')), $data);           
		echo json_encode($edit);
	}

	public function delete($id){
        $del = $this->mjenis->delete_by_id($id); 
        if($del){
            echo json_encode(array("status" => TRUE));            
        }else{
            echo json_encode(array("status" => FALSE));
        }     
    }

    public function printpdf() {
        $data['data_list'] = $this->mjenis->select_all();
        $data['judul'] = 'List jenis Kelamin';
        $html = $this->load->view('ref_pasien/jenis_kelamin/print', $data, true);
        $pdfFilePath = "list jenis Kelamin.pdf";
        $this->load->library('m_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }

    public function export() {
        error_reporting(E_ALL);    
        include_once './assets/phpexcel/Classes/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $data = $this->mjenis->select_all();
        $objPHPExcel = new PHPExcel(); 
        $objPHPExcel->setActiveSheetIndex(0); 
        $rowCount = 1; 
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "KD"); 
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "Jenis Kelamin");
        $rowCount++;
        foreach($data as $value){
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $value->kd_jenis_kelamin); 
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $value->jenis_kelamin); 
            $rowCount++; 
        } 
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
        $objWriter->save('./assets/excel/Jenis Kelamin List.xlsx'); 
        $this->load->helper('download');
        force_download('./assets/excel/Jenis Kelamin List.xlsx', NULL);
    }

}