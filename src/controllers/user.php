<?php

namespace Controllers;
require BASE_PATH . '/src/handlers/user.php';

use Core\Session;
use HttpException;
use Handlers\User;

use function Core\body;
use function Core\errorResponse;
use function Core\jsonResponse;

class UserController {

    public static function registerUser()
    {
        try{
            $user = body();
            $response = User::registerUser($user);
            jsonResponse($response);
        } catch(HttpException $err) {
            errorResponse($err);
        }
    }

    public static function loginUser()
    {
        try {
            $user = body();
            var_dump($user);
            $response = User::loginUser($user);
            jsonResponse($response);
        } catch(HttpException $err) {
            errorResponse($err);
        }
    }

    public static function logoutUser()
    {
        try {
            $response = User::logoutUser();
            jsonResponse($response);
        } catch(HttpException $err) {
            errorResponse($err);
        }
    }

    public static function otpVerify()
    {
        try {
            $pin = (int) body()['pin'];
            $response = User::verifyOtp($pin);
            jsonResponse($response);
        } catch(HttpException $err) {
            var_dump('b');
            errorResponse($err);
        }
    }

    public static function updatePassword()
    {
        try {
            $postData = body();
            $id = Session::userId();
            $newPassword = $postData['newPassword'];
            $oldPassword = $postData['oldPassword'];
            $response = User::updatePassword($oldPassword, $newPassword, $id);
            jsonResponse($response);
        } catch(HttpException $err) {
            errorResponse($err);
        }
    }

    public static function isAdmin()
    {
        $response = ['admin' => true];
        jsonResponse($response);
    }


}