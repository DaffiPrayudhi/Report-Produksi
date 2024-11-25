<?php 

namespace App\Models;

use CodeIgniter\Model;

class MesinFAModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'mesin_fa';
    protected $primaryKey = 'id_mesin';

    protected $returnType = 'array';

    protected $allowedFields = ['id_mesin', 'line','model','komponen', 'tipe_ng'];

    public function getTipeNgByKomponen($komponen)
    {
        return $this->select('tipe_ng')
                    ->distinct()
                    ->where('komponen', $komponen)
                    ->findAll();
    }

    public function getPartNumbersByModelAndLine($model, $line)
    {
        return $this->select('komponen')
                    ->distinct()
                    ->where('model', $model)
                    ->where('line', $line)
                    ->where('komponen IS NOT NULL')
                    ->findAll();
    }

    public function getKategori()
    {
        return $this->select('komponen')
                    ->distinct()
                    ->findAll();
    }

    public function getModelsByLine($line)
    {
        return $this->select('model')
                    ->distinct()
                    ->where('line', $line)
                    ->where('model IS NOT NULL')
                    ->findAll();
    }
    
    public function getKomponenByModel($model)
    {
        return $this->select('komponen')
                    ->distinct()
                    ->where('model', $model)
                    ->findAll();
    }

    public function getUniqueModels()
    {
        return $this->select('model')
                    ->distinct()
                    ->findAll();
    }
}