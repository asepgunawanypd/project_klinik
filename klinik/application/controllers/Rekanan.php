<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekanan extends AUTH_Controller  {

	public function __construct() {
		parent::__construct();
        $this->load->model('M_rekanan', 'mrekanan');
	}

	public function index(){
		$data['page'] = "Rekanan";
		$data['userdata'] = $this->userdata;
        $data['access'] = $this->is_access;
		$data['modal_view'] = show_my_modal('rekanan/rekanan/view', 'modal_view', $data);
		$data['modal_crud'] = show_my_modal('rekanan/rekanan/crud', 'modal_crud', $data);
		$this->template->views('rekanan/rekanan/main_rekanan', $data);
	}

	public function dataTable(){
	  	$post = $this->input->post();
	  	$data = $this->mrekanan->dataTable($post);
	  	$results = array(
			"draw" => $this->input->post("draw"),
			"iTotalDisplayRecords" => $data["total"],
			"aaData"=>$data["rows"]);
	   	echo json_encode($results);	
	}

	public function view(){
        $id = $this->input->post('id');
        $data = $this->mrekanan->view($id);
        echo json_encode($data);
    }

    public function filename_exists(){
        $id = $this->input->post('id');
        $data = $this->mrekanan->filename_exists($id);
        if ($data == TRUE) {
            echo 'error';
        }
    }

    public function add() {
		$data = array(
				'rekanan' => $this->input->post('rekanan'),
                'account' => $this->input->post('account'),
                'up' => $this->input->post('up'),
                'alamat' => $this->input->post('alamat'),
                'phone' => $this->input->post('phone'),
                'email' => $this->input->post('email'),
				'created_by' => $this->userdata->nama,
				'created_at' => date('Y-m-d H:i:s')
			);
		$insert = $this->mrekanan->add($data);            
		echo json_encode($insert);
	}

	public function update() {
		$data = array(
				'rekanan' => $this->input->post('rekanan'),
                'account' => $this->input->post('account'),
                'up' => $this->input->post('up'),
                'alamat' => $this->input->post('alamat'),
                'phone' => $this->input->post('phone'),
                'email' => $this->input->post('email'),
				'created_by' => $this->input->post('created_by'),
                'created_at' => $this->input->post('created_at'),
                'update_by' => $this->userdata->nama,
                'update_at' => date('Y-m-d H:i:s')
			);
		$edit = $this->mrekanan->edit(array('id' => $this->input->post('id')), $data);           
		echo json_encode($edit);
	}

	public function delete($id){
        $del = $this->mrekanan->delete_by_id($id); 
        if($del){
            echo json_encode(array("rekanan" => TRUE));            
        }else{
            echo json_encode(array("rekanan" => FALSE));
        }     
    }

    public function printpdf() {
        $data['data_list'] = $this->mrekanan->select_all();
        $data['judul'] = 'List Rekanan';
        $html = $this->load->view('rekanan/rekanan/print', $data, true);
        $pdfFilePath = "list Rekanan.pdf";
        $this->load->library('m_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }

    public function export() {
        error_reporting(E_ALL);    
        include_once './assets/phpexcel/Classes/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $data = $this->mrekanan->select_all();
        $objPHPExcel = new PHPExcel(); 
        $objPHPExcel->setActiveSheetIndex(0); 
        $rowCount = 1; 
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "ID"); 
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "Rekanan");
        $rowCount++;
        foreach($data as $value){
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $value->id); 
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $value->rekanan); 
            $rowCount++; 
        } 
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
        $objWriter->save('./assets/excel/List Rekanan.xlsx'); 
        $this->load->helper('download');
        force_download('./assets/excel/List Rekanan.xlsx', NULL);
    }

}