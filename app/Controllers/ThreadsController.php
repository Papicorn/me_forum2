<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SubparentsModel;
use App\Models\CategoryModel;
use App\Models\ParentsModel;
use App\Models\ThreadsModel;
use App\Models\UserModels;
use DateTime;
use IntlDateFormatter;

class ThreadsController extends BaseController
{
    public function index($id_subparents, $id_threads, $title)
    {
        $subparentsModel = new SubparentsModel();
        $subparent = $subparentsModel->find($id_subparents);
        $id_parent = $subparent['id_parents'];

        $threadsModel = new ThreadsModel();
        $threads = $threadsModel->find($id_threads);
        $id_userOwn = $threads['id_user'];

        $parentModel = new ParentsModel();
        $parent = $parentModel->find($id_parent);
        $id_category = $parent['id_category'];

        $categoryModel = new CategoryModel();
        $category = $categoryModel->find($id_category);

        $userModel = new UserModels();
        $user = $userModel->getUserByUsername(session()->get('username'));
        $ownerThreads = $userModel->find($id_userOwn);

        $dateString = '2024-04-09 04:59:22';
        $date = new DateTime($dateString);

        // Create an IntlDateFormatter instance
        $fmt = new IntlDateFormatter(
            'id_ID',
            IntlDateFormatter::FULL,
            IntlDateFormatter::NONE,
            'Asia/Jakarta', // Timezone
            IntlDateFormatter::GREGORIAN,
            'd MMMM yyyy HH:mm' // Format
        );

        // Format the date
        $formattedDate = $fmt->format($date);

        if($id_threads &&  url_title($threads['title'], '-', true) == $title) {
            $data['parents'] = $parent;
            $data['subparents'] = $subparent;
            $data['category'] = $category;
            $data['threads'] = $threads;
            $data['user'] = $user;
            $data['created_at'] = $fmt->format($date);
            $data['ownerThreads'] = $ownerThreads;
            return view('forum/threads', $data);
        } else {
            return view('error/html/error_404');
        }
    }
    public function createThreads($id_subparents, $id_user)
    {
        $validationRules = [
            'title' => 'required|max_length[50]',
            'content' => 'required'
        ];
        $validationMessage = [
            'title' => [
                'required' => 'Field title tidak boleh kosong!',
                'max_length' => 'Maximal character title adalah 50'
            ],
            'content' => [
                'required' => 'Field content tidak boleh kosong!'
            ]
        ];

        if(!$this->validate($validationRules, $validationMessage)) {
            $error = $this->validator->getErrors();
            return redirect()->back()->with('error', $error);
        };

        $threadsModel = new ThreadsModel();

        $title = $this->request->getPost('title');        
        $content = $this->request->getPost('content');        
        $privacy = $this->request->getPost('privacy');        

        $data = [
            'title' => $title,
            'content' => $content,
            'privacy' => $privacy,
            'id_user' => $id_user,
            'id_subparents' => $id_subparents
        ];

        if($threadsModel->insert($data)) {
            $alert = [
                'pesan' => 'Threads berhasil dibuat!',
                'alert' => 'success'
            ];
            $threads = $threadsModel->getThreadsAfterCreate($title);
            $id_threads = $threads['id_threads'];

            return redirect()->to(base_url(route_to('threads', $id_subparents, $id_threads, url_title($title, '-', true))))->with('alert', $alert);
        } else {
            $alert = [
                'pesan' => 'Threads gagal dibuat!',
                'alert' => 'danger'
            ];
            return redirect()->back()->with('alert', $alert);
        };
    }
    public function editThreads($id_threads)
    {
        $validationRules = [
            'title' => 'required|max_length[50]',
            'content' => 'required'
        ];
        $validationMessage = [
            'title' => [
                'required' => 'Field title tidak boleh kosong!',
                'max_length' => 'Maximal character title adalah 50'
            ],
            'content' => [
                'required' => 'Field content tidak boleh kosong!'
            ]
        ];

        if(!$this->validate($validationRules, $validationMessage)) {
            $error = $this->validator->getErrors();
            return redirect()->back()->with('error', $error);
        };

        $threadsModel = new ThreadsModel();

        $title = $this->request->getPost('title');        
        $content = $this->request->getPost('content');        
        $privacy = $this->request->getPost('privacy');        

        $data = [
            'id_threads' => $id_threads,
            'title' => $title,
            'content' => $content,
            'privacy' => $privacy
        ];

        if($threadsModel->save($data)) {
            $alert = [
                'pesan' => 'Threads berhasil diubah!',
                'alert' => 'success'
            ];
            $threads = $threadsModel->getThreadsAfterCreate($title);
            $id_subparents = $threads['id_subparents'];
            $id_threads = $threads['id_threads'];

            return redirect()->to(base_url(route_to('threads', $id_subparents, $id_threads, url_title($title, '-', true))))->with('alert', $alert);
        } else {
            $alert = [
                'pesan' => 'Threads gagal diubah!',
                'alert' => 'danger'
            ];
            return redirect()->back()->with('alert', $alert);
        };
    }
    public function deleteThreads($id_threads)
    {
        $threadsModel = new threadsModel();
        if($id_threads !== NULL && $threadsModel->find($id_threads)) {
            $threads = $threadsModel->find($id_threads);
            $id_subparents = $threads['id_subparents'];

            $subparentsModel = new SubparentsModel();
            $subparents = $subparentsModel->find($id_subparents);
            $id_parents = $subparents['id_parents'];

            if($threadsModel->delete($id_threads)) {
                $alert = [
                    'pesan' => 'Threads berhasil dihapus!',
                    'alert' => 'success'
                ];
                return redirect()->to(base_url(route_to('subparents', $id_parents, $id_subparents, url_title($subparents['title'], '-', true))))->with('alert', $alert);
            } else {
                $alert = [
                    'pesan' => 'Threads gagal dihapus!',
                    'alert' => 'success'
                ];
                return redirect()->back()->with('alert', $alert);
            };
        };
    }
}


