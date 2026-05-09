<?php

namespace App\Controllers;

use Config\Database;

class Cart extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function index()
    {
        $this->data += [
            'seo_data' => [
                'title' => ''
            ]
        ];

        if ($this->request->getMethod() == 'POST') {

        }

        //view the cart
    }
}