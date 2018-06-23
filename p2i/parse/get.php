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

/*
$app_id = 'lDMpTyYdKSTaRKB19Y517Ti5I4tp1xuLLeaHruoQ' ;
$rest_key = 'RUsqSNj0aWAr4E2NyOCc22nvOFRN9297WdtAU9IU' ;
$master_key = 'qujqISOIfbjpQ8wFYjMh0E0ktit1kWFf9zoSoOHL' ;
*/
$app_id = 'eLKqkCO0kBMMFGApVhiw1aoAYM2l2AJ5WYaIqQEk' ;
$rest_key = 'ZZUUs8QhO65E53yyh4HXPdjAQeqBGKUP4Fob2XlM' ;
$master_key = 'NoQsfrktxxx3G5T8y1w4QwKBhyQGeU48QE8zOSQy' ;

$dest_url = 'https://parseapi.back4app.com/';

ParseClient::initialize( $app_id, $rest_key, $master_key );
ParseClient::setServerURL($dest_url,'/') ;

$line=$argv[1];

$query = new ParseQuery($line);
        
$query->ascending("index");        


//try {
    $results = $query->find();
    foreach ( $results as $result ) {
       	$index = $result->get('index');
    	$name = $result->get('name');
	$kanji = $result->get('name_kanji');
	$kana = $result->get('name_kana');	
	echo $index . "," . $kanji . "," . $kana . "," . $name . "\n" ;
    }
//}

?>
