#!/bin/bash 

if [ $# -lt 1 ]; then
   echo "MUST specify instance name." 1>&2
   exit 1
fi

instance_name=$1

echo -n "Create EC2 instance" $instance_name "? [Y/n]: "
read ANS

case $ANS in
  "" | [Yy]* )
    ;;
  * )
    echo "Canceled."
    exit
    ;;
esac

ARRAY_EC2_INSTANCE_ID=$( \
  aws ec2 describe-instances \
    --filter "Name=tag:Name,Values="${instance_name}"" \
    --query 'Reservations[].Instances[].InstanceId' \
    --output text \
) \
  && echo ${ARRAY_EC2_INSTANCE_ID}

aws ec2 terminate-instances --instance-ids ${ARRAY_EC2_INSTANCE_ID}
aws ec2 delete-key-pair --key-name ${instance_name}
