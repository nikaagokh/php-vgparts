<?php

require BASE_PATH . '/src/handlers/product.php';

use Handlers\Product;
$yearId = $_GET['word'];
$offset = (int) $_GET['offset'];

$products = Product::getProductsBySearch($yearId, $offset);

require BASE_PATH . '/src/views/product/category-year.php';
