#!/bin/bash

ctrl=$1
#
# AWS IoT
#
option="--cafile cert/vvv.pem --cert cert/2ebfc45a36-certificate.pem.crt --key cert/2ebfc45a36-private.pem.key"
device_id="858585858585"
mqtt_topic="home/myroom/ctrl"
endpoint_url="a30rc4gq2q16ca.iot.ap-northeast-1.amazonaws.com -p 8883"

send_data() {
    temp="$1"
    humidity="$2"
    echo $temp $humidity
    mosquitto_pub $option -h $endpoint_url -t $mqtt_topic \
		  -m '{"ctrl":'\"$temp\"'}' \
		  -i d:rochefort10
}

send_data $ctrl


