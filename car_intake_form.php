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
 		      	} else {
		          	echo "Error: " . $sql . "<br>" . $conn->error;
		      	}

  				header('Location: /EastFallsCarDealership/privateListingsPage.php?message=' . urlencode('Success! Car saved.'));    

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
 <?php include 'nav.php' ?>
	<!-- <h1>Does it work?</h1> -->



	<div class="background-container">
		<div class = "container">
			<div class = "row">
				<div class= "col-md-8 col-md-offset-2 col-xs-12">
					<div class="form-container">

					<div class= "heading">
						<H3>New Inventory Intake Form</H3>
						<br>
						<!-- <h1>does it work</h1> -->
						<form <?php if (isset($car_id)) echo "action='update.php'" ?> method="POST" enctype="multipart/form-data">

						<?php if (isset($car_id)) echo "<input type='hidden' name='car_id' value =" . $car_id ." > " ; ?>

						    <div class="form-spacing">
						        <label for="name">Auto Maker:</label>
<!-- 						        <input type="text" id="name" name="auto_maker" required />
 -->						        <select class="form-spacing" name = "maker_id">

									<?php
				                  	$sql = "SELECT id, name FROM auto_maker";
				                 	 $automakers = $conn->query($sql);




			                if ($automakers->num_rows > 0) {
			                    // output data of each row
			                    while($row = $automakers->fetch_assoc()) {
			                        echo "<option value='" . $row["id"] ."'";
			                        if (isset($car_id) and  $listing['auto_maker_id'] == $row["id"]) echo "selected";
			                        echo ">" . $row["name"] . "</option>";
			                    }	
			                	}

                		?>

					             </select>
					            
						    </div>

						    <script>
							   function yesnoCheck(that) {
							       if (that.value == "other") {
							           alert("check");
							           document.getElementById("ifYes").style.display = "block";
							       } else {
							           document.getElementById("ifYes").style.display = "none";
							       }
							   }
							</script>

						    <!-- <div classs="form-spacing" id="ifYes" style="display: none;">
						    	<input type="text" name="new_maker" />
						    </div>
 -->
						    <div class="form-spacing">
						       <label for="car_name">Car name:</label>
						       <input type="text" id="car_name" name="car_name" <?php if(isset($listing['car_name'])) echo "value=' " .  $listing['car_name'] . " ' "?> required />

						        
						    </div>
						    <div class="dropdown">
						    	<label for="year:">Year:</label>   
						    	<select name = "year">

								    <option value="2017" <?php if (isset($car_id) and  $listing['year'] == 2017) echo "selected"; ?>>2017</option>
								    <option value="2016" <?php if (isset($car_id) and  $listing['year'] == 2016) echo "selected"; ?>>2016</option>
								    <option value="2015" <?php if (isset($car_id) and  $listing['year'] == 2015) echo "selected"; ?>>2015</option>
								    <option value="2014" <?php if (isset($car_id) and  $listing['year'] == 2014) echo "selected"; ?>>2014</option>
								    <option value="2013" <?php if (isset($car_id) and  $listing['year'] == 2013) echo "selected"; ?>>2013</option>
								    <option value="2012" <?php if (isset($car_id) and  $listing['year'] == 2012) echo "selected"; ?>>2012</option>
								    <option value="2011" <?php if (isset($car_id) and  $listing['year'] == 2011) echo "selected"; ?>>2011</option>
								    <option value="2010" <?php if (isset($car_id) and  $listing['year'] == 2010) echo "selected"; ?>>2010</option>
								    <option value="2009"<?php if (isset($car_id) and  $listing['year'] == 2009) echo "selected"; ?>>2009</option>
								    <option value="2008" <?php if (isset($car_id) and  $listing['year'] == 2008) echo "selected"; ?>>2008</option>
								    <option value="2007" <?php if (isset($car_id) and  $listing['year'] == 2007) echo "selected"; ?>>2007</option>
								    <option value="2006" <?php if (isset($car_id) and  $listing['year'] == 2006) echo "selected"; ?>>2006</option>
								    <option value="2005" <?php if (isset($car_id) and  $listing['year'] == 2005) echo "selected"; ?>>2005</option>
								    <option value="2004" <?php if (isset($car_id) and  $listing['year'] == 2004) echo "selected"; ?>>2004</option>
								    <option value="2003" <?php if (isset($car_id) and  $listing['year'] == 2003) echo "selected"; ?>>2003</option>
								    <option value="2002"<?php if (isset($car_id) and  $listing['year'] == 2002) echo "selected"; ?>>2002</option>
								    <option value="2001"<?php if (isset($car_id) and  $listing['year'] == 2001) echo "selected"; ?>>2001</option>
								    <option value="2000" <?php if (isset($car_id) and  $listing['year'] == 2000) echo "selected"; ?>>2000</option>
								    <option value="1999" <?php if (isset($car_id) and  $listing['year'] == 1999) echo "selected"; ?>>1999</option>
								    <option value="1998" <?php if (isset($car_id) and  $listing['year'] == 1998) echo "selected"; ?>>1998</option>
								    <option value="1997" <?php if (isset($car_id) and  $listing['year'] == 1997) echo "selected"; ?>>1997</option>
								    <option value="1996" <?php if (isset($car_id) and  $listing['year'] == 1996) echo "selected"; ?>>1995</option>
								    <option value="1995" <?php if (isset($car_id) and  $listing['year'] == 1995) echo "selected"; ?>>1995</option>
								    <option value="1994" <?php if (isset($car_id) and  $listing['year'] == 1994) echo "selected"; ?>>1994</option>
								    <option value="1993"<?php if (isset($car_id) and  $listing['year'] == 1993) echo "selected"; ?>>1993</option>
						     	</select>
						    </div>

						    <div class="form-spacing">
						     	<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
 								<span class="sr-only">Error:</span>
						        <label for="purchase_date:">Purchase Date:</label>   
						       <input type="text" id="purchase_date" name="purchase_date" placeholder="12-01-16" <?php if(isset($listing['purchase_date'])) echo "value=' " .  $listing['purchase_date'] . " ' "?> required />

						    </div>

						    <div class="form-group">
						        <label for="description">Description:</label>
						        <textarea class="form-control" rows="3" id="description" name = "description"maxlength="200"  ><?php if(isset($listing['description'])) echo $listing['description']?></textarea>
						    </div>

						    <div class="form-spacing">
						        <label for="exampleInputPrice1">Price:</label>
						        <input type="text" id="exampleInputPrice1" name="price" placeholder="10,000" <?php if(isset($listing['price'])) echo "value=' " .  $listing['price'] . " ' "?> required />
						    </div>
 
						    
						    <div class="img">
						        <label for="exampleInputPrice1">Image Upload:</label>
						         <span class=" glyphicon glyphicon-upload" aria-hidden="true"></span>
	   							 <span class="sr-only">Error:</span>
	   							 <br>
	   							 <?php if(isset($listing['image'])) { ?>
	   							 	<span>Current: </span><?php echo $listing['image']?>
	   							 	<br>
	   							 	<span>Replace With: </span>
	   							 <?php } ?>
    							<input type="file" name="image" id="image" style="display:inline;"/>
							</div>
							<br>

					        <div class="button">   
					        	<button type="submit" class="btn btn-danger">Submit</button>
						    </div>

						</form>
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
  <script type="text/javascript" src="js/bootstrap.js"></script>

  <script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
  <script type="text/javascript" src="js/bootstrap-datepicker.js"></script>


</scirpt>
</body>
</html>