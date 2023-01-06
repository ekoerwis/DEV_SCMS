<?php

namespace App\Models\Content;

class logSheetSterilizerModel extends \App\Models\BaseModel
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
            $w_dt_div = " AND STZID = '$dt_div' ";
        }

        $sql="SELECT LGSID, UEP,
        FS_CONV_UTCUEP2WIB(UEP) TDATE_UEP_DATEF,
        TO_CHAR(FS_CONV_UTCUEP2WIB(UEP),'DD/MON/YYYY HH24:MI:SS')  TDATE_UEP, 
        COMP_ID, SITE_ID, POSTDT, STZID, 
        STZIN_ST, TO_CHAR(STZIN_ST,'HH24:MI') STZIN_ST_TIME, 
        STZIN_ED, TO_CHAR(STZIN_ED,'HH24:MI')STZIN_ED_TIME, 
        STZIN_MN, FLOOR(STZIN_MN) STZIN_MN_2, 
        STZPRO_ST,TO_CHAR(STZPRO_ST,'HH24:MI') STZPRO_ST_TIME,
        STZPRO_ED, TO_CHAR(STZPRO_ED,'HH24:MI') STZPRO_ED_TIME,
        STZPRO_MN, FLOOR(STZPRO_MN) STZPRO_MN_2, 
        STZOUT_ST, TO_CHAR(STZOUT_ST,'HH24:MI') STZOUT_ST_TIME,
        STZOUT_ED, TO_CHAR(STZOUT_ED,'HH24:MI') STZOUT_ED_TIME,
        STZOUT_MN, FLOOR(STZOUT_MN) STZOUT_MN_2, 
        STZTM_TOT, FLOOR(STZIN_MN) + FLOOR(STZPRO_MN) + FLOOR(STZOUT_MN) STZTM_TOT_2, 
        STZACC, STZNOTE FROM POM_LGS_STZ WHERE  ROWNUM > 0 $w_tdate $w_dt_div
        ";

        return $sql;
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
			$TDATE  = '';
		} else {
			$TDATE  =  date("d/M/Y", strtotime($_POST['TDATE']));
		}

        $DT_DIV = isset($_POST['DT_DIV']) ? strval($_POST['DT_DIV']) : '';

        $sqlReport = $this->reportSqlString($TDATE, $DT_DIV );

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
        

        $sql = "SELECT * FROM (SELECT LGSID, 	UEP, 	TDATE_UEP_DATEF, 	TDATE_UEP, 	COMP_ID, 	SITE_ID, 	POSTDT, 	STZID, 	STZIN_ST, 	STZIN_ST_TIME, 	STZIN_ED, 	STZIN_ED_TIME, 	STZIN_MN, 	STZIN_MN_2, 	STZPRO_ST, 	STZPRO_ST_TIME, 	STZPRO_ED, 	STZPRO_ED_TIME, 	STZPRO_MN, 	STZPRO_MN_2, 	STZOUT_ST, 	STZOUT_ST_TIME, 	STZOUT_ED, 	STZOUT_ED_TIME, 	STZOUT_MN, 	STZOUT_MN_2, 	STZTM_TOT, 	STZTM_TOT_2, 	STZACC, 	STZNOTE, 
        ROWNUM AS RNUM FROM ( $mainSql ORDER BY $sort $order) WHERE ROWNUM <= $limit) WHERE RNUM > $offset";
        
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
