<!DOCTYPE HTML>
<html>
 <head>
 	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
 	<link rel="stylesheet" type="text/css" href="css/tomaraoStyles.css">
 	<title> ADD PRODUCT </title>
 </head>
<body id="addProduct">
<form action="php/tomaraoAddProductAction.php" method="POST" autocomplete="off">
	<div class="whole-page">

	<h1> ADD PRODUCT </h1>
		
		<table>
			<tr>
				<td class="floresColumn"><label for="tomaraoPname"> Product Name </label></td>
				<td><input class="leftSide" type="text" id="tomaraoPname" name="name" required></td>
			</tr>

			<tr>
				<td class="floresColumn"><label for="tomaraoUnit"> Unit </label></td>
				<td><input class="leftSide" type="text" id="tomaraoUnit" name="unit" required></td>
			</tr>

			<tr>
				<td class="floresColumn"><label for="tomaraoPrice"> Price per Unit </label></td>
				<td><input class="leftSide" type="text" id="tomaraoPrice" name="price_per_unit" required></td>
			</tr>

			<tr>
				<td class="floresColumn"><label for="tomararaoFile"> Image URL </label></td>
				<td><input type="file" id="tomaraoFile" name="image_url" required></td>
			</tr>
		</table>
		<br>
		<br>

	<button type="submit" class="tomaraoCompute" name="SUBMIT"> Add Product </button>
	<button type="reset" class="tomaraoClear" formaction="tomaraoProduct.php"> Cancel </button>
	</div>
</form>
</body>
</html>