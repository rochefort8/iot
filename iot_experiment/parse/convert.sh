#!/bin/sh

cat 20170414.txt | awk "{print \$2}" | cut -d, -f1-2 > /tmp/0.txt

for f in $(cat /tmp/0.txt)
do
    h=$(echo $f|cut -d: -f1|sed -e 's/^0\+\([0-9]\+\)$/\1/')
    m=$(echo $f|cut -d: -f2|sed -e 's/^0\+\([0-9]\+\)$/\1/')
    s=$(echo $f|cut -d: -f3| cut -d, -f1|sed -e 's/^0\+\([0-9]\+\)$/\1/')

    x=$((3600*$h+60*$m+$s))
    y=$(echo $f|cut -d, -f2)
    echo "$x,$y"
done
	 

