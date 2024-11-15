<?php
namespace Core;
use HttpException;

function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";

    die();
}

function urlIs($value)
{
    return $_SERVER['REQUEST_URI'] === $value;
}

function abort($code = 404)
{
    http_response_code($code);

    require base_path("views/{$code}.php");

    die();
}

function authorize($condition, $status = 403)
{
    if (! $condition) {
        abort($status);
    }

    return true;
}

function base_path($path)
{
    return BASE_PATH . $path;
}

function render($name, $attributes = [])
{
    extract($attributes);

    require('src/views/' . $name . '.php');
}

function body() {
    $jsonData = json_decode(file_get_contents('php://input'));
    $data = [];
    foreach ($jsonData as $key => $value) {
        $data[$key] = $value;
    }
    return $data;
}

function uploadFile($dir) {
    if($_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $tmpFilePath = $_FILES['file']['tmp_name'];
        $slug = generateSlug();
        $fileName = $slug . $_FILES['file']['name'];
        $uploadPath = $dir . $fileName;
        if(move_uploaded_file($tmpFilePath, $uploadPath)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function uploadFiles($dir) {
    $uploads = [];
    $errors = [];
    foreach($_FILES['files']['tmp_name'] as $index => $tmpFilePath) {
        $slug = generateSlug();
        $fileName = $slug . $_FILES['files']['name'][$index];
        $uploadPath = $dir . $fileName;
        if($_FILES['files']['error'][$index] === UPLOAD_ERR_OK) {
            if(move_uploaded_file($tmpFilePath, $uploadPath)) {
                $uploads[] = $fileName;
            } else {
                $errors[] = $fileName;
            }
        } else {
            $errors[] = $fileName;
        }
    }

    if(!empty($errors)) {
        return false;
    } else {
        return true;
    }
}


function generateSlug($length = 10) {
    $characters = 'abcd2391eplmnozjx456zqw78';
    $slug = '';
    for($i = 0; $i < $length; $i++) {
        $slug .= $characters[rand(0, strlen($characters) -1)];
    }
    return $slug;
}

function redirect($path)
{
    header("location: {$path}");
    exit();
}

function throwError($message, $status) 
{
    $error = new HttpException($message, $status);
    throw $error;
}

function errorResponse($err) 
{
    $status = $err->getStatus();
    $message = $err->getMessage();
    http_response_code($status);
    echo json_encode(['message' => $message]);
    die();
}

function jsonResponse($response) 
{
    http_response_code(200);
    header('Content-Type: application/json');
    echo json_encode($response);
    die();
}

function assoc($value)
{
    return json_decode($value, true);
}

function partial($name, $attributes = [])
{
    extract($attributes);
    require('src/views/partials/' . $name . '.php');
}

function warningResponse($message, $status) {
    http_response_code($status);
    header('Content-Type: application/json');
    echo json_encode(['message' => $message]);
    die();
}

