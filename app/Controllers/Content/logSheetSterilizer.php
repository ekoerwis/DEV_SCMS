<?php

namespace App\Controllers\Content;
use App\Models\Content\logSheetSterilizerModel;
use \Config\App;

use CodeIgniter\HTTP\RequestInterface;
// use App\Models\UserModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;



class logSheetSterilizer extends \App\Controllers\BaseController
{
    public $logSheetSterilizerModel;

	public function __construct() {

		parent::__construct();
		
		$this->logSheetSterilizerModel = new logSheetSterilizerModel;

		$this->data['site_title'] = 'LogSheet Fertilizer ';

		$this->addStyle ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/themes/icon.css');
		// $this->addStyle ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/themes/default/easyui.css');
		$this->addStyle ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/themes/bootstrap/easyui.css');
		$this->addStyle ( $this->config->baseURL . 'public/themes/modern/css/easyui-custom.css');

		$this->addJs ( $this->config->baseURL . 'public/vendors/overlayscrollbars/jquery.overlayScrollbars.min.js');
		$this->addJs ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/jquery.min.js');
		$this->addJs ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/jquery.easyui.min.js');

		$this->addJs ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/extension-datagridview-1.0.1/datagrid-detailview.js');
		$this->addJs ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/extension-datagridview-1.0.1/datagrid-groupview.js');
        $this->addJs ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/datagrid-export-1.0.3/datagrid-export.js');

		$this->addJs ( $this->config->baseURL . 'public/themes/modern/js/easyui-custom.js');
		// tambahan untuk client paging
        $this->addJs($this->config->baseURL . 'public/themes/modern/js/easyui-dg-client-pagination-custom.js');
		
		helper(['cookie', 'form']);
	}

	public function index(){
		$this->cekHakAkses('READ_DATA');
		$data = $this->data;
		// berfungsi untuk nilai otorisasi berdasarkan role
		$data['auth_tambah']=$this->actionUser['CREATE_DATA'];
		$data['auth_ubah']=$this->actionUser['UPDATE_DATA'];
		$data['auth_hapus']=$this->actionUser['DELETE_DATA'];

		$tinggiContent = 0;
		$data['tinggi_dg']='';
		$tinggiContent = $this->session->get('dg_height');
		
		if(intval($tinggiContent) > 0) {
			$data['tinggi_dg']= 'height:'.$tinggiContent.'px';
		}

		$this->view('Content/logSheetSterilizer/logSheetSterilizerView.php', $data);
	}

    public function dataList(){
        $this->cekHakAkses('READ_DATA');
		echo json_encode($this->logSheetSterilizerModel->dataList());        
	}


	public function exportExcelFile()
    {
        $this->cekHakAkses('READ_DATA');
        $data = $this->data;
        $data_parameter = $this->logSheetSterilizerModel->dataListExcel();

        
        if (empty($_GET['TDATE'])) {
			$data_db['TDATE'] = '';
		} else {
			$data_db['TDATE'] =  date("d/M/Y", strtotime($_GET['TDATE']));
		}

        $userOrganisasi = $this->session->get('userOrganisasi');
        $userid = $userOrganisasi['LOGINID'];
        

        $fileName = 'writable/filedownload/logSheetSterilizer_'.$userid.'.xlsx';
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getActiveSheet()->setShowGridlines(false);

        $spreadsheet
        ->getActiveSheet()
        ->getStyle('A5:N6')
        ->getBorders()
        ->getAllBorders()
        ->setBorderStyle(Border::BORDER_THIN);

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(33, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(90, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(73, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(108, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(140, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(220, 'px');

        $spreadsheet->getActiveSheet()->getStyle('A5:N6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A5:N6')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->getStyle('F3:J3')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('F3:J3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        
        $sheet = $spreadsheet->getActiveSheet();
        
        // HEADER
        $sheet->mergeCells('A1:D1');
        $sheet->setCellValue('A1', 'UNION SAMPOERNA TRIPUTRA PERSADA');
        $sheet->mergeCells('A2:D2');
        $sheet->setCellValue('A2', 'PT. SMG');
        $sheet->mergeCells('A3:D3');
        $sheet->setCellValue('A3', 'PALM OIL MILL');

        $sheet->mergeCells('F3:J3');
        $sheet->setCellValue('F3', 'STERILIZER STATION LOG SHEET');

        $sheet->setCellValue('M1', 'HARI/TANGGAL');
        $sheet->setCellValue('M2', 'SHIFT');
        $sheet->setCellValue('M3', 'JAM KERJA');
        
        $sheet->setCellValue('N1', ': '.$data_db['TDATE']);
        $sheet->setCellValue('N2', ': ');
        $sheet->setCellValue('N3', ': ');
        // BATAS HEADER

        // TABLE HEADER
        $sheet->mergeCells('A5:A6');
        $sheet->setCellValue('A5', 'NO');
        $sheet->mergeCells('B5:B6');
        $sheet->setCellValue('B5', 'STERILIZER');
        
        $sheet->mergeCells('C5:D5');
        $sheet->setCellValue('C5', 'BUAH MASUK');
        $sheet->setCellValue('C6', 'START');
        $sheet->setCellValue('D6', 'STOP');
        $sheet->mergeCells('E5:E6');
        $spreadsheet->getActiveSheet()->getStyle('E5:E6')->getAlignment()->setWrapText(true);
        $sheet->setCellValue('E5', 'WAKTU (MENIT)');

        $sheet->mergeCells('F5:G5');
        $sheet->setCellValue('F5', 'BUAH MASUK');
        $sheet->setCellValue('F6', 'START');
        $sheet->setCellValue('G6', 'STOP');
        $sheet->mergeCells('H5:H6');
        $spreadsheet->getActiveSheet()->getStyle('H5:H6')->getAlignment()->setWrapText(true);
        $sheet->setCellValue('H5', 'WAKTU (MENIT)');

        $sheet->mergeCells('I5:J5');
        $sheet->setCellValue('I5', 'BUAH KELUAR');
        $sheet->setCellValue('I6', 'START');
        $sheet->setCellValue('J6', 'STOP');
        $sheet->mergeCells('K5:K6');
        $spreadsheet->getActiveSheet()->getStyle('K5:K6')->getAlignment()->setWrapText(true);
        $sheet->setCellValue('K5', 'WAKTU (MENIT)');

        $sheet->mergeCells('L5:L6');
        $spreadsheet->getActiveSheet()->getStyle('L5:L6')->getAlignment()->setWrapText(true);
        $sheet->setCellValue('L5', 'TOTAL WAKTU (MENIT)');

        $sheet->mergeCells('M5:M6');
        $sheet->setCellValue('M5', 'PARAF MANDOR');

        $sheet->mergeCells('N5:N6');
        $sheet->setCellValue('N5', 'KETERANGAN');

        // BATAS TABLE HEADER

        $rows = 7;

        $numData=0;
        foreach ($data_parameter as $val) {
            $spreadsheet
            ->getActiveSheet()
            ->getStyle('A7:N' . $rows)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

            $numData++;

            $sheet->setCellValue('A' . $rows, $numData);
            $sheet->setCellValue('B' . $rows, $val['STZID']);
            $sheet->setCellValue('C' . $rows, $val['STZIN_ST']);
            $sheet->setCellValue('D' . $rows, $val['STZIN_ED']);
            $sheet->setCellValue('E' . $rows, $val['STZIN_MN']);
            $sheet->setCellValue('F' . $rows, $val['STZPRO_ST']);
            $sheet->setCellValue('G' . $rows, $val['STZPRO_ED']);
            $sheet->setCellValue('H' . $rows, $val['STZPRO_MN']);
            $sheet->setCellValue('I' . $rows, $val['STZOUT_ST']);
            $sheet->setCellValue('J' . $rows, $val['STZOUT_ED']);
            $sheet->setCellValue('K' . $rows, $val['STZOUT_MN']);
            $sheet->setCellValue('L' . $rows, $val['STZTM_TOT']);
            $sheet->setCellValue('M' . $rows, $val['STZACC']);
            $sheet->setCellValue('N' . $rows, $val['STZNOTE']);


            $rows++;
        }

        $writer = new Xlsx($spreadsheet);

        $writer->save($fileName);

        header("Content-Type: application/vnd.ms-excel");

        header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');

        header('Expires: 0');

        header('Cache-Control: must-revalidate');

        header('Pragma: public');

        header('Content-Length:' . filesize($fileName));

        flush();

        readfile($fileName);

        echo "<script>window.close();</script>";

        exit;
    }


	// batas pakai
	
	


		


}
