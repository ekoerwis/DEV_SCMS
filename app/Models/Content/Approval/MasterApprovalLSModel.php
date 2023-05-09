<?php

namespace App\Models\Content\Approval;

class MasterApprovalLSModel extends \App\Models\BaseModel
{
    
	public function __construct() {
		parent::__construct();
	}

         
    public function dataList()
    {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'ID';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        

        $MONTHNUMBER = isset($_POST['MONTHNUMBER']) ? intval($_POST['MONTHNUMBER']) : 0;
        $YEARNUMBER = isset($_POST['YEARNUMBER']) ? intval($_POST['YEARNUMBER']) : 0;

        $mainSql="SELECT A.ID, A.IDCONTENT, A.REMARKS, A.MAXLEVEL, A.INACTIVEDATE, B.IDMODULE, B.TABLECONTENT
        , C.ID_MODULE, C.NAMA_MODULE, C.JUDUL_MODULE, C.DESKRIPSI
        FROM MS_APPROVAL_LS_HEADER A, MS_CONTENT_TABLE B, MODULE C
        WHERE A.IDCONTENT = B.ID
        AND B.IDMODULE = C.ID_MODULE";

        $limit = $page*$rows;
        $offset = ($page-1)*$rows;
        $result = array();
        
        $sql = "SELECT count(*) AS JUMLAH FROM 
                (
                    $mainSql
                )";
        $sql = $this->db->query($sql)->getRowArray();
        $result["total"] = $sql['JUMLAH'];
        

        $sql = "SELECT * FROM (SELECT ID, IDCONTENT, REMARKS, MAXLEVEL, INACTIVEDATE, IDMODULE, TABLECONTENT, ID_MODULE, NAMA_MODULE, JUDUL_MODULE, DESKRIPSI, ROWNUM AS RNUM FROM ( $mainSql ORDER BY $sort $order) WHERE ROWNUM <= $limit) WHERE RNUM > $offset";
        
        $dataRow = $this->db->query($sql)->getResultArray();

        // $result['rows'] = $dataRow;

        $dataFull = array();

		// $result['rows'] = $data;
        foreach ($dataRow as $data) {
			$dataDetail['dataDetail'] = $this->getMsApprovalLsDetail($data['ID']);
			$data = array_merge($data, $dataDetail);

			array_push($dataFull, $data);
		}

		$result['rows'] = $dataFull;
    
        return $result;
    }

    public function getMsApprovalLsDetail($ID = '')
	{
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'LVL';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';

		if ($ID == '') {
			$id = isset($_GET['id']) ? strval($_GET['id']) : '';
		} else {
			$id = $ID;
		}

		$mainSql = "SELECT * FROM (
        SELECT A.ID, A.IDHEADER, A.LVL, A.IDROLE, B.NAMA_ROLE, B.JUDUL_ROLE, B.KETERANGAN FROM MS_APPROVAL_LS_DETAIL A , ROLE B WHERE A.IDROLE = B.ID_ROLE AND A.IDHEADER = $id
        ) ORDER BY $sort $order
         ";

		$result = array();

		$result = $this->db->query($mainSql)->getResultArray();

		return $result;
	}

    
	public function getCbContent()
	{
		
		$sql = "SELECT A.ID, A.IDMODULE, A.TABLECONTENT, A.INACTIVEDATE, 
        TO_CHAR(A.INACTIVEDATE,'FXFMDD-Mon-YYYY') INACTIVEDATE2,A.INPUTBY, B.ID_MODULE, B.NAMA_MODULE, B.JUDUL_MODULE, B.DESKRIPSI
        FROM MS_CONTENT_TABLE A, MODULE B
        WHERE A.IDMODULE = B.ID_MODULE
        AND A.ID NOT IN (SELECT IDCONTENT FROM MS_APPROVAL_LS_HEADER) ORDER BY ID";

		$result = $this->db->query($sql)->getResultArray();

		return $result;
	
	}

    
    // batas pakai

    // Fungsi Save  -------------------------------------------------------------
	public function saveData($user_data)
	{
		$ID_MODULE = isset($_POST['ID_MODULE']) ? strval($_POST['ID_MODULE']) : '';
		$TABLECONTENT = isset($_POST['TABLECONTENT']) ? strval($_POST['TABLECONTENT']) : '';
		// $DATECREATED = '';
		// if(!empty($_POST['DATECREATED'])){
		// 	$DATECREATED = date("d/M/Y", strtotime($_POST['DATECREATED']));
		// }


		try {

            $sqlNo = "SELECT MAX(ID)+1 IDNO FROM MS_CONTENT_TABLE";
            $dataIDNO = $this->db->query($sqlNo)->getRowArray()['IDNO'];

            $sess_iduser = $user_data['ID_USER'];

            $sqlInput = "INSERT INTO MS_CONTENT_TABLE (ID, IDMODULE, TABLECONTENT, INPUTBY) VALUES 
            ($dataIDNO, $ID_MODULE ,  '$TABLECONTENT', $sess_iduser)";
            $input = $this->db->query($sqlInput);

            if ($input) {
                $this->db->query('COMMIT');
                $result['msg']['status'] = 'ok';
                $result['msg']['content'] = 'Data Berhasil Disimpan';
                $result['msg']['UNIQUEID'] = $ID_MODULE .' - ' .$TABLECONTENT;
                // $statHeaderMasuk++;
            }
        } catch (\Exception $e) {
            $result['msg']['status'] = 'error';
            $result['msg']['content'] = 'Data Gagal Disimpan : '.$sqlInput;
        }
        

		return $result;
	}

    // Fungsi Delete  -------------------------------------------------------------
		public function deleteData()
		{
	
			$id = isset($_POST['id']) ? strval($_POST['id']) : '';
			
            try {    
                $sqlDelete = "DELETE FROM MS_CONTENT_TABLE WHERE  ID = $id ";
                $delete = $this->db->query($sqlDelete);
    
                if ($delete) {
                    $this->db->query('COMMIT');

                    $this->db->query('COMMIT');
                    $result['msg']['status'] = 'ok';
                    $result['msg']['content'] = 'Proses Delete Berhasil';
                }
            } catch (\Exception $e) {
                $result['msg']['status'] = 'error';
                $result['msg']['content'] = 'Proses Delete Detail Gagal';
                // die($e->getMessage());
            } 
			
			return $result;
		}

    


}
