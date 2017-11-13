<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_obat extends AUTH_Controller  {

	public function __construct() {
		parent::__construct();
        $this->load->model('M_jenis_obat', 'mjenis_obat');
	}

	public function index(){
		$data['page'] = "Jenis_obat";
		$data['userdata'] = $this->userdata;
        $data['access'] = $this->is_access;
		$data['modal_view'] = show_my_modal('ref_farmasi/jenis_obat/view', 'modal_view', $data);
		$data['modal_crud'] = show_my_modal('ref_farmasi/jenis_obat/crud', 'modal_crud', $data);
		$this->template->views('ref_farmasi/jenis_obat/main_jenis_obat', $data);
	}

	public function dataTable(){
	  	$post = $this->input->post();
	  	$data = $this->mjenis_obat->dataTable($post);
	  	$results = array(
			"draw" => $this->input->post("draw"),
			"iTotalDisplayRecords" => $data["total"],
			"aaData"=>$data["rows"]);
	   	echo json_encode($results);	
	}

	public function view(){
        $id = $this->input->post('id');
        $data = $this->mjenis_obat->view($id);
        echo json_encode($data);
    }

    public function filename_exists(){
        $id = $this->input->post('id');
        $data = $this->mjenis_obat->filename_exists($id);
        if ($data == TRUE) {
            echo 'error';
        }
    }

    public function add() {
		$data = array(
                'kd' => $this->input->post('kd'),
				'jenis_obat' => $this->input->post('jenis_obat'),
				'created_by' => $this->userdata->nama,
				'created_at' => date('Y-m-d H:i:s')
			);
		$insert = $this->mjenis_obat->add($data);            
		echo json_encode($insert);
	}

	public function update() {
		$data = array(
				'jenis_obat' => $this->input->post('jenis_obat'),
				'created_by' => $this->input->post('created_by'),
                'created_at' => $this->input->post('created_at'),
                'update_by' => $this->userdata->nama,
                'update_at' => date('Y-m-d H:i:s')
			);
		$edit = $this->mjenis_obat->edit(array('kd' => $this->input->post('kd')), $data);           
		echo json_encode($edit);
	}

	public function delete($id){
        $del = $this->mjenis_obat->delete_by_id($id); 
        if($del){
            echo json_encode(array("jenis_obat" => TRUE));            
        }else{
            echo json_encode(array("jenis_obat" => FALSE));
        }     
    }

    public function printpdf() {
        $data['data_list'] = $this->mjenis_obat->select_all();
        $data['judul'] = 'List Jenis Obat';
        $html = $this->load->view('ref_farmasi/jenis_obat/print', $data, true);
        $pdfFilePath = "list Jenis Obat.pdf";
        $this->load->library('m_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }

    public function export() {
        error_reporting(E_ALL);    
        include_once './assets/phpexcel/Classes/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $data = $this->mjenis_obat->select_all();
        $objPHPExcel = new PHPExcel(); 
        $objPHPExcel->setActiveSheetIndex(0); 
        $rowCount = 1; 
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "Kode"); 
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "Jenis Obat");
        $rowCount++;
        foreach($data as $value){
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $value->kd); 
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $value->jenis_obat); 
            $rowCount++; 
        } 
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
        $objWriter->save('./assets/excel/List Jenis Obat.xlsx'); 
        $this->load->helper('download');
        force_download('./assets/excel/List Jenis Obat.xlsx', NULL);
    }

}