<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\StudentModel;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;
use App\Models\LogActivityModel;

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

    // ==============================
    // DASHBOARD
    // ==============================
    public function index()
    {

        $data['products'] = $this->db->query("
            SELECT 
                products.*,
                categories.nama_kategori as kategori
            FROM products
            LEFT JOIN categories 
            ON categories.id = products.id_kategori
        ")->getResultArray();

        $data['categories'] = $this->categoryModel->findAll();

        // SISWA TERDAFTAR
        $data['siswa_daftar'] = $this->db->query("
            SELECT 
                students.nama_siswa,
                transactions.tanggal_selesai,
                GROUP_CONCAT(products.nama_produk SEPARATOR ', ') as kursus
            FROM transactions
            JOIN students 
            ON students.id = transactions.id_siswa
            LEFT JOIN transaction_details 
            ON transaction_details.id_transaksi = transactions.id
            LEFT JOIN products 
            ON products.id = transaction_details.id_produk
            GROUP BY transactions.id
            ORDER BY transactions.id DESC
        ")->getResultArray();

        return view('kasir/dashboard', $data);
    }

    // ==============================
    // FORM TRANSAKSI
    // ==============================
    public function transaksi()
    {

        $data['products'] = $this->productModel
            ->where('kuota >', 0)
            ->findAll();

        return view('kasir/transaksi', $data);
    }

    // ==============================
    // SIMPAN TRANSAKSI
    // ==============================
public function saveTransaksi()
{

    $nama_siswa     = $this->request->getPost('nama_siswa');
    $no_hp          = $this->request->getPost('no_hp');
    $alamat         = $this->request->getPost('alamat');
    $produkDipilih  = $this->request->getPost('id_produk');
    $durasi         = (int) $this->request->getPost('durasi');
    $bayar          = (int) $this->request->getPost('uang_bayar');
    $tanggal_mulai  = $this->request->getPost('tanggal_mulai');

    if(!$nama_siswa || !$no_hp){
        return redirect()->to('/kasir/transaksi')->with('error','Data siswa belum lengkap');
    }

    if(!$produkDipilih){
        return redirect()->to('/kasir/transaksi')->with('error','Pilih minimal 1 bahasa');
    }

    if($durasi <= 0){
        return redirect()->to('/kasir/transaksi')->with('error','Durasi tidak valid');
    }

    if(!$tanggal_mulai){
        return redirect()->to('/kasir/transaksi')->with('error','Tanggal mulai wajib diisi');
    }

    $this->db->transStart();

    // tanggal selesai
    $tanggal_selesai = date(
        'Y-m-d',
        strtotime("+$durasi month", strtotime($tanggal_mulai))
    );

    // simpan siswa
    $this->studentModel->insert([
        'nama_siswa' => $nama_siswa,
        'no_hp'      => $no_hp,
        'alamat'     => $alamat,
        'status'     => 'aktif',
        'created_at' => date('Y-m-d H:i:s')
    ]);

    $id_siswa = $this->studentModel->getInsertID();

    // hitung total
    $total = 0;

    foreach ($produkDipilih as $id_produk){

        $produk = $this->productModel->find($id_produk);

        if(!$produk){
            return redirect()->to('/kasir/transaksi')->with('error','Produk tidak ditemukan');
        }

        if($produk['kuota'] <= 0){
            return redirect()->to('/kasir/transaksi')->with('error','Kuota kursus habis');
        }

        $total += $produk['harga_produk'] * $durasi;
    }

    if($bayar < $total){
        return redirect()->to('/kasir/transaksi')->with('error','Uang bayar kurang');
    }

    $kembalian = $bayar - $total;

    $invoice = 'INV'.date('YmdHis');

    // simpan transaksi
    $this->transactionModel->insert([
        'invoice'          => $invoice,
        'id_user'          => session()->get('id'),
        'id_siswa'         => $id_siswa,
        'tanggal_mulai'    => $tanggal_mulai,
        'tanggal_selesai'  => $tanggal_selesai,
        'durasi'           => $durasi,
        'total_harga'      => $total,
        'uang_bayar'       => $bayar,
        'uang_kembali'     => $kembalian,
        'metode_pembayaran'=> 'tunai',
        'status'           => 'lunas',
        'created_at'       => date('Y-m-d H:i:s')
    ]);

    $id_transaksi = $this->transactionModel->getInsertID();

    // simpan detail
    foreach ($produkDipilih as $id_produk){

        $produk = $this->productModel->find($id_produk);

        $harga    = $produk['harga_produk'];
        $qty      = $durasi;
        $subtotal = $harga * $qty;

        $this->detailModel->insert([
            'id_transaksi' => $id_transaksi,
            'id_produk'    => $id_produk,
            'harga'        => $harga,
            'qty'          => $qty,
            'subtotal'     => $subtotal
        ]);

        // kurangi kuota
        $this->productModel->update($id_produk,[
            'kuota' => $produk['kuota'] - 1
        ]);
    }

// log activity
$this->logModel->insert([
    'id_user'  => session()->get('id'),
    'activity' => 'Menambahkan transaksi '.$invoice
]);

$this->db->transComplete();

return redirect()->to(base_url('kasir/struk/'.$id_transaksi));
}

    // ==============================
    // STRUK
    // ==============================
public function struk($id)
{

    // ambil transaksi dulu
    $transaksi = $this->transactionModel->find($id);

    if(!$transaksi){
        echo "Transaksi tidak ditemukan";
        exit;
    }

    // ambil data siswa
    $siswa = $this->studentModel->find($transaksi['id_siswa']);

    // ambil detail transaksi
    $detail = $this->detailModel
        ->select('products.nama_produk, transaction_details.harga, transaction_details.qty, transaction_details.subtotal')
        ->join('products','products.id = transaction_details.id_produk')
        ->where('transaction_details.id_transaksi',$id)
        ->findAll();

    // gabungkan nama siswa ke transaksi
    $transaksi['nama_siswa'] = $siswa['nama_siswa'] ?? '-';

    return view('kasir/struk',[
        'transaksi'=>$transaksi,
        'detail'=>$detail
    ]);
}
}