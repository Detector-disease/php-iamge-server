<?php
ob_start();
session_start();
include_once 'dbDetails.php';


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>List of images</title>
  <meta charset="utf-8">
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <img src="favicon.ico" class="img-thumbnail" alt="Image" width="50" height="50"/>
      <a class="navbar-brand" href="#">Cell Detection</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Home</a></li>
      <li><a href="#">About Us</a></li>
    </ul>
  </div>
</nav>


<div class="container">
  <h2>List of images</h2>
  <form action="phpupload.php" method="post" enctype="multipart/form-data">
      Select image to upload:
      <input type="file" name="fileToUpload" id="fileToUpload"><br/>
      <input type="submit" value="Upload Image" name="submit">
  </form>
<br/>
<br/>
<hr>
<br/>
  <table class="table table-striped  table-bordered table-hover">
    <thead>
      <tr>
        <th>ID</th>
        <th>Analyze</th>
        <th>Name</th>
        <th>Image</th>
        <th>Processed Image</th>
        <th>Show</th>

      </tr>
    </thead>
    <tbody>
      
    <?php 
    $raw = mysqli_query($con, "SELECT * FROM `db_images`");
      while($row  = mysqli_fetch_array($raw)){
        $file_name =  explode("/",$row['url']);
        
        $file_name = $file_name[3];

        echo "<tr>";
         echo "<td>".$row['id']."</td>";

         
         if($row["parameters"] === NULL){
          $array_params = json_decode('{"Null":"Null"}',true);
         }else{
          $array_params = json_decode($row["parameters"], true);
         }

         if($row['processed_image'] == ''){
          $img = 'default.png';
         }else if ($row['on_server'] == 1){
          $img = 'https://www.pythonanywhere.com/user/zaverichintan/files/home/zaverichintan/cv_api/cell_detector/'.$row['processed_image'];
         }else{
             
          $img = 'http://olbx.in/android_upload/processed_images/'.$row['processed_image'];
         }
         echo '<td><a id="ajaxcall" href="curl.php?filename='.$file_name.'&id='.$row['id'].'">Analyze</a></td>';

         echo "<td>".$row['name']."</td>";
         // echo '<td><a href="#" data-toggle="popover" data-placement="bottom" title="Parameters" data-content="'.$row["parameters"].'">Parameters</a></td>';
         echo '<td><img src="'.$row['url'].'" class="img-thumbnail" alt="Image" width="304" height="236"></td>';
         echo '<td><img src="'.$img.'" class="img-thumbnail" alt="Image" width="304" height="236"></td>';
         echo '
          <td><button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal'.$row['id'].'">Open</button>

            <div class="modal fade" id="myModal'.$row['id'].'" role="dialog">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" style="font" class="close" data-dismiss="modal" >&times;</button>
                    <h4 class="modal-title">Processed Image</h4>
                  </div>
                  <div class="modal-body">';
                    
                     if($row['processed_image'] == ''){
                      $img = 'default.png';
                     }else if ($row['on_server'] == 1){
                      $img = 'https://www.pythonanywhere.com/user/zaverichintan/files/home/zaverichintan/cv_api/cell_detector/'.$row['processed_image'];
                     }else{
                         
                      $img = 'http://olbx.in/android_upload/processed_images/'.$row['processed_image'];
                     }        
                  
                    echo '<img src="'.$img.'" class="img-thumbnail" alt="Image" width="304" height="236">
                    <p>';

                      foreach ($array_params as $key => $value) {
                        // echo $key;
                        if(!is_array($value)){
                          echo $value;
                        }
                        else{
                         foreach ($value as $key_in => $value_in) {
                             echo $key_in.' : '.$value_in;
                             echo '<br>';
                          }
                             
                        }
                        echo '<br>';
                      }
                    echo '</p>
                  </div>
                </div>
              </div>
            </div>
            </td>';
        echo "</tr>";
      }
    ?>
      

    </tbody>
  </table>


<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();   
});

</script>
</div>

</body>
</html>
