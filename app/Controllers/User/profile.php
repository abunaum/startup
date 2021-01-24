<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\Files\UploadedFile;

class profile extends BaseController
{
    public function index()
    {
        $item = $this->item;
        $toko = $this->toko;
        $user = $this->users->where('id', user()->id)->get()->getFirstRow();
        $data = [
            'khusus' => "profile",
            'judul' => "Profile | $this->namaweb",
            'item' => $item->where('status', 1)->orderBy('nama', 'asc')->findAll(),
            'toko' => $toko->where('username_user', user()->username)->findAll(),
            'user' => $user,
            'validation' => \Config\Services::validation()
        ];
        return view('halaman/user/profile', $data);
    }
    public function ubahdata()
    {
        $file = $this->request->getFiles();
        $nama = $this->request->getVar('nama');
        $gambar = $file['gambar'];
        if ($gambar->isValid()) {
            if (!$this->validate([
                'nama' => 'required|alpha_space|min_length[3]',
                'gambar' => [
                    'rules' => 'uploaded[gambar]|max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
                    'errors' => [
                        'uploaded' => 'Foto gambar profile masih kosong',
                        'max_size' => 'Ukuran gambar maksimal 1 Mb',
                        'is_image' => 'File yang dipilih bukan gambar',
                        'mime_in' => 'File yang dipilih bukan gambar'
                    ]
                ]
            ])) {
                session()->setFlashdata('error', 'Gagal mengubah data , Coba lagi');
                return redirect()->to(base_url('user/profile'))->withInput();
            }
            $user = $this->users->where('id', user()->id)->get()->getFirstRow();
            if ($user->user_image != 'default.svg') {
                @unlink('img/profile/' . $user->user_image);
            }
            $namagambar = $gambar->getName();
            $gambar->move('img/profile');
            $this->users->save([
                'id' => user()->id,
                'fullname' => $nama,
                'user_image' => $namagambar
            ]);
            session()->setFlashdata('pesan', 'Mantap , data berhasil di ubah');
            return redirect()->to(base_url('user/profile'));
        } else {
            if (!$this->validate([
                'nama' => 'required|alpha_space|min_length[3]'
            ])) {
                session()->setFlashdata('error', 'Gagal mengubah data , Coba lagi');
                return redirect()->to(base_url('user/profile'))->withInput();
            }
            $this->users->save([
                'id' => user()->id,
                'fullname' => $nama
            ]);
            session()->setFlashdata('pesan', 'Mantap , data berhasil di ubah');
            return redirect()->to(base_url('user/profile'));
        }
    }
    public function ubahpassword()
    {

        if (!$this->validate([
            'passwordlama' => 'required',
            'passwordbaru' => 'required|strong_password',
            'ulangipassword' => 'required|matches[passwordbaru]'
        ])) {
            session()->setFlashdata('error', 'Password gagal di ubah , Coba lagi');
            return redirect()->to(base_url('user/profile'))->withInput();
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
            return redirect()->to(base_url('user/profile'))->withInput();
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
            if (is_resource(@fsockopen($this->ipwa, $this->portwa))) {
                fclose(@fsockopen($this->ipwa, $this->portwa));
                $wa = $user->whatsapp;
                $post_data = 'sender=primary&number=' . $wa . '&message=' . $user->username . ' %0AAnda berhasil mengubah password';
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $this->waapi);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $result = curl_exec($ch);
            }
        }
        session()->setFlashdata('pesan', 'Password berhasil di ubah');
        return redirect()->to(base_url('user/profile'));
    }
    //--------------------------------------------------------------------

}
