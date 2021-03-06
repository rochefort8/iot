#!/bin/bash

#
# https://quickstart.internetofthings.ibmcloud.com/#/
#
device_id="858585858585"
mqtt_topic="iot-2/evt/ogi/fmt/json"
ibmcloud_iot_quickstart_url="quickstart.messaging.internetofthings.ibmcloud.com"

send_data() {
    temp="$1"
    humidity="$2"
    echo $temp $humidity
    mosquitto_pub -h $ibmcloud_iot_quickstart_url -t $mqtt_topic \
		  -m '{"temp":'\"$temp\"',"humidity":'\"$humidity\"'}' \
		  -i d:quickstart:ogi:$device_id -q 0 -d

}

while [ 1 ];
do
    let temp=${RANDOM}*4/32768+20
    let humidity=${RANDOM}*10/32768+50    
    send_data $temp $humidity
    sleep 10
done
