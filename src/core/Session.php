<?php

namespace Core;
require 'src/models/session.php';

class Session {
    public static function has($key)
    {
        return (bool) static::get($key);
    }

    public static function userId() 
    {
        return $_SESSION['user']['id'] ?? null;
    }

    public static function user($value) 
    {
        ['id' => $id, 'firstName' => $firstName] = $value;
        $user = ['id' => $id, 'firstName' => $firstName];
        self::put('user', $user);
    }

    public static function put($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key, $default = null)
    {
        return $_SESSION['_flash'][$key] ?? $_SESSION[$key] ?? $default;
    }

    public static function flash($key, $value)
    {
        $_SESSION['_flash'][$key] = $value;
    }

    public static function unflash()
    {
       unset($_SESSION['_flash']);
    }

    public static function flush()
    {
        $_SESSION = [];
    }
    
    public static function destroy()
    {
        static::flush();
        session_destroy();
        $params = session_get_cookie_params();
        setcookie('PHPSESSID', '', time() - 3600, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    /*
    public static function readUser($id) {
        $exist = Database::getOne("select data from sessions where id = ?", [$id])['data'];
        if($exist) {
            return json_decode($exist, true);
        } else {
            return null;
        }
    }

    public static function writeUser($id, $data) {
        $exist = Database::getOne("select data from sessions where id = 1")['data'];
        $user = json_decode($exist, true);
        $session = new \Models\Session(1, $user);
        var_dump($session); 
    }
    */
}