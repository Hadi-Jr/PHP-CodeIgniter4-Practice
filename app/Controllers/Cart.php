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

    public function index()
    {
        $this->data += [
            'seo_data' => [
                'title' => lang('App.cart')
            ]
        ];

        $session_id = session_id();
        $user_id = '';
        if (session()->get('user_info')) {
            $user_id = session()->get('user_info')->id;
        }

        $cart_items = $this->cartsModel->getCartItems($session_id, $user_id);

        $total = 0.0;
        if ($cart_items) {
            foreach ($cart_items as $ci) {
                $total += $ci->subtotal;
            }
        }

        $this->data+= [
            'cart_items' => $cart_items,
            'total' => $total
        ];

        if ($cart_items) {
            echo view('templates/meta', $this->data);
            echo view('templates/header', $this->data);
            echo view('cart/cart', $this->data);
            echo view('templates/footer', $this->data);
        } else {
            echo view('templates/meta', $this->data);
            echo view('templates/header', $this->data);
            echo view('cart/empty_cart', $this->data);
            echo view('templates/footer', $this->data);
        }
    }

    public function removeCartItem()
    {
        $item_id = $this->request->getPost('cart_item_id');

        if ($this->cartsModel->deleteItem($item_id)) {
            return $this->response->setJSON(
                [
                    'success' => true,
                    'message' => lang('App.item_deleted')
                ]
            );
        } else {
            return $this->response->setJSON(
                [
                    'success' => false
                ]
            );
        }
    }

    public function decreaseQuantity()
    {
        $item_id = $this->request->getPost('cart_item_id');

        $subtotal = $this->cartsModel->decreaseQtyAndGetSubtotal($item_id);
        if ($subtotal) {
            return $this->response->setJSON(
                [
                    'success' => true,
                    'subtotal' => $subtotal
                ]
            );
        }
    }

    public function increaseQuantity()
    {
        $item_id = $this->request->getPost('cart_item_id');

        $subtotal = $this->cartsModel->increaseQtyAndGetSubtotal($item_id);

        if ($subtotal) {
            return $this->response->setJSON(
                [
                    'success' => true,
                    'subtotal' => $subtotal
                ]
            );
        }
    }

}