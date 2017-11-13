<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Icd_induk extends AUTH_Controller  {

	public function __construct() {
		parent::__construct();
        $this->load->model('M_icd_induk', 'micd');
	}

	public function index(){
		$data['page'] = "Icd_induk";
		$data['userdata'] = $this->userdata;
        $data['access'] = $this->is_access;
		$data['modal_view'] = show_my_modal('icd/icd_induk/view', 'modal_view', $data);
		$data['modal_crud'] = show_my_modal('icd/icd_induk/crud', 'modal_crud', $data);
		$this->template->views('icd/icd_induk/main_icd_induk', $data);
	}

	public function dataTable(){
	  	$post = $this->input->post();
	  	$data = $this->micd->dataTable($post);
	  	$results = array(
			"draw" => $this->input->post("draw"),
			"iTotalDisplayRecords" => $data["total"],
			"aaData"=>$data["rows"]);
	   	echo json_encode($results);	
	}

	public function view(){
        $id = $this->input->post('id');
        $data = $this->micd->view($id);
        echo json_encode($data);
    }
	
	public function filename_exists(){
        $id = $this->input->post('id');
        $data = $this->micd->filename_exists($id);
        if ($data == TRUE) {
            echo 'error';
        }
    }
	
	public function add() {
		$data = array(
				'kd' => $this->input->post('kd'),
				'icd_induk' => $this->input->post('icd_induk'),
				'created_by' => $this->userdata->nama,
				'created_at' => date('Y-m-d H:i:s')
			);
		$insert = $this->micd->add($data);            
		echo json_encode($insert);
	}
	
	public function update() {
		$data = array(
				'icd_induk' => $this->input->post('icd_induk'),
				'created_by' => $this->input->post('created_by'),
                'created_at' => $this->input->post('created_at'),
                'update_by' => $this->userdata->nama,
                'update_at' => date('Y-m-d H:i:s')
			);
		$edit = $this->micd->edit(array('kd' => $this->input->post('kd')), $data);
        echo json_encode($edit);
	}
	
	public function edit_view(){
        $id = $this->input->post('id');
        $data = $this->micd->get_by_id($id);
        echo json_encode($data);
    }
	
	public function delete($id){
        $del = $this->micd->delete_by_id($id); 
        if($del){
            echo json_encode(array("status" => TRUE));            
        }else{
            echo json_encode(array("status" => FALSE));
        }     
    }
	
	public function printpdf() {
        $data['data_list'] = $this->micd->select_all();
        $data['judul'] = 'List ICD Induk';
        $html = $this->load->view('icd/icd_induk/print', $data, true);
        $pdfFilePath = "list ICD Induk.pdf";
        $this->load->library('m_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }
	
	public function export() {
        error_reporting(E_ALL);    
        include_once './assets/phpexcel/Classes/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $data = $this->micd->select_all();
        $objPHPExcel = new PHPExcel(); 
        $objPHPExcel->setActiveSheetIndex(0); 
        $rowCount = 1; 
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "KD"); 
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "ICD Induk");
        $rowCount++;
        foreach($data as $value){
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $value->kd); 
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $value->icd_induk); 
            $rowCount++; 
        } 
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
        $objWriter->save('./assets/excel/List ICD Induk.xlsx'); 
        $this->load->helper('download');
        force_download('./assets/excel/List ICD Induk.xlsx', NULL);
    }
}