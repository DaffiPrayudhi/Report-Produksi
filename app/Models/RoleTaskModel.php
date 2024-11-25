<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleTaskModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'tbl_roles_scrap_control';
    protected $primaryKey = 'roleId';

    protected $returnType = 'array';

    protected $allowedFields = [
        'roleId', 'role', 'status', 'isDeleted', 'createdBy', 'createdDtm', 'updatedBy', 'updatedDtm'
    ];

}
