<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Car Model</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/mystyle.css" rel="stylesheet">

	</head>
<body>

    
    <?php

    include 'dbConnection.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {        
      
      $auto_maker = ($_POST['auto_maker']);
      
      $country_of_origin = $_POST['country_of_origin'];

      
      
      
      $sql = "INSERT INTO auto_maker (name, country)
      VALUES ('$auto_maker', '$country_of_origin')";
    
      if ($conn->query($sql) === TRUE) {
          echo "New record created successfully";
      } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
      }
        
    }
    
    // $conn->close();
    //Check if a beer_id was supplied in the URL Query Parameter
    if (isset($_GET['car_id'])) {

      $car_id = $_GET['car_id'];

      //Query DB for details on that beer
      $carSQL = "SELECT * FROM car_names where id = $car_id";

      $car =  $conn->query($carSQL)->fetch_assoc();

    }

    ?>

	<div class="background-container">


		<div class = "container">
			<div class = "row">
				<div class= "col-md-8 col-md-offset-2 col-xs-12">
					<div class="form-container">
            <div class= "instructions">
              <p> Step Two: Enter the maker, model and your opinion about a car</p>
            </div>
						<!-- <h1>does it work</h1> -->
            <form action="thankyou.php" method="post">
              <div class="form-spacing">
               <label for="msg">Select An Auto Maker</label> 
               <?php if(isset($car_id)) echo "<input type='hidden' name='car_id' value=" . $car_id ." >"; ?>

              
              <select class="form-spacing" name = "maker_id">

                  <?php
                  $sql = "SELECT id, name FROM auto_maker";
                  $result = $conn->query($sql);
              
                    if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                          echo "<option value='" . $row["id"]. "'";
                          if (isset($car) and  $car['auto_maker_id'] == $row["id"]) echo "selected";
                          echo ">" . $row["name"] . "</option>";
                        }
                    }
                    ?>
                    <a ref="index.php"<p>Return to First Page</p></a>
              </select>
              <br>
                 <label for="name">Car Name:</label>
                  <input <?php if (isset($car['name'])) echo "value='" . $car['name'] . "'";?> type="text" maxlength="20" id="name" name="car_name" required />
              </div>
              
              <div class="form-spacing">
                  <label for="msg">What Do You Think About This Car</label>
                  <input  <?php if (isset($car['thoughts'])) echo "value='" . $car['thoughts'] . "'";?> type="text" id="think" name="what_do_you_think_about_this_car" required/>
              </div class="form-spacing">
                  <div class="button">
                  <button type="submit" class="btn btn-primary">Share Your Thoughts</button>
                  </div>
              </div>
              </div>
            </form>
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