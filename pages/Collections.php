<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zenrose Co.</title>
</head>

<body>
    <section id="collections" class="container mt-5">
        <div class="row">
            <div class="col">
                <button class="btn btn-dark mb-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#filter"
                    aria-controls="offcanvasExample">
                    Filter &nbsp; <i class="fa-solid fa-filter"></i>
                </button>

                <div class="offcanvas offcanvas-start" tabindex="-1" id="filter"
                    aria-labelledby="offcanvasExampleLabel">
                    <div class="offcanvas-header">
                        <h2 class="offcanvas-title" id="offcanvasExampleLabel">Filter</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <h5>Category</h5>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked>
                            <label class="form-check-label" for="flexCheckDefault">
                                Men
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                            <label class="form-check-label" for="flexCheckChecked">
                                Women
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                            <label class="form-check-label" for="flexCheckChecked">
                                Kids
                            </label>
                        </div>

                        <hr class="text-dark">
                        <h5>Sub Category</h5>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked>
                            <label class="form-check-label" for="flexCheckDefault">
                                Top wear
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                            <label class="form-check-label" for="flexCheckChecked">
                                Bottom wear
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                            <label class="form-check-label" for="flexCheckChecked">
                                Kids
                            </label>
                        </div>

                        <hr class="text-dark">
                        <h5>Sizes</h5>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked>
                            <label class="form-check-label" for="flexCheckDefault">
                                Small
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                            <label class="form-check-label" for="flexCheckChecked">
                                Medium
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                            <label class="form-check-label" for="flexCheckChecked">
                                Large
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                            <label class="form-check-label" for="flexCheckChecked">
                                XL
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                            <label class="form-check-label" for="flexCheckChecked">
                                2XL
                            </label>
                        </div>

                        <hr class="text-dark">
                        <h5><label for="priceRange" class="form-label">Price Range (PHP) </label></h5>
                        <p>PHP 50.00 </p>
                        <input type="range" class="form-range" id="priceRange">
                        <div class="row">
                            <div class="col-6">
                                <p>PHP 50.00 </p>
                            </div>
                            <div class="col-6 text-end">
                                <p>PHP 300.00 </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 content">
                <div class="product-container">
                    <div class="img-container">
                        <img src="assets/p_img1.png" alt="p_img1.png" class="img-fluid">
                    </div>
                    <p>Women Round Neck Cotton Top</p>
                    <div class="price-container">
                        <p>PHP 100.00</p>
                    </div>
                </div>
                <div class="product-container">
                    <div class="img-container">
                        <img src="assets/p_img2.png" alt="p_img1.png" class="img-fluid">
                    </div>
                    <p>Men Round Neck Pure Cotton T-shirt</p>
                    <div class="price-container">
                        <p>PHP 200.00</p>
                    </div>
                </div>
                <div class="product-container">
                    <div class="img-container">
                        <img src="assets/p_img3.png" alt="p_img1.png" class="img-fluid">
                    </div>
                    <p>Girls Round Neck Cotton Top</p>
                    <div class="price-container">
                        <p>PHP 220.00</p>
                    </div>
                </div>
                <div class="product-container">
                    <div class="img-container">
                        <img src="assets/p_img4.png" alt="p_img1.png" class="img-fluid">
                    </div>
                    <p>Men Round Neck Pure Cotton T-shirt</p>
                    <div class="price-container">
                        <p>PHP 110.00</p>
                    </div>
                </div>
                <div class="product-container">
                    <div class="img-container">
                        <img src="assets/p_img5.png" alt="p_img1.png" class="img-fluid">
                    </div>
                    <p>Women Round Neck Cotton Top</p>
                    <div class="price-container">
                        <p>PHP 130.00</p>
                    </div>
                </div>
                <div class="product-container">
                    <div class="img-container">
                        <img src="assets/p_img6.png" alt="p_img1.png" class="img-fluid">
                    </div>
                    <p>Girls Round Neck Cotton Top</p>
                    <div class="price-container">
                        <p>PHP 140.00</p>
                    </div>
                </div>
                <div class="product-container">
                    <div class="img-container">
                        <img src="assets/p_img7.png" alt="p_img1.png" class="img-fluid">
                    </div>
                    <p>Men Tapered Fit Flat-Front Trousers</p>
                    <div class="price-container">
                        <p>PHP 190.00</p>
                    </div>
                </div>
                <div class="product-container">
                    <div class="img-container">
                        <img src="assets/p_img8.png" alt="p_img1.png" class="img-fluid">
                    </div>
                    <p>Girls Round Neck Cotton Top</p>
                    <div class="price-container">
                        <p>PHP 100.00</p>
                    </div>
                </div>
                <div class="product-container">
                    <div class="img-container">
                        <img src="assets/p_img9.png" alt="p_img1.png" class="img-fluid">
                    </div>
                    <p>Men Tapered Fit Flat-Front Trousers</p>
                    <div class="price-container">
                        <p>PHP 110.00</p>
                    </div>
                </div>
                <div class="product-container">
                    <div class="img-container">
                        <img src="assets/p_img10.png" alt="p_img1.png" class="img-fluid">
                    </div>
                    <p>Men Round Neck Pure Cotton T-shirt</p>
                    <div class="price-container">
                        <p>PHP 120.00</p>
                    </div>
                </div>
                <div class="product-container">
                    <div class="img-container">
                        <img src="assets/p_img11.png" alt="p_img1.png" class="img-fluid">
                    </div>
                    <p>Men Round Neck Pure Cotton T-shirt</p>
                    <div class="price-container">
                        <p>PHP 150.00</p>
                    </div>
                </div>
                <div class="product-container">
                    <div class="img-container">
                        <img src="assets/p_img12.png" alt="p_img1.png" class="img-fluid">
                    </div>
                    <p>Women Round Neck Cotton Top</p>
                    <div class="price-container">
                        <p>PHP 130.00</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>

</html>