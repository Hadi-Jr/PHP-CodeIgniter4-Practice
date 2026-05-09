<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;

class FeaturesModel
{
    protected $db;

    public function __construct(ConnectionInterface &$db)
    {
        $this->db = &$db;
    }

    public function get_product_features($product_id)
    {
        return $this->db
            ->table('features')
            ->where('product_id', $product_id)
            ->get()
            ->getResult();
    }
}