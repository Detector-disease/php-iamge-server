<?php

function isLocal ()
{
      if($_SERVER['HTTP_HOST'] == 'localhost'
        || substr($_SERVER['HTTP_HOST'],0,3) == '10.'
        || substr($_SERVER['HTTP_HOST'],0,7) == '192.168') return true;
    return false;
}

if(isLocal())
{
	$file_name_with_full_path = '/opt/lampp/htdocs/android_upload/adrian.jpg';

}else{
	// $file_name_with_full_path = '/home/olbx/public_html/android_upload/adrian.jpg';
  $file_name_with_full_path = '/home/olbx/public_html/android_upload/uploads/3.jpg';

 }




$url = 'http://zaverichintan.pythonanywhere.com/face_detection/detect/';

$cURL = curl_init();

curl_setopt($cURL, CURLOPT_URL, $url);
// curl_setopt($cURL, CURLOPT_HTTPGET, true);

curl_setopt($cURL, CURLOPT_HTTPHEADER, array(
    'Content-type: multipart/form-data',
    'Accept: application/json'
));


if (function_exists('curl_file_create')) { // php 5.6+
  $cFile = curl_file_create($file_name_with_full_path);
} else { // 
  $cFile = '@' . realpath($file_name_with_full_path);
}

$post = array('image'=> $cFile);

curl_setopt($cURL, CURLOPT_POST,1);
curl_setopt($cURL, CURLOPT_POSTFIELDS, $post);



$result = curl_exec($cURL);

curl_close($cURL);

?>