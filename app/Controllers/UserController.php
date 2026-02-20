<?php

namespace App\Controllers;
use App\Models\UserModel;

class UserController extends BaseController
{
    public function index()
    {
        $model = new UserModel();
        $data['users']=$model->findAll();

        return view('admin/users',$data);
    }

    public function store()
    {
        $model = new UserModel();

        $model->save([
            'username'=>$this->request->getPost('username'),
            'password'=>password_hash($this->request->getPost('password'),PASSWORD_DEFAULT),
            'nama'=>$this->request->getPost('nama'),
            'role'=>$this->request->getPost('role')
        ]);

        return redirect()->to('/admin/users');
    }

    public function delete($id)
    {
        $model = new UserModel();
        $model->delete($id);

        return redirect()->to('/admin/users');
    }
}
