<?php 
require_once"../includes/db.php";

if (isset($_POST['product_id'])) {
	$edit_product_id = $_POST['product_id'];
	
	try{
		// CODE TO DELETE PRODUCT FROM DATABASE
			$sql = "DELETE FROM products WHERE product_id= :p_id";
			$stmt = $pdo->prepare($sql);
			$stmt->execute(['p_id'=>$edit_product_id]);
			$message = "Product Deleted Succesfully";

			header("Location:./view_all_products.php?message=$message");

		}catch(Exception $e){
			echo $error= $e->getMessage();
		}

}







 ?>