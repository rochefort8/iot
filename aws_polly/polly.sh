#!/bin/sh

count=0

for f in $(cat $1);
do
    basename=$(printf "%03d" $count)
   aws polly synthesize-speech --output-format mp3 --voice-id Mizuki --text $f voice/$basename.mp3

    echo $basename
    let count++
done
