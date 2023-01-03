<style type="text/css">
	.datagrid-header .datagrid-cell{
		line-height:normal;
		/* height:auto; */
	    white-space: normal;
	}
</style>
    
    <!--- DATA GRID ------------------------------------------------------------------------->
    <table id="dg" title="" class="easyui-datagrid"  style="<?php  echo $tinggi_dg ; ?>"  url="<?php echo site_url() . '/../Content/logSheetSterilizer/dataList'; ?>" toolbar="#tb-pv" data-options="striped:true,
                    fitColumns:false,
                    pagination:true,
                    pageSize:50,
                    showFooter: true,
                    nowrap:false,
                    singleSelect:true,
                    rownumbers: true,
                    ">
        <thead>
            <tr>
                <th field="STZID" halign="center" data-options="sortable:false,width:80,align:'left' " formatter="" rowspan="2"><b>Fertilizer</b></th>
                <th colspan="2"><b>Buah Masuk</b></th>
                <th field="STZIN_MN" halign="center" data-options="sortable:false,width:80,align:'left' " formatter="" rowspan="2"><b>Waktu (Menit)</b></th>
                <th colspan="2"><b>Merebus</b></th>
                <th field="STZPRO_MN" halign="center" data-options="sortable:false,width:80,align:'left' " formatter="" rowspan="2"><b>Waktu (Menit)</b></th>
                <th colspan="2"><b>Keluar Buah</b></th>
                <th field="STZOUT_MN" halign="center" data-options="sortable:false,width:80,align:'left' " formatter="" rowspan="2"><b>Waktu (Menit)</b></th>
                <th field="STZTM_TOT" halign="center" data-options="sortable:false,width:100,align:'left' " formatter="" rowspan="2"><b>Total Waktu (Menit)</b></th>
                <th field="STZACC" halign="center" data-options="sortable:false,width:100,align:'left' " formatter="" rowspan="2"><b>Paraf Mandor</b></th>
                <th field="STZNOTE" halign="center" data-options="sortable:false,width:200,align:'left' " formatter="" rowspan="2"><b>Keterangan</b></th>
            </tr>
            <tr>
                <th field="STZIN_ST" halign="center" data-options="sortable:false,width:80,align:'left' " formatter=""><b>Start</b></th>
                <th field="STZIN_ED" halign="center" data-options="sortable:false,width:80,align:'left' " formatter=""><b>Stop</b></th>
                <th field="STZPRO_ST" halign="center" data-options="sortable:false,width:80,align:'left' " formatter=""><b>Start</b></th>
                <th field="STZPRO_ED" halign="center" data-options="sortable:false,width:80,align:'left' " formatter=""><b>Stop</b></th>
                <th field="STZOUT_ST" halign="center" data-options="sortable:false,width:80,align:'left' " formatter=""><b>Start</b></th>
                <th field="STZOUT_ED" halign="center" data-options="sortable:false,width:80,align:'left' " formatter=""><b>Stop</b></th>
            </tr>
        </thead>
    </table>

    <div id="tb-pv" class="pb-1 pt-1">        
        <div class='col-xl-12 col-lg-12 col-md-12 row'>
            <div class="col-xl-9 col-lg-9 col-md-9 row">
                <input id="dt-tdate" name="TDATE" class="easyui-datebox" style="width: 200px;"  data-options="required:true">
                <!-- <div class="col-xl-3 col-lg-3 col-md-3 row"> -->
                    <!-- <input id="tb-Year" name="YEARNUMBER" class="easyui-numberbox " style="width: 100px;"  data-options="required:true" prompt="Year"> -->
                    <!-- <input id="cg-MonthNumber" name="MONTHNUMBER" class="easyui-combogrid" style="width: 200px;"  data-options="required:true" prompt="Month"> -->
                    
                <!-- </div> -->
            </div>
            
            <div class=" col-xl-3 col-lg-3 col-md-3  text-right">
                <button id="btn-search" class="btn btn-primary" style="width: 75px;"  onclick="doSearch()"><i class="fas fa-search"></i> Search</button>
                &nbsp;
                <!-- <button id="btn-searchReset" class="btn btn-danger" style="width: 75px;"  onclick="doSearchReset()"><i class="fas fa-eraser"></i> Clear</button> -->
                <!-- &nbsp; -->
                <button id="btn-print" class="btn btn-success" style="width: 75px;" onclick="exportDataExcel()" ><i class="fas fa-print"></i> .Xlsx</button>
            </div>
        </div>

    </div>
    <!-- </form> -->


    <script type="text/javascript">
        $(document).ready(function() {

            settingCalendarTDATE();

            // $('#cg-MonthNumber').combogrid({
            //     panelWidth: 350,
            //     url: "<?php echo site_url() . '/../Content/logSheetSterilizer/getParameterValueByParameterCode?id=GLB04'; ?>",
            //     idField: 'PARAMETERVALUECODE',
            //     textField: 'PARAMETERVALUE',
            //     mode: 'remote',
            //     loadMsg: 'Loading',
            //     pagination: true,
            //     fitColumns: true,
            //     multiple: false,
            //     pageSize:50,
            //     columns: [
            //         [{
            //                 field: 'PARAMETERVALUECODE',
            //                 title: 'Month',
            //                 width: 100
            //             },
            //             {
            //                 field: 'PARAMETERVALUE',
            //                 title: 'Name',
            //                 width: 200
            //             }
            //         ]
            //     ],
            //     onSelect: function(index, row) {
            //     }
            // });


            // doSearch();

        });

        function getMonthName(monthNumber) {
            const date = new Date();
            date.setMonth(monthNumber - 1);

            return date.toLocaleString('en-US', { month: 'short' });
        }


        function settingCalendarTDATE(){

            var d = new Date();
            var enddate = d.setDate(d.getDate() - 1);

            var newD = new Date(enddate);
            // alert(newD.getDate());


            $('#dt-tdate').datebox({
                value :  newD.getDate() + "-"+getMonthName(newD.getMonth()+1) + "-"+newD.getFullYear(),
                // onSelect: function(date){
                // var p_date = date.getDate()+"-"+(date.getMonth()+1) +"-"+date.getFullYear();
                // }
            });

            $('#dt-tdate').datebox().datebox('calendar').calendar('moveTo', new Date(enddate));

            $('#dt-tdate').datebox().datebox('calendar').calendar({
                validator: function(date){
                    var d = new Date();
                    var d2 = d.setDate(d.getDate() - 1);
                    return date <= d2;
                }
            });
        }


        // JS Searching and Reset
        // function doSearch() {

        //     var monthNumber = $('#cg-MonthNumber').combogrid('getValue');
        //     var yearNumber =  $('#tb-Year').numberbox('getValue');

        //     if( monthNumber.trim() == '' || monthNumber.trim() == null ){
        //         alert('"Month" Harus Di Isi Dahulu');
        //         $('#cg-MonthNumber').textbox('textbox').focus();
        //         exit;   
        //     } 

        //     if( yearNumber.trim() == '' || yearNumber.trim() == null ){
        //         alert('"Year" Harus Di Isi Dahulu');
        //         $('#tb-Year').textbox('textbox').focus();
        //         exit;   
        //     } 

        //     $('#dg').datagrid('load', {
        //         MONTHNUMBER: $('#cg-MonthNumber').combogrid('getValue'),
        //         YEARNUMBER: $('#tb-Year').numberbox('getValue'),
        //     });
        // }

        function doSearchReset() {
            // $('#cg-MonthNumber').combogrid('reset');
            // $('#tb-Year').numberbox('reset');

        }

        function formatNumberColumnCostum(val,row){
            // return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            var returnVal ='';
            if(val != null){
                returnVal = parseFloat(val).format(2, 3, ',', '.');
            } 
            return  returnVal;
        }


        function exportDataExcel() {
        
            // var monthNumber = $('#cg-MonthNumber').combogrid('getValue');
            // var yearNumber =  $('#tb-Year').numberbox('getValue');

            // if( monthNumber.trim() == '' || monthNumber.trim() == null ){
            //     alert('"Month" Harus Di Isi Dahulu');
            //     $('#cg-MonthNumber').textbox('textbox').focus();
            //     exit;   
            // } 

            // if( yearNumber.trim() == '' || yearNumber.trim() == null ){
            //     alert('"Year" Harus Di Isi Dahulu');
            //     $('#tb-Year').textbox('textbox').focus();
            //     exit;   
            // } 
            
            // MONTHNUMBER= $('#cg-MonthNumber').combogrid('getValue');
            // YEARNUMBER= $('#tb-Year').numberbox('getValue');

        var url = "<?php  echo site_url() . '/../Content/logSheetSterilizer/exportExcelFile'; ?>";
        window.open(url, "_blank");
    }

    </script>   
