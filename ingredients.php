<?php
  $page_title = 'All Ingredients';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
  $ingredients = join_ingredient_table(); // You need to implement this function in your codebase
?>
<style>
  .ingredients {
    background-color:#35404d;
    border-radius: 8px;
  }
</style>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <div class="pull-right">
          <a href="add_ingredient.php" class="btn btn-primary">Add New</a>
        </div>
        <div class="pull-left">
          <input type="text" id="search" class="form-control" placeholder="Search...">
        </div>
      </div>
      <div class="panel-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th class="text-center" style="width: 50px;">#</th>
              <th> Photo</th>
              <th> Ingredient Name </th>
              <th class="text-center" style="width: 10%;"> Category </th>
              <th class="text-center" style="width: 10%;"> In-Stock </th>
              <th class="text-center" style="width: 10%;"> Purchase Price </th>
              <th class="text-center" style="width: 10%;"> Sale Price </th>
              <th class="text-center" style="width: 10%;"> Date Added </th>
              <th class="text-center" style="width: 10%;"> Expiry </th>
              <th class="text-center" style="width: 10%;"> Supplier </th>
              <th class="text-center" style="width: 100px;"> Actions </th>
            </tr>
          </thead>
          <tbody id="table-body">
            <?php foreach ($ingredients as $ingredient):?>
              <tr>
                <td class="text-center"><?php echo count_id();?></td>
                <td>
                  <?php if($ingredient['media_id'] === '0'): ?>
                    <img class="img-avatar img-circle" src="uploads/ingredients/no_image.png" alt="">
                  <?php else: ?>
                    <img class="img-avatar img-circle" src="uploads/ingredients/<?php echo $ingredient['image']; ?>" alt="">
                  <?php endif; ?>
                </td>
                <td> <?php echo remove_junk($ingredient['ingredient_name']); ?></td>
                <td class="text-center"> <?php echo remove_junk($ingredient['category']); ?></td>
                <td class="text-center"> <?php echo remove_junk($ingredient['stock_quantity']); ?></td>
                <td class="text-center"> <?php echo remove_junk($ingredient['purchase_price']); ?></td>
                <td class="text-center"> <?php echo remove_junk($ingredient['sale_price']); ?></td>
                <td class="text-center"> <?php echo read_date($ingredient['date_added']); ?></td>
                <td class="text-center"> <?php echo read_date($ingredient['expiry']); ?></td>
                <td class="text-center"> <?php echo remove_junk($ingredient['supplier']); ?></td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="edit_ingredient.php?id=<?php echo (int)$ingredient['ingredient_id'];?>" class="btn btn-info btn-xs"  title="Edit" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    <a href="delete_ingredient.php?id=<?php echo (int)$ingredient['ingredient_id'];?>" class="btn btn-danger btn-xs"  title="Delete" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-trash"></span>
                    </a>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php include_once('layouts/footer.php'); ?>
<script>
  // Add event listener for input in the search bar
  document.getElementById('search').addEventListener('input', function() {
    var searchText = this.value.toLowerCase();
    var rows = document.querySelectorAll('#table-body tr');

    rows.forEach(function(row) {
      var cells = row.getElementsByTagName('td');
      var found = false;
      
      for (var i = 0; i < cells.length && !found; i++) {
        var cellText = cells[i].textContent.toLowerCase();
        if (cellText.indexOf(searchText) > -1) {
          found = true;
        }
      }
      
      row.style.display = found ? '' : 'none';
    });
  });
</script>
