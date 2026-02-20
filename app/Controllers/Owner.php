<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\TransactionModel;
use App\Models\LogActivityModel;

class Owner extends BaseController
{
    protected $productModel;
    protected $transactionModel;
    protected $logModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->transactionModel = new TransactionModel();
        $this->logModel = new LogActivityModel();
    }

    public function index()
    {
        $data['total_transaksi'] = $this->transactionModel->countAll();
        $data['total_produk'] = $this->productModel->countAll();
        return view('owner/dashboard', $data);
    }

    public function laporan()
    {
        $start = $this->request->getGet('start');
        $end = $this->request->getGet('end');

        if ($start && $end) {
            $data['transactions'] = $this->transactionModel->filterByDate($start, $end);
        } else {
            $data['transactions'] = $this->transactionModel->findAll();
        }

        return view('owner/laporan', $data);
    }

    public function logActivity()
    {
        $data['logs'] = $this->logModel
            ->select('log_activity.*, users.nama')
            ->join('users', 'users.id = log_activity.id_user')
            ->findAll();

        return view('owner/log', $data);
    }
}
