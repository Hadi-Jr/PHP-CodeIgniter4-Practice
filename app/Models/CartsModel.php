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

    public function add_to_cart($product_id, $quantity, $session_id, $user_id)
    {
        $product = $this->db
            ->table('products')
            ->where('id', $product_id)
            ->get()
            ->getRow();

        $cart = $this->getActiveCart($session_id, $user_id);

        if ($cart) {
            $cart_item = $this->db
                ->table('cart_items')
                ->where('product_id', $product_id)
                ->where('cart_id', $cart->id)
                ->get()
                ->getRow();

            if ($cart_item) {
                $this->db
                    ->table('cart_items')
                    ->where('id', $cart_item->id)
                    ->update(
                        [
                            'quantity' => $cart_item->quantity + $quantity,
                            'subtotal' => $cart_item->subtotal + ($quantity * $product->price)
                        ]
                    );
            } else {
                $subtotal = $quantity * $product->price;
                $data = [
                    'user_id' => $user_id,
                    'product_id' => $product_id,
                    'quantity' => $quantity,
                    'cart_id' => $cart->id,
                    'subtotal' => $subtotal
                ];

                $this->db->table('cart_items')
                    ->insert($data);
            }
        } else {
            $cart_data = [
                'session_id' => $session_id,
                'user_id' => $user_id ?? null,
                'status' => 1
            ];

            $this->db->table('carts')
                ->insert($cart_data);

            $new_cart_id = $this->db->insertID();

            $cart_item_data = [
                'user_id' => $user_id ?? null,
                'product_id' => $product_id,
                'quantity' => $quantity,
                'subtotal' => $product->price * $quantity,
                'cart_id' => $new_cart_id
            ];

            $this->db->table('cart_items')
                ->insert($cart_item_data);
        }
    }

    public function getActiveCart($session_id, $user_id = null)
    {
        if ($user_id) {
            $cart = $this->db
                ->table('carts')
                ->where('user_id', $user_id)
                ->where('status', 1)
                ->get()
                ->getRow();
        } else {
            $cart = $this->db
                ->table('carts')
                ->where('session_id', $session_id)
                ->where('status', 1)
                ->get()
                ->getRow();
        }

        return $cart;
    }

    public function transferGuestCartToUser($user_id, $session_id)
    {
        $cart = $this->getActiveCart($session_id);

        if ($cart) {
            $this->db->table('carts')
                ->where('session_id', $session_id)
                ->update([
                    'user_id' => $user_id
                ]);
        }
    }
}