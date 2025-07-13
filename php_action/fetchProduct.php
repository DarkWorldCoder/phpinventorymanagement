<?php 	



require_once 'core.php';

$sql = "SELECT product.product_id, product.product_name, product.product_image, product.brand_id,
 		product.categories_id, product.quantity, product.rate, product.active, product.status, 
 		brands.brand_name, categories.categories_name FROM product 
		INNER JOIN brands ON product.brand_id = brands.brand_id 
		INNER JOIN categories ON product.categories_id = categories.categories_id  
		WHERE product.status = 1 AND product.quantity>0";

$result = $connect->query($sql);

$output = array('data' => array());

if($result->num_rows > 0) { 

 // $row = $result->fetch_array();
 $active = ""; 

 while($row = $result->fetch_array()) {
 	$productId = $row[0];
 	// active 
 	if($row[7] == 1) {
 		// activate member
 		$active = "<label class='label label-success'>Available</label>";
 	} else {
 		// deactivate member
 		$active = "<label class='label label-danger'>Not Available</label>";
 	} // /else

 	$button = '
	<div class="btn-group" style="position: relative;">
	  <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border: 1px solid var(--gray-300); background: white; color: var(--gray-700); padding: 4px 8px; font-size: 12px;">
	    <i class="fa fa-cog"></i> Action <span class="caret"></span>
	  </button>
	  <ul class="dropdown-menu dropdown-menu-right" style="min-width: 120px; z-index: 1050; background: white; border: 1px solid var(--gray-200); border-radius: 6px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);">
	    <li>
	      <a href="javascript:void(0)" data-toggle="modal" data-target="#editProductModal" onclick="editProduct('.$productId.')" style="padding: 8px 12px; color: var(--gray-700); text-decoration: none; display: block; font-size: 13px;">
	        <i class="fa fa-edit" style="color: var(--primary-600); margin-right: 6px;"></i> Edit Product
	      </a>
	    </li>
	    <li style="border-top: 1px solid var(--gray-100);">
	      <a href="javascript:void(0)" data-toggle="modal" data-target="#removeProductModal" onclick="removeProduct('.$productId.')" style="padding: 8px 12px; color: var(--danger-600); text-decoration: none; display: block; font-size: 13px;">
	        <i class="fa fa-trash" style="color: var(--danger-600); margin-right: 6px;"></i> Remove Product
	      </a>
	    </li>       
	  </ul>
	</div>';

	// $brandId = $row[3];
	// $brandSql = "SELECT * FROM brands WHERE brand_id = $brandId";
	// $brandData = $connect->query($sql);
	// $brand = "";
	// while($row = $brandData->fetch_assoc()) {
	// 	$brand = $row['brand_name'];
	// }

	$brand = $row[9];
	$category = $row[10];

	$imageUrl = substr($row[2], 3);
	$productImage = "<img class='img-round' src='".$imageUrl."' style='height:30px; width:50px;'  />";

 	$output['data'][] = array( 		
 		// image
 		$productImage,
 		// product name
 		$row[1], 
 		// rate
 		$row[6],
 		// quantity 
 		$row[5], 		 	
 		// brand
 		$brand,
 		// category 		
 		$category,
 		// active
 		$active,
 		// button
 		$button 		
 		); 	
 } // /while 

}// if num_rows

$connect->close();

echo json_encode($output);