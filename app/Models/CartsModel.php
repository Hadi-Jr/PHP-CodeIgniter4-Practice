<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;

class CartsModel
{
    protected $db;

    public function __construct(ConnectionInterface &$db)
    {
        $this->db = &$db;
    }
}