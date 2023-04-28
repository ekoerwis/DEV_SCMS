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
            <tr class="trHeadTable1">
                <th rowspan="3" class="thTable1"  width="50px"><b>JAM</b></th>
                <th class="thTable1"  colspan="18"><b>RUNNING HOUR</b></th>
                <!-- <th rowspan="3" field="TMP1" halign="center" data-options="sortable:false,width:60,align:'center' " ><b>PARAF MANDOR</b></th> -->
                <!-- <th rowspan="3" field="TMP1" halign="center" data-options="sortable:false,width:160,align:'center' " ><b>KETERANGAN</b></th> -->
            </tr>
            <tr class="trHeadTable1">
                <th class="thTable1" colspan="2" ><b>DIGESTER NO 1</b></th>
                <th class="thTable1" colspan="2" ><b>DIGESTER NO 2</b></th>
                <th class="thTable1" colspan="2" ><b>DIGESTER NO 3</b></th>
                <th class="thTable1" colspan="2" ><b>DIGESTER NO 4</b></th>
                <th class="thTable1" colspan="2" ><b>DIGESTER NO 5</b></th>
                <th class="thTable1" colspan="2" ><b>DIGESTER NO 6</b></th>
                <th class="thTable1" colspan="2" ><b>CBC 1</b></th>
                <th class="thTable1" colspan="2" ><b>CBC 2</b></th>
                <th class="thTable1" colspan="2" ><b>CBC 3</b></th>
            </tr>
            <tr class="trHeadTable1">
                <th class="thTable1"  width="50px "><b>START</b></th>
                <th class="thTable1"  width="50px "><b>STOP</b></th>
                <th class="thTable1"  width="50px "><b>START</b></th>
                <th class="thTable1"  width="50px "><b>STOP</b></th>
                <th class="thTable1"  width="50px "><b>START</b></th>
                <th class="thTable1"  width="50px "><b>STOP</b></th>
                <th class="thTable1"  width="50px "><b>START</b></th>
                <th class="thTable1"  width="50px "><b>STOP</b></th>
                <th class="thTable1"  width="50px "><b>START</b></th>
                <th class="thTable1"  width="50px "><b>STOP</b></th>
                <th class="thTable1"  width="50px "><b>START</b></th>
                <th class="thTable1"  width="50px "><b>STOP</b></th>
                <th class="thTable1"  width="50px "><b>START</b></th>
                <th class="thTable1"  width="50px "><b>STOP</b></th>
                <th class="thTable1"  width="50px "><b>START</b></th>
                <th class="thTable1"  width="50px "><b>STOP</b></th>
                <th class="thTable1"  width="50px "><b>START</b></th>
                <th class="thTable1"  width="50px "><b>STOP</b></th>
            </tr>
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
                <td class="tdTable1" ><?php if(intval($data_sql[$i]['TMP1']) > 0) { echo 'V'; } ?></td>
                <td class="tdTable1" ><?php if(intval($data_sql[$i]['TMP2']) < 1) { echo 'X'; } ?></td>
                <td class="tdTable1" ><?php if(intval($data_sql[$i]['VCM1']) > 0) { echo 'V'; } ?></td>
                <td class="tdTable1" ><?php if(intval($data_sql[$i]['VCM2']) < 1) { echo 'X'; } ?></td>
                <td class="tdTable1" ><?php if(intval($data_sql[$i]['CSTTMP1']) > 0) { echo 'V'; } ?></td>
                <td class="tdTable1" ><?php if(intval($data_sql[$i]['CSTTMP2']) < 1) { echo 'X'; } ?></td>
                <td class="tdTable1" ><?php if(intval($data_sql[$i]['CSTTMP3']) > 0) { echo 'V'; } ?></td>
                <td class="tdTable1" ><?php if(intval($data_sql[$i]['CSTTMP4']) < 1) { echo 'X'; } ?></td>
                <td class="tdTable1" ><?php if(intval($data_sql[$i]['CSTTMP5']) > 0) { echo 'V'; } ?></td>
                <td class="tdTable1" ><?php if(intval($data_sql[$i]['CSTTMP6']) < 1) { echo 'X'; } ?></td>
                <td class="tdTable1" ><?php if(intval($data_sql[$i]['CSTOLY1']) > 0) { echo 'V'; } ?></td>
                <td class="tdTable1" ><?php if(intval($data_sql[$i]['CSTOLY2']) < 1) { echo 'X'; } ?></td>
                <td class="tdTable1" ><?php if(intval($data_sql[$i]['CSTOLY3']) > 0) { echo 'V'; } ?></td>
                <td class="tdTable1" ><?php if(intval($data_sql[$i]['CSTOLY4']) < 1) { echo 'X'; } ?></td>
                <td class="tdTable1" ><?php if(intval($data_sql[$i]['CSTOLY5']) > 0) { echo 'V'; } ?></td>
                <td class="tdTable1" ><?php if(intval($data_sql[$i]['CSTOLY6']) < 1) { echo 'X'; } ?></td>
                <td class="tdTable1" ><?php if(intval($data_sql[$i]['SDTTMP1']) > 0) { echo 'V'; } ?></td>
                <td class="tdTable1" ><?php if(intval($data_sql[$i]['SDTTMP2']) < 1) { echo 'X'; } ?></td>
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
