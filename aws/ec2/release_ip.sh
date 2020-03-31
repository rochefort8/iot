#!/bin/bash 

DOMAIN_VPC="rdc-tl14-dev-vpc"

if [ $# -lt 1 ]; then
   echo "MUST specify instance name" 1>&2
   exit 1
fi


instance_name=$1

echo -n "Release IP for EC2 instance" $instance_name "? [Y/n]: "
read ANS

case $ANS in
  "" | [Yy]* )
  ;;
  
  * )
    echo "Canceled."
    exit
    ;;
esac

PUBLIC_IP=$( \
  aws ec2 describe-instances \
    --filter "Name=tag:Name,Values="${instance_name}"" \
    --query 'Reservations[].Instances[].PublicIpAddress' \
    --output text \
) \
  && echo ${PUBLIC_IP}

EIP_ASSOCIATION_ID=$( \
    aws ec2 describe-addresses --public-ips ${PUBLIC_IP} \
    --query 'Addresses[].AssociationId' --output text \
) \
    && echo ${EIP_ASSOCIATION_ID}

EIP_ALLCATION_ID=$( \
    aws ec2 describe-addresses --public-ips ${PUBLIC_IP} \
    --query 'Addresses[].AllocationId' --output text \
) \
    && echo ${EIP_ALLCATION_ID}

aws ec2 disassociate-address --association-id ${EIP_ASSOCIATION_ID}
aws ec2 release-address --allocation-id ${EIP_ALLCATION_ID}
