<?php

namespace App\Models\Content;

class logSheetSterilizerModel extends \App\Models\BaseModel
{
    
	public function __construct() {
		parent::__construct();
	}

    public function reportSqlString($tdate='' ){

        $sql="SELECT LGSID, UEP,TO_CHAR(TO_DATE('01/01/1970 00:00:00', 'DD/MM/YYYY HH24:MI:SS') + NUMTODSINTERVAL(UEP / 1000,'SECOND'), 'DD/MON/YYYY HH24:MI:SS') TDATE_UEP, COMP_ID, SITE_ID, POSTDT, STZID, STZIN_ST, STZIN_ED, STZIN_MN, STZPRO_ST, STZPRO_ED, STZPRO_MN, STZOUT_ST, STZOUT_ED, STZOUT_MN, STZTM_TOT, STZACC, STZNOTE FROM POM_LGS_STZ
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
			$data_db['TDATE'] = '';
		} else {
			$data_db['TDATE'] =  date("d/M/Y", strtotime($_POST['TDATE']));
		}

        $sqlReport = $this->reportSqlString($data_db['TDATE']);
        
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
        

        $sql = "SELECT * FROM (SELECT LGSID, UEP, TDATE_UEP, COMP_ID, SITE_ID, POSTDT, STZID, STZIN_ST, STZIN_ED, STZIN_MN, STZPRO_ST, STZPRO_ED, STZPRO_MN, STZOUT_ST, STZOUT_ED, STZOUT_MN, STZTM_TOT, STZACC, STZNOTE, ROWNUM AS RNUM FROM ( $mainSql ORDER BY $sort $order) WHERE ROWNUM <= $limit) WHERE RNUM > $offset";
        
        $sql = $this->db->query($sql)->getResultArray();

        $result['rows'] = $sql;
    
        return $result;
    }


    public function dataListExcel()
    {   
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'UEP';
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
