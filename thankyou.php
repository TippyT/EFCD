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
<body>
  <?php
    include 'dbConnection.php';





    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
      $car_name = $_POST['car_name'];
      $auto_maker= $_POST['maker_id'];
      $thoughts = $_POST['what_do_you_think_about_this_car'];
      // $car_id= $_POST['car_id'];

      if (isset($_POST['car_id'])) {

        $car_id = $_POST['car_id'];
        $sql =  "UPDATE car_names SET name='$car_name', thoughts='$thoughts'
        WHERE id = $car_id";

          if ($conn->query($sql) === TRUE){
              echo "New record created successfully";
          } 
          else{
              echo "Error: " . $sql . "<br>" . $conn->error;
          }
      }
      
      else
      {
        
        $sql = "INSERT INTO car_names (auto_maker_id, name, thoughts)
        VALUES ('$auto_maker','$car_name', '$thoughts')";
        
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

      }
      
    }

    $sqlView = "SELECT
        auto_maker.id, 
        auto_maker.name AS maker_name, 
        country ,
        car_names.id as car_id ,
        auto_maker_id, 
        car_names.name AS car_name, 
        thoughts
        FROM auto_maker 
        JOIN car_names ON auto_maker.id = car_names.auto_maker_id";
        $result = $conn->query($sqlView);
    
    $conn->close();

  ?>
  <div class="background-container">
    <div class = "container">
      <div class = "row">
        <div class= "col-md-8 col-md-offset-2 col-xs-12">
          <div class="form-container">
            <h2>Thanks for Playing Cars!</h2>
            <p>We will select a winner with the <b><em>most charming</em></b> opinions about their car model. <br> Feel free to delete or revise your entry accordingly.</p>
          </div>
          <div class="form-container">
            <!-- <p>display here</p> -->
            <?php
              if ($result->num_rows > 0) {
                  // output data of each row
                  while($row = $result->fetch_assoc()) {
                      echo $row['car_name'] . " | " . $row['thoughts'] . "|" . 

                      '<a href=delete.php?car_id="' . $row['car_id'] . '">DELETE</a>' . " | ".
                      '<a href=car_model.php?car_id="' . $row['car_id'] . '">EDIT</a>' .

                      '' . 

                      "<br>";
                  }
              }
            ?>
          </div>
        </div>
      </div>
    </div>



    
  </div>



  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
</body>
</html>