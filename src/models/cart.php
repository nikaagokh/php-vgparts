<?php

namespace Models;

class Cart {
    public $productId;
    public $userId;
    public $quantity;

    public function __construct($productId='', $userId='', $quantity=0) {
        $this->productId = $productId;
        $this->userId = $userId;
        $this->quantity = $quantity;
    }
}