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

        $totalPendapatan = $db->table('transactions')
            ->selectSum('total_harga')
            ->get()
            ->getRow()
            ->total_harga ?? 0;

        $pendapatanHariIni = $db->table('transactions')
            ->selectSum('total_harga')
            ->where('created_at >=', $todayStart)
            ->where('created_at <=', $todayEnd)
            ->get()
            ->getRow()
            ->total_harga ?? 0;

        $totalUser  = $this->userModel->countAll();
        $totalSiswa = $this->studentModel->countAll();

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
    $mapel = $this->request->getGet('mapel'); // array

    // ✅ ambil semua mapel
    $data['mapelList'] = $this->productModel->findAll();

    $builder = $this->transactionModel
        ->select('transactions.*, students.nama_siswa, GROUP_CONCAT(products.nama_produk SEPARATOR ", ") as kursus')
        ->join('students', 'students.id = transactions.id_siswa')
        ->join('transaction_details', 'transaction_details.id_transaksi = transactions.id')
        ->join('products', 'products.id = transaction_details.id_produk')
        ->groupBy('transactions.id');

    // ✅ MULTI FILTER
    if(!empty($mapel)){
        $builder->whereIn('products.id', $mapel);
    }

    $data['transactions'] = $builder->findAll();

    // ================= CARD =================
    $data['totalTransaksi']  = count($data['transactions']);
    $data['totalPendapatan'] = array_sum(array_column($data['transactions'], 'total_harga'));

    $today = date('Y-m-d');

    $data['pendapatanHariIni'] = $this->transactionModel
        ->where('DATE(created_at)', $today)
        ->selectSum('total_harga')
        ->first()['total_harga'] ?? 0;

    $data['pendapatanBulanIni'] = $this->transactionModel
        ->where('MONTH(created_at)', date('m'))
        ->where('YEAR(created_at)', date('Y'))
        ->selectSum('total_harga')
        ->first()['total_harga'] ?? 0;

    return view('owner/laporan', $data);
}

            // =============================
        // DETAIL TRANSAKSI (OWNER)
        // =============================
        public function detail($id)
        {
            $db = \Config\Database::connect();

            $transaksi = $db->table('transactions')
                ->select('transactions.*, students.nama_siswa')
                ->join('students', 'students.id = transactions.id_siswa')
                ->where('transactions.id', $id)
                ->get()
                ->getRowArray();

            if (!$transaksi) {
                return redirect()->back()->with('error','Transaksi tidak ditemukan');
            }

            $detail = $db->table('transaction_details')
                ->select('transaction_details.*, products.nama_produk')
                ->join('products', 'products.id = transaction_details.id_produk')
                ->where('id_transaksi', $id)
                ->get()
                ->getResultArray();

            return view('owner/detail_transaksi', [
                'transaksi' => $transaksi,
                'detail'    => $detail
            ]);
        }

    // =============================
    // CETAK PDF
    // =============================
   public function cetakPdf()
{
    $db = \Config\Database::connect();

    $transactions = $db->table('transactions')
        ->select("
            transactions.*,
            transactions.tanggal_mulai,
            transactions.tanggal_selesai,
            students.nama_siswa,
            GROUP_CONCAT(products.nama_produk SEPARATOR ', ') as kursus
        ")
        ->join('students', 'students.id = transactions.id_siswa', 'left')
        ->join('transaction_details', 'transaction_details.id_transaksi = transactions.id', 'left')
        ->join('products', 'products.id = transaction_details.id_produk', 'left')
        ->groupBy('transactions.id')
        ->orderBy('transactions.id', 'DESC')
        ->get()
        ->getResultArray();

    $totalTransaksi = count($transactions);

    $totalPendapatan = 0;
    foreach($transactions as $t){
        $totalPendapatan += $t['total_harga'];
    }

    $pendapatanHariIni = $db->table('transactions')
        ->selectSum('total_harga')
        ->where('DATE(created_at)', date('Y-m-d'))
        ->get()->getRow()->total_harga ?? 0;

    $pendapatanBulanIni = $db->table('transactions')
        ->selectSum('total_harga')
        ->where('MONTH(created_at)', date('m'))
        ->get()->getRow()->total_harga ?? 0;

    $data = [
        'transactions'       => $transactions,
        'totalTransaksi'     => $totalTransaksi,
        'totalPendapatan'    => $totalPendapatan,
        'pendapatanHariIni'  => $pendapatanHariIni,
        'pendapatanBulanIni' => $pendapatanBulanIni,
    ];

    $html = view('owner/laporan_pdf', $data);

    $dompdf = new \Dompdf\Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape'); // biar muat banyak kolom
    $dompdf->render();
    $dompdf->stream("laporan.pdf", ["Attachment" => false]);
}

    // =============================
    // LOG ACTIVITY
    // =============================
public function logActivity()
{
    $start  = $this->request->getGet('start');
    $end    = $this->request->getGet('end');
    $search = $this->request->getGet('search');

    $builder = $this->logModel
        ->select('log_activity.*, users.nama, users.role')
        ->join('users','users.id = log_activity.id_user');

    if(!empty($start)){
        $builder->where('DATE(log_activity.created_at) >=', $start);
    }

    if(!empty($end)){
        $builder->where('DATE(log_activity.created_at) <=', $end);
    }

    if(!empty($search)){
        $builder->groupStart()
            ->like('users.nama', $search)
            ->orLike('log_activity.activity', $search)
        ->groupEnd();
    }

    $data['logs'] = $builder
        ->orderBy('log_activity.created_at','DESC')
        ->findAll();

    return view('owner/log',$data);
}

public function struk($id)
{
    $db = \Config\Database::connect();

    $transaksi = $db->table('transactions')
        ->select('transactions.*, students.nama_siswa')
        ->join('students', 'students.id = transactions.id_siswa')
        ->where('transactions.id', $id)
        ->get()
        ->getRowArray();

    if (!$transaksi) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    $detail = $db->table('transaction_details')
        ->select('transaction_details.*, products.nama_produk')
        ->join('products', 'products.id = transaction_details.id_produk')
        ->where('id_transaksi', $id)
        ->get()
        ->getResultArray();

    // LOAD VIEW PDF
    $html = view('owner/struk_pdf', [
        'transaksi' => $transaksi,
        'detail'    => $detail
    ]);

    // DOMPDF
    $dompdf = new \Dompdf\Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper([0,0,226,600], 'portrait');
    $dompdf->render();

    // DOWNLOAD
    return $this->response
        ->setHeader('Content-Type', 'application/pdf')
        ->setHeader('Content-Disposition', 'attachment; filename="struk-'.$transaksi['invoice'].'.pdf"')
        ->setBody($dompdf->output());
}
}