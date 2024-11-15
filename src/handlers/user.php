<?php
namespace Handlers;

use Models\OtpUser;
use PHPMailer\PHPMailer\PHPMailer;
use Core\Database;
use Core\Session;
use function Core\throwError;

require('src/models/otpuser.php');
require('src/models/user.php');

class User {
    private static $mailer;

    private static function connect() 
    {
        if(!isset(self::$mailer)) {
            self::$mailer = new PHPMailer();
            self::$mailer->isSMTP();
            self::$mailer->Host = 'smtp.gmail.com';
            self::$mailer->Port = 587;
            self::$mailer->SMTPSecure = 'tls';
            self::$mailer->SMTPAuth = true; 
            self::$mailer->Username = 'vgparts.info@gmail.com';
            self::$mailer->Password = 'jtbv qckw whtm fuwf';
        }
    }
    public static function registerUser($user) 
    {
        $exist = self::emailCheck($user['email']);
        if($exist) throwError('მომხმარებელი მსგავსი მეილით უკვე არსებობს', 400);
        $pin = self::generatePinCode();
        $verifyUser = self::sendOtp($user['email'], $pin);
        if($verifyUser) {
            $otpUser = (new OtpUser($pin, $user['firstName'], $user['lastName'], $user['email'], $user['password']))->toArray();
            Database::insertRow('otp_user', $otpUser);
            return ['sent' => true];
        } else {
            return ['sent' => false];
        }
    }

    public static function loginUser($user) 
    {
        $validatedUser = self::validateUser($user);
        Session::user($validatedUser);
        return ['message' => 'თქვენ წარმატებით გაიარეთ ავტორიზაცია'];
    }

    public static function logoutUser()
    {
        Session::destroy();
        return ['message' => 'თქვენ წარმატებით გამოხვედით სისტემიდან'];
    }

    public static function validateUser($user)
    {
        $exist = self::emailCheck($user['email']);
        if(!$exist) throwError('მომხმარებელი ვერ მოიძებნა', 400);
        $inputPassword = $user['password'];
        $hashedPassword = $exist['password'];
        $match = self::comparePassword($inputPassword, $hashedPassword);
        var_dump($match);
        if(!$match) throwError('მომხმარებლის პაროლი არასწორია', 400);
        unset($exist['password']);
        unset($exist['create_at']);
        unset($exist['expire_at']);
        return $exist;
        
    }

    public static function verifyOtp($otp)
    {
        $otpUser = self::otpUser($otp);
        if(!$otpUser || $otpUser['otp'] !== $otp) {
            Database::deleteRow('otp_user', ['otp' => $otp]);
            throwError('თქვენი პინი არასწორია', 400);
        }
        return self::registerOtpUser($otpUser);
    }

    public static function updatePassword($oldPassword, $newPassword, $id) {
        $user = self::idExists($id);
        $match = self::comparePassword($oldPassword, $user['password']);
        if(!$match) throwError('პაროლი არ ემთხვევა', 400);
        $hashedPassword = self::hashPassword($newPassword);
        $user['password'] = $hashedPassword;
        return Database::updateRow('user', $user, ['id' => $id]);
    }

    public static function renewPassword($otp, $password) {
        $otpUser = self::otpUser($otp);
        if(!$otpUser) throwError("პაროლის შეცვლა ვერ მოხერხდა", 400);
        $user = self::emailExists($otpUser['email']);
        if(!$user) throwError("მსგავსი მომხმარებელი ვერ მოიძებნა", 400);
        $user['password'] = self::hashPassword($password);
        Database::deleteRow('otp_user', ['otp' => $otp]);
        Database::updateRow('user', $user, ['id' => $user['id']]);
        return $otpUser;
    }

    

    private static function registerOtpUser($otpUser) {
        $password = self::hashPassword($otpUser['password']);
        $user = (new \Models\User($otpUser['firstName'], $otpUser['lastName'], $otpUser['email'], $password))->toArray();
        Database::insertRow('user', $user);
        return ['done' => true];
    }

    private static function otpUser($otp)
    {
        return Database::getOne("select * from otp_user where otp = ?", [$otp]);
    }

    private static function idExists($id)
    {
        $query = "select * from user where id = ?";
        $exist = Database::getOne($query, [$id]);
        return $exist;
    }

    private static function emailCheck($email)
    {
        $query = "select * from user where email = ?";
        $exist = Database::getOne($query, [$email]);
        return $exist;
    }

    private static function emailExists($email)
    {
        $query = "select * from otp_user where email = ?";
        $exist = Database::getOne($query, [$email]);
        return $exist;
    }

    private static function comparePassword($password, $hashedPassword)
    {
        return password_verify($password, $hashedPassword);
    }

    private static function hashPassword($password) {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    private static function generatePinCode() 
    {
        $otp = rand(10000000, 99999999);
        return $otp;
    }

    private static function sendOtp($email, $pin) 
    {
        self::connect();
        self::$mailer->setFrom('vgparts.info@gmail.com', 'VGParts Info');
        self::$mailer->addAddress($email);
        self::$mailer->CharSet = 'UTF-8';
        self::$mailer->Subject = 'ვერიფიკაცია';
        self::$mailer->Body = "თქვენი ვერიფიკაციის კოდია - $pin";

        if (self::$mailer->send()) {
            return true; 
        } else {
            return false;
        }
    }
}