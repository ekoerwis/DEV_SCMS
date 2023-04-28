<!-- ga tw kenapa xls ga mau baca css di header 18Apr22 -->
<style>
.btnSearch:hover {
  background-color: #4191e1;
}

.btnResetSearch:hover {
  background-color: #e66f7b  ;
}

.btnDownloadXls:hover {
  background-color: #34ce57;
}

.reportContent {
    font-family: serif; 
    font-size: 8pt; 
    background-color: #FFFFFF;
}

.table1{
    border-collapse: collapse;
    border: 1px solid black;
    font-size: 8pt; 
}

.trHeadTable1 {
    border: 1px solid black;
    border-collapse: collapse;
}

.thTable1 {
    border: 1px solid black;
    border-collapse: collapse;
    text-align: center;
    font-size: 7pt;
}

.tdTable1 {
    /* border: 1px solid black; */
    border-collapse: collapse;
    border-top: 1px solid black;
    border-right: 1px solid black;
    border-left: 1px solid black;
    /* border-bottom: 1px solid black; */
    text-align: center;
    
}

.tdTable1LikeRowSpan {
    /* border: 1px solid black; */
    border-collapse: collapse;
    border-right: 1px solid black;
    border-left: 1px solid black;
    /* border-top: 1px solid black; */
    /* border-bottom: 1px solid black; */
}

.tdTable1Aggrt{
    /* border-bottom: 1px solid black; */
    border-collapse: collapse;
    border-top: 1px solid black;
    border-right: 1px solid black;
    border-left: 1px solid black;
    text-align: right;
    background-color: #DEDEDE;
}

.thTable1Aggrt{
    border-collapse: collapse;
    border-top: 1px solid black;
    /* border-bottom: 1px solid black; */
    border-right: 1px solid black;
    border-left: 1px solid black;
    text-align: center;
    background-color: #DEDEDE;
}

</style>

<div id="containerReport" class="reportContent">
    <table id="dataTable" class="table1">
        <thead>
        <!-- class="trHeadTable1" -->
        <!-- class="thTable1" -->
            <tr class="trHeadTable1">
                <th rowspan="4" class="thTable1"  width="50px"><b>JAM</b></th>
                <th class="thTable1" colspan="3"><b>THRESHER</b></th>
                <th class="thTable1" colspan="16"><b>EMPTY BUNCH PRESS</b></th>
                <!-- <th class="thTable1" rowspan="3" field="TMP1" halign="center" data-options="sortable:false,width:60,align:'center' " ><b>PARAF MANDOR</b></th> -->
                <!-- <th class="thTable1" rowspan="3" field="TMP1" halign="center" data-options="sortable:false,width:160,align:'center' " ><b>KETERANGAN</b></th> -->
            </tr>
            <tr class="trHeadTable1">
                <th class="thTable1" rowspan="3" field="TMP1" width="60px"><b>SAMPLE</b></th>
                <th class="thTable1" rowspan="3" field="TMP2" width="60px"><b>USB</b></th>
                <th class="thTable1" rowspan="3" field="VCM1" width="60px"><b>%</b></th>
                <th class="thTable1" colspan="4" ><b>VOLT / AMPERE</b></th>
                <th class="thTable1" colspan="6" ><b>KONDISI GEAR BOX</b></th>
                <th class="thTable1" colspan="2" ><b>POMPA</b></th>
                <th class="thTable1" colspan="4" ><b>HM</b></th>
            </tr>
            <tr class="trHeadTable1">
                <th class="thTable1" rowspan="2" field="VCM2" width="60px"><b>EBP I</b></th>
                <th class="thTable1" rowspan="2" field="CSTTMP1" width="60px"><b>EBP I</b></th>
                <th class="thTable1" rowspan="2" field="CSTTMP2" width="60px"><b>EBP II</b></th>
                <th class="thTable1" rowspan="2" field="CSTTMP3" width="60px"><b>EBP II</b></th>
                <th class="thTable1" colspan="3" ><b>EBP I</b></th>
                <th class="thTable1" colspan="3" ><b>EBP II</b></th>
                <th class="thTable1" rowspan="2" field="CSTTMP4" width="60px"><b>NO. 1</b></th>
                <th class="thTable1" rowspan="2" field="CSTTMP5" width="60px"><b>NO. 2</b></th>
                <th class="thTable1" colspan="2" ><b>EBP I</b></th>
                <th class="thTable1" colspan="2" ><b>EBP II</b></th>
            </tr>
            <tr class="trHeadTable1">
                <th class="thTable1" field="CSTTMP6" width="60px"><b>BAIK</b></th>
                <th class="thTable1" field="CSTOLY1" width="60px"><b>NORMAL</b></th>
                <th class="thTable1" field="CSTOLY2" width="60px"><b>KURANG</b></th>
                <th class="thTable1" field="CSTOLY3" width="60px"><b>BAIK</b></th>
                <th class="thTable1" field="CSTOLY4" width="60px"><b>NORMAL</b></th>
                <th class="thTable1" field="CSTOLY5" width="60px"><b>KURANG</b></th>
                <th class="thTable1" field="CSTOLY6" width="60px"><b>START</b></th>
                <th class="thTable1" field="SDTTMP1" width="60px"><b>STOP</b></th>
                <th class="thTable1" field="SDTTMP2" width="60px"><b>START</b></th>
                <th class="thTable1" field="SDTTMP3" width="60px"><b>STOP</b></th>
            </tr>
        </thead>
        <tbody>
            <?php
                if(isset($data_sql)) {
                $jmlData = count($data_sql);
            ?>
            <?php
                $numData=0;
                for($i=0;$i < $jmlData;$i++){
                    $numData++;
            ?>
            <tr>
                <td class="tdTable1" ><?= $data_sql[$i]['TIME_DISP'] ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['TMP1'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['TMP2'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['VCM1'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['VCM2'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['CSTTMP1'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['CSTTMP2'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['CSTTMP3'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['CSTTMP4'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['CSTTMP5'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['CSTTMP6'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['CSTOLY1'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['CSTOLY2'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['CSTOLY3'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['CSTOLY4'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['CSTOLY5'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['CSTOLY6'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['SDTTMP1'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['SDTTMP2'],2,".",",") ?></td>
                <td class="tdTable1" ><?= number_format($data_sql[$i]['SDTTMP3'],2,".",",") ?></td>
            </tr>
<?php
            
        }
?>
        </tbody>
    </table>
<?php
    }
?>
</div>