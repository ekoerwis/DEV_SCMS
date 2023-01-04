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
}

.tdTable1 {
    /* border: 1px solid black; */
    border-collapse: collapse;
    border-top: 1px solid black;
    border-right: 1px solid black;
    border-left: 1px solid black;
    /* border-bottom: 1px solid black; */
    
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


<!-- <div id="containerReport" class="card"> -->
<?php //echo isset($PARAM['BUDGETYEAR']) ? strval($PARAM['BUDGETYEAR']) : ''; ?>

<div id="containerReport" class="reportContent">
<?php  if(isset($viewFormat) AND $viewFormat=='Web') {?>
    <div id="tb-pv" class="pb-2">        
        <div class='col-xl-12 col-lg-12 col-md-12 row pt-2 ml-2'>
            <div class="col-xl-9 col-lg-9 col-md-9 row">
            <!-- <form method="post" action=""> -->
                <input id="tb-Year" name="YEARNUMBER" class="easyui-numberbox" style="width:80px;" data-options="required:true" prompt="Year">&nbsp;
                <input id="cg-MonthNumber" name="MONTHNUMBER" class="" style="width: 100px;" data-options="" prompt="Month">&nbsp;
                <input id="cg-SiteID" name="SITE_ID" class="" style="width: 100px;" data-options="" prompt="Site">&nbsp;
                <input id="cg-TargetType" name="TARGETTYPE" class=""  data-options="" style="width: 100px;" prompt="Target Type">                
                <!-- <input id="cg-TargetCode" name="TARGETCODE" class="easyui-combogrid" style="width: 25%;"  data-options="" prompt="Target Code"> -->
            </div>
            
            <div class=" row">
                <button type="submit" name="SubmitSearch" onclick="doSearch()" class="btn btn-primary btnSearch" value="SubmitSearch" style="height:30px;" ><i class="fas fa-search"></i> Search</button>
            <!-- </form> -->
                &nbsp;&nbsp;&nbsp;
                <button  class="btn btn-danger btnResetSearch" onclick="doSearchReset()" style="height:30px;"><i class="fas fa-eraser" ></i> Clear</button>
                &nbsp;&nbsp;&nbsp;
                <!-- <button  class="btn btn-warning " onclick="exportDataPdf()" style="height:30px;"><i class="fas fa-print"></i> *.Pdf</button>
                &nbsp;&nbsp;&nbsp;
                <button id="btn-print" class="btn btn-success btnDownloadXls" style="height:30px;" onclick="exportDataExcel()" ><i class="fas fa-print"></i> .Xlsx</button> -->
                <button  class="btn btn-warning " onclick="exportData('pdf')" style="height:30px;"><i class="fas fa-print"></i> *.Pdf</button>
                &nbsp;&nbsp;&nbsp;
                <button id="btn-print" class="btn btn-success btnDownloadXls" style="height:30px;" onclick="exportData('Spreadsheet')" ><i class="fas fa-print"></i> .Xlsx</button>
            </div>
        </div>

        <hr>
    </div>
<?php } ?>

    
<?php
    if(isset($data_sql)) {
    $jmlData = count($data_sql);
?>

    <table id="dataTable" class="table1">
        <thead >
            <tr class="trHeadTable1">
                <th class="thTable1" rowspan=2 style="border: 1px solid black;border-collapse: collapse;text-align: center;" width="30px">No</th>
                <th class="thTable1" rowspan=2  style="border: 1px solid black;border-collapse: collapse;text-align: center;" width="70px">STERILIZER</th>
                <th class="thTable1" colspan=2 style="border: 1px solid black;border-collapse: collapse;text-align: center;">MASUK BUAH</th>
                <th class="thTable1" rowspan=2  style="border: 1px solid black;border-collapse: collapse;text-align: center;" width="50px">WAKTU (MENIT)</th>
                <th class="thTable1" colspan=2 style="border: 1px solid black;border-collapse: collapse;text-align: center;">MEREBUS</th>
                <th class="thTable1" rowspan=2  style="border: 1px solid black;border-collapse: collapse;text-align: center;" width="50px">WAKTU (MENIT)</th>
                <th class="thTable1" colspan=2 style="border: 1px solid black;border-collapse: collapse;text-align: center;">KELUAR BUAH</th>
                <th class="thTable1" rowspan=2  style="border: 1px solid black;border-collapse: collapse;text-align: center;" width="50px">WAKTU (MENIT)</th>
                <th class="thTable1" rowspan=2  style="border: 1px solid black;border-collapse: collapse;text-align: center;" width="50px">TOTAL WAKTU (MENIT)</th>
                <th class="thTable1" rowspan=2  style="border: 1px solid black;border-collapse: collapse;text-align: center;" width="100px">PARAF MANDOR</th>
                <th class="thTable1" rowspan=2  style="border: 1px solid black;border-collapse: collapse;text-align: center;" width="100px">KETERANGAN</th>
            </tr>
            <tr class="trHeadTable1">
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center;" width="50px">START</th>
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center;" width="50px">STOP</th>
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center;" width="50px">START</th>
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center;" width="50px">STOP</th>
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center;" width="50px">START</th>
                <th class="thTable1" style="border: 1px solid black;border-collapse: collapse;text-align: center;" width="50px">STOP</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // $totalPeriod_debitamountorg=0;
            // $totalSite_debitamountorg=0;
            // $totalYear_debitamountorg=0;
            // $totalPeriod_creditamountorg = 0;
            // $totalSite_creditamountorg = 0;
            // $totalYear_creditamountorg = 0;
            // $totalPeriod_quantity = 0;
            // $totalSite_quantity = 0;
            // $totalYear_quantity = 0;
            // $totalPeriod_mandays = 0;
            // $totalSite_mandays = 0;
            // $totalYear_mandays = 0;
                $numData=0;
                for($i=0;$i < $jmlData;$i++){
                    $numData++;
            ?>
            <tr>
                <td class="tdTable1" style="text-align: center;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?=$numData?></td>
                <td class="tdTable1" style="text-align: right;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= $data_sql[$i]['STZID'] ?></td>
                <td class="tdTable1" style="text-align: right;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= $data_sql[$i]['STZIN_ST'] ?></td>
                <td class="tdTable1" style="text-align: right;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= $data_sql[$i]['STZIN_ED'] ?></td>
                <td class="tdTable1" style="text-align: right;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= $data_sql[$i]['STZIN_MN'] ?></td>
                <td class="tdTable1" style="text-align: right;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= $data_sql[$i]['STZPRO_ST'] ?></td>
                <td class="tdTable1" style="text-align: right;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= $data_sql[$i]['STZPRO_ED'] ?></td>
                <td class="tdTable1" style="text-align: right;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= $data_sql[$i]['STZPRO_MN'] ?></td>
                <td class="tdTable1" style="text-align: right;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= $data_sql[$i]['STZOUT_ST'] ?></td>
                <td class="tdTable1" style="text-align: right;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= $data_sql[$i]['STZOUT_ED'] ?></td>
                <td class="tdTable1" style="text-align: right;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= $data_sql[$i]['STZOUT_MN'] ?></td>
                <td class="tdTable1" style="text-align: right;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= $data_sql[$i]['STZTM_TOT'] ?></td>
                <td class="tdTable1" style="text-align: right;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= $data_sql[$i]['STZACC'] ?></td>
                <td class="tdTable1" style="text-align: right;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?= $data_sql[$i]['STZNOTE'] ?></td>
                <!-- <td class="tdTable1" style="text-align: right;border-collapse: collapse; border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;"><?=number_format((float)$data_sql[$i]['MANDAYS'], 2, '.', ',') ?></td> -->
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
