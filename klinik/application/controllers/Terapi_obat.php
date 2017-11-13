<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class terapi_obat extends AUTH_Controller  {

	public function __construct() {
		parent::__construct();
        $this->load->model('M_terapi_obat', 'mterapi_obat');
	}

	public function index(){
		$data['page'] = "Terapi_obat";
		$data['userdata'] = $this->userdata;
        $data['access'] = $this->is_access;
		$data['modal_view'] = show_my_modal('ref_farmasi/terapi_obat/view', 'modal_view', $data);
		$data['modal_crud'] = show_my_modal('ref_farmasi/terapi_obat/crud', 'modal_crud', $data);
		$this->template->views('ref_farmasi/terapi_obat/main_terapi_obat', $data);
	}

	public function dataTable(){
	  	$post = $this->input->post();
	  	$data = $this->mterapi_obat->dataTable($post);
	  	$results = array(
			"draw" => $this->input->post("draw"),
			"iTotalDisplayRecords" => $data["total"],
			"aaData"=>$data["rows"]);
	   	echo json_encode($results);	
	}

	public function view(){
        $id = $this->input->post('id');
        $data = $this->mterapi_obat->view($id);
        echo json_encode($data);
    }

    public function filename_exists(){
        $id = $this->input->post('id');
        $data = $this->mterapi_obat->filename_exists($id);
        if ($data == TRUE) {
            echo 'error';
        }
    }

    public function add() {
		$data = array(
                'kd' => $this->input->post('kd'),
				'terapi_obat' => $this->input->post('terapi_obat'),
				'created_by' => $this->userdata->nama,
				'created_at' => date('Y-m-d H:i:s')
			);
		$insert = $this->mterapi_obat->add($data);            
		echo json_encode($insert);
	}

	public function update() {
		$data = array(
				'terapi_obat' => $this->input->post('terapi_obat'),
				'created_by' => $this->input->post('created_by'),
                'created_at' => $this->input->post('created_at'),
                'update_by' => $this->userdata->nama,
                'update_at' => date('Y-m-d H:i:s')
			);
		$edit = $this->mterapi_obat->edit(array('kd' => $this->input->post('kd')), $data);           
		echo json_encode($edit);
	}

	public function delete($id){
        $del = $this->mterapi_obat->delete_by_id($id); 
        if($del){
            echo json_encode(array("terapi_obat" => TRUE));            
        }else{
            echo json_encode(array("terapi_obat" => FALSE));
        }     
    }

    public function printpdf() {
        $data['data_list'] = $this->mterapi_obat->select_all();
        $data['judul'] = 'List Terapi Obat';
        $html = $this->load->view('ref_farmasi/terapi_obat/print', $data, true);
        $pdfFilePath = "list List Terapi Obat.pdf";
        $this->load->library('m_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }

    public function export() {
        error_reporting(E_ALL);    
        include_once './assets/phpexcel/Classes/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $data = $this->mterapi_obat->select_all();
        $objPHPExcel = new PHPExcel(); 
        $objPHPExcel->setActiveSheetIndex(0); 
        $rowCount = 1; 
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "Kode"); 
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "Terapi Obat");
        $rowCount++;
        foreach($data as $value){
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $value->kd); 
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $value->terapi_obat); 
            $rowCount++; 
        } 
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
        $objWriter->save('./assets/excel/List Terapi Obat.xlsx'); 
        $this->load->helper('download');
        force_download('./assets/excel/List Terapi Obat.xlsx', NULL);
    }

}