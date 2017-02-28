<?php
require_once 'dbDetails.php';


function isLocal ()
{
      if($_SERVER['HTTP_HOST'] == 'localhost'
        || substr($_SERVER['HTTP_HOST'],0,3) == '10.'
        || substr($_SERVER['HTTP_HOST'],0,7) == '192.168') return true;
    return false;
}

if(isLocal())
{
	$file_name_with_full_path = '/opt/lampp/htdocs/android_upload/6.bmp';

}else{
	// $file_name_with_full_path = '/home/olbx/public_html/android_upload/adrian.jpg';
  // $file_name = getFileName();
  $file_name = $_GET['filename'];
  $image_id = $_GET['id'];
  $file_name_with_full_path = '/home/olbx/public_html/android_upload/uploads/'.$file_name;
  echo ($file_name_with_full_path);
  

 }


$url = 'http://zaverichintan.pythonanywhere.com/cell_detection/detect/';

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

curl_setopt($cURL,CURLOPT_RETURNTRANSFER,TRUE);

$result = curl_exec($cURL);
curl_close($cURL);

$result_arr = json_decode($result, true);
var_dump($result_arr);

// echo '<a href= "https://www.pythonanywhere.com/user/zaverichintan/files/home/zaverichintan/cv_api/face_detector/'.$result_arr["url"].'">Processed image</a>';
function getimg($url) {         
    $headers[] = 'Accept: image/gif, image/x-bitmap, image/jpeg, image/pjpeg';              
    $headers[] = 'Connection: Keep-Alive';         
    $headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';         
    $user_agent = 'php';         
    $process = curl_init($url);         
    curl_setopt($process, CURLOPT_HTTPHEADER, $headers);         
    curl_setopt($process, CURLOPT_HEADER, 0);         
    curl_setopt($process, CURLOPT_USERAGENT, $user_agent); //check here         
    curl_setopt($process, CURLOPT_TIMEOUT, 30);         
    curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);         
    curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);         
    $return = curl_exec($process);         
    curl_close($process);         
    return $return;     
} 



$params = json_encode($result_arr["parameters"]);
$params = "'".$params."'";

$sql = 'UPDATE `db_images` SET processed_image="'.$result_arr["url"].'", parameters='.$params.' WHERE id='.$image_id;
echo $sql;

if (mysqli_query($con, $sql)) {
    echo "Record updated successfully";

$imgurl = 'https://www.pythonanywhere.com/user/zaverichintan/files/home/zaverichintan/cv_api/cell_detector/'.$result_arr["url"];

echo $imgurl;


$imagename= basename($imgurl);
if(file_exists('./uploads_process/'.$imagename)){continue;} 
$image = getimg($imgurl); 
file_put_contents('uploads_process/'.$imagename,$image); 

} else {
    echo "Error updating record: " . mysqli_error($con);
}

?>