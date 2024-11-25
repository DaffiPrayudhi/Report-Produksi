<?php

namespace App\Models;

use CodeIgniter\Model;

class Linesta extends Model
{
    protected $DBGroup = 'oeeManual';
    protected $table            = 'LineStation';
    protected $primaryKey       = 'id_linsta';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['Line', 'Station'];

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
    
    public function getModelsByLine($line)
    {
        return $this->select('Station as station') 
                    ->distinct()
                    ->where('Line', $line)
                    ->findAll();
    }
    
    public function getModelsByFALLine($line)
    {
        return $this->select('Station as station')  
                    ->distinct()
                    ->where('Line', $line)
                    ->findAll();
    }
    

    public function getUniqueLines()
    {
        return $this->select('Line')
                    ->distinct()
                    ->findAll();
    }

    public function getUniqueModels()
    {
        return $this->select('Station')
                    ->distinct()
                    ->findAll();
    }
}


