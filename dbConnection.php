<?php
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname ="cars";
        
        $rec_limit = 5;

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
	        die("Connection failed: " . $conn->connect_error);
        }
        else {
          # echo "Connected successfully";
        }
?>