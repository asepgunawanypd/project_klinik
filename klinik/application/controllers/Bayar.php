<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bayar extends AUTH_Controller  {

	public function __construct() {
		parent::__construct();
        $this->load->model('M_bayar', 'mbayar');
	}

	public function index(){
		$data['page'] = "Bayar";
		$data['userdata'] = $this->userdata;
        $data['access'] = $this->is_access;
		$data['modal_view'] = show_my_modal('rekanan/bayar/view', 'modal_view', $data);
		$data['modal_crud'] = show_my_modal('rekanan/bayar/crud', 'modal_crud', $data);
		$this->template->views('rekanan/bayar/main_bayar', $data);
	}

	public function dataTable(){
	  	$post = $this->input->post();
	  	$data = $this->mbayar->dataTable($post);
	  	$results = array(
			"draw" => $this->input->post("draw"),
			"iTotalDisplayRecords" => $data["total"],
			"aaData"=>$data["rows"]);
	   	echo json_encode($results);	
	}

	public function view(){
        $id = $this->input->post('id');
        $data = $this->mbayar->view($id);
        echo json_encode($data);
    }

    public function filename_exists(){
        $id = $this->input->post('id');
        $data = $this->mbayar->filename_exists($id);
        if ($data == TRUE) {
            echo 'error';
        }
    }

    public function add() {
		$data = array(
				'bayar' => $this->input->post('bayar'),
                'rekanan_id' => $this->input->post('rekanan_id'),
				'created_by' => $this->userdata->nama,
				'created_at' => date('Y-m-d H:i:s')
			);
		$insert = $this->mbayar->add($data);            
		echo json_encode($insert);
	}

	public function update() {
		$data = array(
				'bayar' => $this->input->post('bayar'),
                'rekanan_id' => $this->input->post('rekanan_id'),
				'created_by' => $this->input->post('created_by'),
                'created_at' => $this->input->post('created_at'),
                'update_by' => $this->userdata->nama,
                'update_at' => date('Y-m-d H:i:s')
			);
		$edit = $this->mbayar->edit(array('id' => $this->input->post('id')), $data);           
		echo json_encode($edit);
	}

	public function delete($id){
        $del = $this->mbayar->delete_by_id($id); 
        if($del){
            echo json_encode(array("bayar" => TRUE));            
        }else{
            echo json_encode(array("bayar" => FALSE));
        }     
    }

    public function printpdf() {
        $data['data_list'] = $this->mbayar->select_all();
        $data['judul'] = 'List Cara Bayar';
        $html = $this->load->view('rekanan/bayar/print', $data, true);
        $pdfFilePath = "list Cara Bayar.pdf";
        $this->load->library('m_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }

    public function export() {
        error_reporting(E_ALL);    
        include_once './assets/phpexcel/Classes/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $data = $this->mbayar->select_all();
        $objPHPExcel = new PHPExcel(); 
        $objPHPExcel->setActiveSheetIndex(0); 
        $rowCount = 1; 
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "ID"); 
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "Cara Bayar");
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "Rekanan id");
        $rowCount++;
        foreach($data as $value){
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $value->id); 
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $value->bayar); 
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $value->rekanan_id); 
            $rowCount++; 
        } 
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
        $objWriter->save('./assets/excel/List Cara Bayar.xlsx'); 
        $this->load->helper('download');
        force_download('./assets/excel/List Cara Bayar.xlsx', NULL);
    }

}