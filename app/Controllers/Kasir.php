<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\StudentModel;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;
use App\Models\LogActivityModel;

class Kasir extends BaseController
{
    protected $productModel;
    protected $studentModel;
    protected $transactionModel;
    protected $detailModel;
    protected $logModel;
    protected $db;

    public function __construct()
    {
        $this->productModel     = new ProductModel();
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
        $data['products'] = $this->productModel->findAll();

        $data['siswa_daftar'] = $this->db->query("
            SELECT 
                students.nama_siswa,
                GROUP_CONCAT(products.nama_produk SEPARATOR ', ') as kursus
            FROM transactions
            JOIN students ON students.id = transactions.id_siswa
            JOIN transaction_details ON transaction_details.id_transaksi = transactions.id
            JOIN products ON products.id = transaction_details.id_produk
            GROUP BY students.id
            ORDER BY students.id DESC
        ")->getResultArray();

        return view('kasir/dashboard', $data);
    }

    // ==============================
    // FORM TRANSAKSI
    // ==============================
    public function transaksi()
    {
        $data['products'] = $this->productModel->findAll();
        return view('kasir/transaksi', $data);
    }

    // ==============================
    // SIMPAN TRANSAKSI
    // ==============================
 public function saveTransaksi()
{
    $produkDipilih = $this->request->getPost('id_produk');
    $durasi        = (int) $this->request->getPost('durasi');
    $bayar         = (int) $this->request->getPost('uang_bayar');

    if (!$produkDipilih) {
        return redirect()->back()->with('error','Pilih minimal 1 bahasa');
    }

    if ($durasi <= 0) {
        return redirect()->back()->with('error','Durasi tidak valid');
    }

    // ======================
    // SIMPAN SISWA
    // ======================
    $this->studentModel->save([
        'nama_siswa' => $this->request->getPost('nama_siswa'),
        'no_hp'      => $this->request->getPost('no_hp'),
        'alamat'     => $this->request->getPost('alamat'),
    ]);

    $id_siswa = $this->studentModel->getInsertID();

    // ======================
    // HITUNG TOTAL
    // ======================
    $total = 0;

    foreach ($produkDipilih as $id_produk) {
        $produk = $this->productModel->find($id_produk);

        if ($produk) {
            $total += $produk['harga_produk'] * $durasi;
        }
    }

    $kembalian = $bayar - $total;
    $id_mapel  = $produkDipilih[0];
    $invoice   = 'INV-' . date('YmdHis');

    // ======================
    // SIMPAN TRANSAKSI
    // ======================
    $this->transactionModel->save([
        'invoice'       => $invoice,
        'id_user'       => session()->get('id'),
        'id_siswa'      => $id_siswa,
        'id_mapel'      => $id_mapel,
        'durasi'        => $durasi,
        'total_harga'   => $total,
        'uang_bayar'    => $bayar,
        'uang_kembali'  => $kembalian,
        'metode_pembayaran' => 'tunai',
        'created_at'    => date('Y-m-d H:i:s'),
        'updated_at'    => date('Y-m-d H:i:s')
    ]);

    $id_transaksi = $this->transactionModel->getInsertID();

    // ======================
    // SIMPAN DETAIL + KURANGI KUOTA
    // ======================
    foreach ($produkDipilih as $id_produk) {

        $produk = $this->productModel->find($id_produk);

        if ($produk) {

            $harga    = $produk['harga_produk'];
            $qty      = $durasi;
            $subtotal = $harga * $qty;

            $this->detailModel->save([
                'id_transaksi' => $id_transaksi,
                'id_produk'    => $id_produk,
                'harga'        => $harga,
                'qty'          => $qty,
                'subtotal'     => $subtotal
            ]);

            $this->productModel->update($id_produk, [
                'kuota' => $produk['kuota'] - 1
            ]);
        }
    }

    // ======================
    // 🔥 SIMPAN LOG ACTIVITY
    // ======================
    $this->logModel->save([
        'id_user'  => session()->get('id'),
        'activity' => 'Menambahkan transaksi dengan Invoice ' . $invoice
    ]);

    return redirect()->to(base_url('kasir/struk/'.$id_transaksi));
}

    // ==============================
    // STRUK
    // ==============================
    public function struk($id)
    {
        $transaksi = $this->transactionModel
            ->select('transactions.*, students.nama_siswa')
            ->join('students','students.id = transactions.id_siswa')
            ->where('transactions.id',$id)
            ->first();

        if (!$transaksi) {
            return redirect()->to(base_url('kasir'));
        }

        $detail = $this->detailModel
            ->select('products.nama_produk, transaction_details.harga, transaction_details.qty, transaction_details.subtotal')
            ->join('products','products.id = transaction_details.id_produk')
            ->where('transaction_details.id_transaksi',$id)
            ->findAll();

        // ======================
        // 🔥 LOG CETAK STRUK
        // ======================
        $this->logModel->save([
            'id_user'  => session()->get('id'),
            'activity' => 'Mencetak struk transaksi Invoice ' . $transaksi['invoice']
        ]);

        return view('kasir/struk', [
            'transaksi' => $transaksi,
            'detail'    => $detail
        ]);
    }

}
