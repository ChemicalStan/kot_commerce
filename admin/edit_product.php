<?php require_once"includes/admin_header.php";

// CODE TO CATCH THE POST ID TO BE EDITED
	if (isset($_POST['product_id'])) {
		$edit_product_id = $_POST['product_id'];

// CODE TO FETCH POST'S DATAS FROM DATABASE
		try {
			$sql = "SELECT * FROM products WHERE product_id = :product_id";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([':product_id'=>$edit_product_id]);
			$products = $stmt->fetchAll();

			foreach ($products as $product) {
				$db_product_name = $product->product_name;
				$db_product_cat_id = $product->product_cat_id;
				$db_product_price = $product->product_price;
				$db_product_image = $product->product_image;
				$db_product_quantity = $product->product_quantity;
				$db_product_status = $product->product_status;
				$db_product_tag = $product->product_tag;
			}

		} catch (Exception $e) {
			echo $message = $e->getMessage();
			
		}


	}
// CODE TO CATCH SUCCES OR ERROR MESSAGE
    if (isset($_GET['message'])) {
       $message = $_GET['message'];
       if (strlen($message) < 23) {
        $success_message = $_GET['message'];
       }else{$error_message = $_GET['message'];}
    }


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
// move uploaded image to a temporary folder 
        move_uploaded_file($product_image_tmp, "../img/$product_image");

// update product in database
  if (!empty($product_name) && !empty($product_price) && !empty($product_image)) {
    
    try{
        $sql = "INSERT INTO products(product_name, product_cat_id, product_price, product_image, product_quantity, product_status, product_tag) VALUES (:pname, :pcat_id, :pprice, :pimage, :pquantity, :pstatus, :ptag)";
        $stmt = $pdo->prepare($sql);

        $stmt->execute(['pname'=>$product_name, 'pcat_id'=>$product_cat_id, 'pprice'=>$product_price, 'pimage'=>$product_image, 'pquantity'=>$product_quantity, 'pstatus'=>$product_status, 'ptag'=>$product_tag]);

        $message = "<h5 class='bg-success text-center'>Product Added Succesfully.</h5>";

        header("Location:./edit_products.php?message=$message");
     }catch(PDOExeption $e){
        echo $message = $e->getMessage();
     }
   }else{
    $message = "<h5 class='bg-warning text-center'>Please No Field Should Be Left Empty!</h5>";
    header("Location:./edit_product.php?message=$message");
   }
         
}

    ?>
<div class="page-container">
    <div class="col-lg-10">
            <div class="card">
                <div class="card-header">
                    <strong>Edit Product</strong>
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
                        <input type="text" name="product_name" value="<?php echo"$db_product_name";?>" class="form-control">
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="Product Category" class="form-control-label">Product Category</label>
                        <select name="product_category" id="<?php echo $cat_id?>">
 <?php 
 // CODE TO FETCH ALL CATEGORIES AND DISPLAY IN SELECT OPTION
   try{
        $sql1 = "SELECT * FROM categories WHERE cat_id = :cat_id";
        $stmt1 = $pdo->prepare($sql1);
        $stmt1->execute([':cat_id'=>$db_product_cat_id]);
        $default_cats = $stmt1->fetchAll();

        foreach ($default_cats as $default_cat) {
        	$db_product_cat_title = $default_cat->cat_title;
        	echo "<option value='$db_product_cat_id'>$db_product_cat_title</option>";
        }
        $sql = "SELECT * FROM categories WHERE cat_id != :cat_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':cat_id'=>$db_product_cat_id]);
        $categories = $stmt->fetchAll();
	    foreach($categories as $category){
	        $cat_title = $category->cat_title;
	        $cat_id = $category->cat_id;
	        echo "<option value='$cat_id'>$cat_title</option>";
	    }

    }catch(PDOException $e){
        $error = $e->getMessage();
        echo $error;
    }

?>
                        </select>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="Product Price" class=" form-control-label">Product Price</label>
                        <input type="text" name="product_price" value="<?php echo"$db_product_price";?>" class="form-control">
                    </div>
                    <hr>
                    <div class="form-group">
                    	<!-- how to set default image file in html/php -->
                        <label for="Product Image" class=" form-control-label">Product Image</label>
                        <img width="100" src="../img/<?php echo $db_product_image?>" alt="">
                        <input type="file" name="image" class="form-control" value="<?php echo"$db_product_image";?>">
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="Product Quantity" class=" form-control-label">Product Quantity</label>
                        <input type="text" name="product_quantity" value="<?php echo"$db_product_quantity";?>" class="form-control">
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="Product Status" class="form-control-label">Product Status</label>

                        <select name="product_status">
                        <?php 
                        // CODE TO DISPLAY DEFAULT PRODUCT STATUS
							echo "<option value='$db_product_status'>$db_product_status</option>";
							if ($db_product_status == 'Published') {
								echo "<option value='Draft'>Draft</option>";
							}else{
								echo "<option value='Published'>Publish</option>";
							}
                        ?>                         
                        </select>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="Product Tag" class=" form-control-label">Product Tag</label>
                        <input type="text" name="product_tag" value="<?php echo"$db_product_tag";?>" class="form-control">
                    </div>
                    <hr>
                    <div class="form-group">
                    <input type="submit" class="btn btn-success btn-sm" name="submit" value="Edit Product">
                    </div>
                </div>
             </form>
            </div>
        </div>
    </div> 



<?php require_once"includes/admin_footer.php"; ?>