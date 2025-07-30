<?php

namespace App\Controllers\Superadmin;

use App\Controllers\BaseController;
use \Hermawan\DataTables\DataTable;
use CodeIgniter\HTTP\ResponseInterface;

class Laporan extends BaseController
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
            'title' => 'LAPORAN',
        ];

        return view('superadmin/laporan/index', $data);
    }

    public function grid($menu = null)
    {
        $db = db_connect();
        helper("datetime_helper");
        $builder = $db->table('ksmard_r_kat_laporan')
            ->select('katlapKode, katlapNama');

        return DataTable::of($builder)->toJson(true);
    }

    public function simpan()
    {
        $rules = [
            'katlapNama' => ['label' => 'Nama Kategori', 'rules' => 'required']
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

        $katlapModel = new \App\Models\Ref\KategoriLaporan_m();
        $post = $this->request->getPost();

        // Jika ada katlapKode berarti ini adalah update
        if (!empty($post['katlapKode'])) {
            // Update data
            $data = [
                'katlapNama' => $post['katlapNama']
            ];

            $katlapModel->update($post['katlapKode'], $data);

            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'pesan' => '<b>Berhasil</b> mengubah data!'
            ]);
        } else {
            // Insert data baru
            $data = [
                'katlapNama' => $post['katlapNama']
            ];
            $katlapModel->insert($data);

            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'pesan' => '<b>Berhasil</b> menambahkan data!'
            ]);
        }
    }

    public function edit()
    {
        $katlapModel = new \App\Models\Ref\KategoriLaporan_m();
        $post = $this->request->getPost();
        $data = $katlapModel->where('katlapKode', $post['katlapKode'])->first();
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
        $id = $this->request->getPost("id"); // katlapKode

        $katlapModel = new \App\Models\Ref\KategoriLaporan_m();

        // Hapus data berdasarkan katlapKode
        $deleted = $katlapModel->where('katlapKode', $id)->delete();

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
