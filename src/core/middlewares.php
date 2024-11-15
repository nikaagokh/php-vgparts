<?php

namespace Core;

use \Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Throwable;

function isAuthenticated() 
{
    if(!isset($_SESSION['user'])) {
        warningResponse('თქვენ არ ხართ ავტორიზებული, გთხოვთ გაიაროთ რეგისტრაცია ან ავტორიზაცია', 401);
    }
}

function isAdmin() 
{
    if(!isset($_SESSION['user'])) {
        warningResponse('რესურსებზე წვდომა შეზღუდულია', 403);
    }
}


function authenticateJWT() 
{
    
    $authorization = getallheaders()['Authorization'] ?? '';
    if(!$authorization) {
        warningResponse('გთხოვთ გაიარეთ რეგისტრაცია', 401);
    }
    $parts = explode(' ', $authorization);
    $token = isset($parts[1]) ? $parts[1] : '';
    echo $token;
    if(!$token) {
        warningResponse('გთხოვთ გაიარეთ რეგისტრაცია', 401);
    }
    
    try {
        $decoded = JWT::decode('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoxMjM0LCJ1c2VybmFtZSI6ImpvaG5fZG9lIiwiYWJjZCI6ImFiYXJhIn0.JQfao2WausD7hw7D8a-sMxZLEKFy2KB1oWKDODGcMxA', new Key($_ENV['JWT_KEY'], 'HS256'));
        var_dump($decoded);
    } catch(Throwable $err) {
        var_dump($err);
    }
}