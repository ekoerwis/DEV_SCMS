<style>
    #container {
        width: 50px;
        height: 300px;
        line-height: 300px;
        margin-left: 10px;
        border: 2px solid black;

    }
</style>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-xl-3 col-lg-6 col-md-12 border-right-blue-grey border-right-lighten-5">
                <div class="my-1 text-center">
                    <div class="card-content">
                        
                        <div class="col-xl-12 col-lg-12 col-md-12 text-center d-flex justify-content-center border border-dark" style="height:180px;">
                            <!-- <h5 class="" style="color: #FF6384;">Temperature</h5> -->
                            <canvas id="ChartDataFTU" style="width:100%;max-width:600px"></canvas>
                        </div>
                        
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-12 border-right-blue-grey border-right-lighten-5 text-center">
                                <h2 id="dataFTUMIN" class="font-weight-bold"></h2>
                                <span class="" style="color: #00B5B8;">
                                    <span class="ft-arrow-down"></span> Min Today</span>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 border-right-blue-grey border-right-lighten-5 text-center">
                                <h2 id="dataFTUMAX" class="font-weight-bold"></h2>
                                <span class="" style="color: #FF6384;">
                                    <span class="ft-arrow-up"></span> Max Today</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

    var myChart;
    var dataExist;

    function generateDataFTU(dataFTU) {
        
        var xValues = [parseFloat(dataFTU),100-parseFloat(dataFTU)];
        var yValues = [parseFloat(dataFTU),100-parseFloat(dataFTU)];
        var barColors = [
            "#FF6384",
            "#6c757d"
        ];

        var data =  {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                }]
            }

        var dougnutLabel ={
            id:'dougnutLabel',
            afterDatasetsDraw(chart, args, pluginOptions){
                var {ctx, data } = chart;

                // ctx.save();
                var xCoor = chart.getDatasetMeta(0).data[0].x;
                var yCoor = chart.getDatasetMeta(0).data[0].y;

                var ttt=data.labels[0];

                ctx.font = 'bold 30px sans-serif';
                ctx.fillStyle='rgba(54,162, 235,1)';
                ctx.textAlign='center';
                ctx.textBaseLine='middle';
                ctx.fillText(ttt,xCoor,yCoor);
            }
        }

        var config = {
            type: "doughnut",
            data: data,
            options: {
                title: {
                    display: true,
                    text: "World Wide Wine Production 2018"
                },
                // animation: true,
            },
            plugins : [dougnutLabel]
        };


        var ctx = document.getElementById("ChartDataFTU").getContext("2d");


       if(myChart == null){
        
        myChart = new Chart(ctx, config); 
        
        dataExist = parseFloat(dataFTU);

        console.log('status myChart = baru / '+dataExist);


           
       } else {

        console.log(parseFloat(dataExist) +' / '+parseFloat(dataFTU));

        if(dataExist != parseFloat(dataFTU)){
            myChart.destroy();
            myChart = new Chart(ctx, config);    

            dataExist = parseFloat(dataFTU);
        }

        // myChart.destroy();
        // myChart = new Chart(ctx, config);    
       
        // var newDataset = {
        //     label: 'Dataset ' ,
        //     backgroundColor:  [
        //     "#FF6384",
        //     "#6c757d"
        // ],
        //     data: [parseFloat(dataFTU), 100-parseFloat(dataFTU)]
        // };

        // myChart.config.data.datasets[0]=newDataset;
        // myChart.update();
        // console.log('status myChart = lama');
       
    }


        $("#dataFTUMIN").html(12);
        $("#dataFTUMAX").html(90);

    }
</script>

<h3>SMA-MQTT2WEBSOCKET</h3>
<h3>HOST: <a href='DevWebSocket.html'>
        <script>
            document.write("<?= $hostname_mqtt ?>");
        </script>
    </a></h3>
<h3>PORT: <a href='DevWebSocket.html'>
        <script>
            document.write(<?= $port_mqtt ?>);
        </script>
    </a></h3>
<h3>ID CLIENT: <a href='DevWebSocket.html'>
        <script>
            document.write("<?= $clientID_mqtt ?>");
        </script>
    </a></h3>
<h3>TOPIC: <a href='DevWebSocket.html'>
        <script>
            document.write("<?= $topic_mqtt ?>");
        </script>
    </a></h3>
<h3>RANGE PUBLIS DATA 0 - 100</h3>
<p>Temperature</p>
<div id="container">
    <div id="top" style="width: 100%; background-color:white;text-align:center;"></div>
</div>


<script>
    $(document).ready(function() {
        // generateDataFTU(70);

        mqttClient = new Paho.MQTT.Client("<?= $hostname_mqtt ?>", <?= $port_mqtt ?>, "<?= $clientID_mqtt ?>");

        Connect();

        mqttClient.onMessageArrived = MessageArrived;
        mqttClient.onConnectionLost = ConnectionLost;

    });

    /*Initiates a connection to the MQTT broker*/
    function Connect() {
        mqttClient.connect({
            onSuccess: Connected,
            onFailure: ConnectionFailed,
            keepAliveInterval: 10,
            reconnect: true
        });
    }

    /*Callback for successful MQTT connection */
    function Connected() {
        console.log("Connected to broker");
        mqttClient.subscribe("<?= $topic_mqtt ?>");
    }

    /*Callback for failed connection*/
    function ConnectionFailed(res) {
        console.log("Connect failed:" + res.errorMessage);
    }

    /*Callback for lost connection*/
    function ConnectionLost(res) {
        if (res.errorCode !== 0) {
            console.log("Connection lost:" + res.errorMessage);
            Connect();
        }
    }

    /*Callback for incoming message processing */
    function MessageArrived(message) {
        console.log(message.destinationName + " : " + message.payloadString);

        var a = parseInt(message.payloadString);
        var ht = 100 - a;
        document.getElementById("top").style.height = "" + ht + "%";
        document.getElementById("top").innerHTML = message.payloadString + "&#176" + "C";
        document.getElementById("container").style.backgroundColor = "yellow";
        switch (message.payloadString) {
            case "ON":
                displayClass = "on";
                break;
            case "OFF":
                displayClass = "off";
                break;
            default:
                displayClass = "unknown";
        }
        var topic = message.destinationName.split("/");
        if (topic.length == 3) {
            var ioname = topic[1];
            UpdateElement(ioname, displayClass);
        }

        generateDataFTU(message.payloadString);
    }
</script>