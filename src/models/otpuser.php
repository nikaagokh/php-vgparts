<?php

namespace Models;

class OtpUser {
    public $otp;
    public $firstName;
    public $lastName;
    public $email;
    public $password;
    public $expire_at;

    public function __construct($otp='', $firstName='', $lastName='', $email='', $password='') {
        $this->otp = $otp;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
    }

    public function toArray() {
        $data = [];
        foreach ($this as $key => $value) {
            $data[$key] = $value;
        }
        return $data;
    }
}
