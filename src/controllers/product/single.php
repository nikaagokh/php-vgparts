<?php

require BASE_PATH . '/src/handlers/product.php';

use Handlers\Product;
$id = (int) $_GET['id'];

$products = Product::getSingleProduct($id);

require BASE_PATH . '/src/views/product/category-year.php';