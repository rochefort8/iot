#!/bin/bash
#
IMAGE_ID="ami-0d900447fcd5674a1"
INSTANCETYPE="t2.micro"
SUBNET_ID="subnet-027dbbfc1c15246a2"
SECURITY_GROUP_ID="sg-0adc3d86d340c9393"

instance_name=""

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

aws ec2 create-key-pair --key-name ${instance_name} --query 'KeyMaterial' --output text > ./${instance_name}.pem

if [ $? -ne 0 ]; then
    echo "Could not create key pair" ${instance_name}"."
    exit 1
fi

aws ec2 run-instances --region ap-northeast-1 --image-id ${IMAGE_ID} \
  --count 1 \
  --associate-public-ip-address \
  --instance-type t2.micro --key-name ${instance_name} \
  --subnet-id ${SUBNET_ID} \
  --security-group-ids ${SECURITY_GROUP_ID} \
  --tag-specifications 'ResourceType=instance,Tags=[{Key=Name,Value='${instance_name}'}]' \
  --credit-specification CpuCredits=standard

if [ $? -ne 0 ]; then
    echo "Could not create EC2 instance" ${instance_name}"."
    aws ec2 delete-key-pair --key-name ${instance_name}"."
    exit 1
fi

aws ec2 describe-instances --filter "Name=tag:Name,Values="${instance_name}"" | grep PublicIpAddress

exit 0

