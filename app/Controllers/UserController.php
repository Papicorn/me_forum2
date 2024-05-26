<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModels;

class UserController extends BaseController
{
    public function index()
    {
        if(session()->get('is_logged_in') == true){
            return redirect()->to(base_url(route_to('home')));
        } else {
            return view('auth/login');
        }
    }
    public function halRegister()
    {
        if(session()->get('is_logged_in') == true){
            return redirect()->to(base_url(route_to('home')));
        } else {
            return view('auth/register');
        }
    }
    public function register()
    {
        $validationRules = [
            'fullname' => 'required|max_length[50]|min_length[3]',
            'username' => 'required|min_length[3]|max_length[20]|is_unique[user.username]|alpha_numeric',
            'email' => 'required|is_unique[user.email]|valid_email|max_length[50]',
            'password' => 'required|min_length[6]'
        ];

        if(!$this->validate($validationRules)) {
            $error = $this->validator->getErrors();
            return redirect()->back()->with('error', $error);
        }

        $userModel = new UserModels();

        $fullname = $this->request->getPost('fullname');
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $data = [
            'full_name' => $fullname,
            'username' => $username,
            'email' => $email,
            'password' => $passwordHash
        ];

        if($userModel->insert($data)) {
            $alert = [
                'pesan' => 'Akun anda berhasil di daftarkan, silahkan login!',
                'alert' => 'success'
            ];
            return redirect()->to(base_url(route_to('login')))->with('alert', $alert);
        } else {
            $alert = [
                'pesan' => 'Akun anda gagal di daftarkan, silahkan coba lagi!',
                'alert' => 'danger'
            ];
            return redirect()->to(base_url(route_to('register')))->with('alert', $alert);
        }
    }
    public function login()
    {
        $validationRules = [
            'username' => 'required',
            'password' => 'required|min_length[6]'
        ];
        $validatationMessage = [
            'username' => [
                'required' => 'Username tidak boleh kosong'
            ],
            'password' => [
                'required' => 'Password tidak boleh kosong',
                'min_length' => 'Minimal character password adalah 6'
            ]
        ];

        if(!$this->validate($validationRules, $validatationMessage)) {
            $error = $this->validator->getErrors();
            return redirect()->to(base_url(route_to('masuk')))->with('error', $error);
        };

        $muser = new UserModels();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $checking = $muser->getUserByUsername($username);

        if($checking && password_verify($password, $checking['password'])){
            $sessionLogin = [
                'username' => $checking['username'],
                'is_logged_in' => true
            ];
            $alert = [
                'pesan' => 'Selamat datang '. $checking['full_name'] . '!',
                'alert' => 'success'
            ];

            session()->set($sessionLogin);
            session()->regenerate();

            return redirect()->to(base_url('/home'))->with('alert', $alert);
        } else {
            $error = [
                'Kata sandi dan username tidak cocok!'
            ] ;
            return redirect()->to(base_url(route_to('masuk')))->with('error', $error);
        }
    }
    public function logout()
    {
        session()->destroy();

        return redirect()->to(base_url(route_to('home')));
    }
}
