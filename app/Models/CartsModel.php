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

    public function getCartItemsByCartId($cart_id)
    {
        //name, image
        $cart_items = $this->db
            ->table('cart_items ci')
            ->select('ci.quantity, ci.subtotal, p.en_name, p.bg_name, p.de_name, p.price, p.image_url')
            ->where('cart_id', $cart_id)
            ->join('products p', 'p.id = ci.product_id')
            ->get()
            ->getResult();

        return $cart_items;
    }

    public function getCartItems($session_id, $user_id)
    {
        $cart = $this->getActiveCart($session_id, $user_id);

        if ($cart) {
            $cartItems = $this->db
                ->table('cart_items ci')
                ->select('ci.*, p.price, p.image_url, p.en_name, p.bg_name, p.de_name')
                ->where('ci.cart_id', $cart->id)
                ->join('products p', 'ci.product_id = p.id')
                ->get()
                ->getResult();

            return $cartItems;
        }
        return false;
    }

    public function deleteItem($item_id)
    {
        $cartItemTable = $this->db->table('cart_items');
        $cartItem = $cartItemTable->where('id', $item_id)->get()->getRow();

        if ($cartItemTable->where('id', $item_id)->delete()) {
            if (!$cartItemTable->where('cart_id', $cartItem->cart_id)->get()->getResult()) {
                $this->db->table('carts')
                    ->where('id', $cartItem->cart_id)
                    ->update([
                        'status' => 2
                    ]);
            }

            return true;
        } else {
            return false;
        }
    }

    public function updateSubtotal($item_id, $type)
    {
        $cartItem = $this->db
            ->table('cart_items')
            ->where('id', $item_id)
            ->get()
            ->getRow();

        $productPrice = $this->db
            ->table('products')
            ->where('id', $cartItem->product_id)
            ->get()
            ->getRow('price');

        if ($type === 'increase') {
            $newSubtotal = $cartItem->subtotal + $productPrice;
        } else {
            $newSubtotal = $cartItem->subtotal - $productPrice;
        }

        if ($this->db
            ->table('cart_items')
            ->where('id', $item_id)
            ->update([
                'subtotal' => $newSubtotal
            ])) {
            return $newSubtotal;
        }
        return false;
    }

    public function decreaseQtyAndGetTotals($item_id)
    {
        $cart_item = $this->db
            ->table('cart_items')
            ->where('id', $item_id)
            ->get()
            ->getRow();

        $itemQuantity = $cart_item->quantity - 1;

        $newSubTotal = $this->updateSubtotal($item_id, 'decrease');

        if ($this->db->table('cart_items')
            ->where('id', $item_id)
            ->update(['quantity' => $itemQuantity])) {

            $newTotal = $this->getTotalAmountInCart($cart_item->cart_id);
            return [
                'new_subtotal' => $newSubTotal,
                'new_total' => $newTotal
            ];
        }

        return false;
    }

    public function increaseQtyAndGetTotals($item_id)
    {
        $cart_item = $this->db
            ->table('cart_items')
            ->where('id', $item_id)
            ->get()
            ->getRow();

        $itemQuantity = $cart_item->quantity + 1;

        $newSubTotal = $this->updateSubtotal($item_id, 'increase');

        if ($this->db->table('cart_items')
            ->where('id', $item_id)
            ->update(['quantity' => $itemQuantity])) {

            $newTotal = $this->getTotalAmountInCart($cart_item->cart_id);
            return [
                'new_subtotal' => $newSubTotal,
                'new_total' => $newTotal
            ];
        }

        return false;
    }

    public function getTotalAmountInCart($cart_id)
    {
        $total = 0.0;

        $cart_items = $this->db
            ->table('cart_items')
            ->where('cart_id', $cart_id)
            ->get()
            ->getResult();

        foreach ($cart_items as $ci) {
            $total += $ci->subtotal;
        }

        return $total;
    }
}