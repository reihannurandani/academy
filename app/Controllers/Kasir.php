<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\StudentModel;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;
use App\Models\LogActivityModel;
use Dompdf\Dompdf;

class Kasir extends BaseController
{
    protected $productModel;
    protected $categoryModel;
    protected $studentModel;
    protected $transactionModel;
    protected $detailModel;
    protected $logModel;
    protected $db;

    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');

        $this->productModel     = new ProductModel();
        $this->categoryModel    = new CategoryModel();
        $this->studentModel     = new StudentModel();
        $this->transactionModel = new TransactionModel();
        $this->detailModel      = new TransactionDetailModel();
        $this->logModel         = new LogActivityModel();
        $this->db               = \Config\Database::connect();
    }

    // ======================
    // DASHBOARD
    // ======================
    public function index()
    {
        $data['products'] = $this->db->query("
            SELECT products.*, categories.nama_kategori as kategori
            FROM products
            LEFT JOIN categories ON categories.id = products.id_kategori
        ")->getResultArray();

        $data['categories'] = $this->categoryModel->findAll();

        $data['siswa_daftar'] = $this->db->query("
            SELECT 
                students.nama_siswa,
                transactions.tanggal_selesai,
                GROUP_CONCAT(products.nama_produk SEPARATOR ', ') as kursus
            FROM transactions
            JOIN students ON students.id = transactions.id_siswa
            LEFT JOIN transaction_details 
                ON transaction_details.id_transaksi = transactions.id
            LEFT JOIN products 
                ON products.id = transaction_details.id_produk
            GROUP BY transactions.id
            ORDER BY transactions.id DESC
        ")->getResultArray();

        return view('kasir/dashboard', $data);
    }

    // ======================
    // FORM TRANSAKSI
    // ======================
    public function transaksi()
    {
        $data['categories'] = $this->categoryModel->findAll();
        return view('kasir/transaksi', $data);
    }

    // ======================
    // AJAX PRODUK BY KATEGORI
    // ======================
    public function getProdukByKategori()
    {
        $id_kategori = $this->request->getPost('id_kategori');

        $produk = $this->productModel
            ->where('id_kategori', $id_kategori)
            ->where('kuota >', 0)
            ->findAll();

        return $this->response->setJSON($produk);
    }

    // ======================
    // SIMPAN TRANSAKSI
    // ======================
    public function saveTransaksi()
    {
        $nama_siswa    = $this->request->getPost('nama_siswa');
        $no_hp         = $this->request->getPost('no_hp');
        $alamat        = $this->request->getPost('alamat');
        $produkDipilih = $this->request->getPost('id_produk');
        $durasi        = (int) $this->request->getPost('durasi');
        $bayar         = (int) $this->request->getPost('uang_bayar');
        $tanggal_mulai = $this->request->getPost('tanggal_mulai');

        if(!$nama_siswa || !$no_hp){
            return redirect()->back()->with('error','Data siswa belum lengkap');
        }

        if(!$produkDipilih){
            return redirect()->back()->with('error','Pilih minimal 1 kursus');
        }

        if($durasi <= 0){
            return redirect()->back()->with('error','Durasi tidak valid');
        }

        if(!$tanggal_mulai){
            return redirect()->back()->with('error','Tanggal mulai wajib diisi');
        }

        $this->db->transStart();

        $tanggal_selesai = date('Y-m-d', strtotime("+$durasi month", strtotime($tanggal_mulai)));

        // SIMPAN SISWA
        $this->studentModel->insert([
            'nama_siswa' => $nama_siswa,
            'no_hp'      => $no_hp,
            'alamat'     => $alamat,
            'status'     => 'aktif',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $id_siswa = $this->studentModel->getInsertID();

        // HITUNG TOTAL
        $total = 0;
        foreach ($produkDipilih as $id_produk){
            $produk = $this->productModel->find($id_produk);

            if(!$produk || $produk['kuota'] <= 0){
                return redirect()->back()->with('error','Produk tidak tersedia');
            }

            $total += $produk['harga_produk'] * $durasi;
        }

        if($bayar < $total){
            return redirect()->back()->with('error','Uang bayar kurang');
        }

        $invoice = 'INV'.date('YmdHis');

        $this->transactionModel->insert([
            'invoice'          => $invoice,
            'id_user'          => session()->get('id'),
            'id_siswa'         => $id_siswa,
            'tanggal_mulai'    => $tanggal_mulai,
            'tanggal_selesai'  => $tanggal_selesai,
            'durasi'           => $durasi,
            'total_harga'      => $total,
            'uang_bayar'       => $bayar,
            'uang_kembali'     => $bayar - $total,
            'metode_pembayaran'=> 'tunai',
            'status'           => 'lunas',
            'created_at'       => date('Y-m-d H:i:s')
        ]);

        $id_transaksi = $this->transactionModel->getInsertID();

        foreach ($produkDipilih as $id_produk){
            $produk = $this->productModel->find($id_produk);

            $this->detailModel->insert([
                'id_transaksi' => $id_transaksi,
                'id_produk'    => $id_produk,
                'harga'        => $produk['harga_produk'],
                'qty'          => $durasi,
                'subtotal'     => $produk['harga_produk'] * $durasi
            ]);

            $this->productModel->update($id_produk, [
                'kuota' => $produk['kuota'] - 1
            ]);
        }

        $this->logModel->insert([
            'id_user'  => session()->get('id'),
            'activity' => 'Menambahkan transaksi '.$invoice
        ]);

        $this->db->transComplete();

        return redirect()->to('/kasir/transaksi')
        ->with('success','Transaksi berhasil!')
        ->with('id_transaksi', $id_transaksi);
    }

    // ======================
    // RIWAYAT
    // ======================
    public function riwayat()
    {
        $data['transaksi'] = $this->db->query("
            SELECT transactions.*, students.nama_siswa
            FROM transactions
            JOIN students ON students.id = transactions.id_siswa
            ORDER BY transactions.id DESC
        ")->getResultArray();

        return view('kasir/riwayat', $data);
    }

    // ======================
    // DETAIL TRANSAKSI
    // ======================
    public function detail($id)
    {
        $transaksi = $this->db->table('transactions')
            ->select('transactions.*, students.nama_siswa')
            ->join('students', 'students.id = transactions.id_siswa')
            ->where('transactions.id', $id)
            ->get()
            ->getRowArray();

        if(!$transaksi){
            return redirect()->to('/kasir/riwayat')
                ->with('error','Data tidak ditemukan');
        }

        $detail = $this->db->table('transaction_details')
            ->select('transaction_details.*, products.nama_produk')
            ->join('products', 'products.id = transaction_details.id_produk')
            ->where('id_transaksi', $id)
            ->get()
            ->getResultArray();

        return view('kasir/detail_transaksi', [
            'transaksi' => $transaksi,
            'detail'    => $detail
        ]);
    }
    // ======================
    // LIST PERPANJANGAN
    // ======================
public function perpanjang()
{
    $mapel = $this->request->getGet('mapel') ?? [];

    $builder = $this->db->table('transactions');
    $builder->select("
        transactions.*,
        students.nama_siswa,
        GROUP_CONCAT(DISTINCT products.nama_produk SEPARATOR ', ') as kursus,
        GROUP_CONCAT(DISTINCT categories.nama_kategori SEPARATOR ', ') as kategori
    ");

    $builder->join('students', 'students.id = transactions.id_siswa', 'left');
    $builder->join('transaction_details', 'transaction_details.id_transaksi = transactions.id', 'left');
    $builder->join('products', 'products.id = transaction_details.id_produk', 'left');
    $builder->join('categories', 'categories.id = products.id_kategori', 'left');

    // ✅ FILTER MULTI MAPEL AMAN
    if (!empty($mapel)) {
        $builder->whereIn('products.id', $mapel);
    }

    $builder->groupBy('transactions.id');
    $builder->orderBy('transactions.id', 'DESC');

    $data['transaksi'] = $builder->get()->getResultArray();
    $data['mapelList'] = $this->productModel->findAll();
    $data['selectedMapel'] = $mapel;

    return view('kasir/perpanjang_list', $data);
}

    // ======================
    // FORM PERPANJANGAN
    // ======================
public function perpanjangForm($id)
{
    $transaksi = $this->transactionModel->find($id);

    if(!$transaksi){
        return redirect()->to('/kasir/perpanjang')
            ->with('error','Data tidak ditemukan');
    }

    $siswa = $this->studentModel->find($transaksi['id_siswa']);

    // ✅ Ambil mapel yang sudah pernah diambil siswa
    $mapelSiswa = $this->db->table('transaction_details td')
        ->select('products.id, products.nama_produk, products.harga_produk')
        ->join('transactions t', 't.id = td.id_transaksi')
        ->join('products', 'products.id = td.id_produk')
        ->where('t.id_siswa', $transaksi['id_siswa'])
        ->groupBy('products.id')
        ->get()
        ->getResultArray();

    return view('kasir/perpanjang_form', [
        'transaksi'   => $transaksi,
        'siswa'       => $siswa,
        'mapelSiswa'  => $mapelSiswa, 
        'products'    => $this->productModel->findAll()
    ]);
}

    // ======================
    // SIMPAN PERPANJANGAN (MULTI PRODUK)
    // ======================
public function simpanPerpanjang()
{
    $db = \Config\Database::connect();

    $id_siswa       = $this->request->getPost('id_siswa');
    $produk         = $this->request->getPost('produk');
    $uang           = (int) $this->request->getPost('uang_bayar');
    $durasi         = (int) $this->request->getPost('durasi');
    $tanggal_mulai  = $this->request->getPost('tanggal_mulai');

    if(!$produk){
        return redirect()->back()->with('error','Pilih minimal 1 kursus');
    }

    if($durasi <= 0){
        return redirect()->back()->with('error','Durasi tidak valid');
    }

    if(!$tanggal_mulai){
        return redirect()->back()->with('error','Tanggal mulai wajib diisi');
    }

    $total = 0;

    foreach($produk as $id_produk){
        $p = $db->table('products')->where('id',$id_produk)->get()->getRow();

        if($p){
            $total += $p->harga_produk * $durasi;
        }
    }

    if($uang < $total){
        return redirect()->back()->with('error','Uang tidak cukup!');
    }

    // 🔥 hitung tanggal selesai
    $tanggal_selesai = date('Y-m-d', strtotime("+$durasi month", strtotime($tanggal_mulai)));

    $invoice = 'INV-'.time();

    $db->table('transactions')->insert([
        'invoice'          => $invoice,
        'id_user'          => session()->get('id'),
        'id_siswa'         => $id_siswa,
        'tanggal_mulai'    => $tanggal_mulai,
        'tanggal_selesai'  => $tanggal_selesai,
        'durasi'           => $durasi,
        'total_harga'      => $total,
        'uang_bayar'       => $uang,
        'uang_kembali'     => $uang - $total,
        'metode_pembayaran'=> 'tunai',
        'status'           => 'lunas',
        'created_at'       => date('Y-m-d H:i:s')
    ]);

    $id_transaksi = $db->insertID();

    foreach($produk as $id_produk){
        $p = $db->table('products')->where('id',$id_produk)->get()->getRow();

        if($p){
            $db->table('transaction_details')->insert([
                'id_transaksi' => $id_transaksi,
                'id_produk'    => $id_produk,
                'qty'          => $durasi,
                'harga'        => $p->harga_produk,
                'subtotal'     => $p->harga_produk * $durasi
            ]);
        }
    }

    return redirect()->to('/kasir/perpanjang')
        ->with('success','Perpanjangan berhasil!')
        ->with('id_transaksi', $id_transaksi);
}

public function cetakStruk($id)
{
    $db = \Config\Database::connect();

    // ✅ Ambil data transaksi
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

  
    $html = view('owner/struk_pdf', [
        'transaksi' => $transaksi,
        'detail'    => $detail
    ]);


    $dompdf = new \Dompdf\Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper([0,0,226,600], 'portrait');
    $dompdf->render();

    
    return $this->response
        ->setHeader('Content-Type', 'application/pdf')
        ->setHeader('Content-Disposition', 'attachment; filename="struk-'.$transaksi['invoice'].'.pdf"')
        ->setBody($dompdf->output());
}
}