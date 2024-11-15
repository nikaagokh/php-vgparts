<?php

namespace Controllers;
use Core\CURL;
use Error;
use Core\Helper;
use function Core\assoc;
use function Core\render;

class ViewController {
    public static function getHomePage() {
        try {
            $discountsResponse = assoc(CURL::get('http://localhost/vgparts/api/product/discounted?offset=1&limit=12'));
            $popularsResponse = assoc(CURL::get('http://localhost/vgparts/api/product/popular?offset=1&limit=12'));
            $categories = assoc(CURL::get('http://localhost/vgparts/api/category/roots'));
            render('home', [
                'discounts' => $discountsResponse,
                'populars' => $popularsResponse,
                'categories' => $categories
            ]);
        } catch (Error $err) {
            echo "Err";
        }
    }

    public static function getProduct() {
        try {
            $parsedUrl = parse_url($_SERVER['REQUEST_URI'])['path'];
            $id = (int) basename($parsedUrl);
            $product = assoc(CURL::get("http://localhost/vgparts/api/product/single?id={$id}"));
            $simillars = assoc(CURL::get("http://localhost/vgparts/api/product/simillars?id={$id}"));
            $priceObj = Helper::generatePrice($product);
            render('product', [
                'product' => $product,
                'simillars' => $simillars,
                'priceObj' => $priceObj
            ]);
        } catch(Error $err) {
            echo "Err";
        }
    }

    public static function getSubcategories() {
        try {
            $id = $_GET['id'];
            $category = $_GET['category'];
            $subcategories = assoc(CURL::get("http://localhost/vgparts/api/category/subcategories?id={$id}"));
            render('subcategory', [
                'subcategories' => $subcategories,
                'category' => $category
            ]);
        } catch(Error $err) {
            echo "Err";
        }
    }

    public static function getCategories() {
        try {

            $yearId = (int) $_GET['yearId'];
            $categoryId = (int) $_GET['categoryId'];
            $offset = (int) $_GET['offset'];
            $response = assoc(CURL::get("http://localhost/vgparts/api/product/categoryYear?yearId={$yearId}&categoryId={$categoryId}&offset={$offset}"));
            $products = $response['rows'];
            $hydration = json_encode($response['rows']);
            $count = $response['totalCount'];
            $pages = $response['totalPages'];
            $pagesToShow = Helper::pagesToShow($pages, $offset);
            $isFirstPage = ($offset === 1);
            $isLastPage = ($offset === count($pages));

            render('category', [
                'yearId' => $yearId,
                'categoryId' => $categoryId,
                'currentPage' => $offset,
                'products' => $products,
                'hydration' => $hydration,
                'count' => $count,
                'pages' => $pages,
                'isFirstPage' => $isFirstPage,
                'isLastPage' => $isLastPage,
                'pagesToShow' => $pagesToShow
            ]);
        } catch(Error $err) {
            echo $err;
        }
    }

    public static function getGroups() {
        try {
            $path = $_GET['path'];
            $group = $_GET['group'];
            $offset = (int) $_GET['offset'];
            $response = assoc(CURL::get("http://localhost/vgparts/api/product/{$path}?limit=24&offset={$offset}"));
            $products = $response['products'];
            $pages = $response['totalPages'];
            $count = $response['totalCount'];
            $pagesToShow = Helper::pagesToShow($pages, $offset);
            $hydration = json_encode($products);
            $isFirstPage = ($offset === 1);
            $isLastPage = ($offset === count($pages));
    
            render('groupby', [
                'path' => $path,
                'group' => $group,
                'currentPage' => $offset,
                'products' => $products,
                'hydration' => $hydration,
                'count' => $count,
                'pages' => $pages,
                'isFirstPage' => $isFirstPage,
                'isLastPage' => $isLastPage,
                'pagesToShow' => $pagesToShow
            ]);
        } catch(Error $err) {
            $err;
        }
        
    }

    public static function getFilters() {
        try {
            $yearIds = $_GET['yearIds'];
            $offset = (int) $_GET['offset'];
            $response = assoc(CURL::get("http://localhost/vgparts/api/product/filtered?yearIds={$yearIds}&offset={$offset}"));
            $products = $response['products'];
            $count = $response['totalCount'];
            $pages = $response['totalPages'];
            $pagesToShow = Helper::pagesToShow($pages, $offset);
            $hydration = json_encode($products);
            $isFirstPage = ($offset === 1);
            $isLastPage = ($offset === count($pages));
            render('filter', [
                'currentPage' => $offset,
                'products' => $products,
                'hydration' => $hydration,
                'count' => $count,
                'pages' => $pages,
                'isFirstPage' => $isFirstPage,
                'isLastPage' => $isLastPage,
                'pagesToShow' => $pagesToShow,
                'yearIds' => $yearIds
            ]);
        } catch(Error $err) {
            echo $err;
        }
    }

    public static function getCart() {
        try {
            render('cart');
        } catch(Error $err) {
            echo $err;
        }
    }

    public static function getBuy() {
        try {
            render('buy');
        } catch (Error $err) {
            echo $err;
        }
    }


}