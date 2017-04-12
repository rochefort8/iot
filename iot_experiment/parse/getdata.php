<?php
require 'vendor/autoload.php';

date_default_timezone_set('Asia/Tokyo');

use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseACL;
use Parse\ParsePush;
use Parse\ParseUser;
use Parse\ParseInstallation;
use Parse\ParseException;
use Parse\ParseAnalytics;
use Parse\ParseFile;
use Parse\ParseCloud;
use Parse\ParseClient;

$app_id = 'lDMpTyYdKSTaRKB19Y517Ti5I4tp1xuLLeaHruoQ' ;
$rest_key = 'RUsqSNj0aWAr4E2NyOCc22nvOFRN9297WdtAU9IU' ;
$master_key = 'qujqISOIfbjpQ8wFYjMh0E0ktit1kWFf9zoSoOHL' ;

$dest_url = 'https://parseapi.back4app.com/';

ParseClient::initialize( $app_id, $rest_key, $master_key );
ParseClient::setServerURL($dest_url,'/') ;

$query = new ParseQuery("MONO");
$query->limit(1000);

try {
    $objects = $query->find();
//    $objects = $query->first();
    
    echo "Successfully retrieved " . count($objects) . " scores.";

    for ($i = 0; $i < count($objects); $i++) {
          $object = $objects[$i];
	  $id=$object->getObjectId() ;
  	  $f = $object->get("data") ;
	  if ($f != null) {
	     $contents = $f->getData() ;
	     $name=$f->getName();
	     file_put_contents("data/".$name,$contents) ;
	  }

}
} catch (\Parse\ParseException $e) {
     print $e ;
}
?>
