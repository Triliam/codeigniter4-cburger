<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Product;

class ProductsController extends BaseController
{
    // protected $product_model;

    // public function __construct(Product $product_model) {
    //     $this->product_model = $product_model;
    // }

    public function index()
    {
        $data = [
            'title' => 'Produto',
            'page' => 'Produto',
        ];

        //get products
        $product_model = new Product();
        $data['products'] = $product_model->where('id_restaurant', session()->user['id_restaurant'])->findAll();
        return view('dashboard/products/index', $data);
    }

    public function newProduct()
    {
        $data = [
            'title' => 'Produto',
            'page' => 'Novo Produto',
        ];

        //form validation
        $data['validation_errors'] = session()->getFlashdata('validation_errors');

        //get categories
        $product_model = new Product();
        $data['categories'] = $product_model->where('id_restaurant', session()->user['id_restaurant'])->select('category')->distinct()->findAll();
        
        return view('dashboard/products/new_product_frm', $data);
    }

    public function submitProduct()
    {
        //form validation
        $validation = $this->validate([
            // product image
            'file_image' => [
                'label' => 'imagem do produto',
                'rules' => [
                    'uploaded[file_image]',
                    'mime_in[file_image,image/png]',
                    'max_size[file_image,200]'
                ],
                'errors' => [
                    'uploaded' => 'O campo {field} é obrigatório',
                    'mime_in' => 'O campo {field} deve ser uma imagem PNG',
                    'max_size' => 'O campo {field} deve ter no máximo 200KB'
                ]
            ],

            // input fields
            'text_name' => [
                'label' => 'nome do produto',
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => 'O campo {field} é obrigatório',
                    'min_length' => 'O campo {field} deve ter no mínimo 3 caracteres',
                    'max_length' => 'O campo {field} deve ter no máximo 100 caracteres'
                ]
            ],
            'text_description' => [
                'label' => 'descrição do produto',
                'rules' => 'required|min_length[3]|max_length[200]',
                'errors' => [
                    'required' => 'O campo {field} é obrigatório',
                    'min_length' => 'O campo {field} deve ter no mínimo 3 caracteres',
                    'max_length' => 'O campo {field} deve ter no máximo 200 caracteres'
                ]
            ],
            'text_category' => [
                'label' => 'categoria do produto',
                'rules' => 'required|min_length[3]|max_length[50]',
                'errors' => [
                    'required' => 'O campo {field} é obrigatório',
                    'min_length' => 'O campo {field} deve ter no mínimo 3 caracteres',
                    'max_length' => 'O campo {field} deve ter no máximo 50 caracteres'
                ]
            ],
            'text_price' => [
                'label' => 'preço do produto',
                'rules' => 'required|regex_match[/^\d+\,\d{2}$/]',
                'errors' => [
                    'required' => 'O campo {field} é obrigatório',
                    'regex_match' => 'O campo {field} deve ser um número com o formato x,xx',
                ]
            ],
            'text_promotion' => [
                'label' => 'promoção do produto',
                'rules' => 'required|greater_than[-1]|less_than[100]',
                'errors' => [
                    'required' => 'O campo {field} é obrigatório',
                    'greater_than' => 'O campo {field} deve ser um número maior que {param}',
                    'less_than' => 'O campo {field} deve ser um número menor que {param}',
                ]
            ],
            'text_initial_stock' => [
                'label' => 'estoque inicial do produto',
                'rules' => 'required|greater_than[99]',
                'errors' => [
                    'required' => 'O campo {field} é obrigatório',
                    'greater_than' => 'O campo {field} deve ser um número maior que {param}',
                ]
            ],
            'text_stock_minimum_limit' => [
                'label' => 'limite mínimo de estoque do produto',
                'rules' => 'required|greater_than[99]',
                'errors' => [
                    'required' => 'O campo {field} é obrigatório',
                    'greater_than' => 'O campo {field} deve ser um número maior que {param}',
                ]
            ]
        ]);
        if (!$validation) {

            return redirect()->back()->withInput()->with('validation_errors', $this->validator->getErrors());
        }
        //check if product already exists
        $product_model = new Product();
        $product = $product_model->where('name', $this->request->getPost('text_name'))->where('id_restaurant', session()->user['id_restaurant'])->first();
        if ($product) {
            return redirect()->back()->withInput()->with('validation_errors', ['text_name' => 'Já existe um produto com esse nome']);
        }

        //upload image
        $file_image = $this->request->getFile('file_image');
        $file_image->move(ROOTPATH . 'public/assets/images/products', $file_image->getName(), true);

        //prepare data to insert
        $data = [
            'id_restaurant' => session()->user['id_restaurant'],
            'name' => $this->request->getPost('text_name'),
            'description' => $this->request->getPost('text_description'),
            'category' => $this->request->getPost('text_category'),
            'price' => $this->request->getPost('text_price'),
            'promotion' => $this->request->getPost('text_promotion'),
            'stock' => $this->request->getPost('text_initial_stock'),
            'stock_min_limit' => $this->request->getPost('text_stock_minimum_limit'),
            'image' => $file_image->getName()
        ];

        //insert data
        $product_model->insert($data);

        //redirect
        return  redirect()->to('/products');
    }

    public function edit($enc_id)
    {
        $id = Decrypt($enc_id);
        if(empty($id)) {
            return redirect()->to('/products');
        }
        
        $data = [
            'title' => 'Produtos',
            'page' => 'Editar produtos'
        ];

        //form validation

        $data['validation_errors'] = session()->getFlashdata('validation_errors');

        //get product data by id
        $product_model = new Product();
        $data['product'] = $product_model->find($id);

        //get distinct categories
        $data['categories'] = $product_model->where('id_restaurant', session()->user['id_restaurant'])->select('category')->distinct()->findAll();

        //check if  the product image exists

        if(!file_exists('./assets/images/products/' . $data['product']->image)){
            $data['product']->image = 'no_image.png';
        }
        return view('dashboard/products/edit_product_frm', $data);
    }

    public function edit_submit() 
    {
         //form validation
        $validation = $this->validate([
            // product image
            'file_image' => [
                'label' => 'imagem do produto',
                'rules' => [
                    'uploaded[file_image]',
                    'mime_in[file_image,image/png]',
                    'max_size[file_image,200]'
                ],
                'errors' => [
                    'uploaded' => 'O campo {field} é obrigatório',
                    'mime_in' => 'O campo {field} deve ser uma imagem PNG',
                    'max_size' => 'O campo {field} deve ter no máximo 200KB'
                ]
            ],

            // input fields
            'text_name' => [
                'label' => 'nome do produto',
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => 'O campo {field} é obrigatório',
                    'min_length' => 'O campo {field} deve ter no mínimo 3 caracteres',
                    'max_length' => 'O campo {field} deve ter no máximo 100 caracteres'
                ]
            ],
            'text_description' => [
                'label' => 'descrição do produto',
                'rules' => 'required|min_length[3]|max_length[200]',
                'errors' => [
                    'required' => 'O campo {field} é obrigatório',
                    'min_length' => 'O campo {field} deve ter no mínimo 3 caracteres',
                    'max_length' => 'O campo {field} deve ter no máximo 200 caracteres'
                ]
            ],
            'text_category' => [
                'label' => 'categoria do produto',
                'rules' => 'required|min_length[3]|max_length[50]',
                'errors' => [
                    'required' => 'O campo {field} é obrigatório',
                    'min_length' => 'O campo {field} deve ter no mínimo 3 caracteres',
                    'max_length' => 'O campo {field} deve ter no máximo 50 caracteres'
                ]
            ],
            'text_price' => [
                'label' => 'preço do produto',
                'rules' => 'required|regex_match[/^\d+\,\d{2}$/]',
                'errors' => [
                    'required' => 'O campo {field} é obrigatório',
                    'regex_match' => 'O campo {field} deve ser um número com o formato x,xx',
                ]
            ],
            'text_promotion' => [
                'label' => 'promoção do produto',
                'rules' => 'required|greater_than[-1]|less_than[100]',
                'errors' => [
                    'required' => 'O campo {field} é obrigatório',
                    'greater_than' => 'O campo {field} deve ser um número maior que {param}',
                    'less_than' => 'O campo {field} deve ser um número menor que {param}',
                ]
            
            ],
            'text_stock_minimum_limit' => [
                'label' => 'limite mínimo de estoque do produto',
                'rules' => 'required|greater_than[99]',
                'errors' => [
                    'required' => 'O campo {field} é obrigatório',
                    'greater_than' => 'O campo {field} deve ser um número maior que {param}',
                ]
            ]
        ]);

        //check if id is ok
        $id = Decrypt($this->request->getPost('id_product'));
        if(empty($id)){
            return redirect()->to('/products');
        }

         if (!$validation) {

            return redirect()->back()->withInput()->with('validation_errors', $this->validator->getErrors());
        }
    }
}
