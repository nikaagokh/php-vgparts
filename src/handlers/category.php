<?php

namespace Handlers;

use Core\Database;

class Category
{
    public static function getAllCategoriesWithChildren()
    {
        $query = "
        SELECT 
            cat.id, 
            cat.name, 
            cat.image,
            CONCAT(
                '[', 
                GROUP_CONCAT(
                    CONCAT(
                        '{\"id\":', sub.id, 
                        ',\"name\":\"', REPLACE(sub.name, '\"', '\\\"'), '\"',
                        ',\"images\":[', (
                            SELECT 
                                GROUP_CONCAT(
                                    CONCAT(
                                        '{\"id\":', cy.id,
                                        ',\"imageUrl\":\"', REPLACE(cy.imageUrl, '\"', '\\\"'), '\"',
                                        ',\"range\":\"', y.start, '-', y.end, '\"}'
                                    ) SEPARATOR ','
                                )
                            FROM category_year cy 
                            LEFT JOIN year y ON y.id = cy.yearId
                            WHERE cy.categoryId = sub.id
                        ), ']}'    
                    ) 
                    SEPARATOR ','
                ),
                ']'
            ) AS subcategories
        FROM 
            category cat
        LEFT JOIN 
            category sub ON cat.id = sub.categoryId
        WHERE 
            cat.categoryId IS NULL
        GROUP BY 
            cat.id, cat.name
        ";
        $categories = Database::getMany($query);
        foreach($categories as &$category) {
            if(isset($category['subcategories'])) {
                $category['subcategories'] = json_decode($category['subcategories'], true);
            }
        }
        return $categories;
    }

    public static function getAllCategories()
    {
        $query = "select * from category where categoryId is null";
        $categories = Database::getMany($query);
        return $categories;
    }

    public static function getChildrenCategories($id)
    {
        $query = "
        WITH RECURSIVE CTE AS (
            SELECT c.id, c.name, cy.imageUrl, y.start, y.end
            FROM category c
            left join category_year cy on c.id = cy.categoryId
            left join year y on cy.yearId = y.id
            WHERE c.categoryId = ?
            UNION ALL
            SELECT e.id, e.name, cy.imageUrl, y.start, y.end
            FROM category e
            left join category_year cy on e.id = cy.categoryId
            left join year y on cy.yearId = y.id
            INNER JOIN CTE c ON e.categoryId = c.id
        )
        SELECT * FROM CTE;
       ";

        $categories = Database::getMany($query, [$id]);
        return $categories;
    }

    public static function getSubcategories($id)
    {
        $query = "
    SELECT 
        cat.id, 
        cat.name, 
        cat.categoryId, 
        CONCAT('[', GROUP_CONCAT(
            CONCAT(
                '{\"yearId\": ', catyear.id, ', \"imageUrl\": \"', catyear.imageUrl, '\"}'
            )
        ), ']') AS cyear
    FROM 
        category AS cat
    LEFT JOIN 
        category AS sub ON cat.id = sub.categoryId
    LEFT JOIN 
        category_year AS catyear ON cat.id = catyear.categoryId
    LEFT JOIN 
        year AS year ON catyear.yearId = year.id
    WHERE 
        cat.categoryId = ?
    GROUP BY 
        cat.id";
        $categories = Database::getMany($query, [$id]);
        foreach($categories as &$category) {
            if(isset($category['cyear'])) {
                $category['cyear'] = json_decode($category['cyear'], true);
            }
        }
        return $categories;
    }

    public static function getOneCategory($id)
    {
        $query = "select * from category where id = ?";
        $categories = Database::getOne($query, [$id]);
        return $categories;
    }
}
