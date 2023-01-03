<?php
namespace App\Models\Builtin;

class RoleModel extends \App\Models\BaseModel
{
	public function __construct() {
		parent::__construct();
		// helper('stringSQLrep'); 
	}
	
	public function getAllModules() {
		
		$sql = 'SELECT * FROM {prefix_portal}module';
		$sql=$this->ubahPrefix($sql);

		return $this->db->query($sql)->getResultArray();
	}
	
	public function getModuleStatus() {
		$sql = 'SELECT * FROM {prefix_portal}module_status';
		$sql=$this->ubahPrefix($sql);

		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	public function listModuleRole() {
		$sql = 'SELECT * FROM {prefix_portal}module_role LEFT JOIN {prefix_portal}module USING(id_module) ORDER BY NAMA_MODULE';
		$sql=$this->ubahPrefix($sql);

		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	public function getAllRole() {
		$sql = 'SELECT * FROM {prefix_portal}role';
		$sql=$this->ubahPrefix($sql);

		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	// EDIT
	public function getRole() {

		$id_role = $this->request->getGet('id');

		$sql = 'SELECT * FROM {prefix_portal}role WHERE id_role = ?';
		$sql=$this->ubahPrefix($sql);

		$result = $this->db->query($sql, [$id_role])->getRowArray();
		if (!$result)
			$result = [];
		return $result;
	}
	
	public function saveData() 
	{
		// $fields = ['ID_ROLE','NAMA_ROLE','JUDUL_ROLE', 'KETERANGAN'];
		// diganti eko karena ID_ROLE menggunakan sequence 26mar22
		$fields = ['NAMA_ROLE','JUDUL_ROLE', 'KETERANGAN','ID_MODULE'];
		// batas diganti eko karena ID_ROLE menggunakan sequence 26mar22

		foreach ($fields as $field) {
			$data_db[$field] = $this->request->getPost($field);
		}
		// $fields['ID_MODULE'] = $this->request->getPost('ID_MODULE') ?: 0;
		
		// Save database
		if ($this->request->getPost('id')) {

			// tambahan eko
			$fields = ['NAMA_ROLE','JUDUL_ROLE', 'KETERANGAN','ID_MODULE'];

			foreach ($fields as $field) {
				$data_db[$field] = $this->request->getPost($field);
			}
			// batas tambahan eko

			$id_role = $this->request->getPost('id');

			$tablename = '{prefix_portal}ROLE';
			$tablename=$this->ubahPrefix($tablename);

			$save = $this->db->table($tablename)->update($data_db, ['ID_ROLE' => $id_role]);
		} else {
			$tablename = '{prefix_portal}ROLE';
			$tablename=$this->ubahPrefix($tablename);

			$save = $this->db->table($tablename)->insert($data_db);
			// diganti eko
			// $id_role = $this->db->insertID();
			// $id_role = $this->request->getPost('id_role');

			// baru untuk mencari id_role yang baru masuk 26mar22
			$sqlCari = "SELECT * FROM ROLE WHERE NAMA_ROLE = '".$_POST['NAMA_ROLE']."' AND JUDUL_ROLE = '".$_POST['JUDUL_ROLE']."' AND KETERANGAN = '".$_POST['KETERANGAN']."'";
			$sqlCari=$this->ubahPrefix($sqlCari);
			$resultCari = $this->db->query($sqlCari)->getRowArray();
			$id_role = $resultCari['ID_ROLE'];
			//BATAS  baru untuk mencari id_role yang baru masuk 26mar22
			
		}
		
		if ($save) {
			$result['status'] = 'ok';
			$result['message'] = 'Data berhasil disimpan';
			$result['id_role'] = $id_role;
		} else {
			$result['status'] = 'error';
			$result['message'] = 'Data gagal disimpan';
		}
								
		return $result;
	}
	
	public function deleteData() {
		$tablename = '{prefix_portal}ROLE';
		$tablename=$this->ubahPrefix($tablename);

		$this->db->table($tablename)->delete(['ID_ROLE' => $this->request->getPost('id')]);

		// tambahan eko 15 jun 2022
		$tablename2 = '{prefix_portal}MENU_ROLE';
		$tablename2=$this->ubahPrefix($tablename2);

		$this->db->table($tablename2)->delete(['ID_ROLE' => $this->request->getPost('id')]);

		$tablename3 = '{prefix_portal}MODULE_ROLE';
		$tablename3=$this->ubahPrefix($tablename3);

		$this->db->table($tablename3)->delete(['ID_ROLE' => $this->request->getPost('id')]);

		$tablename4 = '{prefix_portal}USER_ROLE';
		$tablename4=$this->ubahPrefix($tablename4);

		$this->db->table($tablename4)->delete(['ID_ROLE' => $this->request->getPost('id')]);
		//batas tambahan eko 15 jun 2022

		return $this->db->affectedRows();
	}
}
?>