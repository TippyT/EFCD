<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 
    <title>Thank You For Playing</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/mystyle.css" rel="stylesheet">

  </head>
<body><?php
   include 'dbConnection.php';       
   $car_id = $_GET['car_id'];        
   $sql = "DELETE FROM car_names WHERE id=$car_name_id";        
   $result = $conn->query($sql);        
   if ($conn->query($sql) === TRUE) {
       echo " & Deleted Successfully!";
   } else {
       echo "Error deleting record: " . $conn->error;
   }
 ?>

 <a href="thankyou.php"><h2>home</h2></a>
 
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
</body>
</html>