<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Obat extends AUTH_Controller  {

	public function __construct() {
		parent::__construct();
        $this->load->model('M_obat', 'mobat');
        $this->load->model('M_golongan_obat', 'mgol');
        $this->load->model('M_satuan_kecil', 'mkecil');
        $this->load->model('M_satuan_besar', 'mbesar');
        $this->load->model('M_terapi_obat', 'mterapi');
	}

	public function index(){
		$data['page'] = "Obat";
		$data['userdata'] = $this->userdata;
        $data['access'] = $this->is_access;
        $data['SelectGolongan'] = $this->mgol->select_all();
        $data['SelectSatuanKecil'] = $this->mkecil->select_all();
        $data['SelectSatuanBesar'] = $this->mbesar->select_all();
        $data['SelectTerapi'] = $this->mterapi->select_all();
		$data['modal_view'] = show_my_modal('ref_farmasi/obat/view', 'modal_view', $data);
		$data['modal_crud'] = show_my_modal('ref_farmasi/obat/crud', 'modal_crud', $data);
		$this->template->views('ref_farmasi/obat/main_obat', $data);
	}

	public function dataTable(){
	  	$post = $this->input->post();
	  	$data = $this->mobat->dataTable($post);
	  	$results = array(
			"draw" => $this->input->post("draw"),
			"iTotalDisplayRecords" => $data["total"],
			"aaData"=>$data["rows"]);
	   	echo json_encode($results);	
	}

	public function view(){
        $id = $this->input->post('id');
        $data = $this->mobat->view($id);
        echo json_encode($data);
    }

    public function filename_exists(){
        $id = $this->input->post('id');
        $data = $this->mobat->filename_exists($id);
        if ($data == TRUE) {
            echo 'error';
        }
    }

    public function add() {
        $data = array(
            'kd_obat_val' => $this->input->post('kd_obat_val'), 
            'obat' => $this->input->post('obat'), 
            'golongan_obat_id' => $this->input->post('golongan_obat_id'), 
            'jenis_imunisasi_id' => $this->input->post('jenis_imunisasi_id'), 
            'satuan_kecil_id' => $this->input->post('satuan_kecil_id'), 
            'satuan_besar_id' => $this->input->post('satuan_besar_id'), 
            'terapi_obat_id' => $this->input->post('terapi_obat_id'), 
            'generik' => $this->input->post('generik'), 
            'fraction' => $this->input->post('fraction'), 
            'singkatan' => $this->input->post('singkatan'), 
            'is_default' => $this->input->post('is_default'), 
            'created_by' => $this->userdata->nama,
            'created_at' => date('Y-m-d H:i:s')
        );
		$insert = $this->mobat->add($data);            
		echo json_encode($insert);
	}

	public function update() {
		$data = array(
            'kd_obat_val' => $this->input->post('kd_obat_val'), 
            'obat' => $this->input->post('obat'), 
            'golongan_obat_id' => $this->input->post('golongan_obat_id'), 
            'jenis_imunisasi_id' => $this->input->post('jenis_imunisasi_id'), 
            'satuan_kecil_id' => $this->input->post('satuan_kecil_id'), 
            'satuan_besar_id' => $this->input->post('satuan_besar_id'), 
            'terapi_obat_id' => $this->input->post('terapi_obat_id'), 
            'generik' => $this->input->post('generik'), 
            'fraction' => $this->input->post('fraction'), 
            'singkatan' => $this->input->post('singkatan'), 
            'is_default' => $this->input->post('is_default'), 
			'created_by' => $this->input->post('created_by'),
            'created_at' => $this->input->post('created_at'),
            'update_by' => $this->userdata->nama,
            'update_at' => date('Y-m-d H:i:s')
		);
		$edit = $this->mobat->edit(array('id' => $this->input->post('id')), $data);           
		echo json_encode($edit);
	}

	public function delete($id){
        $del = $this->mobat->delete_by_id($id); 
        if($del){
            echo json_encode(array("obat" => TRUE));            
        }else{
            echo json_encode(array("obat" => FALSE));
        }     
    }

    public function printpdf() {
        $data['data_list'] = $this->mobat->select_all();
        $data['judul'] = 'List Obat';
        $html = $this->load->view('ref_farmasi/obat/print', $data, true);
        $pdfFilePath = "list Obat.pdf";
        $this->load->library('m_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }

    public function export() {
        error_reporting(E_ALL);    
        include_once './assets/phpexcel/Classes/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $data = $this->mobat->select_all();
        $objPHPExcel = new PHPExcel(); 
        $objPHPExcel->setActiveSheetIndex(0); 
        $rowCount = 1; 
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "ID"); 
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "Kode Obat Val");
        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, "Obat");
        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, "Golongan Obat");
        $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, "Jenis Imunisasi");
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "Satuan Kecil");
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, "Satuan Besar");
        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, "Terapi Obat");
        $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, "Generik");
        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, "Fraction");
        $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, "Singkatan");
        $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, "is_default");
        $rowCount++;
        foreach($data as $value){
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $value->id);
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $value->obat);  
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $value->kd_obat_val); 
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $value->golongan_obat_id); 
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $value->objenis_imunisasi_idat); 
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $value->satuan_kecil_id); 
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $value->satuan_besar_id); 
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $value->terapi_obat_id); 
            $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $value->generik); 
            $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $value->fraction); 
            $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $value->singkatan); 
            $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $value->is_default); 
            $rowCount++; 
        } 
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
        $objWriter->save('./assets/excel/List Obat.xlsx'); 
        $this->load->helper('download');
        force_download('./assets/excel/List Obat.xlsx', NULL);
    }

}