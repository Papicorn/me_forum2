<?php

namespace App\Models;

use CodeIgniter\Model;

class ThreadsModel extends Model
{
    protected $table            = 'threads';
    protected $primaryKey       = 'id_threads';
    protected $protectFields    = true;
    protected $allowedFields    = ['title', 'content', 'privacy', 'id_user', 'id_subparents'];
    
    public function countThreadsBySubparent($subparentId)
    {
        return $this->where('id_subparents', $subparentId)->countAllResults();
    }

    public function countThreadsByParent($subparentId)
    {
        return 0;
    }
    public function getThreadsAfterCreate($title)
    {
        $data = $this->db->table($this->table)
                        ->where('title', $title)
                        ->orderBy('id_threads', 'DESC')
                        ->get()
                        ->getRowArray();

        return $data;
    }
    public function getJoinUser($id_subparent)
    {
        $data = $this->db->table($this->table)
                     ->select('threads.*, user.username')
                     ->join('user', 'user.id_user = threads.id_user')
                     ->get()
                     ->getResultArray();

        return $data;
    }
}
