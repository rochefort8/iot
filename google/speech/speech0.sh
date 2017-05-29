curl -s -X POST -H Content-Type: application/json --data-binary @request-hello-jp.json "https://speech.googleapis.com/v1beta1/speech:syncrecognize?key=${SPEECH_API_KEY}"
