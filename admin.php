<?php
$page_title = 'Admin Home Page';
require_once('includes/load.php');

// Checkin What level user has permission to view this page
page_require_level(1);

?>
<?php
$c_categorie     = count_by_id('categories');
$c_product       = count_by_id('products');
$c_sale          = count_by_id('sales');
$c_user          = count_by_id('users');
$products_sold   = find_higest_saleing_product('10');
$recent_products = find_recent_product_added('5');
$recent_sales    = find_recent_sale_added('5')
?>
<?php include_once('layouts/header.php'); ?>
<style>
  .admin {
    background-color: #35404d;
    border-radius: 8px;
  }
  .panel-box {
    height: auto !important;
  }
</style>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">
  <a href="users.php" style="color:black;">
    <div class="col-md-3 hvr-grow">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-secondary1">
          <i class="glyphicon glyphicon-user"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top"> <?php echo $c_user['total']; ?> </h2>
          <p class="text-muted">Users</p>
        </div>
      </div>
    </div>
  </a>

  <a href="categorie.php" style="color:black;">
    <div class="col-md-3 hvr-grow">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-red">
          <i class="glyphicon glyphicon-th-large"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top"> <?php echo $c_categorie['total']; ?> </h2>
          <p class="text-muted">Categories</p>
        </div>
      </div>
    </div>
  </a>

  <a href="product.php" style="color:black;">
    <div class="col-md-3 hvr-grow">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-blue2">
          <i class="glyphicon glyphicon-shopping-cart"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top"> <?php echo $c_product['total']; ?> </h2>
          <p class="text-muted">Products</p>
        </div>
      </div>
    </div>
  </a>

  <a href="sales.php" style="color:black;">
    <div class="col-md-3 hvr-grow">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-green">
        <i class="fa-solid fa-peso-sign"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top"> <?php echo $c_sale['total']; ?></h2>
          <p class="text-muted">Sales</p>
        </div>
      </div>
    </div>
  </a>
</div>


<div class="row">
  <!-- Product Stocks Panel -->
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Product Stocks</span>
        </strong>
      </div>
      <div class="panel-body">
        <table class="table table-striped table-bordered table-condensed">
          <thead>
            <tr>
              <th>Title</th>
              <th>Total Quantity</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($products_sold as $product_sold) : ?>
              <tr>
                <td><?php echo remove_junk(first_character($product_sold['name'])); ?></td>
                <td><?php echo (int)$product_sold['totalQty']; ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
<!-- Raw Ingredients Stocks and Expiry Panel -->
<div class="col-md-6">
  <div class="panel panel-default">
    <div class="panel-heading">
      <strong>
        <span class="glyphicon glyphicon-th"></span>
        <span>Raw Ingredients Stocks and Expiry</span>
      </strong>
    </div>
    <div class="panel-body">
      <table class="table table-striped table-bordered table-condensed">
        <thead>
          <tr>
            <th>Title</th>
            <th>Total Quantity</th>
            <th>Expiry</th>
          </tr>
        </thead>
        <tbody>
          <?php
            // Connect to your database
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "scinventory_system";

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch data from the database
            $sql = "SELECT ingredient_name, stock_quantity, expiry FROM raw_ingredients";
            $result = $conn->query($sql);

            // Display data in the table
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["ingredient_name"] . "</td>";
                    echo "<td>" . $row["stock_quantity"] . "</td>";
                    echo "<td>" . $row["expiry"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No raw ingredients found</td></tr>";
            }

            // Close the connection
            $conn->close();
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

</div>



<!-- Chart -->
<div class="row">
    <?php
    require_once('chart.php');
    ?>
</div>

<!-- End Chart -->
<div class="row">
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Highest Selling Products</span>
        </strong>
      </div>
      <div class="panel-body">
        <table class="table table-striped table-bordered table-condensed">
          <thead>
            <tr>
              <th>Title</th>
              <th>Total Sold</th>
              <th>Total Quantity</th>
            <tr>
          </thead>
          <tbody>
            <?php foreach ($products_sold as  $product_sold) : ?>
              <tr>
                <td><?php echo remove_junk(first_character($product_sold['name'])); ?></td>
                <td><?php echo (int)$product_sold['totalSold']; ?></td>
                <td><?php echo (int)$product_sold['totalQty']; ?></td>
              </tr>
            <?php endforeach; ?>
          <tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>LATEST SALES</span>
        </strong>
      </div>
      <div class="panel-body">
        <table class="table table-striped table-bordered table-condensed">
          <thead>
            <tr>
              <th class="text-center" style="width: 50px;">#</th>
              <th>Product Name</th>
              <th>Date</th>
              <th>Total Sale</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($recent_sales as  $recent_sale) : ?>
              <tr>
                <td class="text-center"><?php echo count_id(); ?></td>
                <td>
                  <a href="edit_sale.php?id=<?php echo (int)$recent_sale['id']; ?>">
                    <?php echo remove_junk(first_character($recent_sale['name'])); ?>
                  </a>
                </td>
                <td><?php echo remove_junk(ucfirst($recent_sale['date'])); ?></td>
                <td>₱<?php echo remove_junk(first_character($recent_sale['price'])); ?></td>
              </tr>

            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Recently Added Products</span>
        </strong>
      </div>
      <div class="panel-body">

        <div class="list-group">
          <?php foreach ($recent_products as  $recent_product) : ?>
            <a class="list-group-item clearfix" href="edit_product.php?id=<?php echo    (int)$recent_product['id']; ?>">
              <h4 class="list-group-item-heading">
                <?php if ($recent_product['media_id'] === '0') : ?>
                  <img class="img-avatar img-circle" src="uploads\products\no_image.png" alt="">
                <?php else : ?>
                  <img class="img-avatar img-circle" src="uploads/products/<?php echo $recent_product['image']; ?>" alt="" />
                <?php endif; ?>
                <?php echo remove_junk(first_character($recent_product['name'])); ?>
                <span class="label label-warning pull-right">
                ₱<?php echo (int)$recent_product['sale_price']; ?>
                </span>
              </h4>
              <span class="list-group-item-text pull-right">
                <?php echo remove_junk(first_character($recent_product['categorie'])); ?>
              </span>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">

</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<script>
$(document).ready(function(){
    // AJAX call to fetch data from the PHP file
    $.ajax({
        url: "check_quantity.php",
        type: "GET",
        dataType: "json",
        success: function(response) {
            // Check if there are low stock items
            if(response.length > 0) {
                // Show Toastr notification for each low stock item
                $.each(response, function(index, item) {
                    toastr.warning(item + " is low in stock!");
                });
            }
        },
        error: function(xhr, status, error) {
            console.error("Error:", error);
        }
    });
});
</script>
<script>
$(document).ready(function(){
    // AJAX call to fetch data from the PHP file
    $.ajax({
        url: "check_expiry.php",
        type: "GET",
        dataType: "json",
        success: function(response) {
            // Check if there are items expiring within 7 days
            if(response.length > 0) {
                // Show Toastr notification for each item
                $.each(response, function(index, item) {
                    toastr.error(item + " is expiring within 7 days!");
                });
            }
        },
        error: function(xhr, status, error) {
            console.error("Error:", error);
        }
    });
});
</script>



<?php include_once('layouts/footer.php'); ?>