<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Golongan_darah extends AUTH_Controller  {

	public function __construct() {
		parent::__construct();
        $this->load->model('M_golongan_darah', 'mgol');
	}

	public function index(){
		$data['page'] = "Golongan_darah";
		$data['userdata'] = $this->userdata;
        $data['access'] = $this->is_access;
		$data['modal_view'] = show_my_modal('ref_pasien/golongan_darah/view', 'modal_view', $data);
		$data['modal_crud'] = show_my_modal('ref_pasien/golongan_darah/crud', 'modal_crud', $data);
		$this->template->views('ref_pasien/golongan_darah/main_golongan_darah', $data);
	}

	public function dataTable(){
	  	$post = $this->input->post();
	  	$data = $this->mgol->dataTable($post);
	  	$results = array(
			"draw" => $this->input->post("draw"),
			"iTotalDisplayRecords" => $data["total"],
			"aaData"=>$data["rows"]);
	   	echo json_encode($results);	
	}

	public function view(){
        $id = $this->input->post('id');
        $data = $this->mgol->view($id);
        echo json_encode($data);
    }

    public function filename_exists(){
        $id = $this->input->post('id');
        $data = $this->mgol->filename_exists($id);
        if ($data == TRUE) {
            echo 'error';
        }
    }

    public function add() {
		$data = array(
				'kd_golongan_darah' => $this->input->post('kd_golongan_darah'),
				'golongan_darah' => $this->input->post('golongan_darah'),
				'created_by' => $this->userdata->nama,
				'created_at' => date('Y-m-d H:i:s')
			);
		$insert = $this->mgol->add($data);            
		echo json_encode($insert);
	}

	public function update() {
		$data = array(
				'golongan_darah' => $this->input->post('golongan_darah'),
				'created_by' => $this->input->post('created_by'),
                'created_at' => $this->input->post('created_at'),
                'update_by' => $this->userdata->nama,
                'update_at' => date('Y-m-d H:i:s')
			);
		$edit = $this->mgol->edit(array('kd_golongan_darah' => $this->input->post('kd_golongan_darah')), $data);           
		echo json_encode($edit);
	}

	public function delete($id){
        $del = $this->mgol->delete_by_id($id); 
        if($del){
            echo json_encode(array("status" => TRUE));            
        }else{
            echo json_encode(array("status" => FALSE));
        }     
    }

    public function printpdf() {
        $data['data_list'] = $this->mgol->select_all();
        $data['judul'] = 'List Golongan Darah';
        $html = $this->load->view('ref_pasien/golongan_darah/print', $data, true);
        $pdfFilePath = "list Golongan Darah.pdf";
        $this->load->library('m_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }

    public function export() {
        error_reporting(E_ALL);    
        include_once './assets/phpexcel/Classes/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $data = $this->mgol->select_all();
        $objPHPExcel = new PHPExcel(); 
        $objPHPExcel->setActiveSheetIndex(0); 
        $rowCount = 1; 
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "KD"); 
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "Golongan Darah");
        $rowCount++;
        foreach($data as $value){
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $value->kd_golongan_darah); 
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $value->golongan_darah); 
            $rowCount++; 
        } 
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
        $objWriter->save('./assets/excel/Golongan Darah List.xlsx'); 
        $this->load->helper('download');
        force_download('./assets/excel/Golongan Darah List.xlsx', NULL);
    }

}