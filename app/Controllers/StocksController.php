<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Product;


class StocksController extends BaseController
{
    public function index()
    {

        //load all products
        $product_model = new Product();
        $products = $product_model->where('id_restaurant', session()->user['id_restaurant'])->findAll();

        $data = [
            'title' => 'Stocks',
            'page' => 'Stocks',
            'products' => $products
        ];

        return view('dashboard/stocks/index', $data);
    }
}
