<?php

namespace App\Controllers\Superadmin;

use App\Controllers\BaseController;
use \Hermawan\DataTables\DataTable;
use CodeIgniter\HTTP\ResponseInterface;

class Provinsi extends BaseController
{
    public function index()
    {
        $session = session();
        helper('form');
        if (!$session->get('cekLogin')) {
            // If not logged in, redirect to login page
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'PROVINSI',
        ];

        return view('superadmin/provinsi/index', $data);
    }

    public function grid($menu = null)
    {
        $db = db_connect();
        helper("datetime_helper");
        $builder = $db->table('ksmard_r_provinsi')
            ->select('provKode, provNamaLengkap, provNamaPendek, provIdSvg');

        return DataTable::of($builder)->toJson(true);
    }

    public function simpan()
    {
        $rules = [
            'provNamaLengkap' => ['label' => 'Nama Provinsi Lengkap', 'rules' => 'required'],
            'provNamaPendek' => ['label' => 'Nama Provinsi Pendek', 'rules' => 'required'],
            'provIdSvg' => ['label' => 'ID SVG', 'rules' => 'required']
        ];
        $validation = service('validation');
        $validation->setRules($rules);
        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'simpan' => false,
                'validasi' => false,
                'pesan' => $validation->getErrors()
            ]);
        }

        $post = $this->request->getPost();
        // Ambil seluruh data dari ProvinsiM, lalu cek apakah nama pendek dan id svg sudah ada
        $provinsiModel = new \App\Models\Ref\ProvinsiM();
        
        // Jika ini adalah update (ada provKode), exclude data yang sedang diedit
        if (!empty($post['provKode'])) {
            $provinsiData = $provinsiModel->where('provKode !=', $post['provKode'])
                ->groupStart()
                    ->where('provNamaPendek', $post['provNamaPendek'])
                    ->orWhere('provIdSvg', $post['provIdSvg'])
                ->groupEnd()
                ->findAll();
        } else {
            // Untuk insert baru, cek semua data
            $provinsiData = $provinsiModel->where('provNamaPendek', $post['provNamaPendek'])
                ->orWhere('provIdSvg', $post['provIdSvg'])
                ->findAll();
        }

        if (!empty($provinsiData)) {
            return $this->response->setJSON([
                'simpan' => false,
                'validasi' => true,
                'pesan' => 'Nama Pendek atau ID SVG sudah ada!'
            ]);
        }

        // Jika ada provKode berarti ini adalah update
        if (!empty($post['provKode'])) {
            // Update data
            $data = [
                'provNamaLengkap' => $post['provNamaLengkap'],
                'provNamaPendek' => $post['provNamaPendek'],
                'provIdSvg' => $post['provIdSvg']
            ];

            $provinsiModel->update($post['provKode'], $data);

            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'pesan' => '<b>Berhasil</b> mengubah data!'
            ]);
        } else {
            // Insert data baru
            $data = [
                'provNamaLengkap' => $post['provNamaLengkap'],
                'provNamaPendek' => $post['provNamaPendek'],
                'provIdSvg' => $post['provIdSvg']
            ];
            $provinsiModel->insert($data);

            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'pesan' => '<b>Berhasil</b> menambahkan data!'
            ]);
        }
    }

    public function edit()
    {
        $provinsiModel = new \App\Models\Ref\ProvinsiM();
        $post = $this->request->getPost();
        $data = $provinsiModel->where('provKode', $post['provKode'])->first();
        if ($data) {
            return $this->response->setJSON([
                'edit' => true,
                'data' => $data
            ]);
        } else {
            return $this->response->setJSON([
                'edit' => false,
                'pesan' => 'Data tidak ditemukan'
            ]);
        }
    }

    public function hapus()
    {
        $id = $this->request->getPost("id"); // provKode

        $provinsiModel = new \App\Models\Ref\ProvinsiM();

        // Hapus data berdasarkan provKode
        $deleted = $provinsiModel->where('provKode', $id)->delete();

        if ($deleted) {
            return $this->response->setJSON([
                'hapus' => true,
                'pesan' => 'Berhasil menghapus data!'
            ]);
        } else {
            return $this->response->setJSON([
                'hapus' => false,
                'pesan' => 'Gagal menghapus data. Silakan coba lagi.'
            ]);
        }
    }
}
