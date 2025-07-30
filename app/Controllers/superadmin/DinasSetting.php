<?php

namespace App\Controllers\Superadmin;

use App\Controllers\BaseController;
use \Hermawan\DataTables\DataTable;
use CodeIgniter\HTTP\ResponseInterface;

class DinasSetting extends BaseController
{
    public function index()
    {
        $session = session();
        helper('form');
        if (!$session->get('cekLogin')) {
            // If not logged in, redirect to login page
            return redirect()->to('/login');
        }

        $dinasModel = new \App\Models\Superadmin\Dinas_m();
        // ambil semua data dinas, ambil dinNama dari ksmard_m_dinas join dengan dinasModel berdasarkan dinsetDinKode = dinKode
        $dinas = $dinasModel->findAll();
        // ambil dinKode dan dinNama saja
        $options = [];
        foreach ($dinas as $d) {
            $value = json_encode(['dinKode' => $d['dinKode'], 'dinNama' => $d['dinNama']]);
            $options[$value] = $d['dinNama'];
        }

        $data = [
            'title' => 'PERSENTASE DINAS',
            'options' => $options
        ];

        return view('superadmin/dinas_setting/index', $data);
    }

    public function grid($menu = null)
    {
        $db = db_connect();
        helper("datetime_helper");
        $builder = $db->table('ksmard_r_dinas_setting')
            ->join('ksmard_m_dinas', 'ksmard_m_dinas.dinKode = ksmard_r_dinas_setting.dinsetDinKode', 'left')
            ->select('
            ksmard_r_dinas_setting.dinsetKode,
            ksmard_m_dinas.dinNama,
            ksmard_r_dinas_setting.dinsetPersenBotl,
            ksmard_r_dinas_setting.dinsetPersenJual,
            ksmard_r_dinas_setting.dinsetDinKode');

        return DataTable::of($builder)->toJson(true);
    }

    public function simpan()
    {
        $rules = [
            'dinKode' => ['label' => 'Dinas', 'rules' => 'required'],
            'dinsetPersenBotl' => ['label' => 'Persen Beli', 'rules' => 'required|numeric'],
            'dinsetPersenJual' => ['label' => 'Persen Jual', 'rules' => 'required|numeric']
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

        $dinasSettingModel = new \App\Models\Ref\KategoriDinasSettingM();
        $post = $this->request->getPost();
        $dinInfo = json_decode($post['dinKode'], true);
        $dinKode = $dinInfo['dinKode'];

        // Jika ada dinsetKode berarti ini adalah update
        if (!empty($post['dinsetKode'])) {
            // Update data
            $data = [
                'dinsetDinKode' => $dinKode,
                'dinsetPersenBotl' => $post['dinsetPersenBotl'],
                'dinsetPersenJual' => $post['dinsetPersenJual']
            ];

            $dinasSettingModel->update($post['dinsetKode'], $data);

            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'pesan' => '<b>Berhasil</b> mengubah data!'
            ]);
        } else {
            // Insert data baru
            // Cek apakah dinsetDinKode sudah ada di tabel setting
            $exist = $dinasSettingModel->where('dinsetDinKode', $dinKode)->first();
            if ($exist) {
                return $this->response->setJSON([
                    'simpan' => false,
                    'validasi' => true,
                    'pesan' => 'Dinas sudah memiliki data ini!'
                ]);
            }

            $data = [
                'dinsetDinKode' => $dinKode,
                'dinsetPersenBotl' => $post['dinsetPersenBotl'],
                'dinsetPersenJual' => $post['dinsetPersenJual']
            ];

            $dinasSettingModel->insert($data);

            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'pesan' => '<b>Berhasil</b> menambahkan data!'
            ]);
        }
    }

    public function edit()
    {
        $dinasSettingModel = new \App\Models\Ref\KategoriDinasSettingM();
        $post = $this->request->getPost();
        
        // Ambil data dinas setting berdasarkan dinsetKode dengan join ke tabel dinas
        $db = db_connect();
        $exist = $db->table('ksmard_r_dinas_setting')
            ->join('ksmard_m_dinas', 'ksmard_m_dinas.dinKode = ksmard_r_dinas_setting.dinsetDinKode', 'left')
            ->select('
                ksmard_r_dinas_setting.dinsetKode,
                ksmard_r_dinas_setting.dinsetDinKode,
                ksmard_r_dinas_setting.dinsetPersenBotl,
                ksmard_r_dinas_setting.dinsetPersenJual,
                ksmard_m_dinas.dinNama
            ')
            ->where('ksmard_r_dinas_setting.dinsetKode', $post['dinsetKode'])
            ->get()
            ->getRowArray();

        if ($exist) {
            return $this->response->setJSON([
                'edit' => true,
                'data' => $exist
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
        $id = $this->request->getPost("id"); // dinsetKode
        
        $dinasSettingModel = new \App\Models\Ref\KategoriDinasSettingM();
        
        // Hapus data berdasarkan dinsetKode
        $deleted = $dinasSettingModel->where('dinsetKode', $id)->delete();

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
