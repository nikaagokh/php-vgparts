<?php

require BASE_PATH . '/src/handlers/product.php';

use Handlers\Product;
$offset = (int) $_GET['offset'];
$limit = (int) $_GET['limit'];
$products = Product::getProductsByDiscount($offset, $limit);

require BASE_PATH . '/src/views/product/discounted.php';