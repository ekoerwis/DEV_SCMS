<?php

namespace App\Controllers\Test;
use App\Models\Test\testDashboardMqttModel;
use \Config\App;

use CodeIgniter\HTTP\RequestInterface;
// use App\Models\UserModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;


class testDashboardMqtt extends \App\Controllers\BaseController
{
    public $testDashboardMqttModel;

	public function __construct() {

		parent::__construct();
		
		$this->testDashboardMqttModel = new testDashboardMqttModel;

		$this->data['site_title'] = 'Historical Pressure Chart ';

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

        
        // mengaktifkan chartJS 2.9.4 pilih salat satu yang perlu diaktifkan 2.9.4 atau versi 4.3.0
        // $this->addJs (  $this->config->baseURL . 'public/vendors/chartJs/2.9.4/Chart.js');
		// mengaktifkan chartJS 4.3.0
        $this->addJs (  $this->config->baseURL . 'public/vendors/chartJs/4.3.0/chart.js');
        $this->addJs (  $this->config->baseURL . 'public/vendors/mqttws/mqttws31.min.js');
        $this->addJs (  $this->config->baseURL . 'public/vendors/mqttws/paramConnectionSMA.js');
		
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

        $data['dataGraph']=$this->testDashboardMqttModel->dataGraph();

		$this->view('Test/testDashboardMqtt/testDashboardMqttView.php', $data);
	}

    public function getData(){
		$this->cekHakAkses('READ_DATA');
		
        echo json_encode($this->testDashboardMqttModel->dataGraph());

	}

	public function getDataBpv(){
		$this->cekHakAkses('READ_DATA');
		
        echo json_encode($this->testDashboardMqttModel->getDataBpv());

	}

	public function getDataTurbin(){
		$this->cekHakAkses('READ_DATA');
		
        echo json_encode($this->testDashboardMqttModel->getDataTurbin());

	}

    // batas pakai


}
