<?php

namespace Models;

class Session {
    public $id;
    public $data;
    public $expires_at;

    public function __construct($id, $data)
    {
        $this->id = $id;
        $this->data = json_encode($data);
        $this->expires_at = time();
    }
}