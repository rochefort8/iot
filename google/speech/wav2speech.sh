#!/bin/sh
#
# $ adintool -in mic -ouame data ilena
#

wavfile=$1

# 16000Hz 16bit mono wav -> flac
flac $wavfile -f

# base64 encoding
content=`base64 ${wavfile%.*}.flac | tr -d '\r\n'`

# Create json with encoded data
cp r.json tmp.json
echo -n "\"content\":\"" >> tmp.json
echo -n $content >> tmp.json
echo \" >> tmp.json
echo "}}" >> tmp.json

#publish command
curl -s -X POST -H Content-Type: application/json --data-binary @tmp.json "https://speech.googleapis.com/v1beta1/speech:syncrecognize?key=${SPEECH_API_KEY}"
