<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pendidikan extends AUTH_Controller  {

	public function __construct() {
		parent::__construct();
        $this->load->model('M_pendidikan', 'mpendidikan');
	}

	public function index(){
		$data['page'] = "Pendidikan";
		$data['userdata'] = $this->userdata;
        $data['access'] = $this->is_access;
		$data['modal_view'] = show_my_modal('ref_pasien/pendidikan/view', 'modal_view', $data);
		$data['modal_crud'] = show_my_modal('ref_pasien/pendidikan/crud', 'modal_crud', $data);
		$this->template->views('ref_pasien/pendidikan/main_pendidikan', $data);
	}

	public function dataTable(){
	  	$post = $this->input->post();
	  	$data = $this->mpendidikan->dataTable($post);
	  	$results = array(
			"draw" => $this->input->post("draw"),
			"iTotalDisplayRecords" => $data["total"],
			"aaData"=>$data["rows"]);
	   	echo json_encode($results);	
	}

	public function view(){
        $id = $this->input->post('id');
        $data = $this->mpendidikan->view($id);
        echo json_encode($data);
    }

    public function filename_exists(){
        $id = $this->input->post('id');
        $data = $this->mpendidikan->filename_exists($id);
        if ($data == TRUE) {
            echo 'error';
        }
    }

    public function add() {
		$data = array(
				'pendidikan' => $this->input->post('pendidikan'),
				'created_by' => $this->userdata->nama,
				'created_at' => date('Y-m-d H:i:s')
			);
		$insert = $this->mpendidikan->add($data);            
		echo json_encode($insert);
	}

	public function update() {
		$data = array(
				'pendidikan' => $this->input->post('pendidikan'),
				'created_by' => $this->input->post('created_by'),
                'created_at' => $this->input->post('created_at'),
                'update_by' => $this->userdata->nama,
                'update_at' => date('Y-m-d H:i:s')
			);
		$edit = $this->mpendidikan->edit(array('id' => $this->input->post('id')), $data);           
		echo json_encode($edit);
	}

	public function delete($id){
        $del = $this->mpendidikan->delete_by_id($id); 
        if($del){
            echo json_encode(array("status" => TRUE));            
        }else{
            echo json_encode(array("status" => FALSE));
        }     
    }

    public function printpdf() {
        $data['data_list'] = $this->mpendidikan->select_all();
        $data['judul'] = 'List Pendidikan';
        $html = $this->load->view('ref_pasien/pendidikan/print', $data, true);
        $pdfFilePath = "list Pendidikan.pdf";
        $this->load->library('m_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }

    public function export() {
        error_reporting(E_ALL);    
        include_once './assets/phpexcel/Classes/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $data = $this->mpendidikan->select_all();
        $objPHPExcel = new PHPExcel(); 
        $objPHPExcel->setActiveSheetIndex(0); 
        $rowCount = 1; 
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "ID"); 
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "Pendidikan");
        $rowCount++;
        foreach($data as $value){
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $value->id); 
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $value->pendidikan); 
            $rowCount++; 
        } 
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
        $objWriter->save('./assets/excel/List Pendidikan.xlsx'); 
        $this->load->helper('download');
        force_download('./assets/excel/List Pendidikan.xlsx', NULL);
    }

}