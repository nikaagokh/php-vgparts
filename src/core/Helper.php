<?php

namespace Core;

class Helper {
    public static function PURL($value)
    {
        return 'http://localhost/vgparts/public/images/product/' . $value;
    }

    public static function CURL($value)
    {
        return 'http://localhost/vgparts/public/images/logos/' . $value;
    }

    public static function SURL($value)
    {
        return 'http://localhost/vgparts/public/images/subcategories/' . $value;
    }

    public static function AURL($value)
    {
        return 'http://localhost/vgparts/public/images/assets/' . $value;
    }

    public static function encode($value)
    {
        return json_encode($value);
    }

    public static function isCurrentPage($page, $currentPage)
    {
        return $page == $currentPage;
    }

    public static function visible($pages)
    {
        if(count($pages) > 0) {
            return 'style="display:block";';
        } else {
            return 'style="display:none";';
        }

        //style="display: none;"
    }

    public static function generatePrice($product)
    {
        $price = $product['price'];
        $discount = $product['discount'];
        $newPrice = $price - ($price * ($discount / 100));
        $oldPrice = $price;
        $discountPrice = $price - $newPrice;
        return [
            'newPrice' => $newPrice,
            'oldPrice' => $oldPrice,
            'discountPrice' => $discountPrice
        ];
    }

    public static function pagesToShow($totalPages, $currentPage) 
    {
        $pageCount = 5;
        $halfPageCount = floor($pageCount / 2);
        $startPage = 1;
    
        if ($currentPage < 5) {
            $startPage = 1;
        } elseif ($currentPage + 2 > $totalPages) {
            $startPage = $totalPages - 4;
        } else {
            $startPage = max(1, $currentPage - $halfPageCount);
        }
    
        $endPage = min(count($totalPages), $startPage + $pageCount - 1);
        return range($startPage, $endPage);
    }
}