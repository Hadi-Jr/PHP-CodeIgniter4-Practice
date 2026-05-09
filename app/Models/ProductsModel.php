<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;

class ProductsModel
{
    protected $db;

    public function __construct(ConnectionInterface &$db)
    {
        $this->db = &$db;
    }

    public function get_category_products($category_id)
    {
        $products = $this->db
            ->table('products')
            ->where('category_id', $category_id)
            ->get()
            ->getResult();

        if ($products) {
            return $products;
        } else {
            return false;
        }
    }

    public function get_single_product($product_id)
    {
        $localCatName = session()->get('locale') . '_name';
        return $this->db
            ->table('products p')
            ->select('p.*, c.'.$localCatName.' as cat_name, c.slug as cat_slug')
            ->join('categories c', 'p.category_id = c.id')
            ->where('p.id', $product_id)
            ->get()
            ->getRow();
    }

    public function get_product_ratings($product_id)
    {
        return $this->db
            ->table('rating')
            ->where('product_id', $product_id)
            ->get()
            ->getResult();
    }

    public function rate_product($product_id, $rate_value, $user_id)
    {
        $data = [
            'product_id' => $product_id,
            'rating' => $rate_value,
            'user_id' => $user_id
        ];

        $old_rating = $this->db
            ->table('rating')
            ->where('product_id', $product_id)
            ->where('user_id', $user_id)
            ->get()
            ->getRow();

        if (!$old_rating) {
            $this->db
                ->table('rating')
                ->insert($data);

            return $this->db->insertID();
        } else {
            return false;
        }
    }
}