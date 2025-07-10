<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductsSeed extends Seeder
{
    public function run()
    {
        $data =[
               [
        'id_restaurant' => 1,
        'name' => 'Cig Hamburger',
        'description' => 'O melhor hambúrguer pelo melhor preço.',
        'category' => 'Hambúrgueres',
        'price' => '6.50',
        'availability' => 1,
        'promotion' => 0,
        'stock' => 1000,
        'stock_min_limit' => 100,
        'image' => 'rest_00001_burger_01.png',
        'created_at' => date('Y-m-d H:i:s')
    ],
    [
        'id_restaurant' => 1,
        'name' => 'Cig Cheese In',
        'description' => 'O sabor do queijo dentro do hambúrguer.',
        'category' => 'Hambúrgueres',
        'price' => '8.00',
        'availability' => 1,
        'promotion' => 0,
        'stock' => 1000,
        'stock_min_limit' => 100,
        'image' => 'rest_00001_burger_02.png',
        'created_at' => date('Y-m-d H:i:s')
    ],
    [
        'id_restaurant' => 1,
        'name' => 'Cig Double',
        'description' => 'Duas vezes mais sabor.',
        'category' => 'Hambúrgueres',
        'price' => '12.50',
        'availability' => 1,
        'promotion' => 0,
        'stock' => 1000,
        'stock_min_limit' => 100,
        'image' => 'rest_00001_burger_03.png',
        'created_at' => date('Y-m-d H:i:s')
    ],
  
    [
        'id_restaurant' => 1,
        'name' => 'Cig Coca',
        'description' => 'Bebida refrescante.',
        'category' => 'Bebidas',
        'price' => '3.50',
        'availability' => 1,
        'promotion' => 0,
        'stock' => 1000,
        'stock_min_limit' => 100,
        'image' => 'rest_00001_drink_01.png',
        'created_at' => date('Y-m-d H:i:s')
    ],
  
    [
        'id_restaurant' => 1,
        'name' => 'Cig Caramelo Ice',
        'description' => 'Gelado com topping de caramelo.',
        'category' => 'Sobremesas',
        'price' => '3.00',
        'availability' => 1,
        'promotion' => 0,
        'stock' => 1000,
        'stock_min_limit' => 100,
        'image' => 'rest_00001_ice_cream_01.png',
        'created_at' => date('Y-m-d H:i:s')
    ],

        ];
        $this->db->table('products')->insertBatch($data);
    }
}
