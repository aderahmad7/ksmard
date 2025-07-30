<?php

namespace App\Controllers\Superadmin;

use App\Controllers\BaseController;
use \Hermawan\DataTables\DataTable;
use CodeIgniter\HTTP\ResponseInterface;

class Pengolahan extends BaseController
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
            'title' => 'PENGOLAHAN',
        ];

        return view('superadmin/pengolahan/index', $data);
    }

    public function grid($menu = null)
    {
        $db = db_connect();
        helper("datetime_helper");
        $builder = $db->table('ksmard_r_kat_pengolahan_pks')
            ->select('katolahKode, katolahNama, katolahSubNama');

        return DataTable::of($builder)->toJson(true);
    }

    public function simpan()
    {
        $rules = [
            'katolahNama' => ['label' => 'Nama Kategori', 'rules' => 'required'],
            'katolahSubNama' => ['label' => 'Sub Kategori', 'rules' => 'required']
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

        $katolahModel = new \App\Models\Ref\KategoriPengolahan_m();
        $post = $this->request->getPost();

        // Jika ada katolahKode berarti ini adalah update
        if (!empty($post['katolahKode'])) {
            // Update data
            $data = [
                'katolahNama' => $post['katolahNama'],
                'katolahSubNama' => $post['katolahSubNama']
            ];

            $katolahModel->update($post['katolahKode'], $data);

            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'pesan' => '<b>Berhasil</b> mengubah data!'
            ]);
        } else {
            // Insert data baru
            $data = [
                'katolahNama' => $post['katolahNama'],
                'katolahSubNama' => $post['katolahSubNama']
            ];
            $katolahModel->insert($data);

            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'pesan' => '<b>Berhasil</b> menambahkan data!'
            ]);
        }
    }

    public function edit()
    {
        $katolahModel = new \App\Models\Ref\KategoriPengolahan_m();
        $post = $this->request->getPost();
        $data = $katolahModel->where('katolahKode', $post['katolahKode'])->first();
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
        $id = $this->request->getPost("id"); // katolahKode

        $katolahModel = new \App\Models\Ref\KategoriPengolahan_m();

        // Hapus data berdasarkan katolahKode
        $deleted = $katolahModel->where('katolahKode', $id)->delete();

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
