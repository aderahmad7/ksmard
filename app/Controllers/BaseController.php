<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->periodeNoInput=["dikirim","divalidasi"];
        $this->periodeYesInput=["draft","revisi"];
        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }

    public function DoUpload($fieldName = 'userfile')
    {
        $validationRule = [
            $fieldName => [
                'label' => 'Image File',
                'rules' => [
                    'uploaded[' . $fieldName . ']',
                    //'is_image[' . $fieldName . ']',
                    'mime_in[' . $fieldName . ',image/jpg,image/jpeg,image/gif,image/png,image/webp,application/pdf]',
                    'max_size[' . $fieldName . ',2000]'         // dalam KB
                ],
            ],
        ];

        if (! $this->validate($validationRule)) {
            // Mengembalikan error validasi
            return [
                'status' => false,
                'error'  => $this->validator->getErrors()[$fieldName] ?? 'File validation failed.'
            ];
        }

        $img = $this->request->getFile($fieldName);

        if ($img && ! $img->hasMoved()) {
            // Simpan ke folder writable/uploads/ dengan nama acak
            $newName = $img->getRandomName();
            $img->move('uploads', $newName);

            return [
                'status' => true,
                'filename' => $newName
            ];
        }

        // Jika file sudah dipindahkan atau tidak ditemukan
        return [
            'status' => false,
            'error' => 'File gagal dipindahkan atau tidak ditemukan.'
        ];
    }

    public function GetPeriode($filename)
    {
        $validationRule = [
            $filename => [
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

        $periode = new \App\Models\Pks\Periode_m();
        $periodeData = $periode->find($this->request->getPost($filename));
        if ($periodeData){
            return [
                'status' => true,
                'data' => $periodeData
            ];
        } else {
            return [
                'status' => false,
                'error'  => 'Periode tidak ditemukan.'
            ];
        }
        
    }


}
