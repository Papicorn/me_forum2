<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use CodeIgniter\HTTP\ResponseInterface;

class CategoryController extends BaseController
{
    protected $categoryModel;
    protected $id_category;
    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }
    public function index()
    {
        //
    }
    public function createCategory()
    {
        $validationRules = [
            'title' => 'required|max_length[50]'
        ];
        $validationMessage = [
            'title' => [
                'required' => 'Kolom title tidak boleh kosong!',
                'max_length' => 'Maximal character title adalah 50'
            ]
        ];

        if(!$this->validate($validationRules, $validationMessage)) {
            $error = $this->validator->getErrors();
            return redirect()->to(base_url(route_to('home')))->with('error', $error);
        }

        $category = $this->request->getPost('title');
        
        $data = [
            'category' => $category
        ];

        if($this->categoryModel->insert($data)) {
            $alert = [
                'pesan' => 'Category berhasil ditambahkan!',
                'alert' => 'success'
            ];
            return redirect()->to(base_url(route_to('home')))->with('alert', $alert);
        } else {
            $alert = [
                'pesan' => 'Category gagal ditambahkan!',
                'alert' => 'danger'
            ];
            return redirect()->to(base_url(route_to('home')))->with('alert', $alert);
        };
    }
    public function deleteCategory($id_category)
    {
        if($id_category !== NULL && $this->categoryModel->find($id_category)) {
            if($this->categoryModel->delete($id_category)) {
                $alert = [
                    'pesan' => 'Category berhasil terhapus!',
                    'alert' => 'success'
                ];
                return redirect()->to(base_url(route_to('home')))->with('alert', $alert);
            } else {
                $alert = [
                    'pesan' => 'Category gagal terhapus!',
                    'alert' => 'danger'
                ];
                return redirect()->to(base_url(route_to('home')))->with('alert', $alert);
            };
        } else {
            $alert = [
                'pesan' => 'Category tidak terpilih atau tidak ada!',
                'alert' => 'danger'
            ];
            return redirect()->to(base_url(route_to('home')))->with('alert', $alert);
        };
    }
    public function editCategory($id_category)
    {
        $validationRules = [
            'title' => 'required|max_length[50]'
        ];
        $validationMessage = [
            'title' => [
                'required' => 'Kolom title tidak boleh kosong!',
                'max_length' => 'Maximal character title adalah 50'
            ]
        ];

        if(!$this->validate($validationRules, $validationMessage)) {
            $error = $this->validator->getErrors();
            return redirect()->back()->with('error', $error);
        };

        $title = $this->request->getPost('title');

        $data = [
            'id_category' => $id_category,
            'category' => $title
        ];

        if($this->categoryModel->save($data)) {
            $alert = [
                'pesan' => 'Category berhasil diubah!',
                'alert' => 'success'
            ];
            return redirect()->back()->with('alert', $alert);
        } else {
            $alert = [
                'pesan' => 'Category gagal diubah!',
                'alert' => 'danger'
            ];
            return redirect()->back()->with('alert', $alert);
        };
    }
}
