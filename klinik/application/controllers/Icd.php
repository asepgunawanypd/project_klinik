<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Icd extends AUTH_Controller  {

	public function __construct() {
		parent::__construct();
        $this->load->model('M_icd', 'micd');
        $this->load->model('M_icd_induk', 'micdinduk');
	}

	public function index(){
		$data['page'] = "Icd";
		$data['userdata'] = $this->userdata;
        $data['access'] = $this->is_access;
        $data['dataSelect'] = $this->micdinduk->select_all();
		$data['modal_view'] = show_my_modal('icd/icd/view', 'modal_view', $data);
		$data['modal_crud'] = show_my_modal('icd/icd/crud', 'modal_crud', $data);
		$this->template->views('icd/icd/main_icd', $data);
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
				'icd_induk_id' => $this->input->post('icd_induk_id'),
                'penyakit' => $this->input->post('penyakit'),
                'includes' => $this->input->post('includes'),
                'excludes' => $this->input->post('excludes'),
                'notes' => $this->input->post('notes'),
                'status_app' => $this->input->post('status_app'),
                'description' => $this->input->post('description'),
                'is_default' => $this->input->post('is_default'),
                'is_odontogram' => $this->input->post('is_odontogram'),
				'created_by' => $this->userdata->nama,
				'created_at' => date('Y-m-d H:i:s')
			);
		$insert = $this->micd->add($data);            
		echo json_encode($insert);
	}
	
	public function update() {
		$data = array(
				'icd_induk_id' => $this->input->post('icd_induk_id'),
                'penyakit' => $this->input->post('penyakit'),
                'includes' => $this->input->post('includes'),
                'excludes' => $this->input->post('excludes'),
                'notes' => $this->input->post('notes'),
                'status_app' => $this->input->post('status_app'),
                'description' => $this->input->post('description'),
                'is_default' => $this->input->post('is_default'),
                'is_odontogram' => $this->input->post('is_odontogram'),
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
        $data['judul'] = 'List ICD';
        $html = $this->load->view('icd/icd/print', $data, true);
        $pdfFilePath = "list ICD.pdf";
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
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "KD ICD Induk");
        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, "Penyakit");
        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, "Includes");
        $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, "Excludes");
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "Notes");
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, "Status App");
        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, "Description");
        $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, "is_default");
        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, "is_odontogram");
        $rowCount++;
        foreach($data as $value){
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $value->kd); 
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $value->icd_induk_id); 
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $value->penyakit); 
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $value->includes); 
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $value->excludes); 
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $value->notes); 
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $value->status_app); 
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $value->description); 
            $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $value->is_default); 
            $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $value->is_odontogram); 
            $rowCount++; 
        } 
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
        $objWriter->save('./assets/excel/List ICD.xlsx'); 
        $this->load->helper('download');
        force_download('./assets/excel/List ICD.xlsx', NULL);
    }
}