<?php

namespace Models;

class User {
    public $firstName;
    public $lastName;
    public $email;
    public $password;
    public $role;

    public function __construct($firstName = '', $lastName = '', $email = '', $password = '', $role = 'user')
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }

    public function toArray() {
        $data = [];
        foreach ($this as $key => $value) {
            $data[$key] = $value;
        }
        return $data;
    }
}