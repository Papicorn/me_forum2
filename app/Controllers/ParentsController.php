<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ParentsModel;
use App\Models\SubparentsModel;
use App\Models\CategoryModel;
use App\Models\ThreadsModel;
use App\Models\UserModels;

class ParentsController extends BaseController
{
    public function index($id_parents, $title)
    {
        $parentsModel = new ParentsModel();
        $parent = $parentsModel->find($id_parents);
        $getCategory = $parent['id_category'];

        $categoryModel = new CategoryModel();
        $category = $categoryModel->find($getCategory);

        $subparentsModel = new SubparentsModel();
        $subparents = $subparentsModel->findAll();

        $threadsModel = new ThreadsModel();
        $thread = $threadsModel->findAll();

        $userModel = new UserModels();
        $username = session()->get('username');
        $user = $userModel->getUserByUsername($username);

        $rowssubparent = $subparentsModel->where('id_parents', $id_parents)->countAllResults();
        $countthreads = $threadsModel->where('id_subparents', $id_parents)->countAllResults();

        if ($id_parents && url_title($parent['title'], '-', true) == $title) {
            $data['parent'] = $parent;
            $data['subparents'] = $subparents;
            $data['row_subparents'] = $rowssubparent;
            $data['category'] = $category;
            $data['user'] = $user;

            foreach ($data['subparents'] as &$subparent) {
                // Hitung jumlah threads untuk subparent saat ini
                $subparent['thread_count'] = $threadsModel->countThreadsBySubparent($subparent['id_subparents']);
            }

            return view('forum/parents', $data);
        } else {
            $data['message'] = 'Parents not found, please check again!';
            return view('errors\html\error_404', $data);
        }
    }
    public function createParents()
    {
        $validationRules = [
            'title' => 'required|max_length[50]',
            'description' => 'max_length[100]',
            'id_category' => 'required'
        ];
        $validationMessage = [
            'title' => [
                'required' => 'Field title tidak boleh kosong!',
                'max_length' => 'Maximal character dari title adalah 50!'
            ],
            'description' => [
                'max_length' => 'Maximal character dari description adalah 100!'
            ],
            'id_category' => [
                'required' => 'Field category tidak boleh kosong!'
            ]
        ];

        if(!$this->validate($validationRules, $validationMessage)){
            $error = $this->validator->getErrors();
            return redirect()->to(base_url(route_to('home')))->with('error', $error);
        };

        $parentsModel = new ParentsModel();

        $title = $this->request->getPost('title');
        $description = $this->request->getPost('description');
        $id_category = $this->request->getPost('id_category');
        $icon = $this->request->getPost('icon');

        $data = [
            'title' => $title,
            'description' => $description,
            'id_category' => $id_category,
            'icon' => $icon
        ];
        if($parentsModel->insert($data)){
            $alert = [
                'pesan' => 'Parent berhasil ditambahkan!',
                'alert' => 'success'
            ];
            return redirect()->to(base_url(route_to('home')))->with('alert', $alert);
        } else {
            $alert = [
                'pesan' => 'Parent gagal ditambahkan!',
                'alert' => 'danger'
            ];
            return redirect()->to(base_url(route_to('home')))->with('alert', $alert);
        };
    }
    public function deleteParents($id_parents)
    {
        $parentsModel = new ParentsModel();
        if($id_parents !== NULL && $parentsModel->find($id_parents)) {
            if($parentsModel->delete($id_parents)) {
                $alert = [
                    'pesan' => 'Parents berhasil dihapus!',
                    'alert' => 'success'
                ];
                return redirect()->to(base_url(route_to('home')))->with('alert', $alert);
            } else {
                $alert = [
                    'pesan' => 'Parents gagal dihapus!',
                    'alert' => 'danger'
                ];
                return redirect()->to(base_url(route_to('home')))->with('alert', $alert);
            };
        } else {
            $alert = [
                'pesan' => 'Parents tidak dipilih atau tidak ada!',
                'alert' => 'danger'
            ];
            return redirect()->to(base_url(route_to('home')))->with('alert', $alert);
        };
    }
    public function editParents($id_parents)
    {
        $validationRules = [
            'title' => 'required|max_length[50]',
            'description' => 'max_length[100]',
            'id_category' => 'required'
        ];
        $validationMessage = [
            'title' => [
                'required' => 'Field title tidak boleh kosong!',
                'max_length' => 'Maximal character dari title adalah 50!'
            ],
            'description' => [
                'max_length' => 'Maximal character dari description adalah 100!'
            ],
            'id_category' => [
                'required' => 'Field category tidak boleh kosong!'
            ]
        ];

        if(!$this->validate($validationRules, $validationMessage)){
            $error = $this->validator->getErrors();
            return redirect()->to(base_url(route_to('home')))->with('error', $error);
        };

        $parentsModel = new ParentsModel();

        $title = $this->request->getPost('title');
        $description = $this->request->getPost('description');
        $id_category = $this->request->getPost('id_category');
        $icon = $this->request->getPost('icon');

        $data = [
            'id_parents' => $id_parents,
            'title' => $title,
            'description' => $description,
            'id_category' => $id_category,
            'icon' => $icon
        ];
        if($parentsModel->save($data)){
            $alert = [
                'pesan' => 'Parent berhasil ditambahkan!',
                'alert' => 'success'
            ];
            return redirect()->back()->with('alert', $alert);
        } else {
            $alert = [
                'pesan' => 'Parent gagal ditambahkan!',
                'alert' => 'danger'
            ];
            return redirect()->back()->with('alert', $alert);
        };
    }
}
