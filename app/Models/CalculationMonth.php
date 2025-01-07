<?php

namespace App\Models;

use CodeIgniter\Model;

class CalculationMonth extends Model
{
    protected $DBGroup = 'oeeManual';
    protected $table            = 'month_calculation';
    protected $primaryKey       = 'id_clc';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['month','year','line','oee','bts','avail','s_downtime'];

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

    public function getMonthlyDataWithJoin($line, $year)
    {
        $builder = $this->db->table($this->table);
        $builder->select('month_calculation.month, month_calculation.year, month_calculation.line, month_calculation.oee, month_calculation.bts, month_calculation.avail');
        $builder->where('month_calculation.year', $year);

        if ($line) {
            $builder->where('month_calculation.line', $line);
        }

        return $builder->get()->getResultArray();
    }

    public function getDistinctLines()
    {
        $builder = $this->db->table($this->table);
        $builder->distinct();
        $builder->select('line');
        return $builder->get()->getResultArray();
    }
    public function getMonthlyDataWithJointest($line, $year)
    {
        $builder = $this->db->table($this->table);
        $builder->select('month_calculation.month, month_calculation.year, month_calculation.line, month_calculation.oee, month_calculation.bts, month_calculation.avail');
        $builder->where('month_calculation.year', $year);

        if ($line) {
            $builder->where('month_calculation.line', $line);
        }

        return $builder->get()->getResultArray();
    }

    public function getDistinctLinestest()
    {
        $builder = $this->db->table($this->table);
        $builder->distinct();
        $builder->select('line');
        return $builder->get()->getResultArray();
    }

}

