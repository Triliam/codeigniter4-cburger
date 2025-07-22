<?php

namespace App\Models;

use CodeIgniter\Model;

class Stock extends Model
{
    protected $table            = 'stocks';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_product', 'stock_quantity', 'stock_in_out', 'stock_supplier', 'reason', 'movement_date', 'created_at', 'updated_at'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function get_stock_suppliers($id_restaurant) {
        //get distinct suppliers within stocks table that belongs to this restaurant
        $builder = $this->db->table('stocks')->distinct()->select('stocks.stock_supplier')->join('products', 'stocks.id_product = products.id')->where('products.id_restaurant', $id_restaurant)->where('stocks.stock_in_out', 'IN');

        $query = $builder->get();
        return $query->getResult();
    }
}
