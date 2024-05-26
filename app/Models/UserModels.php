<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModels extends Model
{
    protected $table            = 'user';
    protected $primaryKey       = 'id_user';
    protected $protectFields    = true;
    protected $allowedFields      = ['username', 'full_name', 'password', 'email'];

    public function getUserByUsername($username)
    {
        $data = $this->db->table($this->table)
        ->where('username', $username)
        ->get()
        ->getRowArray();

        return $data;
    }
}
