<?php

namespace App\Controllers;

use App\Models\CartsModel;
use App\Models\ClientsModel;
use Config\Database;

class Registration extends BaseController
{
    protected $db;
    protected $clientsModel;
    protected $cartsModel;

    public function __construct()
    {
        $this->db = Database::connect();
        $this->clientsModel = new ClientsModel($this->db);
        $this->cartsModel = new CartsModel($this->db);
    }

    public function index()
    {
        $this->data += [
            'seo_data' => [
                'title' => lang('App.login')
            ]
        ];

        if ($this->request->getMethod() == 'POST') {

            $rules = [
                'email' => [
                    'rules' => 'required|min_length[6]|max_length[100]|valid_email',
                    'errors' => [
                        'required' => lang('Errors.required'),
                        'min_length' => lang('Errors.min_length'),
                        'valid_email' => lang('Errors.valid_email'),
                        'max_length' => lang('Errors.max_length')
                    ]
                ],
                'password' => [
                    'rules' => 'required|min_length[6]|max_length[100]',
                    'errors' => [
                        'required' => lang('Errors.required'),
                        'min_length' => lang('Errors.min_length'),
                        'max_length' => lang('Errors.max_length')
                    ]
                ]
            ];

            if (!$this->validate($rules)) {
                $this->data['alert_message'] = [
                    'type' => 'danger',
                    'message' => $this->validator->listErrors()
                ];
            } else {
                $email = $this->request->getPost('email');
                $password = $this->request->getPost('password');

                $user = $this->clientsModel->getUser($email, $password);

                if(!$user || empty($user)) {
                    $this->data['alert_message'] = [
                        'type' => 'danger',
                        'message' => lang('Errors.wrong_credentials')
                    ];
                } else {
                    session()->set('user_info', $user);

                    $session_id = session_id();
                    $this->cartsModel->transferGuestCartToUser($user->id, $session_id);

                    $this->data['alert_message'] = [
                        'type' => 'success',
                        'message' => lang('App.successful_login')
                    ];
                }
            }

            echo '	<div class="alert alert-'.$this->data['alert_message']['type'].'" role="alert">
						  '.$this->data['alert_message']['message'].'
						</div>';
            exit;
        }

        echo view('templates/meta', $this->data);
        echo view('registration/login', $this->data);
        echo view('templates/footer', $this->data);
    }

    public function registerNewUser()
    {
        $this->data += [
            'seo_data' => [
                'title' => lang('App.register')
            ]
        ];

        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'email' => [
                    'rules' => 'required|min_length[6]|max_length[100]|valid_email',
                    'errors' => [
                        'required' => lang('Errors.required'),
                        'min_length' => lang('Errors.min_length'),
                        'valid_email' => lang('Errors.valid_email'),
                        'max_length' => lang('Errors.max_length')
                    ]
                ],
                'password' => [
                    'rules' => 'required|min_length[6]|max_length[100]',
                    'errors' => [
                        'required' => lang('Errors.required'),
                        'min_length' => lang('Errors.min_length'),
                        'max_length' => lang('Errors.max_length')
                    ]
                ],
                'first_name' => [
                    'rules' => 'required|min_length[6]|max_length[100]',
                    'errors' => [
                        'required' => lang('Errors.required'),
                        'min_length' => lang('Errors.min_length'),
                        'max_length' => lang('Errors.max_length')
                    ]
                ],
                'last_name' => [
                    'rules' => 'required|min_length[6]|max_length[100]',
                    'errors' => [
                        'required' => lang('Errors.required'),
                        'min_length' => lang('Errors.min_length'),
                        'max_length' => lang('Errors.max_length')
                    ]
                ],
                'confirmPassword' => [
                    'rules' => 'required|min_length[6]|max_length[100]|matches[password]',
                    'errors' => [
                        'required' => lang('Errors.required'),
                        'min_length' => lang('Errors.min_length'),
                        'max_length' => lang('Errors.max_length'),
                        'matches' => lang('Errors.confirm_password')
                    ]
                ]
            ];

            if (!$this->validate($rules)) {
                $this->data['alert_message'] = [
                    'type' => 'danger',
                    'message' => $this->validator->listErrors()
                ];
            } else {
                $email = $this->request->getPost('email');
                $password = $this->request->getPost('password');
                $first_name = $this->request->getPost('first_name');
                $last_name = $this->request->getPost('last_name');

                $new_user = $this->clientsModel->register($email, $first_name, $last_name, $password);

                if (!$new_user) {
                    $this->data['alert_message'] = [
                        'type' => 'danger',
                        'message' => lang('Errors.already_exists')
                    ];
                } else {
                    $this->data['alert_message'] = [
                        'type' => 'success',
                        'message' => lang('App.successful_registration')
                    ];
                }
            }

            echo '	<div class="alert alert-'.$this->data['alert_message']['type'].'" role="alert">
						  '.$this->data['alert_message']['message'].'
						</div>';
            exit;
        }

        echo view('templates/meta', $this->data);
        echo view('registration/register', $this->data);
        echo view('templates/footer', $this->data);
    }

    public function logout()
    {
        session()->removeTempdata('user_info');
        return redirect()->to('/home');
    }
}