<?php

require BASE_PATH . '/src/handlers/product.php';
use Handlers\Product;
$id = (int) $_GET['id'];

$products = Product::getSimillarProducts($id);

require BASE_PATH . '/src/views/product/simillars.php';