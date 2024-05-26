<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table            = 'category';
    protected $primaryKey       = 'id_category';
    protected $protectFields    = true;
    protected $allowedFields    = ['id_category', 'category'];
}
