<?php

namespace App\Controllers\Content\LogSheet;
use App\Models\Content\LogSheet\logSheetCPOStorageTankModel;
use \Config\App;

use CodeIgniter\HTTP\RequestInterface;
// use App\Models\UserModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;



class logSheetCPOStorageTank extends \App\Controllers\BaseController
{
    public $logSheetCPOStorageTankModel;

	public function __construct() {

		parent::__construct();
		
		$this->logSheetCPOStorageTankModel = new logSheetCPOStorageTankModel;

		$this->data['site_title'] = 'LogSheet CPO Storage ';

		$this->addStyle ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/themes/icon.css');
		// $this->addStyle ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/themes/default/easyui.css');
		$this->addStyle ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/themes/bootstrap/easyui.css');
		$this->addStyle ( $this->config->baseURL . 'public/themes/modern/css/easyui-custom.css');

		$this->addJs ( $this->config->baseURL . 'public/vendors/overlayscrollbars/jquery.overlayScrollbars.min.js');
		$this->addJs ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/jquery.min.js');
		$this->addJs ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/jquery.easyui.min.js');

		$this->addJs ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/extension-datagridview-1.0.1/datagrid-detailview.js');
		$this->addJs ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/extension-datagridview-1.0.1/datagrid-groupview.js');
        // $this->addJs ( $this->config->baseURL . 'public/vendors/jquery-easyui-1.9.12/datagrid-export-1.0.3/datagrid-export.js');

		$this->addJs ( $this->config->baseURL . 'public/themes/modern/js/easyui-custom.js');
		// tambahan untuk client paging
        $this->addJs($this->config->baseURL . 'public/themes/modern/js/easyui-dg-client-pagination-custom.js');
		
		helper(['cookie', 'form', 'stringSQLrep', 'mpdfCustom']);
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

		$this->view('Content/LogSheet/logSheetCPOStorageTank/logSheetCPOStorageTankView.php', $data);
	}

    public function getStg(){
        $this->cekHakAkses('READ_DATA');
		echo json_encode($this->logSheetCPOStorageTankModel->getStg());     
    }

    public function dataList(){
        $this->cekHakAkses('READ_DATA');
		echo json_encode($this->logSheetCPOStorageTankModel->dataList());        
	}

    

    public function cekDataexportExcelFile(){
        $this->cekHakAkses('READ_DATA');
		echo json_encode($this->logSheetCPOStorageTankModel->dataListExcel());        
	}


	public function exportExcelFile()
    {
        $this->cekHakAkses('READ_DATA');
        $data = $this->data;
        $data_parameter = $this->logSheetCPOStorageTankModel->dataListExcel();

        
        if (empty($_GET['TDATE'])) {
			$data_db['TDATE'] = '';
		} else {
			$data_db['TDATE'] =  date("d-M-y", strtotime($_GET['TDATE']));

            $hari = $this->indonesiaDays(date("l", strtotime($_GET['TDATE'])));
		}

        $userOrganisasi = $this->session->get('userOrganisasi');
        $userid = $userOrganisasi['LOGINID'];

        $titleOrg =$this->logSheetCPOStorageTankModel->getSCD_MA_PARAM('ORG','ORGPRN')[0]['VALSTR'];
        $titleSite =$this->logSheetCPOStorageTankModel->getSCD_MA_PARAM('ORG','ORGSITELONG')[0]['VALSTR'];
        

        $fileName = 'writable/filedownload/logSheetCPOStorageTank_'.$userid.'.xlsx';
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getActiveSheet()->setShowGridlines(false);

        $spreadsheet
        ->getActiveSheet()
        ->getStyle('A5:S6')
        ->getBorders()
        ->getAllBorders()
        ->setBorderStyle(Border::BORDER_THIN);

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(33, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(78, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(55, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(55, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(55, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(55, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(80, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(160, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(55, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(55, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(55, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(55, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(55, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(55, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(55, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(55, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(55, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('R')->setWidth(55, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension('S')->setWidth(55, 'px');

        $spreadsheet->getActiveSheet()->getStyle('A5:S7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A5:S7')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A5:S7')->getAlignment()->setWrapText(true);

        // $spreadsheet->getActiveSheet()->getStyle('F3:J3')->getFont()->setBold(true);
        // $spreadsheet->getActiveSheet()->getStyle('F3:J3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        
        $sheet = $spreadsheet->getActiveSheet();
        
        // HEADER
        $sheet->mergeCells('A1:F1');
        $sheet->setCellValue('A1', $titleOrg);
        $sheet->mergeCells('A2:D2');
        $sheet->setCellValue('A2', $titleSite);
        $sheet->mergeCells('A3:D3');
        $sheet->setCellValue('A3', 'PALM OIL MILL');

        $sheet->mergeCells('E3:O3');
        $sheet->setCellValue('E3', 'CPO STORAGE TANK LOG SHEET');
        $spreadsheet->getActiveSheet()->getStyle('E3:O3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


        $sheet->setCellValue('Q1', 'HARI/TANGGAL');
        $sheet->setCellValue('Q2', 'SHIFT');
        $sheet->setCellValue('Q3', 'JAM KERJA');
        
        $sheet->setCellValue('R1', ': '.$hari.','.$data_db['TDATE']);
        $sheet->setCellValue('R2', ': ');
        $sheet->setCellValue('R3', ': ');
        // BATAS HEADER

        // TABLE HEADER
        $sheet->mergeCells('A5:A7');
        $sheet->setCellValue('A5', 'JAM');
        $sheet->mergeCells('B5:G5');
        $sheet->setCellValue('B5', 'STANDARD');
        
        $sheet->mergeCells('B6:B7');
        $sheet->setCellValue('B6', 'LEVEL cm');
        $sheet->mergeCells('C6:C7');
        $sheet->setCellValue('C6', 'LEVEL mm');
        $sheet->mergeCells('D6:D7');
        $sheet->setCellValue('D6', 'SUHU');
        $sheet->mergeCells('E6:E7');
        $sheet->setCellValue('E6', 'BERAT JENIS');
        $sheet->mergeCells('F6:F7');
        $sheet->setCellValue('F6', 'MUAI RUANG');
        $sheet->mergeCells('G6:G7');
        $sheet->setCellValue('G6', 'BERAT (Kg)');

        $sheet->mergeCells('H5:S5');
        $sheet->setCellValue('H5', 'DATA SAMPLING');
        $sheet->mergeCells('H6:H7');
        $sheet->setCellValue('H6', 'WAKTU');
        $sheet->mergeCells('I6:N6');
        $sheet->setCellValue('I6', 'SUHU INTERNAL');
        $sheet->setCellValue('I7', '1');
        $sheet->setCellValue('J7', '2');
        $sheet->setCellValue('K7', '3');
        $sheet->setCellValue('L7', '4');
        $sheet->setCellValue('M7', '5');
        $sheet->setCellValue('N7', 'AVG');
        
        $sheet->mergeCells('O6:S6');
        $sheet->setCellValue('O6', 'SUHU EKSTERNAL');
        $sheet->setCellValue('O7', '1');
        $sheet->setCellValue('P7', '2');
        $sheet->setCellValue('Q7', '3');
        $sheet->setCellValue('R7', 'SCALA');
        $sheet->setCellValue('S7', 'AVG');

        // BATAS TABLE HEADER

        $rows = 8;

        $numData=0;
        foreach ($data_parameter as $val) {
            $spreadsheet
            ->getActiveSheet()
            ->getStyle('A7:S' . $rows)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

            $numData++;

            // $sheet->setCellValue('A' . $rows, $numData);
            $sheet->setCellValue('A' . $rows, $val['TIME_DISP']);
            $sheet->setCellValue('B' . $rows, $val['STGLVCM']);
            $sheet->setCellValue('C' . $rows, $val['STGLVMM']);
            $sheet->setCellValue('D' . $rows, $val['STGTMPINTAVG']);
            $sheet->setCellValue('E' . $rows, $val['BJ']);
            $sheet->setCellValue('F' . $rows, $val['CORECTIONF']);
            $sheet->setCellValue('G' . $rows, $val['WEIGHT']);
            $sheet->setCellValue('H' . $rows, $val['SUMSTGID_UEP_TIME']);
            $sheet->setCellValue('I' . $rows, $val['STGTMPINT1']);
            $sheet->setCellValue('J' . $rows, $val['STGTMPINT2']);
            $sheet->setCellValue('K' . $rows, $val['STGTMPINT3']);
            $sheet->setCellValue('L' . $rows, $val['STGTMPINT4']);
            $sheet->setCellValue('M' . $rows, $val['STGTMPINT5']);
            $sheet->setCellValue('N' . $rows, $val['STGTMPINTAVG']);
            $sheet->setCellValue('O' . $rows, $val['STGTMPEXT1']);
            $sheet->setCellValue('P' . $rows, $val['STGTMPEXT2']);
            $sheet->setCellValue('Q' . $rows, $val['STGTMPEXT3']);
            $sheet->setCellValue('R' . $rows, $val['STGTMPEXTF']);
            $sheet->setCellValue('S' . $rows, $val['STGTMPEXTAVG']);


            $rows++;
        }

        $spreadsheet->getActiveSheet()->getStyle('A8:S'. $rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('B8:G' . $rows)->getNumberFormat()->setFormatCode('#,##0.00');
        $spreadsheet->getActiveSheet()->getStyle('I8:S' . $rows)->getNumberFormat()->setFormatCode('#,##0.00');
        $spreadsheet->getActiveSheet()->getStyle('A1:A1')->getNumberFormat()->setFormatCode('@');


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

    public function exportPDFFile()
    {
        $this->cekHakAkses('READ_DATA');

        if (empty($_GET['TDATE'])) {
			$TDATE = '';
		} else {
			$TDATE =  date("d-M-y", strtotime($_GET['TDATE']));

            $hari = $this->indonesiaDays(date("l", strtotime($_GET['TDATE'])));
		}

        $STG_ID = isset($_GET['STG_ID']) ? strval($_GET['STG_ID']) : '';

		$data['Judul'] = 'Laporan '.$this->data['site_title'];
		$data['data_sql'] = $this->logSheetCPOStorageTankModel->dataListExcel();

        $titleOrg =$this->logSheetCPOStorageTankModel->getSCD_MA_PARAM('ORG','ORGPRN')[0]['VALSTR'];
        $titleSite =$this->logSheetCPOStorageTankModel->getSCD_MA_PARAM('ORG','ORGSITELONG')[0]['VALSTR'];

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8', 
            'format' => 'A4-L', 
            'setAutoTopMargin' => 'stretch', 
            'setAutoBottomMargin' => 'stretch',
            'shrink_tables_to_fit'=>'false'
        ]);

        // $mpdf->shrink_tables_to_fit=-1;

        $headerPdf = '<table style="width:100%;">
        <tr>
            <td style=" width:33.33%; text-align: left;"> 
                <table style="font-size: 8pt;">
                    <tr><td  style="font-size: 7pt;color: #0000ff;"><b>'.$titleOrg.'</b></td></tr>
                    <tr><td>'.$titleSite.'.</td></tr>
                    <tr><td>PALM OIL MILL</td></tr>
                </table>
            </td>
            <td style="width:33.33%; text-align:center;">  
                CPO STORAGE TANK
                <br>
                '.$STG_ID.'
            </td>
            <td style="width:33.33%; text-align:right;">  
                <table style="float:right;font-size: 8pt;">
                    <tr><td style="text-align:left;">Hari/Tanggal</td><td>:</td><td>'.$hari.', '.$TDATE.'</td></tr>
                    <tr><td style="text-align:left;">Shift</td><td>:</td><td style="text-align:left;">........</td></tr>
                    <tr><td style="text-align:left;">Jam Kerja</td><td>:</td><td style="text-align:left;">........</td></tr>
                </table>
            </td>
        </tr>
        </table>
        <hr style="height:2px;border-width:0;color:gray;background-color:gray">';

        // <tr><td style="text-align:left;">Jam Kerja</td><td>:</td><td>{PAGENO} of {nbpg}</td></tr>

        $mpdf->SetHTMLHeader($headerPdf);

        $footerPdf = '<table style="width:100%;font-size: 6pt; border-collapse: collapse;">
        <tr>
            <td colspan=2 style=" width:12.5%; text-align: center;border: 1px solid black;">Dibuat</td>
            <td colspan=2 style=" width:12.5%; text-align: center;border: 1px solid black;">Diperiksa</td>
            <td style=" width:12.5%; text-align: center;border: 1px solid black;">Disetujui </td>
            <td style=" width:12.5%; text-align: center;border: 1px solid black;">Diketahui</td>
            <td colspan=2 style=" width:12.5%; text-align: center;"> </td>
        </tr>
        <tr>
            <td style=" width:12.5%;height:60px;border: 1px solid black;"></td>
            <td style=" width:12.5%;height:60px;border: 1px solid black;"></td>
            <td style=" width:12.5%;height:60px;border: 1px solid black;"></td>
            <td style=" width:12.5%;height:60px;border: 1px solid black;"></td>
            <td style=" width:12.5%;height:60px;border: 1px solid black;"></td>
            <td style=" width:12.5%;height:60px;border: 1px solid black;"></td>
            <td colspan=2 style="width:12.5%;height:60px; text-align: center;vertical-align: top;">FM Condensate</td>
        </tr>
        <tr>
            <td style=" width:12.5%;text-align: center;border: 1px solid black;">Opt. Proses A</td>
            <td style=" width:12.5%;text-align: center;border: 1px solid black;">Opt. Proses B</td>
            <td style=" width:12.5%;text-align: center;border: 1px solid black;">Ast. Proses A</td>
            <td style=" width:12.5%;text-align: center;border: 1px solid black;">Ast. Proses B</td>
            <td style=" width:12.5%;text-align: center;border: 1px solid black;">Asst Mill</td>
            <td style=" width:12.5%;text-align: center;border: 1px solid black;">Mill Manager</td>
            <td style=" width:12.5%;"></td>
            <td style=" width:12.5%;"></td>
        </tr>
        </table>
        ';

        // <tr><td style="text-align:left;">Jam Kerja</td><td>:</td><td>{PAGENO} of {nbpg}</td></tr>

        // dimatikan karena tidak tahu footernya apa
        // $mpdf->SetHTMLFooter($footerPdf);

        $mpdf->AddPage();

        $html = view('Content/LogSheet/logSheetCPOStorageTank/pdfView.php', $data);
        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output($data['Judul'].'.pdf', 'I'); // opens in browser
        //$mpdf->Output('arjun.pdf','D'); // it downloads the file into the user system, with give name
        //return view('welcome_message');
		
    }

    public function indonesiaDays($longDays=''){

        if($longDays == 'Monday'){
            $indonesiaD = 'Senin';
        } else if($longDays == 'Tuesday'){
            $indonesiaD = 'Selasa';
        }  else if($longDays == 'Wednesday'){
            $indonesiaD = 'Rabu';
        }  else if($longDays == 'Thursday'){
            $indonesiaD = 'Kamis';
        }  else if($longDays == 'Friday'){
            $indonesiaD = 'Jumat';
        }  else if($longDays == 'Saturday'){
            $indonesiaD = 'Sabtu';
        }  else if($longDays == 'Sunday'){
            $indonesiaD = 'Minggu';
        } else {
            $indonesiaD = '';
        }

        return $indonesiaD;
        
    }

	public function cekPdfView(){
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

		echo view('Content/LogSheet/logSheetCPOStorageTank/pdfView.php', $data);
	}


	// batas pakai
	
	


		


}
