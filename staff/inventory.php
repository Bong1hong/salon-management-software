<?php include "../db_connect.php"; ?>

<?php
  
  if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $retailprice = $_POST['retailprice'];
    $quantity = $_POST['quantity'];
    $status = "In stock";
    
    $pdoQuery = "INSERT INTO `inventories` (`inventoryName`,`description`,`quantity`,`unitPrice`,`purchasingPrice`,`status`) VALUES (:name,:description,:quantity,:retailprice,:price,:status)";
    
    $pdoResult = $conn->prepare($pdoQuery);
    $pdoExecute = $pdoResult->execute(array(":name"=>$name,":description"=>$description,":quantity"=>$quantity,":retailprice"=>$retailprice,":price"=>$price,":status"=>$status));
  }
?>

<!-- Change status module -->
<?php 
    if(isset($_POST['id'])){
      $id = $_POST['id'];
      $query = "SELECT * FROM inventories";
      $data = $conn->query($query);
      $data->execute();

      foreach($data as $row)
      {
        if ($row['status'] == "In stock"){
          $update = "UPDATE inventories SET status = 'Out of stock' WHERE inventoryId = '$id'";
          $result = $conn->prepare($update);
          $execute = $result->execute();
        }

        if ($row['status'] == "Out of stock"){
          $update = "UPDATE inventories SET status = 'In stock' WHERE inventoryId = '$id'";
          $result = $conn->prepare($update);
          $execute = $result->execute();
        }
      }
    }
?>

<!-- Delete product module -->
<?php 
    if(isset($_POST['idDel'])){
      $id = $_POST['idDel'];
      $query = "SELECT * FROM inventories";
      $data = $conn->query($query);
      $data->execute();

      foreach($data as $row)
      {
        if($row['inventoryId'] == $id){
          $delete = "DELETE FROM inventories WHERE inventoryId = '$id'";
          $result = $conn->prepare($delete);
          $execute = $result->execute();
        }
      }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    
    <!-- icon css link -->
    <link rel="stylesheet" type="text/css" href="../font/flaticon.css"/>
    
    <!-- Bootstrap library -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Latest compiled Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

    <!-- Add icon library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="../style.css">
    
    <script src="../script.js"></script>
  
</head>
  <!--store the added inventory to database-->

<body>
    <div class="container">
        <h1>Staff Product View</h1>
      
        <table class="table table-bordered ttb">
            
            <tr>
              <th>No.</th>
              <th>Item Name</th>
              <th id="itemDesc">Item Description</th>
              <th>Quantity</th>
              <th>Price (MYR)</th>
              <th>Retail Price (MYR)</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
            
            <!-- Display Existing Product -->
            <?php
              $query = "SELECT * FROM inventories";
              $data = $conn->query($query);
              
              $data->execute();
            
              $inventoryNo = 0;
              
              foreach($data as $row)
              {
                $inventoryNo ++;
                $id = $row['inventoryId'];
                echo "<tr><td>" . $inventoryNo . "</td>" . "<td>" . $row['inventoryName'] . "</td>" . "<td>" . $row['description'] . "</td>" . "<td>" . $row['quantity'] . "</td>" . "<td>" . $row['unitPrice'] . "</td>" . "<td>" . $row['purchasingPrice'] . "</td>" . "<td>" . $row['status'] . "</td>" . "<td><form method='post' onsubmit='return confirm(\"Are you sure you want to perform this action?\");'><button type='submit' class='btn btn-primary' name='id' value ='$id'>Change Status</button> " . "<button type='submit' class='btn btn-danger' name='idDel' value ='$id'>Delete</button> ". " <button type='submit' class='btn btn-success' name='idArc' value ='$id'>Archive</button>"."</div></form></td></tr>";
              }
            ?>  
          
        </table>
      
      <div class="product-c"><button class="addItem" onclick="openForm()"><img src="../images/add.png" alt="add-btn"></button><span id="anp">Add new product</span></div>
        
        <!-- This is the pop up form -->
        <div class="form-popup form-control" id="myForm">
            <form method="post" class="form-container" enctype="multipart/form-data" onsubmit="return confirm('Are you sure you want to submit this form?');">
                <fieldset>
                <h1>Add new product</h1>

                <div class="form-group">
                    <label for="product-name"><b>Product Name</b></label>
                    <input type="text" placeholder="Enter new product name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="product-description"><b>Product Description</b></label><br/>
                    <textarea rows="4" cols="80" name="description" placeholder="Enter product description here" class="form-control" required></textarea>
                </div>
                    
                <div class="form-group">    
                    <label for="product-image"><b>Product Image</b></label>
                    <input type="file" name="fileToUpload" id="fileToUpload" class="form-control">
                    <!--<input type="submit" value="Upload Image" name="submit">-->
                </div>
                    
                <div class="form-group">    
                    <label for="product-quantity"><b>Product Quantity</b></label>
                    <input type="number" name="quantity" class="form-control" required>
                </div>
                  
                <div class="form-group">    
                    <label for="product-price"><b>Product Price (RM)</b></label>
                    <input type="text" name="price" class="form-control" required>
                </div>
                    
                <div class="form-group">
                    <label for="product-retail-price"><b>Product Retail Price (RM)</b></label>
                    <input type="text" name="retailprice" class="form-control" required>
                </div>
                </fieldset>
                
                <button type="submit" name="submit" class="btn">Add</button>
                <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
            </form>
        </div>
    </div>
  

</body>
  
</html>