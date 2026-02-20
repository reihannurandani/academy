<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    /*
    =====================================
    TAMPILKAN HALAMAN LOGIN
    =====================================
    */
    public function login()
    {
        // Jika sudah login, langsung arahkan sesuai role
        if (session()->get('logged_in')) {
            return $this->redirectByRole(session()->get('role'));
        }

        return view('login');
    }

    /*
    =====================================
    PROSES LOGIN
    =====================================
    */
    public function prosesLogin()
    {
        $session = session();
        $model   = new UserModel();

        $username = trim($this->request->getPost('username'));
        $password = trim($this->request->getPost('password'));

        // Validasi input
        if (empty($username) || empty($password)) {
            return redirect()->back()->with('error', 'Username dan Password wajib diisi!');
        }

        // Cari user aktif berdasarkan username
        $user = $model->where('username', $username)
                      ->where('status', 'aktif')
                      ->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan atau tidak aktif!');
        }

        // Verifikasi password
        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Password salah!');
        }

        // Set session login
        $session->set([
            'id'        => $user['id'],
            'username'  => $user['username'],
            'nama'      => $user['nama'],
            'role'      => $user['role'],
            'logged_in' => true
        ]);

        // Redirect sesuai role
        return $this->redirectByRole($user['role']);
    }

    /*
    =====================================
    REDIRECT BERDASARKAN ROLE
    =====================================
    */
    private function redirectByRole($role)
    {
        switch ($role) {
            case 'admin':
                return redirect()->to('/admin/dashboard');

            case 'kasir':
                return redirect()->to('/kasir/dashboard');

            case 'owner':
                return redirect()->to('/owner/dashboard');

            default:
                session()->destroy();
                return redirect()->to('/login')
                       ->with('error', 'Role tidak dikenali!');
        }
    }

    /*
    =====================================
    LOGOUT
    =====================================
    */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    /*
    =====================================
    RESET PASSWORD ADMIN (OPSIONAL)
    AKSES: /reset-admin
    =====================================
    */
    public function resetAdmin()
    {
        $model = new UserModel();

        $model->update(1, [
            'password' => password_hash('admin123', PASSWORD_DEFAULT)
        ]);

        return "Password admin berhasil direset ke: admin123";
    }
}
