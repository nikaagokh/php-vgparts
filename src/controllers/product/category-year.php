<?php

require BASE_PATH . '/src/handlers/product.php';

use Handlers\Product;
$yearId = (int) $_GET['yearId'];
$offset = (int) $_GET['offset'];
$products = Product::getProductsByCategoryYear($yearId, $offset);

require BASE_PATH . '/src/views/product/category-year.php';
