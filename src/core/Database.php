<?php

namespace Core;

use PDO;
use PDOException;

class Database
{
    private static $connection;

    private static function connect()
    {
        if (!isset(self::$connection)) {
            $username = "root";
            $password = "";
            $dsn = "mysql:host=localhost;dbname=vgpart;";
            self::$connection = new PDO($dsn, $username, $password, [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        }
    }

    private static function query($query, $params = [])
    {
        self::connect();
        $statement = self::$connection->prepare($query);
        
        $statement->execute($params);
        return $statement;
    }

    public static function crud($query, $params = []) {
        self::connect();
        $statement = self::$connection->prepare($query);
        return $statement->execute($params);
    }

    public static function getMany($query, $params = [])
    {
        $statement = self::query($query, $params);
        return $statement->fetchAll();
    }

    public static function getOne($query, $params = [])
    {
        $statement = self::query($query, $params);
        return $statement->fetch();
    }

    public static function findOrFail($query, $params = [])
    {
        $result = self::getOne($query, $params);
        if (!$result) {
            // Handle error or throw exception
        }
        return $result;
    }


    public static function insertRow($tableName, $object) {
        try {
            $columns = implode(', ', array_keys($object));
            $values = implode(', ', array_fill(0, count($object), '?'));
            $query = "INSERT INTO $tableName ($columns) VALUES ($values)";
            $params = array_values($object);
            $statement = self::query($query, $params);
            if($statement->rowCount() > 0) {
                return ['changed' => true, 'წარმატებით დაემატა'];
            } else {
                return ['changed' => false, 'დამატება ვერ მოხერხდა'];
            }
        } catch (PDOException $e) {
            return ['changed' => false, 'დამატება ვერ მოხერხდა'];
        }
    }

    public static function updateRow($tableName, $updateObject, $whereObject) {
        try {
            if (isset($updateObject['id'])) {
                unset($updateObject['id']);
            }
            if(isset($updateObject['otp'])) {
                unset($updateObject['otp']);
            }
            $setValues = implode(', ', array_map(function($key) { return "$key = ?"; }, array_keys($updateObject)));
            $whereValues = implode(' AND ', array_map(function($key) { return "$key = ?"; }, array_keys($whereObject)));
            $query = "UPDATE $tableName SET $setValues WHERE $whereValues";
            
            $params =  array_merge(array_values($updateObject), array_values($whereObject));
            $statement = self::query($query, $params);
            if($statement->rowCount() > 0) {
                return ['changed' => true, 'message' => 'პროდუქტი წარმატებით შეიცვალა'];
            } else {
                return ['changed' => false, 'message' => 'პროდუქტის მნიშვნელობები იგივეა'];
            }
        } catch(PDOException $e) {
            return ['changed' => false, 'message' => 'მსგავსი მახასიათებლებით არაფერი მოიძებნა'];
        }
    }

    public static function upsertRow($tableName, $object, $whereObject) {
        $statement = self::updateRow($tableName, $object, $whereObject);
        var_dump($statement);
        if($statement['changed'] == false) {
            return self::insertRow($tableName, $object);
        }
        return $statement;
        
    }

    public static function deleteRow($tableName, $whereObject) {
        try {
            $whereValues = implode(' AND ', array_map(function($key) { return "$key = ?"; }, array_keys($whereObject)));
            $query = "DELETE FROM $tableName WHERE $whereValues";
            $params = array_values($whereObject);
            $statement = self::query($query, $params);
            if($statement->rowCount() > 0) {
                return ['changed' => true];
            } else {
                return ['changed' => false];
            }
        } catch (PDOException $e) {
            var_dump($e);
            return ['changed' => false];
        }
        
    }
}