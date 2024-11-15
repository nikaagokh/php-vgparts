<?php

namespace Controllers;
require BASE_PATH . '/src/handlers/category.php';
use Handlers\Category;
use Error;
use ErrorException;
use HttpException;

use function Core\errorResponse;
use function Core\jsonResponse;

class CategoryController {
    public static function getFullCategories() {
        try{
            $categories = Category::getAllCategoriesWithChildren();
            jsonResponse($categories);
        } catch (HttpException $err) {
            errorResponse($err);
        }
       
    }

    public static function getRootCategories() {
        try {
            $categories = Category::getAllCategories();
            jsonResponse($categories);
        } catch (HttpException $err) {
            errorResponse($err);
        }
    }

    public static function getOneCategory() {
        try {
            $id = $_GET['id'];
            $categories = Category::getOneCategory($id);
            jsonResponse($categories);
        } catch (HttpException $err) {
            errorResponse($err);
        }
    }

    public static function getSubcategories() {
        try {
            $id = $_GET['id'];
            $subcategories = Category::getSubcategories($id);
            jsonResponse($subcategories);
        } catch(HttpException $err) {
            errorResponse($err);
        }
    }

    public static function getChildrenCategories() {
        try {
            $id = $_GET['id'];
            $subcategories = Category::getChildrenCategories($id);
            jsonResponse($subcategories);
        } catch(HttpException $err) {
            errorResponse($err);
        }
    }
}