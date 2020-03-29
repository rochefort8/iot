#!/bin/bash 

if [ $# -lt 2 ]; then
   echo "MUST specify 2 arguments." 1>&2
   exit 1
fi


instance_name=$1
start_stop=$2

if [ $start_stop != "start" -a $start_stop != "stop" ]; then
    echo "MUST specify start or Stop at 2nd argument."
    exit 1
fi


echo -n $start_stop "EC2 instance" $instance_name "? [Y/n]: "
read ANS

case $ANS in
  "" | [Yy]* )
  ;;
  
  * )
    echo "Canceled."
    exit
    ;;
esac


state="running"
if [ $start_stop = "start" ]; then
   state="stopped"
fi

ARRAY_EC2_INSTANCE_ID=$( \
  aws ec2 describe-instances \
    --filter "Name=tag:Name,Values="${instance_name}"" \
    "Name=instance-state-name,Values="${state}"" \
    --query 'Reservations[].Instances[].InstanceId' \
    --output text \
) \
  && echo ${ARRAY_EC2_INSTANCE_ID}

aws ec2 ${start_stop}-instances --instance-ids ${ARRAY_EC2_INSTANCE_ID}

