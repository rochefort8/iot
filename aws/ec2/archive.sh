#!/bin/bash
#

instance_name=""

if [ $# -lt 1 ]; then
   echo "MUST specify instance name." 1>&2
   exit 1
fi

instance_name=$1

case $ANS in
  "" | [Yy]* )
    ;;
  * )
    echo "Canceled."
    exit
    ;;
esac

mkdir ${instance_name}
mv ${instance_name}*.* ${instance_name}
zip -r ${instance_name}.zip ${instance_name}

