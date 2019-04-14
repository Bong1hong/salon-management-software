<?php include "db_connect.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    
    <!-- icon css link -->
    <link rel="stylesheet" type="text/css" href="font/flaticon.css"/>
    
    <!-- Bootstrap library -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Latest compiled Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

    <!-- Add icon library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="style.css">
    
    <script src="script.js"></script>
  
</head>
  
<body>
    <div class="container">
        <h1>Products</h1>
        <!-- Display all products -->
        <?php
          $query = "SELECT * FROM inventories WHERE archive = 'No'";
          $data = $conn->query($query);
          $data->execute();

          foreach($data as $row)
          {
             echo "<div class='col-lg-4 col-xs-4 product-list-img'><embed src='data:". $row['mime']. ";base64," . base64_encode($row['image_name']). "' width='300' height='300' /></br>
             <p>". $row['inventoryName'] ."</p></div>";
          }
        ?>  
    </div>
</body>
  
</html>