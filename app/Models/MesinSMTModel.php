<?php 

namespace App\Models;

use CodeIgniter\Model;

class MesinSMTModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'mesin_smt';
    protected $primaryKey = 'id_mesin';

    protected $returnType = 'array';

    protected $allowedFields = ['id_mesin', 'kategori', 'tipe_ng',];

    public function getKategori()
{
    return $this->select('kategori')
                ->groupBy('kategori')
                ->findAll();
}




    



}