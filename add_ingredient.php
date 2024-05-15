<?php
  $page_title = 'Add Ingredient';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
  $all_categories = find_all('categories');
  $all_photo = find_all('media');
  $username = $_SESSION['username'];
?>
<?php
 if(isset($_POST['add_ingredient'])){
   $req_fields = array('ingredient-title','ingredient-category','ingredient-quantity','purchase-price', 'sale-price', 'expiry', 'supplier', 'ingredient-unit');
   validate_fields($req_fields);
   if(empty($errors)){
     $i_name  = remove_junk($db->escape($_POST['ingredient-title']));
     $i_cat   = remove_junk($db->escape($_POST['ingredient-category']));
     $i_qty   = remove_junk($db->escape($_POST['ingredient-quantity']));
     $i_buy   = remove_junk($db->escape($_POST['purchase-price']));
     $i_sale  = remove_junk($db->escape($_POST['sale-price']));
     $expiry  = remove_junk($db->escape($_POST['expiry']));
     $supplier = remove_junk($db->escape($_POST['supplier']));
     $i_unit  = remove_junk($db->escape($_POST['ingredient-unit']));

     if (is_null($_POST['ingredient-photo']) || $_POST['ingredient-photo'] === "") {
       $media_id = '0';
     } else {
       $media_id = remove_junk($db->escape($_POST['ingredient-photo']));
     }
     $date    = make_date();
     $query  = "INSERT INTO raw_ingredients (";
     $query .=" ingredient_name,stock_quantity,unit,purchase_price,sale_price,category_id,media_id,date_added,expiry,supplier";
     $query .=") VALUES (";
     $query .=" '{$i_name}', '{$i_qty}', '{$i_unit}', '{$i_buy}', '{$i_sale}', '{$i_cat}', '{$media_id}', '{$date}', '{$expiry}', '{$supplier}'";
     $query .=")";
     $query .=" ON DUPLICATE KEY UPDATE ingredient_name='{$i_name}'";
     if($db->query($query)){
       $session->msg('s',"Ingredient added ");
       insert_logs($username, 'Added an Ingredient', date('Y-m-d H:i:s'));
       redirect('add_ingredient.php', false);
     } else {
       $session->msg('d',' Sorry failed to add!');
       redirect('ingredients.php', false);
     }

   } else{
     $session->msg("d", $errors);
     redirect('add_ingredient.php',false);
   }

 }

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">
  <div class="col-md-8">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Add New Ingredient</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-12">
          <form method="post" action="add_ingredient.php" class="clearfix">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="ingredient-title" placeholder="Ingredient Title">
               </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <select class="form-control" name="ingredient-category">
                      <option value="">Select Ingredient Category</option>
                    <?php  foreach ($all_categories as $cat): ?>
                      <option value="<?php echo (int)$cat['id'] ?>">
                        <?php echo $cat['name'] ?></option>
                    <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <select class="form-control" name="ingredient-photo">
                      <option value="">Select Ingredient Photo</option>
                    <?php  foreach ($all_photo as $photo): ?>
                      <option value="<?php echo (int)$photo['id'] ?>">
                        <?php echo $photo['file_name'] ?></option>
                    <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>

              <div class="form-group">
               <div class="row">
                 <div class="col-md-3">
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-shopping-cart"></i>
                     </span>
                     <input type="number" class="form-control" name="ingredient-quantity" placeholder="Stock Quantity">
                  </div>
                 </div>
                 <div class="col-md-3">
                   <select class="form-control" name="ingredient-unit">
                     <option value="">Select Unit</option>
                     <option value="mg">mg</option>
                     <option value="kg">kg</option>
                     <option value="liter">liter</option>
                     <option value="milliliter">milliliter</option>
                     <option value="milliliter">pcs</option>
                   </select>
                 </div>
                 <div class="col-md-3">
                   <div class="input-group">
                     <span class="input-group-addon">
                       <i class="fa-solid fa-peso-sign"></i>
                     </span>
                     <input type="number" class="form-control" name="purchase-price" placeholder="Cost" value="0">
                     <span class="input-group-addon">.00</span>
                  </div>
                 </div>
                  <!-- <div class="col-md-3">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="fa-solid fa-peso-sign"></i>
                      </span>
                      <input type="number" class="form-control" name="sale-price" placeholder="Sale Price" value="0">
                      <span class="input-group-addon">.00</span>
                   </div>
                  </div> -->
               </div>
              </div>

              <!-- Add expiry and supplier fields -->
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-calendar"></i>
                      </span>
                      <input type="date" class="form-control" name="expiry" placeholder="Expiry Date">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-user"></i>
                      </span>
                      <input type="text" class="form-control" name="supplier" placeholder="Supplier">
                    </div>
                  </div>
                </div>
              </div>
              <!-- End of expiry and supplier fields -->

              <button type="submit" name="add_ingredient" class="btn btn-danger">Add Ingredient</button>
          </form>
         </div>
        </div>
      </div>
    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
