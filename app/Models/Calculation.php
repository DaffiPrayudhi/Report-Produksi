<?php

namespace App\Models;

use CodeIgniter\Model;

class Calculation extends Model
{
    protected $DBGroup = 'oeeManual';
    protected $table            = 'daily_calculation';
    protected $primaryKey       = 'id_clc';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['tgl_bln_thn','line','shift','oee','bts','avail','s_downtime','model'];

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

    public function getFilteredData($startDate, $endDate, $line = null)
    {
        $builder = $this->db->table($this->table);
        $builder->select('tgl_bln_thn, shift, line, oee, bts, avail');
        $builder->where('tgl_bln_thn >=', $startDate);
        $builder->where('tgl_bln_thn <=', $endDate);
        
        if ($line) {
            $builder->where('line', $line);
        }

        return $builder->get()->getResultArray();
    }

    public function getDistinctLines()
    {
        return $this->db->table($this->table)
                        ->select('line')
                        ->distinct()
                        ->where('line IS NOT NULL')
                        ->get()
                        ->getResultArray();
    }
}

