<?php require_once('includes/admin_header.php'); 
    if (isset($_GET['message'])) {
       $message = $_GET['message'];
       if (strlen($message) < 23) {
        $success_message = $_GET['message'];
       }else{$error_message = $_GET['message'];}
    }
?>

<?php 
    try{

        $sql = "SELECT * FROM categories";
        $stmt = $pdo->query($sql);
    }catch(PDOException $e){
        $error = $e->getMessage();
        echo $error;
    }

?>

    <?php 

// THE PHP CODES BELOW HANDLES THE FILES COMMING FROM THE ABOVE FORM INTO THE DATABASE

     if (isset($_POST["submit"])) {
        $product_name = $_POST["product_name"];
        $product_cat_id = $_POST["product_category"];
        $product_price = $_POST["product_price"];
        $product_image = $_FILES['image']['name'];
        $product_image_tmp = $_FILES['image']['tmp_name'];
        $product_quantity = $_POST["product_quantity"];
        $product_status = $_POST["product_status"];
        $product_tag = $_POST["product_tag"];
        $date_added = date('y-m-d');
        
// move uploaded image to a temporary folder 
        move_uploaded_file($product_image_tmp, "../img/$product_image");

// move items to database
  if (!empty($product_name) && !empty($product_price) && !empty($product_image)) {
    
              
    try{
        $sql = "INSERT INTO products(product_name, product_cat_id, product_price, product_image, product_quantity, product_status, product_tag, date_added) VALUES (:pname, :pcat_id, :pprice, :pimage, :pquantity, :pstatus, :ptag, :pdate)";
        $stmt = $pdo->prepare($sql);

        $stmt->execute(['pname'=>$product_name, 'pcat_id'=>$product_cat_id, 'pprice'=>$product_price, 'pimage'=>$product_image, 'pquantity'=>$product_quantity, 'pstatus'=>$product_status, 'ptag'=>$product_tag, 'pdate'=>$date_added]);

        $message = "<h5 class='bg-success text-center'>Product Added Succesfully.</h5>";

        header("Location:./add_product.php?message=$message");
     }catch(PDOExeption $e){
        echo $message = $e->getMessage();
     }
   }else{
    $message = "<h5 class='bg-warning text-center'>Please No Field Should Be Left Empty!</h5>";
    header("Location:./add_product.php?message=$message");
   }
         
}

    ?>
<div class="page-container">
    <div class="col-lg-10">
            <div class="card">
                <div class="card-header">
                    <strong>Add Product</strong>
                    <small> Page</small>
                </div>

                <form action="" method="post" enctype="multipart/form-data">
                <div class="card-body card-block">

                    <div class="form-group">

                        <!-- ERROR MESSAGE LOG -->
        <?php 
        if(isset($message)){ echo $message;}
        ?>
            
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
                        <input type="file" name="image" class="form-control">
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
                        <input type="text" name="product_tag" placeholder="Product Tag" class="form-control">
                    </div>
                    <hr>
                    <div class="form-group">
                    <input type="submit" class="btn btn-success btn-sm" name="submit" value="Add Product">
                    </div>
                </div>
             </form>
            </div>
        </div>
    </div> 





<?php require_once"includes/admin_footer.php"; ?>