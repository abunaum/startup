<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\WaApiLibrary;

class Admin extends BaseController
{
    public $walib;
    public function __construct()
    {
        $this->walib = new WaApiLibrary;
    }
    public function index()
    {
        $data = [
            'namaweb' => $this->namaweb,
            'judul' => "Admin | $this->namaweb"
        ];
        return view('admin/index', $data);
    }

    public function item()
    {
        $item = $this->item;
        $data = [
            'namaweb' => $this->namaweb,
            'judul' => "Admin Item | $this->namaweb",
            'item' => $item->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('admin/item', $data);
    }

    public function item_tambah_prosess()
    {
        if (!$this->validate([
            'nama' => 'required'
        ])) {
            $validation = $this->validation;
            session()->setFlashdata('error', 'Item gagal di tambah , Coba lagi');
            return redirect()->to(base_url('admin/item'))->withInput();
        }
        $item = $this->item;
        $item->save([
            'nama' => $this->request->getVar('nama'),
            'status' => $this->request->getVar('status'),
            'sub' => $this->request->getVar('sub')
        ]);
        session()->setFlashdata('pesan', 'Item Berhasil di tambah');
        return redirect()->to(base_url('admin/item'));
    }

    public function item_hapus($id)
    {
        $this->item->delete($id);
        session()->setFlashdata('pesan', 'Item Berhasil di hapus');
        return redirect()->to(base_url('admin/item'));
    }

    public function item_nonaktifkan($id)
    {
        $item = $this->item;
        $item->save([
            'id' => $id,
            'status' => 0
        ]);
        session()->setFlashdata('pesan', 'Item Berhasil di ubah');
        return redirect()->to(base_url('admin/item'));
    }

    public function item_aktifkan($id)
    {
        $item = $this->item;
        $item->save([
            'id' => $id,
            'status' => 1
        ]);
        session()->setFlashdata('pesan', 'Item Berhasil di ubah');
        return redirect()->to(base_url('admin/item'));
    }

    public function item_subitem_nonaktifkan($id)
    {
        $item = $this->item;
        $item->save([
            'id' => $id,
            'sub' => 0
        ]);
        session()->setFlashdata('pesan', 'Sub Item Berhasil di ubah');
        return redirect()->to(base_url('admin/item'));
    }

    public function item_subitem_aktifkan($id)
    {
        $item = $this->item;
        $item->save([
            'id' => $id,
            'sub' => 1
        ]);
        session()->setFlashdata('pesan', 'Sub Item Berhasil di ubah');
        return redirect()->to(base_url('admin/item'));
    }

    public function subitem()
    {
        $subitem = $this->subitem->orderBy('nama', 'asc');
        $item = $this->item->orderBy('nama', 'asc');
        $item = $item->where('status', 1);
        $item = $item->where('sub', 1);
        $data = [
            'namaweb' => $this->namaweb,
            'judul' => "Admin SubItem | $this->namaweb",
            'itemlist' => $item->findAll(),
            'validation' => \Config\Services::validation(),
            'subitem' => $subitem->paginate(10),
            'pager' => $subitem->pager
        ];
        // dd($item);
        return view('admin/subitem', $data);
    }

    public function subitem_tambah_prosess()
    {
        if (!$this->validate([
            'nama' => 'required'
        ])) {
            $validation = $this->validation;
            session()->setFlashdata('error', 'Sub Item Gagal di ubah, Coba Lagi.');
            return redirect()->to(base_url('admin/subitem'))->withInput();
        }
        $subitem = $this->subitem;
        $subitem->save([
            'nama' => $this->request->getVar('nama'),
            'item' => $this->request->getVar('item'),
            'status' => $this->request->getVar('sub')
        ]);
        session()->setFlashdata('pesan', 'Sub Item Berhasil di tambah');
        return redirect()->to(base_url('admin/subitem'));
    }

    public function subitem_nonaktifkan($id)
    {
        $subitem = $this->subitem;
        $subitem->save([
            'id' => $id,
            'status' => 0
        ]);
        session()->setFlashdata('pesan', 'Sub Item Berhasil di ubah');
        return redirect()->to(base_url('admin/subitem'));
    }

    public function subitem_aktifkan($id)
    {
        $subitem = $this->subitem;
        $subitem->save([
            'id' => $id,
            'status' => 1
        ]);
        session()->setFlashdata('pesan', 'Sub Item Berhasil di ubah');
        return redirect()->to(base_url('admin/subitem'));
    }

    public function subitem_hapus($id)
    {
        $produk = $this->produk->where('jenis', $id)->findAll();
        foreach ($produk as $p) {
            $idproduk = $p['id'];
            $gambarproduk = $p['gambar'];
            $prosesproduk = $this->produk;
            $prosesproduk->delete($idproduk);
            @unlink('img/produk/' . $gambarproduk);
        }
        $this->subitem->delete($id);
        session()->setFlashdata('pesan', 'Sub Item Berhasil di hapus');
        return redirect()->to(base_url('admin/subitem'));
    }

    public function profile()
    {
        $data = [
            'namaweb' => $this->namaweb,
            'judul' => "Password | $this->namaweb",
            'validation' => \Config\Services::validation()
        ];
        return view('admin/profile', $data);
    }

    public function ubahpassword()
    {
        if (!$this->validate([
            'passwordlama' => 'required',
            'passwordbaru' => 'required|strong_password',
            'ulangipassword' => 'required|matches[passwordbaru]'
        ])) {
            session()->setFlashdata('error', 'Password gagal di ubah , Coba lagi');
            return redirect()->to(base_url('admin/profile'))->withInput();
        }
        $user = $this->users->where('id', user()->id)->get()->getFirstRow();
        $userid = $user->id;
        $passworduser = $user->password_hash;
        $passwordlama = $this->request->getVar('passwordlama');
        $passwordbaru = $this->request->getVar('passwordbaru');

        $result = password_verify(base64_encode(
            hash('sha384', $passwordlama, true)
        ), $passworduser);
        if (!$result) {
            session()->setFlashdata('error', 'Password gagal di ubah , Password lama salah.');
            return redirect()->to(base_url('admin/profile'))->withInput();
        }
        $userproses = $this->users;
        $hashOptions = [
            "hashMemoryCost" => 2084,
            "hashTimeCost" => 4,
            "hashThreads" => 4,
            "hashCost" => 10
        ];
        $passwordhash = password_hash(
            base64_encode(
                hash('sha384', $passwordbaru, true)
            ),
            PASSWORD_DEFAULT,
            $hashOptions
        );
        $userproses->save([
            'id' => $userid,
            'password_hash' => $passwordhash
        ]);
        if ($user->wa_hash == 'valid') {
            $koneksiwa = $this->walib->cekkoneksi();
            if ($koneksiwa != 'error') {
                $wa = $user->whatsapp;
                $pesan = $user->username . ' %0AAnda berhasil mengubah password';
                $this->walib->sendwasingle($wa, $pesan);
            }
        }
        session()->setFlashdata('pesan', 'Password berhasil di ubah');
        return redirect()->to(base_url('admin/profile'));
    }

    public function notifikasi()
    {
        $user = $this->users->where('id', user()->id)->get()->getFirstRow();
        $data = [
            'namaweb' => $this->namaweb,
            'judul' => "Notifikasi | $this->namaweb",
            'validation' => \Config\Services::validation()
        ];
        if ($user->whatsapp == null) {
            return view('admin/notifikasi_belum', $data);
        } else if ($user->wa_hash != 'valid') {
            $data['wa'] = $user->whatsapp;
            return view('admin/notifikasi_pending', $data);
        } else {
            return view('admin/notifikasi_sudah', $data);
        }
    }

    public function tambahwa()
    {
        if (!$this->validate([
            'wa' => 'required|min_length[10]|max_length[13]'
        ])) {
            session()->setFlashdata('error', 'Gagal menambah nomor whatsapp, Coba lagi.');
            return redirect()->to(base_url('admin/notifikasi'))->withInput();
        }

        $nowa = '0' . $this->request->getVar('wa');
        $rand = substr(md5(openssl_random_pseudo_bytes(20)), -32);
        $koneksiwa = $this->walib->cekkoneksi();
        if ($koneksiwa != 'error') {
            $wa = $nowa;
            $pesan = 'Kode anda adalah : ' . $rand;
            $this->walib->sendwasingle($wa, $pesan);
        } else {
            session()->setFlashdata('error', 'Server Whatsapp bermasalah.');
            return redirect()->to(base_url('admin/notifikasi'));
        }
        $this->users->save([
            'id' => user()->id,
            'whatsapp' => $nowa,
            'wa_hash' => $rand
        ]);
        session()->setFlashdata('pesan', 'Kode konfirmasi berhasil dikirim ke Whatsapp.');
        return redirect()->to(base_url('admin/notifikasi'));
    }

    public function ubahwhatsapp()
    {
        if (!$this->validate([
            'wa' => 'required|min_length[10]|max_length[13]'
        ])) {
            session()->setFlashdata('error', 'Gagal ubah nomor whatsapp, Coba lagi.');
            return redirect()->to(base_url('admin/notifikasi'))->withInput();
        }

        $nowa = '0' . $this->request->getVar('wa');
        $rand = substr(md5(openssl_random_pseudo_bytes(20)), -32);
        $koneksiwa = $this->walib->cekkoneksi();
        if ($koneksiwa != 'error') {
            $wa = $nowa;
            $pesan = 'Kode anda adalah : ' . $rand;
            $this->walib->sendwasingle($wa, $pesan);
        } else {
            session()->setFlashdata('error', 'Server Whatsapp bermasalah.');
            return redirect()->to(base_url('admin/notifikasi'));
        }
        $this->users->save([
            'id' => user()->id,
            'whatsapp' => $nowa,
            'wa_hash' => $rand
        ]);
        session()->setFlashdata('pesan', 'Nomor Whatsapp berhasil di ubah dan Kode berhasil di kirim.');
        return redirect()->to(base_url('admin/notifikasi'));
    }

    public function whatsapplagi()
    {
        $user = $this->users->where('id', user()->id)->get()->getFirstRow();
        $koneksiwa = $this->walib->cekkoneksi();
        if ($koneksiwa != 'error') {
            $wa = $user->whatsapp;
            $pesan = 'Kode anda adalah : ' . $user->wa_hash;
            $this->walib->sendwasingle($wa, $pesan);
            session()->setFlashdata('pesan', 'Kode konfirmasi berhasil dikirim ke Whatsapp.');
            return redirect()->to(base_url('admin/notifikasi'));
        } else {
            session()->setFlashdata('error', 'Server Whatsapp bermasalah.');
            return redirect()->to(base_url('admin/notifikasi'));
        }
    }

    public function verifwa()
    {
        $kode = $this->request->getVar('kode');
        $user = $this->users->where('id', user()->id)->get()->getFirstRow();
        $kodeuser = $user->wa_hash;
        if ($kode != $kodeuser) {
            session()->setFlashdata('error', 'Kode yang anda masukkan tidak sesuai.');
            return redirect()->to(base_url('admin/notifikasi'));
        } else {
            $this->users->save([
                'id' => user()->id,
                'wa_hash' => 'valid'
            ]);
            session()->setFlashdata('pesan', 'Notifikasi Whatsapp sudah aktif.');
            return redirect()->to(base_url('admin/notifikasi'));
        }
    }
    //--------------------------------------------------------------------

}
