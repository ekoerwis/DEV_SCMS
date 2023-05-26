<style>
    #container {
        width: 50px;
        height: 300px;
        line-height: 300px;
        margin-left: 10px;
        border: 2px solid black;

    }
</style>

<?php
    $hostname_mqtt = "10.20.38.199";
    $port_mqtt="9001";
    $clientID_mqtt="HARI_TEST_WS1";
    $topic_mqtt="PRSTMPDIG1";

?>

<h3>SMA-MQTT2WEBSOCKET</h3>
<h3>HOST: <a href='DevWebSocket.html'>
        <script>
            document.write("<?= $hostname_mqtt?>");
        </script>
    </a></h3>
<h3>PORT: <a href='DevWebSocket.html'>
        <script>
            document.write(<?= $port_mqtt?>);
        </script>
    </a></h3>
<h3>ID CLIENT: <a href='DevWebSocket.html'>
        <script>
            document.write("<?= $clientID_mqtt?>");
        </script>
    </a></h3>
<h3>TOPIC: <a href='DevWebSocket.html'>
        <script>
            document.write("<?= $topic_mqtt?>");
        </script>
    </a></h3>
<h3>RANGE PUBLIS DATA 0 - 100</h3>
<p>Temperature</p>
<div id="container">
    <div id="top" style="width: 100%; background-color:white;text-align:center;"></div>
</div>


<script>
    $(document).ready(function() {
    
        mqttClient = new Paho.MQTT.Client("<?= $hostname_mqtt?>", <?= $port_mqtt?>, "<?= $clientID_mqtt?>");
        
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
    mqttClient.subscribe("<?= $topic_mqtt?>");
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
    }
</script>