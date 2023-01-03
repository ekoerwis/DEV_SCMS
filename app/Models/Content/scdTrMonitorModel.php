<?php

namespace App\Models\Content;

class scdTrMonitorModel extends \App\Models\BaseModel
{
    
	public function __construct() {
		parent::__construct();
	}

    public function reportSqlString($monthnumber="",$yearnumber="" ){

        $sql="SELECT CRTTS, CRTBY, UPDTS, UPDBY, TRM, UTC_MW, UTC_MTU, SVRDT, POSTDT, ORG_ID, ORG_CODE, ORG_CODE_PR, DT_ID, DT_UEP, DT_DIV, DT_ADD, DT_VAL, DT_TYPE,
        TO_CHAR(TO_DATE('01/01/1970 00:00:00', 'DD/MM/YYYY HH24:MI:SS') + NUMTODSINTERVAL(DT_UEP / 1000,'SECOND'), 'DD/MON/YYYY HH24:MI:SS') TDATETIME
        FROM SCD_TRMONITOR
        ";
        return $sql;
    }
         
    public function dataList()
    {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'DT_ID';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        
        $userOrganisasi=$this->session->get('userOrganisasi');


        $sess_comp=$userOrganisasi['COMPANYID'];
        $sess_site= $userOrganisasi['COMPANYSITEID'];

        $sqlReport = $this->reportSqlString();
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
        

        $sql = "SELECT * FROM (SELECT CRTTS, CRTBY, UPDTS, UPDBY, TRM, UTC_MW, UTC_MTU, SVRDT, POSTDT, ORG_ID, ORG_CODE, ORG_CODE_PR, DT_ID, DT_UEP, DT_DIV, DT_ADD, DT_VAL, DT_TYPE, TDATETIME, ROWNUM AS RNUM FROM ( $mainSql ORDER BY $sort $order) WHERE ROWNUM <= $limit) WHERE RNUM > $offset";
        
        $sql = $this->db->query($sql)->getResultArray();

        $result['rows'] = $sql;
    
        return $result;
    }


    public function dataListExcel()
    {   
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'DT_ID';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';

        $result = array();

        $sqlReport = $this->reportSqlString();
        $sql = "SELECT * FROM ( $sqlReport ) WHERE ROWNUM > 0
        ORDER BY $sort $order ";
        
        $sql = $this->db->query($sql)->getResultArray();

        $result = $sql;
    
        return $result;
    }

}
