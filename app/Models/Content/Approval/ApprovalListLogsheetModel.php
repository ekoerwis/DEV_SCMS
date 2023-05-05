<?php

namespace App\Models\Content\Approval;

class ApprovalListLogsheetModel extends \App\Models\BaseModel
{
    
	public function __construct() {
		parent::__construct();
	}

         
    public function dataList($user_data)
    {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'IDMODULE';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        
        $userOrganisasi=$this->session->get('userOrganisasi');

        $sess_comp=$userOrganisasi['COMPANYID'];
        $sess_site= $userOrganisasi['COMPANYSITEID'];

        $sess_iduser = $user_data['ID_USER'];

        $MONTHNUMBER = isset($_POST['MONTHNUMBER']) ? intval($_POST['MONTHNUMBER']) : 0;
        $YEARNUMBER = isset($_POST['YEARNUMBER']) ? intval($_POST['YEARNUMBER']) : 0;

        $mainSql="SELECT * FROM (
            SELECT A.ID, A.IDHEADER, A.LVL, A.IDUSER, B.IDCONTENT, B.REMARKS, B.MAXLEVEL,
            C.IDMODULE, C.TABLECONTENT, D.NAMA_MODULE, D.JUDUL_MODULE, D.DESKRIPSI
            FROM MS_APPROVAL_LS_DETAIL A, MS_APPROVAL_LS_HEADER B, MS_CONTENT_TABLE C, MODULE D
            WHERE A.IDUSER = $sess_iduser 
            AND A.IDHEADER=B.ID
            AND B.IDCONTENT=C.ID
            AND C.IDMODULE = D.ID_MODULE
            AND NVL (B.INACTIVEDATE, TO_DATE ('01-01-2099', 'dd-mm-yyyy')) > SYSDATE
            AND NVL (C.INACTIVEDATE, TO_DATE ('01-01-2099', 'dd-mm-yyyy')) > SYSDATE
        ) WHERE ROWNUM > 0";

        $limit = $page*$rows;
        $offset = ($page-1)*$rows;
        $result = array();
        
    $sql = "SELECT count(*) AS JUMLAH FROM 
                (
                    $mainSql
                )";
        $sql = $this->db->query($sql)->getRowArray();
        $result["total"] = $sql['JUMLAH'];
        

        $sql = "SELECT * FROM (SELECT ID, IDHEADER, LVL, IDUSER, IDCONTENT, REMARKS, MAXLEVEL,
        IDMODULE, TABLECONTENT, NAMA_MODULE, JUDUL_MODULE, DESKRIPSI, ROWNUM AS RNUM FROM ( $mainSql ORDER BY $sort $order) WHERE ROWNUM <= $limit) WHERE RNUM > $offset";
        
        $dataRow = $this->db->query($sql)->getResultArray();

        $dataFull = array();

        foreach ($dataRow as $data) {
			$dataDetail['TOTALLSMONTH'] = $this->getTotalLS($MONTHNUMBER,$YEARNUMBER, $data['TABLECONTENT'])['COUNTDATAMOUNT'];
            $dataDetail['COUNTFINISHLS'] = $this->getCountFinishLS($MONTHNUMBER,$YEARNUMBER, $data['TABLECONTENT'])['COUNTFINISHLS'];
            $dataDetail['UNFINISHLS'] = $dataDetail['TOTALLSMONTH'] - $dataDetail['COUNTFINISHLS'] ;
            $dataDetail['COUNTNEEDACTION'] = $this->getCountNeedActionLS($MONTHNUMBER,$YEARNUMBER, $data['TABLECONTENT'],$data['LVL'])['COUNTNEEDACTION'];
			$data = array_merge($data, $dataDetail);

			array_push($dataFull, $data);
		}

        $result['rows'] = $dataFull;
    
        return $result;
    }

    public function getTotalLS($monthnumber,$yearnumber,  $tablename)
    {   
        $sql = "SELECT COUNT(DISTINCT(POSTDT)) COUNTDATAMOUNT FROM  $tablename WHERE EXTRACT (MONTH FROM POSTDT) = $monthnumber AND EXTRACT (YEAR FROM POSTDT) = $yearnumber";
        
        $sql = $this->db->query($sql)->getRowArray();

        $result = $sql;
    
        return $result;
    }

    public function getCountFinishLS($monthnumber,$yearnumber,  $tablename)
    {   
        $sql = "SELECT COUNT(*) COUNTFINISHLS FROM (
            SELECT X.ID, X.ID_APPROAL_DETAIL, X.LS_POSTDT, X.STATUS, X.REMARKS , A.IDHEADER, A.LVL, A.IDUSER, B.IDCONTENT, B.REMARKS REMARKS_HEADER, B.MAXLEVEL,
            C.IDMODULE, C.TABLECONTENT, D.NAMA_MODULE, D.JUDUL_MODULE, D.DESKRIPSI
            FROM LIST_LS_STATUS_APPROVAL X , MS_APPROVAL_LS_DETAIL A, MS_APPROVAL_LS_HEADER B, MS_CONTENT_TABLE C, MODULE D
            WHERE X.ID_APPROAL_DETAIL = A.ID
            --AND A.LVL >= :P_LVL_USER
            AND A.IDHEADER=B.ID
            AND B.IDCONTENT=C.ID
            AND C.IDMODULE = D.ID_MODULE
            AND  EXTRACT (MONTH FROM LS_POSTDT) = $monthnumber AND EXTRACT (YEAR FROM LS_POSTDT) = $yearnumber
            AND NVL (B.INACTIVEDATE, TO_DATE ('01-01-2099', 'dd-mm-yyyy')) > SYSDATE
            AND NVL (C.INACTIVEDATE, TO_DATE ('01-01-2099', 'dd-mm-yyyy')) > SYSDATE
            ) A ,
            (SELECT MAX(LVL) MAXLVL
            FROM (
            SELECT A.ID, A.IDHEADER, A.LVL, A.IDUSER, B.IDCONTENT, B.REMARKS, B.MAXLEVEL,
            C.IDMODULE, C.TABLECONTENT, D.NAMA_MODULE, D.JUDUL_MODULE, D.DESKRIPSI
            FROM MS_APPROVAL_LS_DETAIL A, MS_APPROVAL_LS_HEADER B, MS_CONTENT_TABLE C, MODULE D
            WHERE 
            --A.IDUSER = :P_ID_USER AND 
            A.IDHEADER=B.ID
            AND B.IDCONTENT=C.ID
            AND C.IDMODULE = D.ID_MODULE
            AND NVL (B.INACTIVEDATE, TO_DATE ('01-01-2099', 'dd-mm-yyyy')) > SYSDATE
            AND NVL (C.INACTIVEDATE, TO_DATE ('01-01-2099', 'dd-mm-yyyy')) > SYSDATE
            ) WHERE TABLECONTENT = '$tablename') B
             WHERE A.TABLECONTENT = '$tablename'
             AND A.LVL = B.MAXLVL";
        
        $sql = $this->db->query($sql)->getRowArray();

        $result = $sql;
    
        return $result;
    }

    public function getCountNeedActionLS($monthnumber,$yearnumber,  $tablename, $lvluser)
    {   
        $sql = "SELECT COUNT(DISTINCT(A.POSTDT)) COUNTNEEDACTION FROM $tablename A 
        WHERE EXTRACT (MONTH FROM A.POSTDT) = $monthnumber 
        AND EXTRACT (YEAR FROM A.POSTDT) = $yearnumber 
        AND A.POSTDT NOT IN  ( SELECT DISTINCT LS_POSTDT FROM (
       SELECT X.ID, X.ID_APPROAL_DETAIL, X.LS_POSTDT, X.STATUS, X.REMARKS , A.IDHEADER, A.LVL, A.IDUSER, B.IDCONTENT, B.REMARKS REMARKS_HEADER, B.MAXLEVEL,
                   C.IDMODULE, C.TABLECONTENT, D.NAMA_MODULE, D.JUDUL_MODULE, D.DESKRIPSI
                   FROM LIST_LS_STATUS_APPROVAL X , MS_APPROVAL_LS_DETAIL A, MS_APPROVAL_LS_HEADER B, MS_CONTENT_TABLE C, MODULE D
                   WHERE X.ID_APPROAL_DETAIL = A.ID
                   AND A.LVL >= $lvluser
                   AND A.IDHEADER=B.ID
                   AND B.IDCONTENT=C.ID
                   AND C.IDMODULE = D.ID_MODULE
                   AND  EXTRACT (MONTH FROM LS_POSTDT) = $monthnumber AND EXTRACT (YEAR FROM LS_POSTDT) = $yearnumber
                   AND NVL (B.INACTIVEDATE, TO_DATE ('01-01-2099', 'dd-mm-yyyy')) > SYSDATE
                   AND NVL (C.INACTIVEDATE, TO_DATE ('01-01-2099', 'dd-mm-yyyy')) > SYSDATE)
                   WHERE TABLECONTENT = '$tablename')";
        
        $sql = $this->db->query($sql)->getRowArray();

        $result = $sql;
    
        return $result;
    }

    // batas pakai


    public function dataListExcel()
    {   
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'UEP';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        

        if (empty($_GET['TDATE'])) {
			$TDATE  = '';
		} else {
			$TDATE  =  date("d/M/Y", strtotime($_GET['TDATE']));
		}

        $DT_DIV = isset($_GET['DT_DIV']) ? strval($_GET['DT_DIV']) : '';

        $result = array();

        $sqlReport = $this->reportSqlString($TDATE, $DT_DIV);
        $sql = "SELECT * FROM ( $sqlReport ) WHERE ROWNUM > 0
        ORDER BY $sort $order ";
        
        $sql = $this->db->query($sql)->getResultArray();

        $result = $sql;
    
        return $result;
    }

}
