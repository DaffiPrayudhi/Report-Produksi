<?php 

namespace App\Models;

use CodeIgniter\Model;

class PartNumberKompModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'part_number_komponen';
    protected $primaryKey = 'id_part_komponen';

    protected $returnType = 'array';

    protected $allowedFields = ['id_part_komponen','komponen', 'part_number'];
    protected $useAutoIncrement = true;


}
