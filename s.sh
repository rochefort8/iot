curl -s -X POST -H 'Content-Type: audio/l16;rate=16000' --data-binary @'hello_jp.wav' "https://speech.googleapis.com/v1beta1/speech:syncrecognize?key=${SPEECH_API_KEY}"
