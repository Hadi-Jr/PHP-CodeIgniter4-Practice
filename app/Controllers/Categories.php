<?php

namespace App\Controllers;

use App\Models\CategoriesModel;
use App\Models\ProductsModel;
use Config\Database;

class Categories extends BaseController
{
    protected $db;
    protected $categoriesModel;
    protected $productsModel;

    public function __construct()
    {
        $this->db = Database::connect();
        $this->categoriesModel = new CategoriesModel($this->db);
        $this->productsModel = new ProductsModel($this->db);
    }

    public function view($category_slug)
    {
        $locale = session()->get('locale');
        $localeCatSuffix = $locale . '_name';

        $category = $this->categoriesModel->get_category_by_slug($category_slug);

        $this->data += [
            'seo_data' => [
                'title' => $category->$localeCatSuffix
            ]
        ];

        $products = $this->productsModel->get_category_products($category->id);

        $this->data += [
            'products' => $products,
            'category_name' => $category->$localeCatSuffix
        ];

        if ($products) {
            echo view('templates/meta', $this->data);
            echo view('templates/header', $this->data);
            echo view('category/products', $this->data);
            echo view('templates/footer', $this->data);
        } else {
            echo view('templates/meta', $this->data);
            echo view('templates/header', $this->data);
            echo view('category/empty_category', $this->data);
            echo view('templates/footer', $this->data);
        }
    }
}