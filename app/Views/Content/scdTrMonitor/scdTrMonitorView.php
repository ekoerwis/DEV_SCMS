<style type="text/css">
	.datagrid-header .datagrid-cell{
		line-height:normal;
		/* height:auto; */
	    white-space: normal;
	}
</style>
    
    <!--- DATA GRID ------------------------------------------------------------------------->
    <table id="dg" title="" class="easyui-datagrid"  style="<?php  echo $tinggi_dg ; ?>"  url="<?php echo site_url() . '/../Content/scdTrMonitor/dataList'; ?>" toolbar="#tb-pv" data-options="striped:true,
                    fitColumns:false,
                    pagination:true,
                    pageSize:50,
                    showFooter: true,
                    nowrap:false,
                    singleSelect:true,
                    ">
        <thead>
            <tr>
                <th field="CRTTS" halign="center" data-options="sortable:false,width:200,align:'left' " formatter=""><b>CRTTS</b></th>
                <th field="CRTBY" halign="center" data-options="sortable:false,width:100,align:'left' " formatter=""><b>CRTBY</b></th>
                <!-- <th field="UPDTS" halign="center" data-options="sortable:false,width:60,align:'left' " formatter=""><b>UPDTS</b></th>
                <th field="UPDBY" halign="center" data-options="sortable:false,width:100,align:'left' " formatter=""><b>UPDBY</b></th> -->
                <!-- <th field="TRM" halign="center" data-options="sortable:false,width:100,align:'left' " formatter=""><b>TRM</b></th> -->
                <!-- <th field="UTC_MW" halign="center" data-options="sortable:false,width:100,align:'left' " formatter=""><b>UTC_MW</b></th>
                <th field="UTC_MTU" halign="center" data-options="sortable:false,width:100,align:'left' " formatter=""><b>UTC_MTU</b></th> -->
                <th field="SVRDT" halign="center" data-options="sortable:false,width:100,align:'left' " formatter=""><b>SVRDT</b></th>
                <th field="POSTDT" halign="center" data-options="sortable:false,width:100,align:'left' " formatter=""><b>POSTDT</b></th>
                <th field="ORG_ID" halign="center" data-options="sortable:false,width:60,align:'left' " formatter=""><b>ORG_ID</b></th>
                <th field="ORG_CODE" halign="center" data-options="sortable:false,width:100,align:'left' " formatter=""><b>ORG_CODE</b></th>
                <th field="ORG_CODE_PR" halign="center" data-options="sortable:false,width:100,align:'left' " formatter=""><b>ORG_CODE_PR</b></th>
                <th field="DT_ID" halign="center" data-options="sortable:false,width:200,align:'left' " formatter=""><b>DT_ID</b></th>
                <th field="DT_UEP" halign="center" data-options="sortable:false,width:100,align:'left' " formatter=""><b>DT_UEP</b></th>
                <th field="DT_DIV" halign="center" data-options="sortable:false,width:80,align:'left' " formatter=""><b>DT_DIV</b></th>
                <th field="DT_ADD" halign="center" data-options="sortable:false,width:100,align:'left' " formatter=""><b>DT_ADD</b></th>
                <th field="DT_VAL" halign="center" data-options="sortable:false,width:80,align:'left' " formatter=""><b>DT_VAL</b></th>
                <th field="DT_TYPE" halign="center" data-options="sortable:false,width:80,align:'left' " formatter=""><b>DT_TYPE</b></th>
                <th field="TDATETIME" halign="center" data-options="sortable:false,width:200,align:'left' " formatter=""><b>TDATETIME</b></th>
            </tr>
        </thead>
    </table>

    <div id="tb-pv" class="pb-1 pt-1">        
        <div class='col-xl-12 col-lg-12 col-md-12 row'>
            <div class="col-xl-9 col-lg-9 col-md-9 row">
                <!-- <div class="col-xl-3 col-lg-3 col-md-3 row"> -->
                    <!-- <input id="tb-Year" name="YEARNUMBER" class="easyui-numberbox " style="width: 100px;"  data-options="required:true" prompt="Year"> -->
                    <!-- <input id="cg-MonthNumber" name="MONTHNUMBER" class="easyui-combogrid" style="width: 200px;"  data-options="required:true" prompt="Month"> -->
                    
                <!-- </div> -->
            </div>
            
            <div class=" col-xl-3 col-lg-3 col-md-3  text-right">
                <!-- <button id="btn-search" class="btn btn-primary" style="width: 75px;"  onclick="doSearch()"><i class="fas fa-search"></i> Search</button> -->
                <!-- &nbsp; -->
                <!-- <button id="btn-searchReset" class="btn btn-danger" style="width: 75px;"  onclick="doSearchReset()"><i class="fas fa-eraser"></i> Clear</button> -->
                <!-- &nbsp; -->
                <button id="btn-print" class="btn btn-success" style="width: 75px;" onclick="exportDataExcel()" ><i class="fas fa-print"></i> .Xlsx</button>
            </div>
        </div>

    </div>
    <!-- </form> -->


    <script type="text/javascript">
        $(document).ready(function() {

            // $('#cg-MonthNumber').combogrid({
            //     panelWidth: 350,
            //     url: "<?php echo site_url() . '/../Content/scdTrMonitor/getParameterValueByParameterCode?id=GLB04'; ?>",
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

        var url = "<?php  echo site_url() . '/../Content/scdTrMonitor/exportExcelFile'; ?>";
        window.open(url, "_blank");
    }

    </script>   
