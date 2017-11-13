<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agama extends AUTH_Controller  {

	public function __construct() {
		parent::__construct();
        $this->load->model('M_agama', 'magama');
	}

	public function index(){
		$data['page'] = "Agama";
		$data['userdata'] = $this->userdata;
        $data['access'] = $this->is_access;
		$data['modal_view'] = show_my_modal('ref_pasien/Agama/view', 'modal_view', $data);
		$data['modal_crud'] = show_my_modal('ref_pasien/Agama/crud', 'modal_crud', $data);
		$this->template->views('ref_pasien/agama/main_agama', $data);
	}

	public function dataTable(){
	  	$post = $this->input->post();
	  	$data = $this->magama->dataTable($post);
	  	$results = array(
			"draw" => $this->input->post("draw"),
			"iTotalDisplayRecords" => $data["total"],
			"aaData"=>$data["rows"]);
	   	echo json_encode($results);	
	}

	public function view(){
        $id = $this->input->post('id');
        $data = $this->magama->view($id);
        echo json_encode($data);
    }

    public function filename_exists(){
        $id = $this->input->post('id');
        $data = $this->magama->filename_exists($id);
        if ($data == TRUE) {
            echo 'error';
        }
    }

    public function add() {
		$data = array(
				'kd_agama' => $this->input->post('kd_agama'),
				'agama' => $this->input->post('agama'),
				'created_by' => $this->userdata->nama,
				'created_at' => date('Y-m-d H:i:s')
			);
		$insert = $this->magama->add($data);            
		echo json_encode($insert);
	}

	public function update() {
		$data = array(
				'agama' => $this->input->post('agama'),
				'created_by' => $this->input->post('created_by'),
                'created_at' => $this->input->post('created_at'),
                'update_by' => $this->userdata->nama,
                'update_at' => date('Y-m-d H:i:s')
			);
		$edit = $this->magama->edit(array('kd_agama' => $this->input->post('kd_agama')), $data);           
		echo json_encode($edit);
	}

	public function delete($id){
        $del = $this->magama->delete_by_id($id); 
        if($del){
            echo json_encode(array("status" => TRUE));            
        }else{
            echo json_encode(array("status" => FALSE));
        }     
    }

    public function printpdf() {
        $data['data_list'] = $this->magama->select_all();
        $data['judul'] = 'List Agama';
        $html = $this->load->view('ref_pasien/agama/print', $data, true);
        $pdfFilePath = "list agama.pdf";
        $this->load->library('m_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }

    public function export() {
        error_reporting(E_ALL);    
        include_once './assets/phpexcel/Classes/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $data = $this->magama->select_all();
        $objPHPExcel = new PHPExcel(); 
        $objPHPExcel->setActiveSheetIndex(0); 
        $rowCount = 1; 
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "KD "); 
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "Agama");
        $rowCount++;
        foreach($data as $value){
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $value->kd_agama); 
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $value->agama); 
            $rowCount++; 
        } 
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
        $objWriter->save('./assets/excel/List Agama.xlsx'); 
        $this->load->helper('download');
        force_download('./assets/excel/List Agama.xlsx', NULL);
    }

}