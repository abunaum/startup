<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Libraries\Itemlibrary;
use App\Libraries\TeleApiLibrary;
use CodeIgniter\API\ResponseTrait;

class toko extends BaseController
{
    public $telelib;

    public function __construct()
    {
        $this->telelib = new TeleApiLibrary();
        $this->getitem = new Itemlibrary();
    }

    use ResponseTrait;

    public function produk()
    {
        $item = $this->getitem->getsub();
        $toko = $this->toko;
        $user = $this->users->where('id', user()->id)->get()->getFirstRow();
        $produkuser = $this->produk->where('owner', user()->id);
        // dd($produkuser->findAll());

        $data = [
            'judul' => "Produk | $this->namaweb",
            'item' => $item,
            'toko' => $toko->where('userid', user()->id)->get()->getFirstRow(),
            'user' => $user,
            'validation' => \Config\Services::validation(),
            'produk' => $produkuser->paginate(6),
            'pager' => $produkuser->pager,
        ];
        if ($user->status_toko != 4) {
            return redirect()->to(base_url('toko'));
        } else {
            return view('Toko/fitur/produk', $data);
        }
    }

    public function tambah()
    {
        $item = $this->getitem->getsub();
        $toko = $this->toko;
        $user = $this->users->where('id', user()->id)->get()->getFirstRow();
        $itemproduk = $this->item;
        $data = [
            'type' => 'tambahproduk',
            'judul' => "Tambah Produk | $this->namaweb",
            'item' => $item,
            'itemproduk' => $itemproduk->orderBy('nama', 'asc')->findAll(),
            'toko' => $toko->where('userid', user()->id)->get()->getFirstRow(),
            'user' => $user,
            'validation' => \Config\Services::validation(),
        ];
        if ($user->status_toko != 4) {
            return redirect()->to(base_url('toko'));
        } else {
            return view('Toko/fitur/tambah', $data);
        }
    }

    public function tambahproduk()
    {
        $subitem = $this->request->getVar('sub');
        $nama = $this->request->getVar('nama');
        $harga = (int) $this->request->getVar('harga');
        $deskripsi = $this->request->getVar('deskripsi');
        $stok = $this->request->getVar('stok');

        $toko = $this->toko->where('userid', user()->id)->get()->getFirstRow();
        $slug = url_title($toko->username . ' ' . $nama);

        if (!$this->validate([
            'item' => 'required',
            'sub' => 'required',
            'nama' => 'required',
            'harga' => 'required',
            'deskripsi' => 'required',
            'stok' => 'required',
            'gambar' => [
                'rules' => 'uploaded[gambar]|max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Gambar produk masih kosong',
                    'max_size' => 'Ukuran gambar maksimal 1 Mb',
                    'is_image' => 'File yang dipilih bukan gambar',
                    'mime_in' => 'File yang dipilih bukan gambar',
                ],
            ],
        ])) {
            session()->setFlashdata('error', 'Gagal menambah produk');
            return redirect()->to(base_url('user/toko/tambah'))->withInput();
        }
        $gambar = $this->request->getFile('gambar');
        $gambar->move('img/produk');
        $namagambar = $gambar->getName();
        $produk = $this->produk;
        $produk->save([
            'jenis' => $subitem,
            'owner' => user()->id,
            'gambar' => $namagambar,
            'nama' => $nama,
            'harga' => $harga,
            'keterangan' => $deskripsi,
            'slug' => $slug,
            'stok' => $stok,
        ]);

        $admin = $this->role->admin()->findAll();
        foreach ($admin as $admin) {
            $id_admin = $admin['user_id'];
            $db = \Config\Database::connect();
            $builder = $db->table('users');
            $builder->where('id', $id_admin);
            $builder->where('telecode', 'valid');
            $adm = $builder->get()->getFirstRow();
            $chatId = $adm->teleid;
            $pesan = user()->username . '\nToko : ' . $toko->username . '\nmenambah produk :' . $nama . '\nharga : ' . $harga;
            $this->telelib->kirimpesan($chatId, $pesan);
        }
        session()->setFlashdata('pesan', 'Produk berhasil di tambah');
        return redirect()->to(base_url('user/toko/produk'));
    }

    public function produkdetail($id = 0)
    {
        $produk = $this->produk->where('id', $id)->get()->getFirstRow();
        $item = $this->getitem->getsub();
        $toko = $this->toko->where('userid', user()->id)->get()->getFirstRow();
        $user = $this->users->where('id', user()->id)->get()->getFirstRow();
        $produkuser = $this->produk->where('owner', user()->id);
        $data = [
            'judul' => "Produk | $this->namaweb",
            'item' => $item,
            'toko' => $toko,
            'user' => $user,
            'validation' => \Config\Services::validation(),
            'produk' => $produk,
            'produkuser' => $produkuser->paginate(6),
            'pager' => $produkuser->pager,
        ];
        if ($toko == null) {
            return redirect()->to(base_url('toko'));
        } elseif ($toko->userid != user()->id) {
            return redirect()->to(base_url('toko'));
        } elseif (user()->status_toko != 4) {
            return redirect()->to(base_url('toko'));
        } else {
            return view('Toko/fitur/produkdetail', $data);
        }
    }

    public function hapusproduk($id)
    {
        $produk = $this->produk->where('id', $id)->get()->getFirstRow();
        if ($produk->owner != user()->id) {
            return redirect()->to(base_url('toko'));
        } else {
            $this->produk->delete($id);
            session()->setFlashdata('pesan', 'Produk Berhasil di hapus');
            return redirect()->to(base_url('user/toko/produk'));
        }
    }
    public function editproduk($id)
    {
        $produk = $this->produk->find($id);
        if ($produk['owner'] != user()->id) {
            return redirect()->to(base_url('user/toko/produk'));
        }
        $file = $this->request->getFiles();
        $gambar = $file['gambar'];
        $nama = $this->request->getVar('nama');
        $keterangan = $this->request->getVar('keterangan');
        $harga = (int)$this->request->getVar('harga');
        $stok = (int)$this->request->getVar('stok');
        if (!$this->validate([
            'nama' => 'required|alpha_numeric_punct|min_length[3]',
            'keterangan' => 'required',
            'harga' => 'required|is_natural|min_length[1]',
            'stok' => 'required|is_natural|min_length[1]',
            'gambar' => [
                'rules' => 'max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar maksimal 1 Mb',
                    'is_image' => 'File yang dipilih bukan gambar',
                    'mime_in' => 'File yang dipilih bukan gambar',
                ],
            ],
        ])) {
            session()->setFlashdata('error', 'Gagal mengubah produk , Coba lagi');
            return redirect()->to(base_url('user/toko/produk/detail') . '/' . $id)->withInput();
        }
        if ($gambar->getError() == 4) {
            $this->produk->save([
                'id' => $id,
                'nama' => $nama,
                'keterangan' => $keterangan,
                'harga' => $harga,
                'stok' => $stok
            ]);
        } else {
            @unlink('img/produk/' . $produk['gambar']);
            $namagambar = $gambar->getRandomName();
            $gambar->move('img/produk', $namagambar);
            $this->produk->save([
                'id' => $id,
                'nama' => $nama,
                'keterangan' => $keterangan,
                'harga' => $harga,
                'gambar' => $namagambar,
                'stok' => $stok
            ]);
        }
        session()->setFlashdata('pesan', 'Mantap , produk berhasil di ubah');
        return redirect()->to(base_url('user/toko/produk/detail') . '/' . $id);
    }
    public function pengaturan()
    {
        $item = $this->getitem->getsub();
        $toko = $this->toko;
        $data = [
            'judul' => "Pengaturan toko | $this->namaweb",
            'item' => $item,
            'toko' => $toko->where('userid', user()->id)->first(),
            'validation' => \Config\Services::validation()
        ];
        return view('halaman/user/pengaturantoko', $data);
    }
}
