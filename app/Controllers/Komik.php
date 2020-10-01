<?php

namespace App\Controllers;

use App\Models\KomikModel;

class Komik extends BaseController
{
    //all method can use this constructor
    protected $komikModel;
    public function __construct()
    {
        $this->komikModel = new KomikModel();
    }

    public function index()
    {
        //$komik = $this->komikModel->findAll();

        $data = [
            'title' => 'Comics',
            'komik' => $this->komikModel->getKomik()
        ];

        return view('komik/index', $data);
    }

    public function detail($slug)
    {
        $data = [
            'title' => 'Detail Komik',
            'komik' => $this->komikModel->getKomik($slug)
        ];

        //jika komik tidak ada di table
        if (empty($data['komik'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul komik ' . $slug . ' tidak ditemukan');
        }

        return view('komik/detail', $data);
    }

    public function create()
    {
        //session();
        $data = [
            'title' => 'Form Tambah Data Komik',
            'validation' => \Config\Services::validation()
        ];

        return view('komik/create', $data);
    }

    public function save()
    {
        //validation input
        if (!$this->validate([
            //rules untuk judul
            'judul' => [
                'rules' => 'required|is_unique[komik.judul]',
                'errors' => [
                    'required' => '{field} Komik harus diisi !',
                    'is_unique' => '{field} komik sudah terdaftar'
                ]
                ],
            //rules untuk sampul
            'sampul' => [
                'rules' => 'uploaded[sampul]|max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image.jpng]',
                'errors' => [
                    'uploaded' => 'Pilih gambar sampul dulu',
                    'max_size' => 'Gambar terlalu besar',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in' => 'Yang anda pilih bukan gambar'
                ]
            ]
        ])) {
            // $validation = \Config\Services::validation();
            // return redirect()->to('/komik/create')->withInput()->with('validation', $validation);
            return redirect()->to('/komik/create')->withInput();
         }
        
         //ambil gambar
         $fileSampul = $this->request->getFile('sampul');
         //pindahkan file ke folder img
         $fileSampul->move('img');
         //ambil nama file
         $namaSampul = $fileSampul->getName();

        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $namaSampul
        ]);
        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
        return redirect()->to('/komik');
    }


    public function delete($id)
    {
        $this->komikModel->delete($id);

        session()->setFlashdata('pesan', 'Data berhasil dihapus.');

        return redirect()->to('/komik');
    }

    public function edit($slug)
    {
        $data = [
            'title' => 'Form Ubah Data Komik',
            'validation' => \Config\Services::validation(),
            'komik' => $this->komikModel->getKomik($slug)
        ];

        return view('komik/edit', $data);
    }

    public function update($id)
    {
        //cek judul
        //jika judul tidak di ubah maka 
        $komiklama = $this->komikModel->getKomik($this->request->getVar('slug'));
        if($komiklama['judul'] == $this->request->getVar('judul')){
            $rule_judul = 'required';
        }else{
            $rule_judul = 'required|is_unique[komik.judul]';
        }

        //validation input
        if (!$this->validate([
            'judul' => [
                'rules' => $rule_judul,//dari condition di atas
                'errors' => [
                    'required' => '{field} Komik harus diisi !',
                    'is_unique' => '{field} komik sudah terdaftar'
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->to('/komik/edit/' .$this->request->getVar('slug'))->withInput()->with('validation', $validation);
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'id' => $id,
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $this->request->getVar('sampul')
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah.');
        return redirect()->to('/komik');
    }
}
