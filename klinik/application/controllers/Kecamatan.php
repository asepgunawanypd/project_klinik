<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kecamatan extends AUTH_Controller  {

	public function __construct() {
		parent::__construct();
        $this->load->model('M_kecamatan', 'mkec');
		$this->load->model('M_kabupaten', 'mkab');
	}

	public function index(){
		$data['page'] = "Kecamatan";
		$data['userdata'] = $this->userdata;
        $data['access'] = $this->is_access;
		$data['dataSelect'] = $this->mkab->select_all();
		$data['modal_view'] = show_my_modal('location/kecamatan/view', 'modal_view', $data);
		$data['modal_crud'] = show_my_modal('location/kecamatan/crud', 'modal_crud', $data);
		$this->template->views('location/Kecamatan/main_kecamatan', $data);
	}

	public function dataTable(){
	  	$post = $this->input->post();
	  	$data = $this->mkec->dataTable($post);
	  	$results = array(
			"draw" => $this->input->post("draw"),
			"iTotalDisplayRecords" => $data["total"],
			"aaData"=>$data["rows"]);
	   	echo json_encode($results);	
	}

	public function view(){
        $id = $this->input->post('id');
        $data = $this->mkec->view($id);
        echo json_encode($data);
    }
	
	public function filename_exists(){
        $id = $this->input->post('id');
        $data = $this->mkec->filename_exists($id);
        if ($data == TRUE) {
            echo 'error';
        }
    }
	
	public function add() {
		$data = array(
				'id' => $this->input->post('id'),
				'kecamatan' => $this->input->post('kecamatan'),
				'kabupaten_id' => $this->input->post('kabupaten_id'),
				'created_by' => $this->userdata->nama,
				'created_at' => date('Y-m-d H:i:s')
			);
		$insert = $this->mkec->add($data);            
		echo json_encode($insert);
	}
	
	public function update() {
		$data = array(
				'id' => $this->input->post('id'),
				'kecamatan' => $this->input->post('kecamatan'),
				'kabupaten_id' => $this->input->post('kabupaten_id'),
				'created_by' => $this->input->post('created_by'),
                'created_at' => $this->input->post('created_at'),
                'update_by' => $this->userdata->nama,
                'update_at' => date('Y-m-d H:i:s')
			);
		$edit = $this->mkec->edit(array('id' => $this->input->post('id')), $data);
        echo json_encode($edit);
	}
	
	public function delete($id){
        $del = $this->mkec->delete_by_id($id); 
        if($del){
            echo json_encode(array("status" => TRUE));            
        }else{
            echo json_encode(array("status" => FALSE));
        }     
    }
	
	public function printpdf() {
        $data['data_list'] = $this->mkec->select_all();
        $data['judul'] = 'List Kecamatan';
        $html = $this->load->view('location/kecamatan/print', $data, true);
        $pdfFilePath = "list Kecamatan.pdf";
        $this->load->library('m_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }
	
	public function export() {
        error_reporting(E_ALL);    
        include_once './assets/phpexcel/Classes/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $data = $this->mkec->select_all();
        $objPHPExcel = new PHPExcel(); 
        $objPHPExcel->setActiveSheetIndex(0); 
        $rowCount = 1; 
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "ID"); 
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "Kecamatan");
        $rowCount++;
        foreach($data as $value){
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $value->id); 
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $value->kecamatan); 
            $rowCount++; 
        } 
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
        $objWriter->save('./assets/excel/List Kecamatan.xlsx'); 
        $this->load->helper('download');
        force_download('./assets/excel/List Kecamatan.xlsx', NULL);
    }
}