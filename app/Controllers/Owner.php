<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\TransactionModel;
use App\Models\LogActivityModel;
use App\Models\StudentModel;
use App\Models\UserModel;

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

        $todayStart = date('Y-m-d 00:00:00');
        $todayEnd   = date('Y-m-d 23:59:59');

        // TOTAL PENDAPATAN
        $totalPendapatan = $db->table('transactions')
            ->selectSum('total_harga')
            ->get()
            ->getRow()
            ->total_harga ?? 0;

        // PENDAPATAN HARI INI
        $pendapatanHariIni = $db->table('transactions')
            ->selectSum('total_harga')
            ->where('created_at >=', $todayStart)
            ->where('created_at <=', $todayEnd)
            ->get()
            ->getRow()
            ->total_harga ?? 0;

        $totalUser  = $this->userModel->countAll();
        $totalSiswa = $this->studentModel->countAll();

        // DATA SISWA + KURSUS + KATEGORI
        $students = $db->table('students')
            ->select("
                students.id,
                students.nama_siswa,
                students.no_hp,
                students.status,
                GROUP_CONCAT(DISTINCT products.nama_produk SEPARATOR ', ') as kursus,
                GROUP_CONCAT(DISTINCT categories.nama_kategori SEPARATOR ', ') as kategori
            ")
            ->join('transactions', 'transactions.id_siswa = students.id', 'left')
            ->join('transaction_details', 'transaction_details.id_transaksi = transactions.id', 'left')
            ->join('products', 'products.id = transaction_details.id_produk', 'left')
            ->join('categories', 'categories.id = products.id_kategori', 'left')
            ->groupBy('students.id')
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

        return redirect()->back()->with('success','Status berhasil diubah');
    }

    // =============================
    // LAPORAN
    // =============================
    public function laporan()
    {
        $db = \Config\Database::connect();

        $todayStart = date('Y-m-d 00:00:00');
        $todayEnd   = date('Y-m-d 23:59:59');

        $month = date('m');
        $year  = date('Y');

        // PENDAPATAN HARI INI
        $pendapatanHariIni = $db->table('transactions')
            ->selectSum('total_harga')
            ->where('created_at >=',$todayStart)
            ->where('created_at <=',$todayEnd)
            ->get()
            ->getRow()
            ->total_harga ?? 0;

        // PENDAPATAN BULAN INI
        $pendapatanBulanIni = $db->table('transactions')
            ->selectSum('total_harga')
            ->where('MONTH(created_at)', $month)
            ->where('YEAR(created_at)', $year)
            ->get()
            ->getRow()
            ->total_harga ?? 0;

        // TOTAL PENDAPATAN
        $totalPendapatan = $db->table('transactions')
            ->selectSum('total_harga')
            ->get()
            ->getRow()
            ->total_harga ?? 0;

        // TOTAL TRANSAKSI
        $totalTransaksi = $db->table('transactions')
            ->countAllResults();

        // DATA TRANSAKSI
        $transactions = $db->table('transactions')
            ->select('invoice,total_harga,created_at')
            ->orderBy('created_at','DESC')
            ->get()
            ->getResultArray();

        return view('owner/laporan',[
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

        $transactions = $db->table('transactions')
            ->select('invoice,total_harga,created_at')
            ->orderBy('created_at','DESC')
            ->get()
            ->getResultArray();

        $html = view('owner/laporan_pdf',[
            'transactions'=>$transactions
        ]);

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4','portrait');
        $dompdf->render();

        return $this->response
            ->setHeader('Content-Type','application/pdf')
            ->setHeader('Content-Disposition','attachment; filename="laporan-keuangan.pdf"')
            ->setBody($dompdf->output());
    }

    // =============================
    // LOG ACTIVITY
    // =============================
    public function logActivity()
    {
        $data['logs'] = $this->logModel
            ->select('log_activity.*, users.nama')
            ->join('users','users.id = log_activity.id_user')
            ->findAll();

        return view('owner/log',$data);
    }
}