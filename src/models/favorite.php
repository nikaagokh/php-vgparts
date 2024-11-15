<?php

namespace Models;

class Favorite {
    public $productId;
    public $userId;

    public function __construct($productId='', $userId='') {
        $this->productId = $productId;
        $this->userId = $userId;
    }
}