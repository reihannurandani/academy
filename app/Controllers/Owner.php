<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\TransactionModel;
use App\Models\LogActivityModel;
use App\Models\StudentModel;
use App\Models\UserModel;
use Dompdf\Dompdf;

class Owner extends BaseController
{
    protected $productModel;
    protected $transactionModel;
    protected $logModel;
    protected $studentModel;
    protected $userModel;

    public function __construct()
    {
        $this->productModel     = new ProductModel();
        $this->transactionModel = new TransactionModel();
        $this->logModel         = new LogActivityModel();
        $this->studentModel     = new StudentModel();
        $this->userModel        = new UserModel();
    }

    // =============================
    // DASHBOARD
    // =============================
    public function index()
    {
        $db = \Config\Database::connect();

        $totalPendapatan = $db->table('transactions')
            ->selectSum('total_harga')
            ->get()
            ->getRow()
            ->total_harga ?? 0;

        $pendapatanHariIni = $db->table('transactions')
            ->selectSum('total_harga')
            ->where('DATE(created_at)', date('Y-m-d'))
            ->get()
            ->getRow()
            ->total_harga ?? 0;

        $totalUser  = $this->userModel->countAll();
        $totalSiswa = $this->studentModel->countAll();

        $students = $db->table('students')
            ->select('students.*, products.nama_produk as kursus, categories.nama_kategori as kategori')
            ->join('products', 'products.id = students.id_kursus', 'left')
            ->join('categories', 'categories.id = students.id_kategori', 'left')
            ->orderBy('students.id', 'DESC')
            ->get()
            ->getResultArray();

        return view('owner/dashboard', [
            'totalPendapatan'   => $totalPendapatan,
            'pendapatanHariIni' => $pendapatanHariIni,
            'totalUser'         => $totalUser,
            'totalSiswa'        => $totalSiswa,
            'students'          => $students
        ]);
    }

    // =============================
    // UPDATE STATUS SISWA
    // =============================
    public function updateStatus($id)
    {
        $status = $this->request->getPost('status');

        $this->studentModel->update($id, [
            'status' => $status
        ]);

        return redirect()->back()->with('success', 'Status berhasil diubah');
    }

    // =============================
    // LAPORAN
    // =============================
    public function laporan()
    {
        $db = \Config\Database::connect();

        $hariIni  = date('Y-m-d');
        $bulanIni = date('Y-m');

        $pendapatanHariIni = $db->table('transactions')
            ->selectSum('total_harga')
            ->where('DATE(created_at)', $hariIni)
            ->get()
            ->getRow()
            ->total_harga ?? 0;

        $pendapatanBulanIni = $db->table('transactions')
            ->selectSum('total_harga')
            ->where("DATE_FORMAT(created_at,'%Y-%m') =", $bulanIni)
            ->get()
            ->getRow()
            ->total_harga ?? 0;

        $totalPendapatan = $db->table('transactions')
            ->selectSum('total_harga')
            ->get()
            ->getRow()
            ->total_harga ?? 0;

        $totalTransaksi = $db->table('transactions')
            ->countAllResults();

        $transactions = $db->table('transactions')
            ->select('invoice, total_harga, created_at')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResultArray();

        return view('owner/laporan', [
            'pendapatanHariIni'  => $pendapatanHariIni,
            'pendapatanBulanIni' => $pendapatanBulanIni,
            'totalPendapatan'    => $totalPendapatan,
            'totalTransaksi'     => $totalTransaksi,
            'transactions'       => $transactions
        ]);
    }

    // =============================
    // CETAK PDF
    // =============================
public function cetakPdf()
{
    $db = \Config\Database::connect();

    $hariIni  = date('Y-m-d');
    $bulanIni = date('Y-m');

    // ================= RINGKASAN =================
    $pendapatanHariIni = $db->table('transactions')
        ->selectSum('total_harga')
        ->where('DATE(created_at)', $hariIni)
        ->get()
        ->getRow()
        ->total_harga ?? 0;

    $pendapatanBulanIni = $db->table('transactions')
        ->selectSum('total_harga')
        ->where("DATE_FORMAT(created_at,'%Y-%m') =", $bulanIni)
        ->get()
        ->getRow()
        ->total_harga ?? 0;

    $totalPendapatan = $db->table('transactions')
        ->selectSum('total_harga')
        ->get()
        ->getRow()
        ->total_harga ?? 0;

    $totalTransaksi = $db->table('transactions')
        ->countAllResults();

    // ================= DATA TRANSAKSI =================
    $transactions = $db->table('transactions')
        ->select('invoice, total_harga, created_at')
        ->orderBy('created_at', 'DESC')
        ->get()
        ->getResultArray();

    $html = view('owner/laporan_pdf', [
        'transactions'        => $transactions,
        'pendapatanHariIni'   => $pendapatanHariIni,
        'pendapatanBulanIni'  => $pendapatanBulanIni,
        'totalPendapatan'     => $totalPendapatan,
        'totalTransaksi'      => $totalTransaksi
    ]);

    $dompdf = new \Dompdf\Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    return $this->response
        ->setHeader('Content-Type', 'application/pdf')
        ->setHeader('Content-Disposition', 'attachment; filename="laporan-keuangan.pdf"')
        ->setBody($dompdf->output());
}
    // =============================
    // LOG ACTIVITY
    // =============================
    public function logActivity()
    {
        $data['logs'] = $this->logModel
            ->select('log_activity.*, users.nama')
            ->join('users', 'users.id = log_activity.id_user')
            ->findAll();

        return view('owner/log', $data);
    }
}