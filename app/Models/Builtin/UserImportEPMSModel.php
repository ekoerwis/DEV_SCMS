<?php

namespace App\Models\Builtin;

class UserImportEPMSModel extends \App\Models\BaseModel
{

	public function __construct() {
		parent::__construct();
		$this->db2 = db_connect("dbtrxi");
        $this->dbApps = db_connect('dbapps');	
	}

    public function dataList() {
            $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
            $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;

            $KEYWORD = isset($_POST['KEYWORD']) ? strval($_POST['KEYWORD']) : '';
            $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'LOGINID';
            $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';

            $limit = $page*$rows;
            $offset = ($page-1)*$rows;
            $result = array();

            $sqlCari = "SELECT LISTAGG(USERNAME,''',''') WITHIN GROUP(ORDER BY USERNAME) AS USERNAME FROM USERS";
            $resultCari =  $this->db->query($sqlCari)->getRowArray();
            $keyCari = "'".$resultCari['USERNAME']."'";

        $sql = "SELECT count(*) AS JUMLAH 
                FROM (
                    SELECT LOGINID, FULLNAME FROM USERPROFILE WHERE ( LOWER(LOGINID) LIKE LOWER('%$KEYWORD%') OR LOWER(FULLNAME) LIKE LOWER('%$KEYWORD%') ) AND LOGINID NOT IN ($keyCari)
                    )";
            
            $sql = $this->dbApps->query($sql)->getRowArray();
            $result["total"] = $sql['JUMLAH'];

            $sql = "SELECT * FROM (
                    SELECT LOGINID, FULLNAME, ROWNUM AS RNUM 
                FROM (
                    SELECT LOGINID, FULLNAME FROM USERPROFILE WHERE ( LOWER(LOGINID) LIKE LOWER('%$KEYWORD%') OR LOWER(FULLNAME) LIKE LOWER('%$KEYWORD%') )  AND LOGINID NOT IN ($keyCari)
            ORDER BY $sort $order
                ) WHERE ROWNUM <= $limit 
            ) WHERE RNUM > $offset";

            $sql = $this->dbApps->query($sql)->getResultArray();
            $result['rows'] = $sql;
        
            return $result;
    }

    public function importProses($data) {
        
        $passDefault = '123456';

        $data_db['EMAIL'] = 'importEPMS@mail.com';
        $data_db['USERNAME'] = $data['LOGINID'];
        $data_db['NAMA'] = $data['FULLNAME'];
        $data_db['PASSWORD'] = password_hash($passDefault, PASSWORD_DEFAULT);
        $data_db['AKTIF'] = 1;

        try {    
            $tablename = 'USERS';
            $input = $this->db->table($tablename)->insert($data_db);
            if ($input) {
                $this->db->query('COMMIT');
                $result = 'ok';
            }
        } catch (\Exception $e) {
            $result = 'error';
            // die($e->getMessage());
        } 

        return $result;
    
    }

}
