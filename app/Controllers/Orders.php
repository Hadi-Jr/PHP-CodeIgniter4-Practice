<?php
namespace App\Controllers;

use App\Models\CartsModel;
use Config\Database;

class Orders extends BaseController
{
    protected $db;
    protected $cartsModel;

    public function __construct()
    {
        $this->db = Database::connect();
        $this->cartsModel = new CartsModel($this->db);
    }

    public function view()
    {
        //view the orders
    }

    public function index($cart_id = null)
    {
        $seo_data = [
            'title' => lang('App.checkout')
        ];

        $this->data += [
            'seo_data' => $seo_data
        ];

        if ($cart_id) {
            $cart_items = $this->cartsModel->getCartItemsByCartId($cart_id);

            $total = 0.0;
            foreach ($cart_items as $ci) {
                $total += $ci->subtotal;
            }

            $this->data += [
                'cart_items' => $cart_items,
                'total' => $total
            ];
        }

        if ($this->request->getMethod() == 'POST') {
            $post_data = $this->request->getPost();

            $rules = [
                'full_name' => [
                    'rules' => 'required|min_length[6]',
                    'errors' => [
                        'required' => lang('Errors.full_name_required'),
                        'min_length' => lang('Errors.full_name_min_length')
                    ]
                ],
                'email' => [
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => lang('Errors.email_required'),
                        'valid_email' => lang('Errors.valid_email')
                    ]
                ],
                'phone_number' => [
                    'rules' => 'required|min_length[10]',
                    'errors' => [
                        'required' => lang('Errors.phone_required'),
                        'min_length' => lang('Errors.phone_min_length')
                    ]
                ],
                'shipping_address' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang('Errors.address_required'),
                    ]
                ],
                'cart_full_name' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang('Errors.cart_name_required')
                    ]
                ],
                'cvv' => [
                    'rules' => 'required|max_length[3]',
                    'errors' => [
                        'required' => lang('Errors.cvv_required'),
                        'min_length' => lang('Errors.cvv_min_length')
                    ]
                ],
                'validity' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => lang('Errors.validity_required')
                    ]
                ],
                'card_number' => [
                    'rules' => 'required|min_length[12]',
                    'errors' => [
                        'required' => lang('Errors.card_number_required'),
                        'min_length' => lang('Errors.card_number_min_length')
                    ]
                ]
            ];

            if (!$this->validate($rules, $post_data)) {
                $this->data['alert_message'] = [
                    ''
                ];
            }

            exit;
        }

        echo view('templates/meta', $this->data);
        echo view('templates/header', $this->data);
        echo view('order/checkout', $this->data);
        echo view('templates/footer', $this->data);
    }
}