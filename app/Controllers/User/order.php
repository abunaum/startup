<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Libraries\TeleApiLibrary;
use App\Libraries\Itemlibrary;
use App\Libraries\PaymentApiLibrary;

class order extends BaseController
{
    public $apilib;

    public function __construct()
    {
        $this->apilib = new PaymentApiLibrary();
        $this->getitem = new Itemlibrary();
    }
    public function produk($id = 0)
    {
        $pesan = $this->request->getVar('pesan');
        $jumlah = $this->request->getVar('jumlah');
        if (!$this->validate([
            'jumlah' => 'required|is_natural_no_zero'
        ])) {
            session()->setFlashdata('error', 'Gagal membuat order , Coba lagi');

            return redirect()->to(base_url("produk/detail/$id"))->withInput();
        }
        $produk = $this->produk;
        $produk = (object)$produk->detail($id)->first();
        $order = [
            'order'  => [
                'id_produk' => $id,
                'pesan' => $pesan,
                'jumlah' => $jumlah
            ]
        ];

        session()->set($order);
        return redirect()->to(base_url('user/order/produk'));
    }

    public function order()
    {
        $order = session('order');
        if (!isset($order)) {
            return redirect()->to(base_url("user/order/keranjang"));
        }
        $produkid = $order['id_produk'];
        $pesan = $order['pesan'];
        $jumlah = $order['jumlah'];
        session()->remove('order');
        $produk = $this->produk->detail($produkid)->first();
        if ($produk['owner'] == user()->id) {
            session()->setFlashdata('error', 'Dilarang membeli produk sendiri !!!');
            return redirect()->to(base_url("produk/detail/$produkid"));
        }
        $this->keranjang->save([
            'buyer' => user()->id,
            'produk' => $produkid,
            'jumlah' => $jumlah,
            'pesan' => $pesan,
            'status' => 1
        ]);
        session()->setFlashdata('pesan', 'Produk berhasil ditambah ke keranjang');
        return redirect()->to(base_url("produk/detail/$produkid"));
    }

    public function keranjang()
    {
        $item = $this->getitem->getsub();
        $keranjang = $this->keranjang;
        $keranjang->join('produk', 'produk.id = keranjang.produk', 'LEFT');
        $keranjang->join('toko', 'toko.userid = produk.owner', 'LEFT');
        $keranjang->select('keranjang.id');
        $keranjang->select('keranjang.jumlah');
        $keranjang->select('keranjang.pesan');
        $keranjang->select('toko.username as nama_toko');
        $keranjang->select('produk.id as id_produk');
        $keranjang->select('produk.nama as nama_produk');
        $keranjang->select('produk.harga as harga_produk');
        $keranjang->select('produk.gambar as gambar_produk');
        $hasilkeranjang = $keranjang->where('buyer', user()->id);
        $keranjang = $hasilkeranjang->findAll();
        $totalkeranjang = $this->keranjang->where('buyer', user()->id)->countAllResults();
        $pembayaran = $this->apilib->getmerchantclosed();
        $totalharga = 0;
        foreach ($keranjang as $kr) {
            $totalharga = $totalharga + ($kr['harga_produk'] * $kr['jumlah']);
        }
        $data = [
            'judul' => "keranjang | $this->namaweb",
            'item' => $item,
            'keranjang' => $keranjang,
            'totalharga' => $totalharga,
            'pembayaran' => $pembayaran,
            'totalkeranjang' => $totalkeranjang,
            'paymentapi' => $this->apilib,
        ];

        return view('halaman/user/keranjang', $data);
    }

    public function hapuskeranjang($id = 0)
    {
        $keranjang = $this->keranjang->where('id', $id)->first();
        if ($keranjang['buyer'] != user()->id) {
            return redirect()->to(base_url('user/order/keranjang'));
        } else {
            $this->keranjang->delete($id);
            $this->keranjang->where('id', $id)->purgeDeleted();
        }
        session()->setFlashdata('pesan', 'Produk berhasil dihapus dari keranjang');
        return redirect()->to(base_url('user/order/keranjang'));
    }

    public function hapussemuakeranjang()
    {
        $this->keranjang->where('buyer', user()->id)->delete();
        $this->keranjang->where('buyer', user()->id)->purgeDeleted();
        session()->setFlashdata('pesan', 'Keranjang sudah kosong');
        return redirect()->to(base_url('user/order/keranjang'));
    }

    public function proseskeranjang()
    {
        $channel = $this->request->getVar('metode');
        if (!isset($channel)) {
            return redirect()->to(base_url('user/order/keranjang'));
        }
        $getkeranjang = $this->keranjang->where('buyer', user()->id)->where('invoice', null)->findAll();
        $rand = rand(111111, 999999);
        $tgl = strtotime($this->gettime);
        $order_number = "INV-$tgl$rand";
        $totalbayar = 0;
        foreach ($getkeranjang as $gk) {
            $id = $gk['id'];
            $this->keranjang->save([
                'id' => $id,
                'invoice' => $order_number
            ]);
            $this->keranjang->delete($id);
            $produk = $this->produk->where('id', $gk['produk'])->withDeleted()->first();
            $jenis = $this->subitem->where('id', $produk['jenis'])->withDeleted()->first();
            $dataitem[] = array(
                'sku'       => $jenis['nama'],
                'name'      => $produk['nama'],
                'price'     => $produk['harga'],
                'quantity'  => $gk['jumlah']
            );
            $totalbayar = $totalbayar + ($produk['harga'] * $gk['jumlah']);
        }
        $returnurl = base_url('user/order/invoice');
        $createpayment = json_decode($this->apilib->createtransaction($dataitem, $order_number, $channel, $totalbayar, $returnurl), true);
        $this->invoice->save(
            [
                "kode" => $order_number,
                "channel" => $channel,
                "nominal" => $totalbayar,
                "fee" => $createpayment['data']['fee'],
                "referensi" => $createpayment['data']['reference'],
                "status" => $createpayment['data']['status']
            ]
        );
        session()->setFlashdata('pesan', "Pembayaran $order_number telah siap");
        return redirect()->to(base_url('user/order/invoice'));
    }

    public function invoice()
    {
        $item = $this->getitem->getsub();
        $getinv = $this->keranjang->where('buyer', user()->id);
        $getinv = $getinv->where('status', 'UNPAID');
        $getinv = $getinv->onlyDeleted()->groupBy("invoice")->findColumn('invoice');
        // dd($getinv);
        if ($getinv) {
            foreach ($getinv as $gi) {
                $invo = $this->invoice->where('kode', $gi)->first();
                $cektransaksi = json_decode($this->apilib->detailtransaksi($invo['referensi']), true);
                $kadaluarsa = date("Y-m-d H:i:s", $cektransaksi['data']['expired_time']);
                $dataker = $this->keranjang->where('invoice', $gi)->where('status', 1)->onlyDeleted()->findAll();
                foreach ($dataker as $dk) {
                    $produk = $this->produk->where('id', $dk['produk'])->withDeleted()->first();
                    $store = $this->toko->where('userid', $produk['owner'])->withDeleted()->first();
                    $data[] = array(
                        'nama_produk' => $produk['nama'],
                        'harga' => $produk['harga'],
                        'jumlah' => $dk['jumlah'],
                        'pesan' => $dk['pesan'],
                        'store' => $store['username'],
                        'gambar' => $produk['gambar']
                    );
                }
                $invv[] = array(
                    'id' => $invo['id'],
                    'kode' => $gi,
                    'status' => $invo['status'],
                    'nominal' => $invo['nominal'],
                    'fee' => $invo['fee'],
                    'metode' => $invo['channel'],
                    'expired' => $kadaluarsa,
                    'data' => $data
                );
                $data = array();
            }
            $invoice = $invv;
            $totalinv = count($invoice);
        } else {
            $invoice = array();
            $totalinv = count($invoice);
        }
        $data = [
            'judul' => "Invoice | $this->namaweb",
            'item' => $item,
            'invoice' => $invoice,
            'totalinv' => $totalinv
        ];
        return view('halaman/user/invoice', $data);
    }

    public function bayar($id = 0)
    {
        $invo = $this->invoice->where('id', $id)->first();
        $cektransaksi = json_decode($this->apilib->detailtransaksi($invo['referensi']), true);
        return redirect()->to($cektransaksi['data']['checkout_url']);
    }
}
