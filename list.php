<?php
ob_start();
session_start();
include_once 'dbDetails.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>List of images</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>List of images</h2>
  <p>Shows list of all images</p>            
  <table class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Analyze</th>
        <th>Name</th>
        <th>Link</th>
        <th>Image</th>
        <th>Processed Image</th>

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

         // echo '<td><button id="ajaxcall">Analyze</button></td>';
         echo '<td><a id="ajaxcall" href="curl.php?filename='.$file_name.'&id='.$row['id'].'">Analyze</a></td>';

         echo "<td>".$row['name']."</td>";
         echo '<td><a href="#" data-toggle="popover" data-placement="bottom" title="Parameters" data-content="'.$row["parameters"].'">Parameters</a></td>';
         echo '<td><img src="'.$row['url'].'" class="img-thumbnail" alt="Image" width="304" height="236"></td>';
       	 echo '<td><img src="https://www.pythonanywhere.com/user/zaverichintan/files/home/zaverichintan/cv_api/face_detector/'.$row['processed_image'].'" class="img-thumbnail" alt="Image" width="304" height="236"></td>';

        echo "</tr>";
      }
    ?>
      
    </tbody>
  </table>


<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();   
});

// $("#ajaxcall").click(function(){
//     // $.get("curl.php", function(data, status){
//     //     alert("ajax");
//     // });
//   alert("asdf");
  
// });

</script>
</div>

</body>
</html>