<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class satuan_besar extends AUTH_Controller  {

	public function __construct() {
		parent::__construct();
        $this->load->model('M_satuan_besar', 'msatuan_besar');
	}

	public function index(){
		$data['page'] = "Satuan_besar";
		$data['userdata'] = $this->userdata;
        $data['access'] = $this->is_access;
		$data['modal_view'] = show_my_modal('ref_farmasi/satuan_besar/view', 'modal_view', $data);
		$data['modal_crud'] = show_my_modal('ref_farmasi/satuan_besar/crud', 'modal_crud', $data);
		$this->template->views('ref_farmasi/satuan_besar/main_satuan_besar', $data);
	}

	public function dataTable(){
	  	$post = $this->input->post();
	  	$data = $this->msatuan_besar->dataTable($post);
	  	$results = array(
			"draw" => $this->input->post("draw"),
			"iTotalDisplayRecords" => $data["total"],
			"aaData"=>$data["rows"]);
	   	echo json_encode($results);	
	}

	public function view(){
        $id = $this->input->post('id');
        $data = $this->msatuan_besar->view($id);
        echo json_encode($data);
    }

    public function filename_exists(){
        $id = $this->input->post('id');
        $data = $this->msatuan_besar->filename_exists($id);
        if ($data == TRUE) {
            echo 'error';
        }
    }

    public function add() {
		$data = array(
                'kd' => $this->input->post('kd'),
				'satuan_besar' => $this->input->post('satuan_besar'),
				'created_by' => $this->userdata->nama,
				'created_at' => date('Y-m-d H:i:s')
			);
		$insert = $this->msatuan_besar->add($data);            
		echo json_encode($insert);
	}

	public function update() {
		$data = array(
				'satuan_besar' => $this->input->post('satuan_besar'),
				'created_by' => $this->input->post('created_by'),
                'created_at' => $this->input->post('created_at'),
                'update_by' => $this->userdata->nama,
                'update_at' => date('Y-m-d H:i:s')
			);
		$edit = $this->msatuan_besar->edit(array('kd' => $this->input->post('kd')), $data);           
		echo json_encode($edit);
	}

	public function delete($id){
        $del = $this->msatuan_besar->delete_by_id($id); 
        if($del){
            echo json_encode(array("satuan_besar" => TRUE));            
        }else{
            echo json_encode(array("satuan_besar" => FALSE));
        }     
    }

    public function printpdf() {
        $data['data_list'] = $this->msatuan_besar->select_all();
        $data['judul'] = 'List Satuan Besar';
        $html = $this->load->view('ref_farmasi/satuan_besar/print', $data, true);
        $pdfFilePath = "list List Satuan Besar.pdf";
        $this->load->library('m_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }

    public function export() {
        error_reporting(E_ALL);    
        include_once './assets/phpexcel/Classes/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $data = $this->msatuan_besar->select_all();
        $objPHPExcel = new PHPExcel(); 
        $objPHPExcel->setActiveSheetIndex(0); 
        $rowCount = 1; 
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "Kode"); 
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "Satuan Besar");
        $rowCount++;
        foreach($data as $value){
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $value->kd); 
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $value->satuan_besar); 
            $rowCount++; 
        } 
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
        $objWriter->save('./assets/excel/List Satuan Besar.xlsx'); 
        $this->load->helper('download');
        force_download('./assets/excel/List Satuan Besar.xlsx', NULL);
    }

}