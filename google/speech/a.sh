curl -X POST --data-binary @audio/good-morning-google.flac --header 'Content-Type: audio/x-flac; rate=44100;' 'https://www.google.com/speech-api/v2/recognize?output=json&lang=en-us&key=${SPEECH_API_KEY}'
