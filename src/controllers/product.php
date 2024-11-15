<?php

namespace Controllers;
require BASE_PATH . '/src/handlers/product.php';

use Handlers\Product;
use HttpException;
use Error;

use function Core\errorResponse;
use function Core\jsonResponse;

class ProductController {
    public static function getProductsBySearch() {
        try {
            $yearId = $_GET['word'];
            $offset = (int) $_GET['offset'];
            $products = Product::getProductsBySearch($yearId, $offset);
            jsonResponse($products);
        } catch(HttpException $err) {
            errorResponse($err);
        }
    }

    public static function getProductsByCategoryYear() {
        try {
            $yearId = (int) $_GET['yearId'];
            $categoryId = (int) $_GET['categoryId'];
            $offset = (int) $_GET['offset'];
            $response = Product::getProductsByCategoryYear($yearId, $offset);
            jsonResponse($response);
        } catch (HttpException $err) {
            errorResponse($err);
        }
    }

    public static function getSimillarProducts() {
        try {
            $id = (int) $_GET['id'];
            $products = Product::getSimillarProducts($id);
            jsonResponse($products);
        } catch (HttpException $err) {
            errorResponse($err);
        }
    }

    public static function getSingleProduct() {
        try {
            $id = (int) $_GET['id'];
            $product = Product::getSingleProduct($id);
            jsonResponse($product);
        } catch(HttpException $err) {
            errorResponse($err);
        }
    }

    public static function getProductsByDiscount() {
        try {
            $offset = (int) $_GET['offset'];
            $limit = (int) $_GET['limit'];
            $products = Product::getProductsByDiscount($offset, $limit);
            jsonResponse($products);
        } catch (HttpException $err) {
            errorResponse($err);
        }
    }

    public static function getProductsByPopular() {
        try {
            $offset = (int) $_GET['offset'];
            $limit = (int) $_GET['limit'];
            $products = Product::getProductsByPopular($offset, $limit);
            jsonResponse($products);
        } catch (HttpException $err) {
            errorResponse($err);
        }
    }

    public static function getProductsByFilter() {
        try {
            $yearIds = array_map('intval', explode(',', $_GET['yearIds']));
            $offset = (int) $_GET['offset'];
            $products = Product::getProductsByFilter($yearIds, $offset);
            jsonResponse($products);
        } catch (HttpException $err) {
            errorResponse($err);
        }
    }
    
}