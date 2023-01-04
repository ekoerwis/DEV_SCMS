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

        $sql="SELECT LGSID, UEP,TO_DATE( TO_CHAR(FROM_TZ( CAST( (TO_DATE('19700101', 'YYYYMMDD') + ( 1 / 24 / 60 / 60 / 1000) * UEP) AS TIMESTAMP ), 'UTC' ) AT TIME ZONE '+07:00','YYYY-MM-DD HH24:MI:SS') , 'YYYY-MM-DD HH24:MI:SS') TDATE_UEP_DATEF,TO_CHAR(FROM_TZ( CAST( (TO_DATE('19700101', 'YYYYMMDD') + ( 1 / 24 / 60 / 60 / 1000) * UEP) AS TIMESTAMP ), 'UTC' ) AT TIME ZONE '+07:00','DD/MON/YYYY HH24:MI:SS')  TDATE_UEP, COMP_ID, SITE_ID, POSTDT, STZID, STZIN_ST, STZIN_ED, STZIN_MN, STZPRO_ST, STZPRO_ED, STZPRO_MN, STZOUT_ST, STZOUT_ED, STZOUT_MN, STZTM_TOT, STZACC, STZNOTE FROM POM_LGS_STZ WHERE  ROWNUM > 0 $w_tdate $w_dt_div
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
        

        $sql = "SELECT * FROM (SELECT LGSID, UEP, TDATE_UEP_DATEF, TDATE_UEP, COMP_ID, SITE_ID, POSTDT, STZID, STZIN_ST, STZIN_ED, STZIN_MN, STZPRO_ST, STZPRO_ED, STZPRO_MN, STZOUT_ST, STZOUT_ED, STZOUT_MN, STZTM_TOT, STZACC, STZNOTE, ROWNUM AS RNUM FROM ( $mainSql ORDER BY $sort $order) WHERE ROWNUM <= $limit) WHERE RNUM > $offset";
        
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
