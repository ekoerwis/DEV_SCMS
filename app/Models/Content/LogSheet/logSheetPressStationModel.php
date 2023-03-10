<?php

namespace App\Models\Content\LogSheet;

class logSheetPressStationModel extends \App\Models\BaseModel
{
    
	public function __construct() {
		parent::__construct();
	}

    public function reportSqlString($tdate='' ,$dt_div=''){

        // $w_tdate = " ";
        // $w_dt_div = " ";

        // if($tdate != ""){
        //     $w_tdate = " AND POSTDT = TO_DATE('$tdate','dd/mon/yyyy') ";
        // }
        
        // if($dt_div != ""){
        //     $w_dt_div = " AND STGID = '$dt_div' ";
        // }

        $sql=" SELECT A.TIME_F, A.TIME_DISP, B.LGSID, B.UEP, B.COMP_ID, B.SITE_ID, B.POSTDT, B.PRSID, B.PRSHR, B.LGSID_UEP ,LGSID_UEP_TIME, B.LGSID_UEP_TIME_H, B.LGSID_UEP_TIME_MIN,
        B.PRSDG_TMP1, B.PRSDG_TMP2, B.PRSDG_TMP3, B.PRSDG_TMP4, B.PRSDG_TMP5, B.PRSDG_TMP6,  (PRSDG_TMP1+PRSDG_TMP2+PRSDG_TMP3+PRSDG_TMP4+PRSDG_TMP5+PRSDG_TMP6)/6 PRSDG_TMP_AVG,
        B.PRSDG_AMP1, B.PRSDG_AMP2, B.PRSDG_AMP3, B.PRSDG_AMP4, B.PRSDG_AMP5, B.PRSDG_AMP6,
        B.PRSDG_SRT1, B.PRSDG_SRT2, B.PRSDG_SRT3, B.PRSDG_SRT4, B.PRSDG_SRT5, B.PRSDG_SRT6, 
        B.PRSDG_END1, B.PRSDG_END2, B.PRSDG_END3, B.PRSDG_END4, B.PRSDG_END5, B.PRSDG_END6, 
        B.PRSSP_CNP1, B.PRSSP_CNP2, B.PRSSP_CNP3, B.PRSSP_CNP4, B.PRSSP_CNP5, B.PRSSP_CNP6, 
        B.PRSSP_SRT1, B.PRSSP_SRT2, B.PRSSP_SRT3, B.PRSSP_SRT4, B.PRSSP_SRT5, B.PRSSP_SRT6, 
        B.PRSSP_END1, B.PRSSP_END2, B.PRSSP_END3, B.PRSSP_END4, B.PRSSP_END5, B.PRSSP_END6, 
        B.PRSDG_HMS1, B.PRSDG_HMS2, B.PRSDG_HMS3, B.PRSDG_HMS4, B.PRSDG_HMS5, B.PRSDG_HMS6, 
        B.PRSDG_HMP1, B.PRSDG_HMP2, B.PRSDG_HMP3, B.PRSDG_HMP4, B.PRSDG_HMP5, B.PRSDG_HMP6, 
        B.PRSCB_HMS1, B.PRSCB_HMS2, B.PRSCB_HMS3, B.PRSCB_HMP1, B.PRSCB_HMP2, B.PRSCB_HMP3
                FROM (
                SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'07' TIME_F,'07' TIME_DISP FROM DUAL
                UNION ALL
                SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'08' TIME_F,'08' TIME_DISP FROM DUAL
                UNION ALL
                SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'09' TIME_F,'09' TIME_DISP FROM DUAL
                UNION ALL
                SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'10' TIME_F,'10' TIME_DISP FROM DUAL
                UNION ALL
                SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'11' TIME_F,'11' TIME_DISP FROM DUAL
                UNION ALL
                SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'12' TIME_F,'12' TIME_DISP FROM DUAL
                UNION ALL
                SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'13' TIME_F,'13' TIME_DISP FROM DUAL
                UNION ALL
                SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'14' TIME_F,'14' TIME_DISP FROM DUAL
                UNION ALL
                SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'15' TIME_F,'15' TIME_DISP FROM DUAL
                UNION ALL
                SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'16' TIME_F,'16' TIME_DISP FROM DUAL
                UNION ALL
                SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'17' TIME_F,'17' TIME_DISP FROM DUAL
                UNION ALL
                SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'18' TIME_F,'18' TIME_DISP FROM DUAL
                UNION ALL
                SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'19' TIME_F,'19' TIME_DISP FROM DUAL
                UNION ALL
                SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'20' TIME_F,'20' TIME_DISP FROM DUAL
                UNION ALL
                SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'21' TIME_F,'21' TIME_DISP FROM DUAL
                UNION ALL
                SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'22' TIME_F,'22' TIME_DISP FROM DUAL
                UNION ALL
                SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy'),'DDMONYY')||'23' TIME_F,'23' TIME_DISP FROM DUAL
                UNION ALL
                SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy') + INTERVAL '1' DAY,'DDMONYY')||'00' TIME_F,'00' TIME_DISP FROM DUAL
                UNION ALL
                SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy') + INTERVAL '1' DAY,'DDMONYY')||'01' TIME_F,'01' TIME_DISP FROM DUAL
                UNION ALL
                SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy') + INTERVAL '1' DAY,'DDMONYY')||'02' TIME_F,'02' TIME_DISP FROM DUAL
                UNION ALL
                SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy') + INTERVAL '1' DAY,'DDMONYY')||'03' TIME_F,'03' TIME_DISP FROM DUAL
                UNION ALL
                SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy') + INTERVAL '1' DAY,'DDMONYY')||'04' TIME_F,'04' TIME_DISP FROM DUAL
                UNION ALL
                SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy') + INTERVAL '1' DAY,'DDMONYY')||'05' TIME_F,'05' TIME_DISP FROM DUAL
                UNION ALL
                SELECT TO_CHAR(TO_DATE('$tdate','dd/mon/yyyy') + INTERVAL '1' DAY,'DDMONYY')||'06' TIME_F,'06' TIME_DISP FROM DUAL
                ) A LEFT JOIN (
        SELECT LGSID, UEP, COMP_ID, SITE_ID, POSTDT, PRSID, PRSHR, LGSID_UEP ,LGSID_UEP_TIME, LGSID_UEP_TIME_H, LGSID_UEP_TIME_MIN,
        PRSDG_TMP1, PRSDG_TMP2, PRSDG_TMP3, PRSDG_TMP4, PRSDG_TMP5, PRSDG_TMP6, 
        PRSDG_AMP1, PRSDG_AMP2, PRSDG_AMP3, PRSDG_AMP4, PRSDG_AMP5, PRSDG_AMP6, 
        PRSDG_SRT1, PRSDG_SRT2, PRSDG_SRT3, PRSDG_SRT4, PRSDG_SRT5, PRSDG_SRT6, 
        PRSDG_END1, PRSDG_END2, PRSDG_END3, PRSDG_END4, PRSDG_END5, PRSDG_END6, 
        PRSSP_CNP1, PRSSP_CNP2, PRSSP_CNP3, PRSSP_CNP4, PRSSP_CNP5, PRSSP_CNP6, 
        PRSSP_SRT1, PRSSP_SRT2, PRSSP_SRT3, PRSSP_SRT4, PRSSP_SRT5, PRSSP_SRT6, 
        PRSSP_END1, PRSSP_END2, PRSSP_END3, PRSSP_END4, PRSSP_END5, PRSSP_END6, 
        PRSDG_HMS1, PRSDG_HMS2, PRSDG_HMS3, PRSDG_HMS4, PRSDG_HMS5, PRSDG_HMS6, 
        PRSDG_HMP1, PRSDG_HMP2, PRSDG_HMP3, PRSDG_HMP4, PRSDG_HMP5, PRSDG_HMP6, 
        PRSCB_HMS1, PRSCB_HMS2, PRSCB_HMS3, PRSCB_HMP1, PRSCB_HMP2, PRSCB_HMP3
                FROM (
        SELECT LGSID, UEP, COMP_ID, SITE_ID, POSTDT, PRSID, PRSHR,
        REGEXP_SUBSTR(LGSID,'[^|]+',1,2) LGSID_UEP,
        TO_CHAR(FS_CONV_UTCUEP2WIB(REGEXP_SUBSTR(LGSID,'[^|]+',1,2)),'DD/MON/YYYY HH24:MI:SS')  LGSID_UEP_TIME,
        TO_CHAR(FS_CONV_UTCUEP2WIB(REGEXP_SUBSTR(LGSID,'[^|]+',1,2)),'DDMONYYHH24')  LGSID_UEP_TIME_H,
        MIN(REGEXP_SUBSTR(LGSID,'[^|]+',1,2)) OVER (PARTITION BY TO_CHAR(FS_CONV_UTCUEP2WIB(REGEXP_SUBSTR(LGSID,'[^|]+',1,2)),'DDMONYYHH24')) LGSID_UEP_TIME_MIN,
        PRSDG_TMP1, PRSDG_TMP2, PRSDG_TMP3, PRSDG_TMP4, PRSDG_TMP5, PRSDG_TMP6, 
        PRSDG_AMP1, PRSDG_AMP2, PRSDG_AMP3, PRSDG_AMP4, PRSDG_AMP5, PRSDG_AMP6, 
        PRSDG_SRT1, PRSDG_SRT2, PRSDG_SRT3, PRSDG_SRT4, PRSDG_SRT5, PRSDG_SRT6, 
        PRSDG_END1, PRSDG_END2, PRSDG_END3, PRSDG_END4, PRSDG_END5, PRSDG_END6, 
        PRSSP_CNP1, PRSSP_CNP2, PRSSP_CNP3, PRSSP_CNP4, PRSSP_CNP5, PRSSP_CNP6, 
        PRSSP_SRT1, PRSSP_SRT2, PRSSP_SRT3, PRSSP_SRT4, PRSSP_SRT5, PRSSP_SRT6, 
        PRSSP_END1, PRSSP_END2, PRSSP_END3, PRSSP_END4, PRSSP_END5, PRSSP_END6, 
        PRSDG_HMS1, PRSDG_HMS2, PRSDG_HMS3, PRSDG_HMS4, PRSDG_HMS5, PRSDG_HMS6, 
        PRSDG_HMP1, PRSDG_HMP2, PRSDG_HMP3, PRSDG_HMP4, PRSDG_HMP5, PRSDG_HMP6, 
        PRSCB_HMS1, PRSCB_HMS2, PRSCB_HMS3, PRSCB_HMP1, PRSCB_HMP2, PRSCB_HMP3
        FROM POM_LGS_PRS WHERE  ROWNUM > 0 AND POSTDT = TO_DATE('$tdate','dd/mon/yyyy')
        ) WHERE LGSID_UEP_TIME_MIN = LGSID_UEP
        ) B
                ON A.TIME_F = B.LGSID_UEP_TIME_H
                ORDER BY A.TIME_F
        ";

        return $sql;
    }

    // public function getStg()
    // {
        
    //     $userOrganisasi=$this->session->get('userOrganisasi');
    //     $sess_comp=$userOrganisasi['COMPANYID'];
    //     $sess_site= $userOrganisasi['COMPANYSITEID'];        

    //     $sql = " SELECT DISTINCT TRIM(STGID) ID, TRIM(STGID) DESCRIPTION FROM POM_LGS_STG_CPO ORDER BY 1";
        
    //     $sql = $this->db->query($sql)->getResultArray();

    //     $result = $sql;
    
    //     return $result;
    // }
         
    public function dataList()
    {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'TIME_F';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        
        $userOrganisasi=$this->session->get('userOrganisasi');


        $sess_comp=$userOrganisasi['COMPANYID'];
        $sess_site= $userOrganisasi['COMPANYSITEID'];

        if (empty($_POST['TDATE'])) {
			$TDATE  = date("d/M/Y", strtotime('yesterday'));
		} else {
			$TDATE  =  date("d/M/Y", strtotime($_POST['TDATE']));
		}

        $STG_ID = isset($_POST['STG_ID']) ? strval($_POST['STG_ID']) : '';

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
        

        $sql = "SELECT * FROM (SELECT TIME_F, TIME_DISP, LGSID, UEP, COMP_ID, SITE_ID, POSTDT, PRSID, PRSHR, LGSID_UEP ,LGSID_UEP_TIME, LGSID_UEP_TIME_H, LGSID_UEP_TIME_MIN,
        PRSDG_TMP1, PRSDG_TMP2, PRSDG_TMP3, PRSDG_TMP4, PRSDG_TMP5, PRSDG_TMP6, PRSDG_TMP_AVG, 
        PRSDG_AMP1, PRSDG_AMP2, PRSDG_AMP3, PRSDG_AMP4, PRSDG_AMP5, PRSDG_AMP6,
        PRSDG_SRT1, PRSDG_SRT2, PRSDG_SRT3, PRSDG_SRT4, PRSDG_SRT5, PRSDG_SRT6, 
        PRSDG_END1, PRSDG_END2, PRSDG_END3, PRSDG_END4, PRSDG_END5, PRSDG_END6, 
        PRSSP_CNP1, PRSSP_CNP2, PRSSP_CNP3, PRSSP_CNP4, PRSSP_CNP5, PRSSP_CNP6, 
        PRSSP_SRT1, PRSSP_SRT2, PRSSP_SRT3, PRSSP_SRT4, PRSSP_SRT5, PRSSP_SRT6, 
        PRSSP_END1, PRSSP_END2, PRSSP_END3, PRSSP_END4, PRSSP_END5, PRSSP_END6, 
        PRSDG_HMS1, PRSDG_HMS2, PRSDG_HMS3, PRSDG_HMS4, PRSDG_HMS5, PRSDG_HMS6, 
        PRSDG_HMP1, PRSDG_HMP2, PRSDG_HMP3, PRSDG_HMP4, PRSDG_HMP5, PRSDG_HMP6, 
        PRSCB_HMS1, PRSCB_HMS2, PRSCB_HMS3, PRSCB_HMP1, PRSCB_HMP2, PRSCB_HMP3,
        ROWNUM AS RNUM FROM ( $mainSql ORDER BY $sort $order) WHERE ROWNUM <= $limit) WHERE RNUM > $offset";
        
        $sql = $this->db->query($sql)->getResultArray();

        $result['rows'] = $sql;
    
        return $result;
    }


    public function dataListExcel()
    {   
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'TIME_F';
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
