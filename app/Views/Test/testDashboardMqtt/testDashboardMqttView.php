<style>
    /* bawaan bang hari */
    /* #container {
        width: 50px;
        height: 300px;
        line-height: 300px;
        margin-left: 10px;
        border: 2px solid black;

    } */
</style>

<div class=" col-xl-3 col-lg-3 col-md-3 col-sm-12">
    <div class="card">
        <div class="card-header text-center" style="padding: 10px 10px 10px 10px;">
            <h4> PRESSURE 1 </h4>
        </div>
        <div class="card-body" style="padding: 10px 10px 10px 10px;">
            <!-- <div class="row"> -->
            <div class="col-xl-12 col-lg-12 col-md-12 ">
                <div class="text-center">
                    <!-- <div class="card-content">  -->

                    <div class="col-xl-12 col-lg-12 col-md-12 text-center " >
                        <div class="text-center"  style="color: #FF6384;"><h5>TEMP &deg; C</h5></div>
                        <div class="d-flex justify-content-center" style="height:200px;"><canvas id="chartDataPRSTMPDIG1" style="width:100%;max-width:600px"></canvas></div>
                    </div>

                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-12  text-center">
                            <h2 id="dataPRSPSSSCP1" class="font-weight-bold"></h2>
                            <span class="" style="color: #00B5B8;">
                                <span class="ft-arrow-down"></span> <b>Press (BAR)</b></span>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12  text-center">
                            <h2 id="dataPRSAMPDIG1" class="font-weight-bold"></h2>
                            <span class="" style="color: #FF6384;">
                                <span class="ft-arrow-up"></span> <b>Dig (AMP)</b></span>
                        </div>
                    </div>
                    <!-- </div> -->
                </div>
            </div>
            <!-- </div> -->
        </div>
    </div>
</div>


<script>
    var myChart;
    var dataExist;

    function generateDataPRSTMPDIG1(dataPRSTMPDIG1) {

        var xValues = [parseFloat(dataPRSTMPDIG1), 100 - parseFloat(dataPRSTMPDIG1).toFixed(2)];
        var yValues = [parseFloat(dataPRSTMPDIG1), 100 - parseFloat(dataPRSTMPDIG1).toFixed(2)];
        var barColors = ["#FF6384", "#6c757d"];

        var data = {
            // labels: xValues,
            datasets: [{
                backgroundColor: barColors,
                data: yValues
            }]
        }

        var dougnutLabel = {
            id: 'dougnutLabel',
            afterDatasetsDraw(chart, args, pluginOptions) {

                var { ctx, data } = chart;

                ctx.save();
                var xCoor = chart.getDatasetMeta(0).data[0].x;
                var yCoor = chart.getDatasetMeta(0).data[0].y;

                var ttt = data.datasets[0].data[0];

                ctx.font = 'bold 26px sans-serif';
                ctx.fillStyle = 'rgba(54,162, 235,1)';
                ctx.textAlign = 'center';
                ctx.textBaseLine = 'middle';
                ctx.fillText(ttt, xCoor, yCoor);
            },
        }

        var config = {
            type: "doughnut",
            data: data,
            options: {
                // plugins:{
                //     title: {
                //         display: false,
                //         text: "ini title text"
                //     },
                //     legend: {
                //         display: false,
                //         text: "ini legend text"
                //     },
                // }

                // animation: true,
            },
            plugins: [dougnutLabel]
        };

        var ctx = document.getElementById("chartDataPRSTMPDIG1").getContext("2d");


        if (myChart == null) {
            myChart = new Chart(ctx, config);
            dataExist = parseFloat(dataPRSTMPDIG1);
            console.log('status myChart = baru / ' + dataExist);
        } else {

            console.log(parseFloat(dataExist) + ' / ' + parseFloat(dataPRSTMPDIG1));

            if (dataExist != parseFloat(dataPRSTMPDIG1)) {
                myChart.destroy();
                myChart = new Chart(ctx, config);

                dataExist = parseFloat(dataPRSTMPDIG1);
            }

        }

    }
</script>
<!-- 
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
            document.write("<?= $topic_mqtt_PRSTMPDIG1 ?>");
        </script>
    </a></h3>
<h3>RANGE PUBLIS DATA 0 - 100</h3>
<p>Temperature</p>
<div id="container">
    <div id="top" style="width: 100%; background-color:white;text-align:center;"></div>
</div> -->


<script>
    $(document).ready(function() {
        // generateDataPRSTMPDIG1(70);

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

        // var messageUnion = [
        mqttClient.subscribe("<?= $topic_mqtt_PRSTMPDIG1 ?>");
        mqttClient.subscribe("<?= $topic_mqtt_PRSPSSSCP1 ?>");
        mqttClient.subscribe("<?= $topic_mqtt_PRSAMPDIG1 ?>");
        // ];
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


        if (message.destinationName == "<?= $topic_mqtt_PRSTMPDIG1 ?>") {
            
            generateDataPRSTMPDIG1(message.payloadString);

            // bawaan bang hari
            // var a = parseInt(message.payloadString);
            // var ht = 100 - a;
            // document.getElementById("top").style.height = "" + ht + "%";
            // document.getElementById("top").innerHTML = message.payloadString + "&#176" + "C";
            // document.getElementById("container").style.backgroundColor = "yellow";
            // switch (message.payloadString) {
            //     case "ON":
            //         displayClass = "on";
            //         break;
            //     case "OFF":
            //         displayClass = "off";
            //         break;
            //     default:
            //         displayClass = "unknown";
            // }
            // var topic = message.destinationName.split("/");
            // if (topic.length == 3) {
            //     var ioname = topic[1];
            //     UpdateElement(ioname, displayClass);
            // }
            // batas bawaan bang hari
        }

        if (message.destinationName == "<?= $topic_mqtt_PRSPSSSCP1 ?>") {
            $("#dataPRSPSSSCP1").html(message.payloadString);
        }

        if (message.destinationName == "<?= $topic_mqtt_PRSAMPDIG1 ?>") {
            $("#dataPRSAMPDIG1").html(message.payloadString);
        }




    }
</script>