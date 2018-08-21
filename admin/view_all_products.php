<?php require_once"./includes/admin_header.php"; ?>

    <div class="row m-t-30">
        <div class="col-md-12">
            <!-- DATA TABLE-->
          <div class="col-lg-12">
            <div class="table-responsive table--no-card m-b-30">
                <table class="table table-bordered table-hover table-earning">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Image</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-right">Status</th>
                            <th class="text-center">Tag</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Edit</th>
                            <th class="text-center">Delete</th>                            
                        </tr>
                    </thead>
                    <tbody>


<?php 

try {

    $sql = "SELECT * FROM products";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll();

    foreach ($products as $product) {
    $product_id = $product->product_id;
    $product_name = $product->product_name;
    $product_cat_id = $product->product_cat_id;
    $product_price = $product->product_price;
    $product_image = $product->product_image;
    $product_quantity = $product->product_quantity;
    $product_status = $product->product_status;
    $product_tag = $product->product_tag;
    $product_date = $product->date_added;

        // $sql = "SELECT * FROM categories WHERE cat_id = :cat_id";
        // $stmt = $pdo->prepare($sql);
        // $stmt = $execute(['cat_id'=>$product_cat_id]);
        // $category = $stmt->fetchAll();
        // echo $cat_title = $category->cat_title;

        


echo    "<tr>
            <td>$product_id</td>
            <td>$product_name</td>";

// TO DISPLAY CATEGORY TITLE INSTEAD OF CATEGORY ID  
        $sql = "SELECT * FROM categories WHERE cat_id = :cat_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['cat_id'=>$product_cat_id]);
        $categories = $stmt->fetchAll(PDO::FETCH_OBJ);
            foreach ($categories as $category) {
                $product_cat_title = $category->cat_title;
                echo "<td>$product_cat_title</td>";
            }
            

 echo      "<td class='text-center'>$product_price</td>
            <td class='text-center'>
            <img class='img-responsive' src='/kingot/img/$product_image' alt='$product_name'>
            </td>
            <td class='text-center'>$product_quantity</td>
            <td class='text-center'>$product_status</td>
            <td class='text-center'>$product_tag</td>
            <td class='text-center'>$product_date</td>
            <td>
              <form method='POST' action='edit_product.php'>
                <input type='hidden' name='product_id' value='$product_id'>
                <input class='btn btn-warning' type='submit' name='edit' value='Edit'>
              </form>       
            </td>
            <td>
              <form method='POST' action='delete_product.php'>
                <input type='hidden' name='product_id' value='$product_id'>
                <input class='btn btn-danger' type='submit' name='delete' value='Delete'>
              </form>       
            </td>

        </tr>";
    }
                                
    } catch (Exception $e) {
                               $error = $e->getMessage(); 
                               echo $error;
                            }                            


?>
        
                    </tbody>
                </table>
            </div>
		  </div>
            <!-- END DATA TABLE-->
        </div>
    </div>

<?php require_once"./includes/admin_footer.php"; ?>