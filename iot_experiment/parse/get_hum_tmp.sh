#!/bin/bash

val0=`$(pwd)/../RPi/hum_tmp/dht11_ex1`
val1=`cat /sys/bus/w1/devices/28-051692626bff/w1_slave | grep "t=" | cut -d= -f2-`

echo $val0,$val1
exit 0
