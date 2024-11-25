<?php

namespace App\Models;

use CodeIgniter\Model;

class Produksi extends Model
{
    protected $DBGroup = 'oeeManual';
    protected $table            = 'daily_production';
    protected $primaryKey       = 'id_rpt';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['tgl_bln_thn', 'line', 'model', 'shift', 'actual_prod', 'plan_prod','cycle_time','cta'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
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
    
    public function getDistinctLines()
    {
        return $this->db->table($this->table)
                        ->select('shift')
                        ->distinct()
                        ->where('shift IS NOT NULL')
                        ->get()
                        ->getResultArray();
    }
}




