<?php
		    include 'dbConnection.php';

		    	if(isset($_GET['car_id']))
		    	{
		    		$car_id = $_GET['car_id'];
	    		// echo "hey this is the id!" . $car_id;
	    		// get all listing information from the db for specific car id
	    		$sql = "SELECT * FROM car_names WHERE id = $car_id";

	    		// query the result from the db
	    		$result =$conn->query($sql);
	    		//if something matches the id, store it in this variable
	    		if ($result->num_rows > 0)
	    		{
	    			$listing=$result->fetch_assoc();
	    		}	

	    		}
		    	

if ($_SERVER['REQUEST_METHOD'] === 'POST') {        
  
		      	$auto_maker = ($_POST['maker_id']);
		      
		      	$car_name = mysqli_real_escape_string($conn, $_POST['car_name']);;

		      	$year = $_POST['year'];

		      	$purchase_date = $_POST['purchase_date'];

		      	$description = mysqli_real_escape_string($conn, $_POST['description']);

		      	$price = mysqli_real_escape_string($conn, $_POST['price']);

		      	// $car_id = $_POST['car_id']; 

		      	// $sql = "INSERT INTO auto_maker (name)
		      	// VALUES ('$auto_maker')";
		      	
			    
			    if(isset($_FILES['image'])) {
					$errors= array();
					$file_name = $_FILES['image']['name'];
					$file_size =$_FILES['image']['size'];
					$file_tmp =$_FILES['image']['tmp_name'];
					$file_type=$_FILES['image']['type']; 
					$file_ext=explode('.',$_FILES['image']['name'])	;
					$file_ext=end($file_ext);    
					
					
					$expensions= array("jpeg","jpg"); 		
					if(in_array($file_ext,$expensions)=== false){
						$errors[]="extension not allowed, please choose a JPEG or PNG file.";
					}
				}

				if(empty($errors)==true){
					 move_uploaded_file($file_tmp,"img/".$file_name);
				#	echo "Whoo Hoo! ";
					}
				else {
					print_r($errors);
				}


		      	$sql = "INSERT INTO car_names (auto_maker_id, car_name, purchase_date, year, description, price, image )
		      	VALUES ('$auto_maker', '$car_name', '$purchase_date', '$year', '$description', '$price', '$file_name')";

		    
		      	if ($conn->query($sql) === TRUE) {
		          	# echo "New record created successfully";
		          	header('Location: /EastFallsCarDealership/privateListingsPage.php?message=' . urlencode('Success! Car saved.'));
		      	} else {
		          	echo "Error: " . $sql . "<br>" . $conn->error;
		      	}

	    	} 

		
		?>
	
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

  
    <title>East Falls Car Dealership Inventory Intake Form</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/mystyle.css" rel="stylesheet">
    <link href="css/bootstrap_datepicker_standalone.less.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap_datepicker.css" rel="stylesheet" type="text/css">

	</head>
<body>
 <nav class="navbar navbar-default">
		  <div class="container-fluid">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand" href="index.php"><b>East Falls Car Dealership<b></a>
		    </div>

		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      <ul class="nav navbar-nav">
		        <li><a href="">About</a></li>
		        <li><a href="">Location</a></li>
		        <li><a href="">Hours</a></li>
		      </ul>

		    </div>
		  </div>
		</nav>
	<!-- <h1>Does it work?</h1> -->

<div class="display_container">

		<?php
		if ( isset($_GET['message'])) {
			echo '<p style="text-align:center;color:green;"><strong>' . $_GET['message'] . '</strong></p>';
			}
		?>
			<div class ="row">
					<div class= "col-md-3 col-md-offset-1 ">
						<div class="form-container">
							<div class="search">
								<H3>Search</H3>
								<br>
								<form method="get">
									Search Listings:
									<input type="search" name="search" value="<?php 
										if (isset($_GET['search'])) echo $_GET['search'];
									?>">

									<p> SORT BY </p>
								
									<select name="auto_maker_id">
										<option value="">Select Brand </option>

  									<?php
					                  $sql = "SELECT id, name FROM auto_maker";
					                  $manufacturerResults = $conn->query($sql);
					              
					                    if ($manufacturerResults->num_rows > 0) {
					                        // output data of each row
					                        while($row = $manufacturerResults->fetch_assoc()) {
					                          echo "<option value='" . $row["id"]. "'";
					                          if (isset($_GET['auto_maker_id']) and  $_GET['auto_maker_id'] == $row["id"]) echo "selected";
					                          echo ">" . $row["name"] . "</option>";
					                        }
					                    }
					                
									?>
  									</select>

  			
  									<div class=sort1>

  									<select name="sort" id ="sort">
  										<option value="year DESC" <?php if (isset($_GET['sort']) and $_GET['sort'] == 'year DESC') echo "selected"; ?>
											>Newest</option>
  										<option value="price DESC" <?php if (isset($_GET['sort']) and $_GET['sort'] == 'price DESC') echo "selected"; ?>
											>Highest Price</option>
  										<option value="price ASC" <?php if (isset($_GET['sort']) and $_GET['sort'] == 'price ASC') echo "selected"; ?>
											>Lowest Price</option>
  									</select>
  									</div>

  									<button>Submit</button>
								</form>
							</div>
						</div>
					</div>	
				
				

					<div class = "col-md-6">
						<div class="form-container">
							<div class= "listings">
							<H3>Listings</H3>
				<?php
					include 'dbConnection.php';

					$sqlView = "SELECT
							        auto_maker.id, 
							        auto_maker.name AS maker_name,
							        car_names.id AS car_id ,
							        auto_maker_id, car_name,
							        purchase_date, 
							        year, description, price, image
							        FROM auto_maker 
							        JOIN car_names ON auto_maker.id = car_names.auto_maker_id WHERE " ;

									

					if (isset($_GET['search']) && strlen($_GET['search']) > 0) {
						$sqlView .= " (car_names.car_name LIKE '%" . $_GET['search'] . "%' OR auto_maker.id LIKE '%" .  $_GET['search'] . "%' OR car_names.description LIKE '%" . $_GET['search'] . "%') AND ";
					}

					if (isset($_GET['auto_maker_id']) && strlen($_GET['auto_maker_id']) > 0) {
						$sqlView .= " auto_maker.id = " . $_GET['auto_maker_id'] . " AND ";
					}

					$sqlView .= " true = true";

					if (isset($_GET['sort']) && strlen($_GET['sort']) > 0) {
						$sqlView .= " ORDER BY " . $_GET['sort'];
					} else {
						$sqlView .= " ORDER BY year DESC";
					}

					// echo $sqlView;
			        $result = $conn->query($sqlView);



					if ($result->num_rows > 0) {


					      // output data of each row
					      while($row = $result->fetch_assoc()) {
						
									echo '<div class="listingUnit">
										<div class="row">
											<div class="col-md-6">
											'.
											'<img style="width: 100%" src="img/'.$row['image'].'">'.
											'</div>
											<div class="col-md-6">
												<p>'.$row['year'].' '.$row['maker_name'].' '.$row['car_name'].'</p>
												<br>
												<p> $'.$row['price'].'</p>
												<br>
												<p>'.$row['description'].'</p>' .'
												
												<hr>
	
											</div>
										</div>
									</div>';

								}
							}

							
						?>
						</div>
					</div>
				</div>	
			</div>
			</div>
		</div>


	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
  <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->


	</body>
</html>



