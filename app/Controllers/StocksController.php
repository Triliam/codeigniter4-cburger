<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Product;
use App\Models\Stock;

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

    public function add($enc_id) {

        //id product
        $id = Decrypt($enc_id);
        if(empty($id)){
            return redirect()->to('/stocks');
        }

        //load products
        $product_model = new Product();
        $product = $product_model->where('id', $id)->first();

        //get distinct suppliers within stocks table that bleongs to this restaurant
        $stock_model = new Stock();
        $stock_suppliers = $stock_model->get_stock_suppliers(session()->user['id_restaurant']);
        

        $data = [
            'title' => 'Estoque',
            'page' => 'Adicionar ao estoque',
            'product' => $product,
            'stock' => $stock_suppliers,
            'validation_errors' => session()->getFlashdata('validation_errors'),
            'server_error' => session()->getFlashdata('server_error')
        ];
        return view('dashboard/stocks/add_frm', $data);
    }

    public function addSubmit() {
        
        //form validation
        $validation = $this->validate($this->_stock_add_form_validation());
        if(!$validation){
            return redirect()->back()->withInput()->with('validation_errors', $this->validator->getErrors());
        }

        //check if id_product is valid
        $id_product = Decrypt($this->request->getPost('id_product'));
        if(empty($id_product)){
            return redirect()->back()->withInput()->with('server_error', 'Ocorreu um erro, tente novamente.');
        }

        //get post data
        $text_stock = $this->request->getPost('text_stock');
        $text_supplier = $this->request->getPost('text_supplier');
        $text_reason = $this->request->getPost('text_reason');
        $text_date = $this->request->getPost('text_date');

        //insert
        $stock_model = new Stock();
        $stock_model->insert([
            'id_product' => $id_product,
            'stock_quantity' => intval($text_stock),
            'stock_in_out' => 'IN',
            'stock_supplier' => $text_supplier,
            'reason' => $text_reason,
            'movement_date' => $text_date,
            
            // 'created_at' => date('Y-m-d H:i'),
        ]);

        //increment product stock
        $product_model = new Product();
        $product_model->where('id', $id_product)->set('stock', 'stock+' . intval($text_stock), false)->update();

        return redirect()->to('/stocks');
    }

        public function remove($enc_id) {

        //id product
        $id = Decrypt($enc_id);
        if(empty($id)){
            return redirect()->to('/stocks');
        }

        //load products
        $product_model = new Product();
        $product = $product_model->where('id', $id)->first();

        

        $data = [
            'title' => 'Estoque',
            'page' => 'Remover do estoque',
            'product' => $product,
            'validation_errors' => session()->getFlashdata('validation_errors'),
            'server_error' => session()->getFlashdata('server_error')
        ];
        return view('dashboard/stocks/remove_frm', $data);
    }

    public function removeSubmit() {
        //form validation
        $validation = $this->validate($this->_stock_remove_form_validation());
        if(!$validation){
            return redirect()->back()->withInput()->with('validation_errors', $this->validator->getErrors());
        }

        //check if id_product is valid
        
        $id_product = Decrypt($this->request->getPost('id_product'));
        //dd($id_product);
        if(empty($id_product)){
            return redirect()->back()->withInput()->with('server_error', 'Ocorreu um erro, tente novamente.');
        }

        //get post data
        $text_stock = $this->request->getPost('text_stock');
        $text_reason = $this->request->getPost('text_reason');
        $text_date = $this->request->getPost('text_date');

        //check stock quantity
        $product_model = new Product();
        $product = $product_model->where('id', $id_product)->first();       
        if($product->stock < intval($text_stock)){
            return redirect()->back()->withInput()->with('server_error', 'A quantidade no estoque é inferior.');
        }
        //store stock movement
        $stock_model = new Stock();
        $stock_model->insert([
            'id_product' => $id_product,
            'stock_quantity' => intval($text_stock),
            'stock_in_out' => 'OUT',
            'stock_supplier' => 'Owner',
            'reason' => $text_reason,
            'movement_date' => $text_date,
        ]);

        //decrement product stock
        $product_model->where('id', $id_product)->set('stock', 'stock-' . intval($text_stock), false)->update();
        return redirect()->to('/stocks');
    }

    private function _stock_add_form_validation() {

        //stock form validation rules

        return [
            'id_product' => [
                'rules' => 'required'
            ],
        
            'text_stock' => [
                'label' => 'Quantidade',
                'rules' => 'required|numeric|greater_than[0]',
                'errors' => [
                    'required' => 'O campo {field} é obrigatório.',
                    'numeric' => 'O campo {field} deve ser númerico.',
                    'greater_than' => 'O campo {field} deve ser maior que {param}.'
                ],
            ], 
             'text_supplier' => [
                'label' => 'Fornecedor',
                'rules' => 'required',
                'errors' => [
                    'required' => 'O campo {field} é obrigatório.',
                ], 
            ],    
                //text_reason not required
             'text_date' => [
                'label' => 'Data',
                'rules' => 'required|valid_date[Y-m-d H:i]',
                'errors' => [
                    'required' => 'O campo {field} é obrigatório.',
                    'valid_date' => 'O  campo {field}  deve ter uma data válida (Y-m-d H:i)'
                ]   
             
            ]
                ];
    }

     private function _stock_remove_form_validation() {

        //stock form validation rules

        return [
            'id_product' => [
                'rules' => 'required'
            ],
        
            'text_stock' => [
                'label' => 'Quantidade',
                'rules' => 'required|numeric|greater_than[0]',
                'errors' => [
                    'required' => 'O campo {field} é obrigatório.',
                    'numeric' => 'O campo {field} deve ser númerico.',
                    'greater_than' => 'O campo {field} deve ser maior que {param}.'
                ],
            ], 
      
                //text_reason not required
             'text_date' => [
                'label' => 'Data',
                'rules' => 'required|valid_date[Y-m-d H:i]',
                'errors' => [
                    'required' => 'O campo {field} é obrigatório.',
                    'valid_date' => 'O  campo {field}  deve ter uma data válida (Y-m-d H:i)'
                ]   
             
            ]
                ];
    }
}
