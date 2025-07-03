<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Restaurant;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{
    public function login()
    {
      
        //load restaurants
        $restaurant_model = new Restaurant();
        $restaurant = $restaurant_model->select('id, name')->findAll();
        // definir o nome da chave, que do lado da view vai ser uma variavel
        $data['restaurants'] = $restaurant;
        
        //validation errors
        // adiciona ao $data[] uma variavel 'validation_errors'
        $data['validation_errors'] = session()->getFlashdata('validation_errors');

        return view('auth/login_frm', $data);
    }

    public function submit(){
        // form validation
        $validation = $this->validate([
            'text_username' => [
                'label' => 'usuário',
                'rules' => 'required|min_length[6]|max_length[16]',
                'errors' => [
                    'required' => 'O campo {field} é obrigatório.',
                    'min_length' => 'O campo {field}, deve ter no mínimo {param} caracteres.',
                     'man_length' => 'O campo {field}, deve ter no max {param} caracteres.',
                ],
            ],
                 'text_password' => [
                'label' => 'senha',
                'rules' => 'required|min_length[6]|max_length[16]',
                'errors' => [
                    'required' => 'O campo {field} é obrigatório.',
                    'min_length' => 'O campo {field}, deve ter no mínimo {param} caracteres.',
                     'man_length' => 'O campo {field}, deve ter no max {param} caracteres.',
                ],
            ],
                     'select_restaurant' => [
                'label' => 'restaurante',
                'rules' => 'required',
                'errors' => [
                    'required' => 'O campo {field} é obrigatório.',
                    
                ],
            ],
        ]);

        if(!$validation) {
            redirect()->back()->withInput()->with('validation_errors', $this->validator->getErrors());  
        }
        echo 'ok';
    }

    public function logout() {
 
    }
}
