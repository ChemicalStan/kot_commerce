<?php require_once('includes/admin_header.php'); ?>

<?php 
    try{

        $sql = "SELECT * FROM categories";
        $stmt = $pdo->query($sql);
    }catch(PDOExeption $e){
        $message = $e->getMessage();
        echo $message;
    }

?>
<div class="page-container">
    <div class="col-lg-10">
            <div class="card">
                <div class="card-header">
                    <strong>Add Product</strong>
                    <small> Page</small>
                </div>

                <form action="./add_products.php" method="post">
                <div class="card-body card-block">
                    <div class="form-group">
                        <label for="Product Name" class=" form-control-label">Product Name</label>
                        <input type="text" name="product_name" placeholder="Enter Product Name" class="form-control">
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="Product Category" class="form-control-label">Product Category</label>
                        <select name="product_category" id="<?php echo $cat_id?>">
                        <?php 
                         while($row = $stmt->fetch(PDO::FETCH_OBJ)){
                            $cat_title = $row->cat_title;
                            $cat_id = $row->cat_id;
                            echo "<option value='$cat_id'>$cat_title</option>";
                         }
                        ?>
                        </select>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="Product Price" class=" form-control-label">Product Price</label>
                        <input type="text" name="product_price" placeholder="Enter Product Price" class="form-control">
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="Product Image" class=" form-control-label">Product Image</label>
                        <input type="file" name="product_imagine" class="form-control">
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="Product Quantity" class=" form-control-label">Product Quantity</label>
                        <input type="text" name="product_quantity" placeholder="Enter Product Quantity" class="form-control">
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="Product Status" class="form-control-label">Product Status</label>
                        <select name="product_status">
                       
                        <option value='Published'>Publish</option>
                        <option value='Draft'>Draft</option>
                         
                        </select>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="Product Tag" class=" form-control-label">Product Tag</label>
                        <input type="text" name="Product Tag" placeholder="Product Tag" class="form-control">
                    </div>
                    <hr>
                    <input type="submit" class="btn btn-success btn-sm" name="submit" value="Add Product">

                </div>
             </form>
            </div>
        </div>
    </div> 

    <?php 

     if (isset($_POST["submit"])) {
        echo $product_name = $_POST["product_name"];
        echo $product_cat_id = $_POST["product_category"];
        $product_price = $_POST["product_price"];

        $product_name = $_POST["product_name"];

        $product_quantity = $_POST["product_quantity"];
        echo $product_status = $_POST["product_status"];
        $product_category = $_POST["product_tag"];

         
     }


    ?>



<?php require_once"includes/admin_footer.php"; ?>