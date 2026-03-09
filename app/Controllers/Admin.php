<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\StudentModel; // TAMBAHAN
use App\Models\LogActivityModel;

class Admin extends BaseController
{
    protected $userModel;
    protected $categoryModel;
    protected $productModel;
    protected $studentModel; // TAMBAHAN
    protected $logModel;

    public function __construct()
    {
        $this->userModel     = new UserModel();
        $this->categoryModel = new CategoryModel();
        $this->productModel  = new ProductModel();
        $this->studentModel  = new StudentModel(); // TAMBAHAN
        $this->logModel      = new LogActivityModel();
    }

    private function log($activity)
    {
        $this->logModel->save([
            'id_user'  => session()->get('id'),
            'activity' => $activity
        ]);
    }

    // ================= DASHBOARD =================

    public function index()
    {
        $data = [
            'totalUsers'    => $this->userModel->countAll(),
            'totalKategori' => $this->categoryModel->countAll(),
            'totalBahasa'   => $this->productModel->countAll(),
            'totalSiswa'    => $this->studentModel->countAll(), // 🔥 TOTAL SISWA
        ];

        return view('admin/dashboard', $data);
    }

    // ================= CATEGORY =================

    public function categories()
    {
        $data['categories'] = $this->categoryModel->findAll();
        return view('admin/categories', $data);
    }

    public function createCategory()
    {
        return view('admin/create_category');
    }

    public function storeCategory()
    {
        $this->categoryModel->save([
            'nama_kategori' => $this->request->getPost('nama_kategori'),
            'deskripsi'     => $this->request->getPost('deskripsi'),
        ]);

        $this->log('Tambah kategori');
        return redirect()->to('/admin/categories');
    }

    public function editCategory($id)
    {
        $data['category'] = $this->categoryModel->find($id);
        return view('admin/edit_category', $data);
    }

    public function updateCategory($id)
    {
        $this->categoryModel->update($id, [
            'nama_kategori' => $this->request->getPost('nama_kategori'),
            'deskripsi'     => $this->request->getPost('deskripsi'),
        ]);

        $this->log('Update kategori');
        return redirect()->to('/admin/categories');
    }

    public function deleteCategory($id)
    {
        $this->categoryModel->delete($id);
        $this->log('Hapus kategori');
        return redirect()->to('/admin/categories');
    }

    // ================= PRODUCT =================

    public function products()
    {
        $data['products'] = $this->productModel->getProductsWithCategory();
        return view('admin/products', $data);
    }

    public function createProduct()
    {
        $data['categories'] = $this->categoryModel->findAll();
        return view('admin/create_product', $data);
    }

    public function storeProduct()
    {
        $this->productModel->save([
            'id_kategori'  => $this->request->getPost('id_kategori'),
            'nama_produk'  => $this->request->getPost('nama_produk'),
            'harga_produk' => $this->request->getPost('harga_produk'),
            'jam_kursus'   => $this->request->getPost('jam_kursus'),
            'kuota'        => $this->request->getPost('kuota'),
            'status'       => $this->request->getPost('status'),
        ]);

        $this->log('Tambah produk');
        return redirect()->to('/admin/products');
    }

    public function editProduct($id)
    {
        $data['product']    = $this->productModel->find($id);
        $data['categories'] = $this->categoryModel->findAll();

        return view('admin/edit_product', $data);
    }

    public function updateProduct($id)
    {
        $this->productModel->update($id, [
            'id_kategori'  => $this->request->getPost('id_kategori'),
            'nama_produk'  => $this->request->getPost('nama_produk'),
            'harga_produk' => $this->request->getPost('harga_produk'),
            'jam_kursus'   => $this->request->getPost('jam_kursus'),
            'kuota'        => $this->request->getPost('kuota'),
            'status'       => $this->request->getPost('status'),
        ]);

        $this->log('Update produk');
        return redirect()->to('/admin/products');
    }

    public function deleteProduct($id)
    {
        $this->productModel->delete($id);
        $this->log('Hapus produk');
        return redirect()->to('/admin/products');
    }

// ================= USERS =================

public function users()
{
    $data['users'] = $this->userModel->findAll();
    return view('admin/users', $data);
}

public function createUser()
{
    return view('admin/create_user');
}

public function storeUser()
{
    $this->userModel->save([
        'nama'     => $this->request->getPost('nama'),
        'username' => $this->request->getPost('username'),

        // TAMBAHAN PASSWORD
        'password' => password_hash(
            $this->request->getPost('password'),
            PASSWORD_DEFAULT
        ),

        'role'   => $this->request->getPost('role'),
        'status' => $this->request->getPost('status'),
    ]);

    $this->log('Tambah user');
    return redirect()->to('/admin/users');
}

public function editUser($id)
{
    $data['user'] = $this->userModel->find($id);
    return view('admin/edit_user', $data);
}

public function updateUser($id)
{
    $update = [
        'nama'     => $this->request->getPost('nama'),
        'username' => $this->request->getPost('username'),
        'role'     => $this->request->getPost('role'),
        'status'   => $this->request->getPost('status'),
    ];

    if ($this->request->getPost('password')) {
        $update['password'] = password_hash(
            $this->request->getPost('password'),
            PASSWORD_DEFAULT
        );
    }

    $this->userModel->update($id, $update);

    $this->log('Update user');
    return redirect()->to('/admin/users');
}

public function deleteUser($id)
{
    $this->userModel->delete($id);
    $this->log('Hapus user');
    return redirect()->to('/admin/users');
}
}
