<?php

namespace Models;

class Product {
    public $nameGeo;
    public $nameEng;
    public $price;
    public $type;
    public $discount;
    public $condition;
    public $description;
    public $quantity;
    public $views;

    public function __construct($nameGeo='', $nameEng='', $price=0, $type=0, $discount=0, $condition='', $description='', $quantity=0, $views=0) {
        $this->nameGeo = $nameGeo;
        $this->nameEng = $nameEng;
        $this->price = $price;
        $this->type = $type;
        $this->discount = $discount;
        $this->condition = $condition;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->views = $views;
    }
}
