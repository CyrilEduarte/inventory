<?php
function find_by_id2($table, $id)
{
    global $db;
    $id = (int)$id;
    if (tableExists($table)) {
        $sql = "SELECT * FROM {$table} WHERE ingredient_id={$id} LIMIT 1";
        if ($result = $db->query($sql)) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }
}

$page_title = 'Edit Ingredient';
require_once('includes/load.php');
// Checking What level user has permission to view this page
page_require_level(2);

$product = find_by_id2('raw_ingredients', (int)$_GET['id']);
$all_categories = find_all('categories');
$all_photo = find_all('media');

if (!$product) {
  $session->msg("d", "Missing ingredient id.");
  redirect('ingredients.php');
}

if (isset($_POST['product'])) {
  $req_fields = array('product-title', 'product-categorie', 'product-quantity', 'buying-price', 'saleing-price');
  validate_fields($req_fields);

  if (empty($errors)) {
    $p_name  = remove_junk($db->escape($_POST['product-title']));
    $p_cat   = (int)$_POST['product-categorie'];
    $p_qty   = remove_junk($db->escape($_POST['product-quantity']));
    $p_buy   = remove_junk($db->escape($_POST['buying-price']));
    $p_sale  = remove_junk($db->escape($_POST['saleing-price']));
    if (is_null($_POST['product-photo']) || $_POST['product-photo'] === "") {
      $media_id = '0';
    } else {
      $media_id = remove_junk($db->escape($_POST['product-photo']));
    }

    $query   = "UPDATE raw_ingredients SET ";
    $query  .= "ingredient_name ='{$p_name}', stock_quantity ='{$p_qty}', ";
    $query  .= "purchase_price ='{$p_buy}', sale_price ='{$p_sale}', category_id ='{$p_cat}', media_id='{$media_id}' ";
    $query  .= "WHERE ingredient_id ='{$product['ingredient_id']}'";
    $result = $db->query($query);

    if ($result && $db->affected_rows() === 1) {
      $session->msg('s', "Ingredient updated ");
      $insert_log = insert_logs(ucfirst($user['name']), 'Updated an Ingredient', date('Y-m-d H:i:s'));
      redirect('ingredients.php', false);
    } else {
      $session->msg('d', 'Sorry failed to update!');
      redirect('edit_ingredient.php?id=' . $product['ingredient_id'], false);
    }
  } else {
    $session->msg("d", $errors);
    redirect('edit_ingredient.php?id=' . $product['ingredient_id'], false);
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
  <div class="panel panel-default">
    <div class="panel-heading">
      <strong>
        <span class="glyphicon glyphicon-th"></span>
        <span>Edit Ingredient Details</span>
      </strong>
    </div>

    <div class="panel-body">
      <div class="col-md-7">
        <form method="post" action="edit_ingredient.php?id=<?php echo (int)$product['ingredient_id'] ?>">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-th-large"></i>
              </span>
              <input type="text" class="form-control" name="product-title" value="<?php echo remove_junk($product['ingredient_name']); ?>">
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <select class="form-control" name="product-categorie">
                  <option value=""> Select a category</option>
                  <?php foreach ($all_categories as $cat) : ?>
                    <option value="<?php echo (int)$cat['id']; ?>" <?php if ($product['category_id'] === $cat['id']) : echo "selected";
                                                                    endif; ?>>
                      <?php echo remove_junk($cat['name']); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="col-md-6">
                <select class="form-control" name="product-photo">
                  <option value=""> No image</option>
                  <?php foreach ($all_photo as $photo) : ?>
                    <option value="<?php echo (int)$photo['id']; ?>" <?php if ($product['media_id'] === $photo['id']) : echo "selected";
                                                                      endif; ?>>
                      <?php echo $photo['file_name'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="qty">Quantity</label>
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="glyphicon glyphicon-shopping-cart"></i>
                    </span>
                    <input type="number" class="form-control" name="product-quantity" value="<?php echo remove_junk($product['stock_quantity']); ?>">
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label for="qty">Buying price</label>
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="fa-solid fa-peso-sign"></i>
                    </span>
                    <input type="number" class="form-control" name="buying-price" value="<?php echo remove_junk($product['purchase_price']); ?>">
                    <span class="input-group-addon">.00</span>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label for="qty">Selling price</label>
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="fa-solid fa-peso-sign"></i>
                    </span>
                    <input type="number" class="form-control" name="saleing-price" value="<?php echo remove_junk($product['sale_price']); ?>">
                    <span class="input-group-addon">.00</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <button type="submit" name="product" class="btn btn-danger">Update</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>
