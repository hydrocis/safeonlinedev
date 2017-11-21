<?php

/*
 * Including the sdk of php
 */


use Aspose\Cloud\Common\AsposeApp;
use Aspose\Cloud\Common\Product;
use Aspose\Cloud\Words\Converter;
use Aspose\Cloud\Storage\Folder;


function my_autoloader($class) {
    $allowed_namespace = array('AsposeApp','Product','Converter','Utils','Folder');
    $arr = explode('\\', $class);
    if( in_array( $arr['3'] , $allowed_namespace)){
        include 'Aspose_Cloud_SDK_For_PHP-master/src/'. $arr[0] . '/' . $arr[1] . '/' .$arr[2] . '/' . $arr[3] . '.php';
    }

}

spl_autoload_register('my_autoloader');

$upload_dir = wp_upload_dir();
$upload_path = $upload_dir['path'] . '/';

/*
 *  Assign appSID and appKey of your Aspose App
 */
AsposeApp::$appSID = get_option('aspose_doc_exporter_app_sid');
AsposeApp::$appKey = get_option('aspose_doc_exporter_app_key');
AsposeApp::$outPutLocation = $upload_path;


/*
 * Assign Base Product URL
 */
Product::$baseProductUri = 'http://api.aspose.com/v1.1';

//echo 'fahad' . $file_name; exit;
global $html_filename;

$folder = new Folder();
$result = $folder->uploadFile($file_name, '');
if($result['Status'] == 'OK') {
	$func = new Converter($html_filename);
	$file_type = get_option('aspose_doc_exporter_file_type');
    if(isset($file_type) && !empty($file_type)){
        $file_type = $file_type;
    } else {
        $file_type = 'docx';
    }

    $func->saveFormat = $file_type;
	$func->convert();
}
