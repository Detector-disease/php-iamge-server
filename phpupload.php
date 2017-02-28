
<?php

//importing dbDetails file 
require_once 'dbDetails.php';

//this is our upload folder 
$upload_path = 'uploads/';

//Getting the server ip 
$server_ip = gethostbyname(gethostname());

//creating the upload url 
$upload_url = '/android_upload/'.$upload_path; 

//upload the code

$target_dir = "uploads/";
 

//getting name from the request 
$name = $_FILES["fileToUpload"]["name"];

//getting file info from the request 
$fileinfo = pathinfo($_FILES["fileToUpload"]["name"]);

//getting the file extension 
$extension = $fileinfo['extension'];

//file url to store in the database 
$file_url = $upload_url . getFileName() . '.' . $extension;

//file path to upload in the server 
$file_path = $upload_path . getFileName() . '.'. $extension;

// $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$target_file =  $file_path;
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 1000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "bmp" ) {
    echo "Sorry, only JPG, JPEG, PNG & BMP files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded."; 


        $sql = "INSERT INTO `db_images` (`id`, `url`, `name`) VALUES (NULL, '$file_url', '$name');";
        echo $sql;
        mysqli_query($con,$sql);            

    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}


/*
We are generating the file name 
so this method will return a file name for the image to be upload 
*/
function getFileName(){


$con = mysqli_connect(HOST,USER,PASS,DB) or die('Unable to Connect...');

$raw = mysqli_query($con,"SELECT max(id) as id FROM `db_images`");
$result = mysqli_fetch_array($raw);

if($result['id']==null)
    return 1; 
else 
    return ++$result['id']; 
}
?>

