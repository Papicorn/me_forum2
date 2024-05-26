<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModels;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ParentsModel;
use App\Models\CategoryModel;
use App\Models\SubparentsModel;
use App\Models\ThreadsModel;
use App\Models\UserModel;

class HalamanUtama extends BaseController
{
    public function index()
    {
        helper('url');
        // GET SESSION
        $username = session()->get('username');

        $getParents = new ParentsModel();
        $data['parent'] = $getParents->findAll();

        $getCategory = new CategoryModel();
        $data['category'] = $getCategory->findAll();

        $getSubparents = new SubparentsModel();
        $data['subparents'] = $getSubparents->findAll();

        $getThreads = new ThreadsModel();
        $data['threads'] = $getThreads->findAll();

        $getUser = new UserModels();
        $data['user'] = $getUser->getUserByUsername($username);

        foreach ($data['parent'] as &$parents) {
            $parents['total_thread'] = 0;

            foreach ($data['subparents'] as &$subparent) {
                if ($subparent['id_parents'] == $parents['id_parents']) {
                    $subparent['total_thread'] = $getThreads->countThreadsBySubparent($subparent['id_subparents']);
                    $parents['total_thread'] += $subparent['total_thread'];
                }
            }
        }

        return view('utama/utama', $data);
    }


    public function redirect()
    {
        return redirect()->to(base_url('/home'));
    }
    
}
