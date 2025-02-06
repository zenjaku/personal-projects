<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zenrose Co.</title>
</head>

<body>
    <section id="cart" class="container mt-5">
        <h3>CART ITEMS</h3>
        <div class="row gap p-3 align-items-center border">
            <div class="col-md-1 col-sm-12">
                <div class="itemNumber fw-bold">1</div>
            </div>
            <div class="col-md-2 col-sm-12">
                <div class="cart-img">
                    <img src="assets/p_img2.png" alt="p_img1.png" class="img-fluid">
                </div>
            </div>
            <div class="col-md-2 col-sm-12">
                <div class="cart-product flex-column">
                    <p class="lead">Men Round Neck Pure Cotton T-shirt</p>
                    <p>Small, Medium</p>
                </div>
            </div>
            <div class="col-md-2 col-sm-12">
                <div class="qty">
                    <div class="item1"><p class="lead text-center fw-bold">Quantity</p></div>
                    <div class="item2"><input type="number" class="quantity" min="0" value="2" oninput="this.value = Math.max(0, this.value)"></div>
                </div>
            </div>
            <div class="col-md-3 col-sm-12">
                <div class="price">
                    <p class="lead fw-bold">PHP 200.00</p>
                </div>
            </div>
            <div class="col-md-2 col-12 d-flex justify-content-end">
                <form id="cartForm" action="" method="POST" autocomplete="off">
                    <div class="btn-container d-flex flex-row gap-2">
                        <button class="btn bg-warning" id="saveBtn" name="SAVE">
                            <i class="fa-solid fa-floppy-disk"></i>
                        </button>
                        <button class="btn bg-danger text-white" id="deleteBtn" name="DELETE">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

</body>

</html>