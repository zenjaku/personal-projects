<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" type="text/css" href="css/tomaraoStyles.css">
	<title> Available Products </title>
</head>

<body id="adminPage">
	<h1> Available Products </h1>
	<form action="" method="POST" autocomplete="off">
		<div class="content">
			<table>
				<tr>
					<td>
						<h2> PRODUCT NAME </h2>
					</td>
					<td>
						<h2> UNIT </h2>
					</td>
					<td>
						<h2> PRICE PER UNIT </h2>
					</td>
					<td>
						<h2> IMAGE </h2>
					</td>
					<td>
						<h2> ACTION </h2>
					</td>
				</tr>

				<?php
				include_once('php/tomaraoConnection.php');
				$search_product = mysqli_query($tomarao, "SELECT * FROM `products`");


				while ($row = mysqli_fetch_assoc($search_product)) {
					?>

					<tr>
						<td>
							<h2> <?= $row['name'] ?> </h2>
						</td>

						<td>
							<h2> <?= $row['unit'] ?> </h2>
						</td>

						<td>
							<h2> <?= $row['price_per_unit'] ?> </h2>
						</td>

						<td>
							<img class="product_img" src="pictures/<?php echo $row['image_url']; ?>" alt="#">
						</td>

						<td class="adminBtn">
							<input type="hidden" name="name" value="<?= $row['name'] ?>">
							<input type="hidden" name="unit" value="<?= $row['unit'] ?>">
							<a class="tomaraoBtn1" href="tomaraoEditProduct.php?product_id=<?= $row['product_id'] ?>"> Edit
							</a> <br>
							<a class="tomaraoBtn1" href="php/tomaraoDeleteProduct.php?product_id=<?= $row['product_id'] ?>"
								onclick="return confirm ('Are you sure you want to delete the product?')"> Delete </a>
						</td>
					</tr>

					<?php
				}
				?>
			</table>
		</div>
	</form>
</body>

</html>