<?php

namespace App\Controllers;

use App\Models\FeaturesModel;
use App\Models\ProductsModel;
use Config\Database;

class Products extends BaseController
{
    protected $db;
    protected $productsModel;
    protected $featuresModel;

    public function __construct()
    {
        $this->db = Database::connect();
        $this->productsModel = new ProductsModel($this->db);
        $this->featuresModel = new FeaturesModel($this->db);
    }

    public function view($product_id)
    {
        $locale = session()->get('locale');
        $localeNameSuffix = $locale . '_name';
        $localeDescSuffix = $locale . '_description';

        $product = $this->productsModel->get_single_product($product_id);

        $features = $this->featuresModel->get_product_features($product_id);

        $additional_data = [];
        $featuresTable = [];
        foreach ($features as $feature) {
            if ($feature->{$locale . '_key'} === 'Method of use'
                || $feature->{$locale . '_key'} === 'Начин на употреба'
                || $feature->{$locale . '_key'} === 'Anwendungsmethode'
                || $feature->{$locale . '_key'} === 'Additional information'
                || $feature->{$locale . '_key'} === 'Допълнителна информация'
                || $feature->{$locale . '_key'} === 'Weitere Informationen') {
                $additional_data[] = $feature;
            } else {
                $featuresTable[] = $feature;
            }
        }

        $all_ratings = $this->productsModel->get_product_ratings($product_id);

        if (!empty($all_ratings)) {
            $product_rating = 0;

            foreach ($all_ratings as $rating) {
                $product_rating += $rating->rating;
            }
            $product_rating /= count($all_ratings);
        } else {
            $product_rating = 1;
        }

        $this->data += [
            'seo_data' => [
                'title' => $product->$localeNameSuffix,
                'description' => $product->$localeDescSuffix
            ],
            'product_data' => $product,
            'locale' => $locale,
            'additional_data' => $additional_data,
            'features_table' => $featuresTable,
            'product_rating' => $product_rating,
            'product_id' => $product_id
        ];

        echo view('templates/meta', $this->data);
        echo view('templates/header', $this->data);
        echo view('product/product_view', $this->data);
        echo view('templates/footer', $this->data);
    }

    public function rate()
    {
        $product_id = $this->request->getPost('product_id');
        $rate_value = $this->request->getPost('rate_value');
        $user_id = $this->request->getPost('user_id');

        if (!$user_id) {
            return $this->response->setJSON(
                [
                    'success' => false,
                    'message' => lang('App.login_required')
                ]
            );
        } else {
            $saved_rating = $this->productsModel->rate_product($product_id, $rate_value, $user_id);

            if ($saved_rating) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => lang('App.thanks_for_rating')
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'already_rated' => true,
                    'message' => lang('App.already_rated')
                ]);
            }
        }
    }
}