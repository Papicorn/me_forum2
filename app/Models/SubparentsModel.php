<?php

namespace App\Models;

use CodeIgniter\Model;

class SubparentsModel extends Model
{
    protected $table            = 'subparents';
    protected $primaryKey       = 'id_subparents';
    protected $protectFields    = true;
    protected $allowedFields    = ['title', 'description', 'id_parents', 'icon'];
}
