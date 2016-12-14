<?php include 'dbConnection.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

  
    <title>East Falls Car Dealership Private Listings Page</title>

        <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/mystyle.css" rel="stylesheet">


	</head>
	<body>
	 <?php include 'nav.php' ?>

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
												<p>Purchase Date: '.$row['purchase_date'].'</p>
												<p> $'.$row['price'].'</p>
												<p>'.$row['description'].'</p>'
												.'<a href=deleteCars.php?car_id="' . $row['car_id'] . '">DELETE</a>' . " | ".
			                      				'<a href=car_intake_form.php?car_id=' . $row['car_id'] . '>EDIT</a>'.'

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

