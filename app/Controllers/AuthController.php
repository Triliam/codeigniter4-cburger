<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Restaurant;
use App\Models\User;
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

        //persistencia dados restaurante
        $data['select_restaurant'] = session()->getFlashdata('select_restaurant');

        //login error
        $data['login_error'] = session()->getFlashdata('login_error');

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
            session()->setFlashdata('select_restaurant', Decrypt($this->request->getPost('select_restaurant')));
         return redirect()->back()->withInput()->with('validation_errors', $this->validator->getErrors());
            
        }
        // check login
        $username = $this->request->getPost('text_username');
        $password = $this->request->getPost('text_password');
        $id_restaurant = Decrypt($this->request->getPost('select_restaurant'));
        $user_model = new User();
        $user = $user_model->check_for_login($username, $password, $id_restaurant);

        if(!$user){
            session()->setFlashdata('select_restaurant', Decrypt($this->request->getPost('select_restaurant')));
         return redirect()->back()->withInput()->with('login_error', 'Usuário ou senha inválidos.');
        }
        //set session
        $restaurant_model = new Restaurant();
        $restaurant_name = $restaurant_model->select('name')->find($user->id_restaurant)->name;

        $user_data = [
            'id' => $user->id,
            'name' => $user->name,
            'id_restaurant' => $user->id_restaurant,
            'restaurant_name' => $restaurant_name,
            'email' => $user->email,
            'phone' => $user->phone,
            'roles' => $user->roles,
        ];

        session()->set('user', $user_data);
        return redirect()->to('/');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login');
    }
}
