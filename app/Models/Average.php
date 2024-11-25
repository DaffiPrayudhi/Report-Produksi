<?php

namespace App\Models;

use CodeIgniter\Model;

class Average extends Model
{
    protected $DBGroup = 'oeeManual';
    protected $table            = 'report_produksi_average';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['years','months','line','oee','bts','avail'];

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

    public function getFilteredData($line = null)
    {
        $builder = $this->db->table($this->table);
        $builder->select('line, oee, bts, avail');
    
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

    public function getMonthlyDataWithJoin($line, $year)
    {
        $builder = $this->db->table($this->table);
        $builder->select('report_produksi_average.years, report_produksi_average.months, report_produksi_average.line, report_produksi_average.oee, report_produksi_average.bts, report_produksi_average.avail');
        $builder->join('grafik_produksi_parameter', 'report_produksi_average.line = grafik_produksi_parameter.line AND report_produksi_average.years = grafik_produksi_parameter.years', 'inner');
        $builder->where('report_produksi_average.years', $year);

        if ($line) {
            $builder->where('report_produksi_average.line', $line);
        }

        return $builder->get()->getResultArray();
    }

}

