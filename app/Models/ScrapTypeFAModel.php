<?php 

namespace App\Models;

use CodeIgniter\Model;

class ScrapTypeFAModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'scraptype_fa';
    protected $primaryKey = 'id_panel';

    protected $returnType = 'array';

    protected $allowedFields = ['id_panel', 'scraptype',];

    public function getScrapType()
    {
        return $this->select('scraptype')
                    ->findAll();
    }

    
}