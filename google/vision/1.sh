#!/bin/sh

#検出に使う画像
IMAGE_PATH_IN="./image.jpg"

#Base64にしたもの
IMAGE_PATH_OUT="/tmp/image_out.base64"

#JSONに組み込むのでBASE64にする
base64 ${IMAGE_PATH_IN} > ${IMAGE_PATH_OUT}

#投げるJSON
REQESTJSON=/tmp/request0.json

#リクエスト用のJSONを書きます
#検出するモノと、検出候補数を記述します
# LABEL_DETECTION          カテゴリの検出
# LANDMARK_DETECTION       観光名所などの場所名
# LOGO_DETECTION           ロゴの検出
# TEXT_DETECTION           OCR、文字の検出
# SAFE_SEARCH_DETECTION    画像が有害な内容を含んでいるかを検出
# IMAGE_PROPERTIES         画像に関する色データを検出
# FACE_DETECTION           顔検出
##付属情報の追加があればもっと精度は上がる
# LatLong                  緯度経度
# latLongRect              場所情報
# languageHints            言語指定

cat << EOF > ${REQESTJSON}
{
  "requests":[
    {
      "image":{
        "content":"`cat ${IMAGE_PATH_OUT}`"
      },

      "features":[
        {
          "type":"LABEL_DETECTION",
          "maxResults":2
        },
        {
          "type":"LANDMARK_DETECTION",
          "maxResults":3
        },
        {
          "type":"LOGO_DETECTION",
          "maxResults":3
        },
        {
          "type":"TEXT_DETECTION",
          "maxResults":3
        },
        {
          "type":"SAFE_SEARCH_DETECTION",
          "maxResults":3
        },
        {
          "type":"IMAGE_PROPERTIES",
          "maxResults":3
        }
      ]
    }
  ]
}
EOF

curl -v -k -s -H "Content-Type: application/json" https://vision.googleapis.com/v1/images:annotate?key=${API_KEY} --data-binary @${REQESTJSON}
