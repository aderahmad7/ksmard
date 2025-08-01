<?php

namespace App\Controllers\Pks;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use \Hermawan\DataTables\DataTable;
use App\Models\Pks\Periode_m;
use App\Models\Pks\Produksi_m;

class Produksi extends BaseController
{
    public function __construct(){
        $this->periodeModel = new Periode_m();
        $this->model = new Produksi_m();
        $this->session = session();
        helper('form');
        helper("datetime_helper");
        helper("dropdown_helper");
        helper("currency_helper");
    }
    public function index()
    {
       
        if (!$this->session->get('cekLogin')) {
            // If not logged in, redirect to login page
            return redirect()->to('/login');
        }
        $kode_pks = $this->session->get('kodePKS');
        
        $periode = $this->periodeModel->where('indkPksKode', $kode_pks)->findAll();
        $periodeCb = [];
        foreach ($periode as $row => $val)
            $periodeCb[$val["indkKode"]] = bulan($val["indkPeriodeBulan"]) . " " . $val["indkPeriodeTahun"];
        $data = [
            'title' => 'Produksi',
            'periode' => $periodeCb
        ];
        return view('pks/produksi/index', $data);
    }

    public function grid($menu = null)
    {
        $validationRule = [
            'periode' => [
                'label' => 'Periode',
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Kolom {field} wajib diisi.',
                    'integer' => '{field} harus berupa angka bulat.',
                ]
            ],
        ];

        if (! $this->validate($validationRule)) {
            // Mengembalikan error validasi
            return [
                'status' => false,
                'error'  => 'Periode tidak ditemukan.'
            ];
        }
        $this->periodeData = $this->periodeModel->find($this->request->getGet('periode'));
        $db = db_connect();
        helper("datetime_helper");
        $builder = $db->table('ksmard_r_kat_produksi')
            ->select('katproKode, katproNama, kat.prodVolume, kat.prodKode,indkStatus,prodKomentar')
            
            ->join('(select prodKode,prodVolume, prodKatproKode, prodIndkKode, prodKomentar from ksmard_t_produksi_pks where ksmard_t_produksi_pks.prodIndkKode="'.$this->request->getGet('periode').'") kat', 'kat.prodKatproKode = ksmard_r_kat_produksi.katproKode','left')
            ->join('ksmard_t_indeks_k_pks', 'ksmard_t_indeks_k_pks.indkKode = kat.prodIndkKode','left');
            
        //print_r($periodeData);exit;
        return DataTable::of($builder)
            ->edit('indkStatus', function($row, $meta){
                    return $this->periodeData["indkStatus"];
                })
            ->filter(function ($builder, $request) {
                if ($request->periode)
                    log_message('debug', $request->periode);
                
            })->toJson(true);
         //echo $db->getLastQuery();
    }

    public function simpan()
    {
       
        $periodeData = $this->GetPeriode('prodIndkKode');
        if (!$periodeData['status']){
            return $this->response->setJSON([
                'simpan' => false,
                'validasi' => false,
                'pesan' => $periodeData['error']
            ]);
            return;
        }
        
        $periodeData=$periodeData["data"];

        if (in_array($periodeData['indkStatus'], $this->periodeNoInput)){
            return $this->response->setJSON([
                'simpan' => false,
                'validasi' => true,
                'pesan' => 'Gagal menyimpan!!, Periode sudah dikirim'
            ]);
            return;
        }
        $rules = [
            'prodKatproKode' => ['label' => 'Jenis TBS', 'rules' => 'required'],
            'prodVolume' => ['label' => 'Volume', 'rules' => 'required'],
            'prodIndkKode' => ['label' => 'Periode', 'rules' => 'required'],
        ];
        if ($this->request->getPost("kode") != null)
            $rules['kode'] = ['label' => 'ID', 'rules' => 'required|is_natural'];
        //print_r($rules);exit;
        $validation = service('validation');
        $validation->setRules($rules);
        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'simpan' => false,
                'validasi' => false,
                'pesan' => $validation->getErrors()
            ]);
            return;
        }

        

        $post = $this->request->getPost();
        
        $kode = $post["kode"];
        unset($post["kode"]);
        //print_r($post);exit;
        $model = $this->model->where("prodIndkKode",$post["prodIndkKode"])
                                ->where("prodKatproKode",$post["prodKatproKode"])
                                ->first();
        if ($model) {
            $exist = $this->model->where($post)->first();
            if ($exist) {
                log_message('debug', print_r('prodKode' . $exist["prodKode"], true));
                log_message('debug', print_r('kode' . $kode, true));
                log_message('debug', print_r($kode != $exist['prodKode'], true));
                if ($kode != $exist['prodKode']) {
                    return $this->response->setJSON([
                        'simpan' => false,
                        'validasi' => true,
                        'pesan' => "Gagal mengubah data. Periode sudah pernah dibuat!"
                    ]);
                    return;
                }
            }
            unset($post["prodKatproKode"]);
            unset($post["prodIndkKode"]);
            $post["prodVolume"] = toDecimal($post["prodVolume"]);

            $this->model->update($kode, $post);
            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'pesan' => '<b>Berhasil</b> mengubah data!'
            ]);
        } else {


            $post["prodVolume"] = toDecimal($post["prodVolume"]);

            $this->model->save($post);
            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'pesan' => '<b>Berhasil</b> menambahkan data!'
            ]);
        }
    }

    public function format_rupiah_to_decimal($val)
    {
        $val = str_replace("Rp ", "", $val);
        $val = str_replace("Rp. ", "", $val);
        $val = str_replace(".", "", $val);
        $val = str_replace(",", ".", $val);
        return $val;
    }

    public function edit()
    {
        if ($this->request->getPost("prodKode")==null){
            return $this->response->setJSON([
                'edit' => false,
                'pesan' => ''
            ]);
            return;
        }
        $rules = [
            'prodKode' => ['label' => 'ID', 'rules' => 'required|is_natural']
        ];

        $validation = service('validation');
        $validation->setRules($rules);
        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'edit' => false,
                'pesan' => $validation->getErrors()
            ]);
            return;
        }
        

        $post = $this->request->getPost();
        unset($post["kode"]);
        $exist = $this->model->where($post)->first();
        if ($exist) {
            return $this->response->setJSON([
                'edit' => true,
                'data' => $exist
            ]);
        }
    }

    public function hapus()
    {

        $rules = [
            'id' => ['label' => 'ID', 'rules' => 'required|is_natural'],
        ];
        $validation = service('validation');
        $validation->setRules($rules);
        if (!$validation->withRequest($this->request)->run()) {
            return;
        }

        $id = $this->request->getPost("id");

        $periode = $this->model->find($id);
        if (!$periode) {
            return $this->response->setJSON([
                'hapus' => false,
                'pesan' => 'Data tidak ditemukan!'
            ]);
        }

        $periode = $this->model->delete($id);
        if ($periode) {
            return $this->response->setJSON([
                'hapus' => true,
                'pesan' => 'Berhasil menghapus data!'
            ]);
        }
    }

    public function periode()
    {
        $periodeData = $this->GetPeriode('periode');
        if (!$periodeData['status']){
            return $this->response->setJSON([
                'simpan' => false,
                'validasi' => false,
                'pesan' => $periodeData['error']
            ]);
            return;
        }

       $periodeData=$periodeData["data"];

       
         $input=false;
        if (in_array($periodeData['indkStatus'], $this->periodeYesInput))
            $input=true;
       
        return $this->response->setJSON([
            'status' => true,
            'input' =>$input,
            'data' => $periodeData
        ]);
        return;
        
        
        
    }
}
