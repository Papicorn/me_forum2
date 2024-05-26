<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SubparentsModel;
use App\Models\ParentsModel;
use App\Models\CategoryModel;
use App\Models\ThreadsModel;
use App\Models\UserModels;

class SubparentsController extends BaseController
{
    public function index($id_parents, $id_subparents, $title)
    {
        $subparentsModel = new SubparentsModel();
        $subparent = $subparentsModel->find($id_subparents);

        $parentsModel = new ParentsModel();
        $parent = $parentsModel->find($id_parents);
        $getCategory = $parent['id_category'];

        $categoryModel = new CategoryModel();
        $category = $categoryModel->find($getCategory);

        $threadsModel = new ThreadsModel();
        $threads = $threadsModel->getJoinUser($id_subparents);

        $userModel = new UserModels();
        $username = session()->get('username');
        $user = $userModel->getUserByUsername($username);

        if ($id_subparents && url_title($subparent['title'], '-', true) == $title) {
            $data['subparents'] = $subparent;
            $data['parent'] = $parent;
            $data['category'] = $category;
            $data['threads'] = $threads;
            $data['user'] = $user;
            return view('forum/subparents', $data);
        } else {
            return "hai";
        }
    }
    public function createSubparents($id_parents)
    {
        $validationRules = [
            'title' => 'required|max_length[50]',
            'description' => 'max_length[100]'
        ];
        $validationMessage = [
            'title' => [
                'required' => 'Field title tidak boleh kosong!',
                'max_Length' => 'Maximal character title adalah 50'
            ],
            'description' => [
                'max_length' => 'Maximal character description adalah 100'
            ]
        ];

        if(!$this->validate($validationRules, $validationMessage)) {
            $error = $this->validator->getErrors();
            return redirect()->back()->with('error', $error);
        };

        $subparentsModel = new SubparentsModel();

        $title = $this->request->getPost('title');
        $description = $this->request->getPost('description');
        $icon = $this->request->getPost('icon');

        $data = [
            'title' => $title,
            'description' => $description,
            'icon' => $icon,
            'id_parents' => $id_parents
        ];

        if($subparentsModel->insert($data)) {
            $alert = [
                'pesan' => 'Subparent berhasil ditambahkan',
                'alert' => 'success'
            ];
            return redirect()->back()->with('alert', $alert);
        } else {
            $alert = [
                'pesan' => 'Subparent gagal ditambahkan',
                'alert' => 'danger'
            ];
            return redirect()->back()->with('alert', $alert);
        };
    }
    public function deleteSubparents($id_subparents)
    {
        $subparentsModel = new SubparentsModel();
        if($id_subparents !== NULL && $subparentsModel->find($id_subparents)) {
            $subparent = $subparentsModel->find($id_subparents);
            $id_parents = $subparent['id_parents'];

            $parentsModel = new ParentsModel();
            $parents = $parentsModel->find($id_parents);
            $title = url_title($parents['title'], '-', true);

            if($subparentsModel->delete($id_subparents)) {
                $alert = [
                    'pesan' => 'Subparent berhasil dihapus!',
                    'alert' => 'success'
                ];
                return redirect()->to(base_url(route_to('parents', $id_parents, $title)));
            } else {
                $alert = [
                    'pesan' => 'Subparents gagal dihapus!',
                    'alert' => 'danger'
                ];
                return redirect()->to(base_url(route_to('home')))->with('alert', $alert);
            };
        } else {
            $alert = [
                'pesan' => 'Subparents tidak dipilih atau tidak ada!',
                'alert' => 'danger'
            ];
            return redirect()->to(base_url(route_to('home')))->with('alert', $alert);
        };
    }
    public function editSubparents($id_subparents)
    {
        $validationRules = [
            'title' => 'required|max_length[50]',
            'description' => 'max_length[100]'
        ];
        $validationMessage = [
            'title' => [
                'required' => 'Field title tidak boleh kosong!',
                'max_Length' => 'Maximal character title adalah 50'
            ],
            'description' => [
                'max_length' => 'Maximal character description adalah 100'
            ]
        ];

        if(!$this->validate($validationRules, $validationMessage)) {
            $error = $this->validator->getErrors();
            return redirect()->back()->with('error', $error);
        };

        $subparentsModel = new SubparentsModel();

        $title = $this->request->getPost('title');
        $description = $this->request->getPost('description');
        $icon = $this->request->getPost('icon');

        $data = [
            'title' => $title,
            'description' => $description,
            'icon' => $icon,
            'id_subparents' => $id_subparents
        ];

        if($subparentsModel->save($data)) {
            $alert = [
                'pesan' => 'Subparent berhasil diubah!',
                'alert' => 'success'
            ];
            return redirect()->back()->with('alert', $alert);
        } else {
            $alert = [
                'pesan' => 'Subparent gagal diubah!',
                'alert' => 'danger'
            ];
            return redirect()->back()->with('alert', $alert);
        };
    }
}
