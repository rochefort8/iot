#!/bin/bash 

DOMAIN_VPC="rdc-tl14-dev-vpc"

if [ $# -lt 1 ]; then
   echo "MUST specify instance name" 1>&2
   exit 1
fi


instance_name=$1

echo -n "Allcate IP for EC2 instance" $instance_name "? [Y/n]: "
read ANS

case $ANS in
  "" | [Yy]* )
  ;;
  
  * )
    echo "Canceled."
    exit
    ;;
esac

EC2_INSTANCE_ID=$( \
  aws ec2 describe-instances \
    --filter "Name=tag:Name,Values="${instance_name}"" \
    --query 'Reservations[].Instances[].InstanceId' \
    --output text \
) \
  && echo ${EC2_INSTANCE_ID}

EIP_ALLOCATION_ID=$( \
    aws ec2 allocate-address --domain ${DOMAIN_VPC} \
    --query 'AllocationId' --output text \
) \
  && echo ${EIP_ALLOCATION_ID}

aws ec2 associate-address --allocation-id ${EIP_ALLOCATION_ID} --instance ${EC2_INSTANCE_ID}

PUBLIC_IP=$(
    aws ec2 describe-addresses --allocation-ids ${EIP_ALLOCATION_ID} \
    --query 'Addresses[].PublicIp' \
    --output text \
) \
  && echo "Allocated IP address" ${PUBLIC_IP} "for" ${instance_name} "."
