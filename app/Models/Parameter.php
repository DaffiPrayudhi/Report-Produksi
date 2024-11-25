<?php

namespace App\Models;

use CodeIgniter\Model;

class Parameter extends Model
{
    protected $DBGroup = 'oeeManual';
    protected $table            = 'grafik_produksi_parameter';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['parameter','target','years','line'];

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

    public function getYearlyDataWithJoin($line, $previousYear)
    {
        $builder = $this->db->table($this->table);
        $builder->select('grafik_produksi_parameter.parameter, grafik_produksi_parameter.target, grafik_produksi_parameter.years, grafik_produksi_parameter.line');
        $builder->where('grafik_produksi_parameter.years', $previousYear);
        $builder->whereIn('grafik_produksi_parameter.parameter', ['bts FY', 'oee FY', 'avail FY', 'bts', 'oee','avail']);
    
        if ($line) {
            $builder->where('grafik_produksi_parameter.line', $line);
        }
    
        return $builder->get()->getResultArray();
    }
    
    
    

    
}

