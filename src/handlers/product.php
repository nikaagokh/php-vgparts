<?php

namespace Handlers;

use Core\Database;

use function Core\throwError;

class Product {
    public static function getProductsBySearch($word, $offset, $limit = 24) {
        
        $query = "
        select prod.*, GROUP_CONCAT(img.path) as images, GROUP_CONCAT(DISTINCT cy.yearId) as yearId from product prod
        left join image img on prod.id = img.productId
        left join product_category pc on prod.id = pc.productId
        left join category_year cy on cy.id = pc.categoryYearId
        where prod.nameGeo like '%{$word}%' or prod.nameEng like '%{$word}%'
        group by prod.id
        limit {$limit} offset {$offset};
        ";
        $rows = Database::getMany($query);
        foreach($rows as &$row) {
            if(isset($row['images'])) {
                $row['images'] = explode(',', $row['images']);
            }
        }
        return $rows;
    }

    public static function getProductsByCategoryYear($yearId, $offset) {
        $query = "
        select prod.*, 
        GROUP_CONCAT(img.path) as images, 
        category.id as categoryId, 
        category.name as categoryName,
        CONCAT(MIN(year.start), '-', MAX(year.end)) as yearRange
        from product as prod
        left join image img on prod.id = img.productId
        left join product_category pc on prod.id = pc.productId
        left join category_year catyear on catyear.id = pc.categoryYearId
        left join category on category.id = catyear.categoryId
        left join year year on year.id = catyear.yearId
        where pc.categoryYearId ={$yearId}
        group by prod.id
        limit " . LIMIT . " offset {$offset}";
        
        $rows = Database::getMany($query);
        foreach($rows as &$row) {
           if(isset($row['images'])) {
              $row['images'] = explode(',', $row['images']);
           }
        }

        $query2 = "
        select count(*) as total from product as prod
        left join product_category pc on prod.id = pc.categoryYearId
        where pc.categoryYearId = {$yearId}
        ";

        $totalCount = Database::getOne($query2)['total'];
        $totalPagesNum = ceil($totalCount / LIMIT);
        $totalPages = [];
        for ($i = 1; $i <= $totalPagesNum; $i++) {
            $totalPages[] = $i;
        }

        $result = [
         'rows' => $rows,
         'totalCount' => $totalCount,
         'totalPages' => $totalPages,
        ];

        return $result;
        
    }
    
    public static function getSimillarProducts($id) {
        $exist = Database::getOne("select * from product where id = ?", [$id]);
        if (count($exist) === 0) {
            return;
        }

        if($exist['type'] == 0) {
            $yearId = Database::getOne("select * from product_category where productId = ? LIMIT 1", [$id])['categoryYearId'];
            $products = Database::getMany("
              select prod.*,
              GROUP_CONCAT(img.path) as images, 
              category.id as categoryId, 
              category.name as categoryName
              from product as prod
              left join image img on prod.id = img.productId
              left join product_category pc on prod.id = pc.productId
              left join category_year catyear on catyear.id = pc.categoryYearId
              left join category on category.id = catyear.categoryId
              where pc.categoryYearId = ? and pc.productId <> ?
              group by prod.id
              limit 15
            ", [$yearId, $id]);
            foreach($products as &$product) {
                if(isset($product['images'])) {
                   $product['images'] = explode(',', $product['images']);
                }
             }
             return $products;

        } else {

            $products = Database::getMany("
              select * from product as prod
              left join image img on prod.id = img.productId
              where prod.type = 1 and prod.id <> ?
            ", [$id]);

            return $products;

        }
    }

    public static function getSingleProduct($id) {
        $query = " 
          select prod.*, GROUP_CONCAT(img.path) as images
          from product prod
          left join image img on prod.id = img.productId
          left join product_category categories on prod.id = categories.productId
          left join category_year catyear on catyear.id = categories.categoryYearId
          left join year year on year.id = catyear.yearId
          where prod.id = ?
          group by prod.id;
        ";
        
        $product = Database::getOne($query, [$id]);
        if (!empty($product['images'])) {
            $imagesArray = explode(',', $product['images']);
            $product['images'] = $imagesArray;
        } else {
            $product['images'] = [];
        }

        return $product;
    }

    public static function getProductsByDiscount($offset, $limit) {
        $limitNumber = $limit == 0 ? LIMIT : $limit;
        $offsetNumber = ($offset - 1) * LIMIT;
        $query = "
          select prod.*, 
          GROUP_CONCAT(img.path) as images, 
          category.id as categoryId, 
          category.name as categoryName,
          CONCAT(MIN(year.start), '-', MAX(year.end)) as yearRange
          from product as prod
          left join image img on prod.id = img.productId
          left join product_category pc on prod.id = pc.productId
          left join category_year catyear on catyear.id = pc.categoryYearId
          left join category on category.id = catyear.categoryId
          left join year year on year.id = catyear.yearId
          where prod.discount > 0
          group by prod.id
          order by prod.discount desc
          limit {$limitNumber} offset {$offsetNumber}
        ";
        $products = Database::getMany($query);
        
        foreach($products as &$product) {
            if(isset($product['images'])) {
               $product['images'] = explode(',', $product['images']);
            }
        }
        $totalCount = Database::getOne("
          select count(*) as total from product as prod
          where prod.discount > 0
        ")['total'];

        $totalPagesNum = ceil($totalCount / LIMIT);
        $totalPages = [];
        for ($i = 1; $i <= $totalPagesNum; $i++) {
            $totalPages[] = $i;
        }

        $result = [
            'products' => $products,
            'totalCount' => $totalCount,
            'totalPages' => $totalPages,
        ];
        return $result;
    }

    public static function getProductsByPopular($offset, $limit) {
        $limitNumber = $limit == 0 ? LIMIT : $limit;
        $offsetNumber = ($offset - 1) * LIMIT;
        $query = "
        select prod.*, 
        GROUP_CONCAT(img.path) as images, 
        category.id as categoryId, 
        category.name as categoryName,
        CONCAT(MIN(year.start), '-', MAX(year.end)) as yearRange
        from product as prod
        left join image img on prod.id = img.productId
        left join product_category pc on prod.id = pc.productId
        left join category_year catyear on catyear.id = pc.categoryYearId
        left join category on category.id = catyear.categoryId
        left join year year on year.id = catyear.yearId
        where prod.type = 0 and prod.views > 100
        group by prod.id
        order by prod.views desc
        limit {$limitNumber} offset {$offsetNumber}
        ";

        $products = Database::getMany($query);
        foreach($products as &$product) {
            if(isset($product['images'])) {
               $product['images'] = explode(',', $product['images']);
            }
        }
        $totalCount = Database::getOne("
          select count(*) as total from product as prod
          where prod.type = 0 and prod.views > 100
        ")['total'];

        $totalPagesNum = ceil($totalCount / LIMIT);
        $totalPages = [];
        for ($i = 1; $i <= $totalPagesNum; $i++) {
            $totalPages[] = $i;
        }

        $result = [
            'products' => $products,
            'totalCount' => $totalCount,
            'totalPages' => $totalPages,
        ];
        return $result;   
    }

    public static function getProductsByFilter($yearIds, $offset) {
        $fill = array_fill(0, count($yearIds), '?');
        $placeholders = implode(', ', $fill);
        $query = "
          select prod.*, 
          GROUP_CONCAT(img.path) as images, 
          category.id as categoryId, 
          category.name as categoryName,
          CONCAT(MIN(year.start), '-', MAX(year.end)) as yearRange
          from product as prod
          left join image img on prod.id = img.productId
          left join product_category pc on prod.id = pc.productId
          left join category_year catyear on catyear.id = pc.categoryYearId
          left join category on category.id = catyear.categoryId
          left join year year on year.id = catyear.yearId
          where pc.categoryYearId in ({$placeholders})
          group by prod.id
          limit " . LIMIT . " offset {$offset}";

        $products = Database::getMany($query, $yearIds);
        foreach($products as &$product) {
            if(isset($product['images'])) {
               $product['images'] = explode(',', $product['images']);
            }
        }
        
        $totalCount = Database::getOne("
           select count(*) as total from product as prod
           left join product_category pc on prod.id = pc.productId
           where pc.categoryYearId in ({$placeholders})
        ", $yearIds)['total'];
        
        $totalPagesNum = ceil($totalCount / LIMIT);
        $totalPages = [];
        for ($i = 1; $i <= $totalPagesNum; $i++) {
            $totalPages[] = $i;
        }

        $result = [
            'products' => $products,
            'totalCount' => $totalCount,
            'totalPages' => $totalPages,
        ];

        return $result;

    }

}


