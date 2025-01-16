<!DOCTYPE HTML>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/tomaraoStyles.css">
	<title></title>
</head>

<body id="products">
	<h1> Products Available </h1>
	<form action="php/tomaraoAdd.php" method="POST">

		<div class="content">
			<?php
			include_once('php/tomaraoConnection.php');
			$search_product = mysqli_query($tomarao, "SELECT * FROM products");

			while ($row = mysqli_fetch_assoc($search_product)) {
				?>
				<div class="product-container">
					<div class="img-container">
						<img class="product_img" src="pictures/<?php echo $row['image_url']; ?>" alt="#">
					</div>

					<div class="info-container">
						<h1>Product Name:
							<label class="lbl_inline">
								<!-- shortcut for echo --> <?= $row['name'] ?>
							</label>
						</h1>
						<h1>Product Price:
							<label class="lbl_inline">PHP &nbsp
								<?= $row['price_per_unit'] ?>
							</label>
						</h1>
					</div>

					<a href="tomaraoOrderAction.php?product_id=<?= $row['product_id'] ?>">
						<div class="buttonContainer">
							<button type="button" class="tomaraoBtn1" style="width: 100%;"> Order Now </button>
						</div>
					</a>


				</div>
				<?php
			}
			?>
		</div>
	</form>
</body>

</html>