<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pekerjaan extends AUTH_Controller  {

	public function __construct() {
		parent::__construct();
        $this->load->model('M_pekerjaan', 'mpekerjaan');
	}

	public function index(){
		$data['page'] = "Pekerjaan";
		$data['userdata'] = $this->userdata;
        $data['access'] = $this->is_access;
		$data['modal_view'] = show_my_modal('ref_pasien/pekerjaan/view', 'modal_view', $data);
		$data['modal_crud'] = show_my_modal('ref_pasien/pekerjaan/crud', 'modal_crud', $data);
		$this->template->views('ref_pasien/pekerjaan/main_pekerjaan', $data);
	}

	public function dataTable(){
	  	$post = $this->input->post();
	  	$data = $this->mpekerjaan->dataTable($post);
	  	$results = array(
			"draw" => $this->input->post("draw"),
			"iTotalDisplayRecords" => $data["total"],
			"aaData"=>$data["rows"]);
	   	echo json_encode($results);	
	}

	public function view(){
        $id = $this->input->post('id');
        $data = $this->mpekerjaan->view($id);
        echo json_encode($data);
    }

    public function filename_exists(){
        $id = $this->input->post('id');
        $data = $this->mpekerjaan->filename_exists($id);
        if ($data == TRUE) {
            echo 'error';
        }
    }

    public function add() {
		$data = array(
				'pekerjaan' => $this->input->post('pekerjaan'),
				'created_by' => $this->userdata->nama,
				'created_at' => date('Y-m-d H:i:s')
			);
		$insert = $this->mpekerjaan->add($data);            
		echo json_encode($insert);
	}

	public function update() {
		$data = array(
				'pekerjaan' => $this->input->post('pekerjaan'),
				'created_by' => $this->input->post('created_by'),
                'created_at' => $this->input->post('created_at'),
                'update_by' => $this->userdata->nama,
                'update_at' => date('Y-m-d H:i:s')
			);
		$edit = $this->mpekerjaan->edit(array('id' => $this->input->post('id')), $data);           
		echo json_encode($edit);
	}

	public function delete($id){
        $del = $this->mpekerjaan->delete_by_id($id); 
        if($del){
            echo json_encode(array("status" => TRUE));            
        }else{
            echo json_encode(array("status" => FALSE));
        }     
    }

    public function printpdf() {
        $data['data_list'] = $this->mpekerjaan->select_all();
        $data['judul'] = 'List Pekerjaan';
        $html = $this->load->view('ref_pasien/pekerjaan/print', $data, true);
        $pdfFilePath = "list Pekerjaan.pdf";
        $this->load->library('m_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }

    public function export() {
        error_reporting(E_ALL);    
        include_once './assets/phpexcel/Classes/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $data = $this->mpekerjaan->select_all();
        $objPHPExcel = new PHPExcel(); 
        $objPHPExcel->setActiveSheetIndex(0); 
        $rowCount = 1; 
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "ID"); 
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "pekerjaan");
        $rowCount++;
        foreach($data as $value){
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $value->id); 
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $value->pekerjaan); 
            $rowCount++; 
        } 
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
        $objWriter->save('./assets/excel/List Pekerjaan.xlsx'); 
        $this->load->helper('download');
        force_download('./assets/excel/List Pekerjaan.xlsx', NULL);
    }

}