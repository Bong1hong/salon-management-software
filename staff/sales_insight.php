<!-- Include navigation bar -->
<?php include '../db_connect.php'; ?>

<?php
    // query to get all products and their total sales
    $most_favourable_product_query = "SELECT i.inventoryName as productName, SUM(s.itemAmount) as count FROM inventories i RIGHT OUTER JOIN salesdetails s ON i.inventoryId = s.inventoryId WHERE i.categories != 'Service' GROUP BY s.inventoryId";

    $most_favourable_product = $conn->query($most_favourable_product_query);
    $most_favourable_product->execute();
    $products = $most_favourable_product->fetchAll(PDO::FETCH_ASSOC);

    $topProduct = "None"; // most favourable product
    $topProductCount = 0;  // most favorable product count
    

    // get top product
    foreach ($products as $row) {
       if ($row["count"] > $topProductCount) {
        $topProduct = $row["productName"];
        $topProductCount = $row["count"];
       }
    }


    // query to get all services and their total sales
    $most_favourable_service_query = "SELECT i.inventoryName as serviceName, SUM(s.itemAmount) as count FROM inventories i RIGHT OUTER JOIN salesdetails s ON i.inventoryId = s.inventoryId WHERE i.categories = 'Service' GROUP BY s.inventoryId";

    $most_favourable_service = $conn->query($most_favourable_service_query);
    $most_favourable_service->execute();
    $services = $most_favourable_service->fetchAll(PDO::FETCH_ASSOC);

    $topService = "None"; // most favourable product
    $topServiceCount = 0;  // most favorable product count

    // Sort max to min
    for($i=0; $i<sizeof($products); $i++) {
      for($j=0; $j<sizeof($products)-$i-1; $j++) {
        if ($products[$j]['count'] < $products[$j + 1]['count']) {
          $temp = $products[$j];
          $products[$j] = $products[$j+1];
          $products[$j+1] = $temp;
        }
      }
    }

    // get top service
    foreach ($services as $row) {
       if ($row["count"] > $topServiceCount) {
        $topService = $row["serviceName"];
        $topServiceCount = $row["count"];
       }
    }


    // query to get the sales count of products
    $most_frequent_product_query = "SELECT i.inventoryName as productName, COUNT(*) as count FROM inventories i RIGHT OUTER JOIN salesdetails s ON i.inventoryId = s.inventoryId WHERE i.categories != 'Service' GROUP BY s.inventoryId";

    $most_frequent_product = $conn->query($most_frequent_product_query);
    $most_frequent_product->execute();
    $frequentProducts = $most_frequent_product->fetchAll(PDO::FETCH_ASSOC);

    $frequentProduct = "None";
    $frequentProductNum = 0;

    foreach ($frequentProducts as $row) {
       if ($row["count"] > $frequentProductNum) {
        $frequentProduct = $row["productName"];
        $frequentProductNum = $row["count"];
       }
    }

    // query to get the sales count of services
    $most_frequent_service_query = "SELECT i.inventoryName as productName, COUNT(*) as count FROM inventories i RIGHT OUTER JOIN salesdetails s ON i.inventoryId = s.inventoryId WHERE i.categories = 'Service' GROUP BY s.inventoryId";

    $most_frequent_service = $conn->query($most_frequent_service_query);
    $most_frequent_service->execute();
    $frequentServices = $most_frequent_service->fetchAll(PDO::FETCH_ASSOC);

    $frequentService = "None";
    $frequentServiceNum = 0;

    foreach ($frequentServices as $row) {
       if ($row["count"] > $frequentServiceNum) {
        $frequentService = $row["productName"];
        $frequentServiceNum = $row["count"];
       }
    }

    $allSalesQuery = "SELECT * from sales";
    $allSalesData = $conn->query($allSalesQuery);
    $allSalesData->execute();
    $sales = $allSalesData->fetchAll(PDO::FETCH_ASSOC);

?>

<html lang="en">
  <head>
    <title>Detail Insight for Staffs</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css" type="text/css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script>
      var products = <?php echo json_encode($products); ?>;
      var sales = <?php echo json_encode($sales); ?>;
    </script>
    
  </head>
  <body onload="loadDetailsChart(sales, 'daily', 3)">
    <?php include "../navigationBar.php" ?>
    <div class="container dashboard-container text-center">
      <h1 class="display-4">Detail Insight for Services &amp; Products</h1>
      <div class="row">
        <div class="col-md-4 col">
          <div class="content">
            <p class="title">Top Service</p>
            <p class="result">*<?php echo $topService ?>*</p>
          </div>
        </div>
        <div class="col-md-4 col">
          <div class="content">
            <p class="title">Top Consistent Service (Sale's frequency)</p>
            <p class="result">*<?php echo $frequentService ?>*</p>
          </div>
        </div>
        <div class="col-md-4 col">
          <div class="content">
            <p class="title">Top Improver Service</p>
            <p class="result">*Waiting to be implemented*</p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4 col">
          <div class="content">
            <p class="title">Top Product</p>
            <p class="result">*<?php echo $topProduct ?>*</p>
          </div>
        </div>
        <div class="col-md-4 col">
          <div class="content">
            <p class="title">Top Consistent Product (Sale's frequency)</p>
            <p class="result">*<?php echo $frequentProduct ?>*</p>
          </div>
        </div>
        <div class="col-md-4 col">
          <div class="content">
            <p class="title">Top Improver Product</p>
            <p class="result">*Waiting to be implemented*</p>
          </div>
        </div>
      </div>
      <div class="row graph-grid">
          <div class="col-md-12 col">
            <div class="content">
             <p class="title">Total sales</p>
              <div class="row rr-si">
                  <div class="col-md-8 col-c1">
                    <form class="navbar-form navbar-right" role="search">
                      <div class="form-group text-left"> 
                        <input type="text" class="form-control" size="10" placeholder="Search by services name and products name">
                        <div class="glyphicon glyphicon-search btn-search"></div>
                      </div>
                    </form>
                  </div>
                  <div class="col-md-4 col-c2">
                    <ul class="pagination"> 
                      <li class="page-item"><button class="page-link type-alternative" onclick="loadDetailsChart(sales, 'yearly', 0)">Yearly</button></li>
                      <li class="page-item"><button class="page-link type-alternative" onclick="loadDetailsChart(sales, 'monthly', 1)">Monthly</button></li>
                      <li class="page-item"><button class="page-link type-alternative" onclick="loadDetailsChart(sales, 'weekly', 2)">Weekly</button></li>
                      <li class="page-item"><button class="page-link type-alternative" onclick="loadDetailsChart(sales, 'daily', 3)">Daily</button></li>
                    </ul>
                  </div>
              </div>
              <div id="canvas-container">
                 <canvas id="product_details_chart" width="400" height="200"></canvas>              
              </div>
            </div>
            
          </div>
      </div>
    </div>

    <script src="../script.js"></script>
  </body>
</html>