<?php

namespace App\Models;

use CodeIgniter\Model;

class ParentsModel extends Model
{
    protected $table            = 'parents';
    protected $primaryKey       = 'id_parents';
    protected $protectFields    = true;
    protected $allowedFields    = ['title', 'description', 'id_category', 'icon'];
}
