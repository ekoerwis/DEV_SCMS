<?php

namespace App\Models\Content\LogSheet;

class logSheetCPOStorageTankModel extends \App\Models\BaseModel
{
    
	public function __construct() {
		parent::__construct();
	}

    public function reportSqlString($tdate='' ,$dt_div=''){

        $w_tdate = " ";
        $w_dt_div = " ";

        if($tdate != ""){
            $w_tdate = " AND POSTDT = '$tdate' ";
        }
        
        if($dt_div != ""){
            $w_dt_div = " AND STGID = '$dt_div' ";
        }

        $sql="
        SELECT SUMSTGID, UEP, COMP_ID, SITE_ID, POSTDT, STGID, STGLV, STGLVMM, STGLVCM, STGTMPINT1, STGTMPINT2, STGTMPINT3, STGTMPINT4, STGTMPINT5, STGTMPINTAVG, STGTMPEXT1, STGTMPEXT2, STGTMPEXT3, STGTMPEXTF, STGTMPEXTAVG, BJ, CORECTIONF, WEIGHT, STGACC, STGNOTE
        FROM POM_LGS_STG_CPO WHERE  ROWNUM > 0  $w_tdate $w_dt_div
        ";

        return $sql;
    }

    public function getStg()
    {
        
        $userOrganisasi=$this->session->get('userOrganisasi');
        $sess_comp=$userOrganisasi['COMPANYID'];
        $sess_site= $userOrganisasi['COMPANYSITEID'];        

        $sql = "SELECT 'ALL' ID, 'ALL' DESCRIPTION FROM DUAL
        UNION ALL
        SELECT DISTINCT STGID , STGID FROM POM_LGS_STG_CPO ";
        
        $sql = $this->db->query($sql)->getResultArray();

        $result = $sql;
    
        return $result;
    }
         
    public function dataList()
    {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'UEP';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        
        $userOrganisasi=$this->session->get('userOrganisasi');


        $sess_comp=$userOrganisasi['COMPANYID'];
        $sess_site= $userOrganisasi['COMPANYSITEID'];

        if (empty($_POST['TDATE'])) {
			$TDATE  = date("d/M/Y", strtotime('yesterday'));
		} else {
			$TDATE  =  date("d/M/Y", strtotime($_POST['TDATE']));
		}

        $STG_ID = isset($_POST['STG_ID']) ? strval($_POST['STG_ID']) : 'ALL';

        $sqlReport = $this->reportSqlString($TDATE, $STG_ID );

        $mainSql="SELECT * FROM ($sqlReport) WHERE ROWNUM > 0";

        $limit = $page*$rows;
        $offset = ($page-1)*$rows;
        $result = array();
        
    $sql = "SELECT count(*) AS JUMLAH FROM 
                (
                    $mainSql
                )";
        $sql = $this->db->query($sql)->getRowArray();
        $result["total"] = $sql['JUMLAH'];
        

        $sql = "SELECT * FROM (SELECT SELECT SUMSTGID, UEP, COMP_ID, SITE_ID, POSTDT, STGID, STGLV, STGLVMM, STGLVCM, STGTMPINT1, STGTMPINT2, STGTMPINT3, STGTMPINT4, STGTMPINT5, STGTMPINTAVG, STGTMPEXT1, STGTMPEXT2, STGTMPEXT3, STGTMPEXTF, STGTMPEXTAVG, BJ, CORECTIONF, WEIGHT, STGACC, STGNOTE, ROWNUM AS RNUM FROM ( $mainSql ORDER BY $sort $order) WHERE ROWNUM <= $limit) WHERE RNUM > $offset";
        
        $sql = $this->db->query($sql)->getResultArray();

        $result['rows'] = $sql;
    
        return $result;
    }


    public function dataListExcel()
    {   
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'UEP';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        

        if (empty($_GET['TDATE'])) {
			$TDATE  = '';
		} else {
			$TDATE  =  date("d/M/Y", strtotime($_GET['TDATE']));
		}

        $STG_ID = isset($_GET['STG_ID']) ? strval($_GET['STG_ID']) : '';

        $result = array();

        $sqlReport = $this->reportSqlString($TDATE, $STG_ID);
        $sql = "SELECT * FROM ( $sqlReport ) WHERE ROWNUM > 0
        ORDER BY $sort $order ";
        
        $sql = $this->db->query($sql)->getResultArray();

        $result = $sql;
    
        return $result;
    }

}
