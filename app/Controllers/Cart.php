<?php

namespace App\Controllers;

use App\Models\CartsModel;
use Config\Database;

class Cart extends BaseController
{
    protected $db;
    protected $cartsModel;

    public function __construct()
    {
        $this->db = Database::connect();
        $this->cartsModel = new CartsModel($this->db);
    }

    public function add()
    {
        $product_id = $this->request->getPost('product_id');
        $quantity = $this->request->getPost('quantity');

        $session_id = session_id();

        $user_id = '';
        if (session()->get('user_info')) {
            $user_id = session()->get('user_info')->id;
        }

        $this->cartsModel->add_to_cart($product_id, $quantity, $session_id, $user_id);

        return $this->response->setJSON(
            [
                'success' => true,
                'message' => lang('App.add_to_cart_success')
            ]
        );
    }
}