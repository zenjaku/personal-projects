<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/tomaraoStyles.css">
	<title> Edit Product </title>
</head>

<body id="editProduct">
	<!----- PHP Connection Section ---->
	<?php
	include_once('php/tomaraoConnection.php');
	$product_id = $_GET['product_id'];

	$search_product = mysqli_query($tomarao, "SELECT * FROM products WHERE product_id = '$product_id'");

	if ($row = mysqli_fetch_assoc($search_product)) { ?>

		<!----- Product Edit Section ---->

		<div class="">
			<form action="php/tomaraoEditProduct.php" method="POST">
				<input type="hidden" value="<?= $row['product_id']; ?>" name="product_id">
				<input type="hidden" value="<?= $row['image_url']; ?>" name="image">

				<h1 style="text-align: center; text-transform: uppercase;">EDIT <?= $row['name']; ?></h1>

				<table>
					<tr>
						<td><label for="name"><b>Product Name</b></label></td>
						<td colspan="2"><input class="inputname" type="text" placeholder="Enter Product Name" name="name"
								value="<?= $row['name']; ?>" required></td>
					</tr>
					<tr>
						<td><label for="unit"><b>Unit</b></label></td>
						<td colspan="2"><input class="inputname" type="text" placeholder="Enter Unit" name="unit"
								value="<?= $row['unit']; ?>" required></td>
					</tr>
					<tr>
						<td><label for="price_per_unit"><b>Price Per Unit</b></label></td>
						<td colspan="2"><input class="inputpass" type="text" placeholder="Enter Price Per Unit" name="price_per_unit"
								value="<?= $row['price_per_unit']; ?>" required></td>
					</tr>
					<tr>
						<td><label for="image_url"><b>Image URL</b></label></td>
						<td colspan="2"><input class="inputpass" type="file" placeholder="Enter Image URL" name="image_url" style="background-color: white;"></td>
					</tr>

					<tr>
						<td></td>
						<td><button type="submit" class="tomaraoCompute" name="update">Update</button></td>
						<td><button type="submit" class="tomaraoClear" formaction="tomaraoProduct.php">Cancel</button></td>
					</tr>

				</table>

			</form>
			<?php
	}
	?>
	</div>
</body>

</html>