<?php

use Controllers\CategoryController;
use Controllers\ProductController;
use Controllers\UserController;
use Controllers\ViewController;


//category
$router->get('/api/category/full', [CategoryController::class, 'getFullCategories']);
$router->get('/api/category/roots', [CategoryController::class, 'getRootCategories']);
$router->get('/api/category/subcategories', [CategoryController::class, 'getSubcategories']);
$router->get('/api/category/children', [CategoryController::class, 'getChildrenCategories']);
$router->get('/api/category', [CategoryController::class, 'getOneCategory']);

//product
$router->get('/api/product/search', [ProductController::class, 'getProductsBySearch']);
$router->get('/api/product/categoryYear', [ProductController::class, 'getProductsByCategoryYear']);
$router->get('/api/product/simillars', [ProductController::class, 'getSimillarProducts']);
$router->get('/api/product/single', [ProductController::class, 'getSingleProduct']);
$router->get('/api/product/discounted', [ProductController::class, 'getProductsByDiscount']);
$router->get('/api/product/popular', [ProductController::class, 'getProductsByPopular']);
$router->get('/api/product/filtered', [ProductController::class, 'getProductsByFilter']);
$router->post('/api/product/add', [ProductController::class, 'addProduct']);
$router->get('/api/product/cart', [ProductController::class, 'getCartProducts']);
//users
$router->post('/api/user/register', [UserController::class, 'registerUser']);
$router->post('/api/user/login', [UserController::class, 'loginUser']);
$router->post('/api/user/otp/verify', [UserController::class, 'otpVerify']);
$router->post('/api/user/password/update', [UserController::class, 'updatePassword'], ['isAuthenticated']);
$router->post('/api/user/password/renew', [UserController::class, 'renewPassword'], ['isAuthenticated']);
$router->get('/api/user/admin', [UserController::class, 'isAdmin'], ['isAdmin'], ['isAuthenticated']);

//views
$router->get('/', [ViewController::class, 'getHomePage']);
$router->get('/product/:id', [ViewController::class, 'getProduct']);
$router->get('/category', [ViewController::class, 'getCategories']);
$router->get('/subcategory', [ViewController::class, 'getSubcategories']);
$router->get('/groupby', [ViewController::class, 'getGroups']);
$router->get('/filtered', [ViewController::class, 'getFilters']);
$router->get('/cart', [ViewController::class, 'getCart']);
$router->get('/buy', [ViewController::class, 'getBuy']);