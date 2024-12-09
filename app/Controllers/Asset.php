<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\TestModel;
use CodeIgniter\Controller;
use Config\Database;
use CodeIgniter\DateTime;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yajra\DataTables\DataTables;

class Asset extends BaseController
{

    protected $UserModel;
    protected $TestModel;
    
    public function __construct()
    {
        $this->UserModel = new UserModel();
        $this->testinput = new TestModel();
        $this->db = Database::connect();
        helper('form');
    }

    public function testinput()
    {
        return view('admnscrap/testinput');
    }

    public function submittest()
    {
        $rules = [
            'nama' => 'required',
            'tgl_bln_thn' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Validation failed. Please check your input.'
            ]);
        }

        $nama = $this->request->getPost('nama');
        $tgl_bln_thn = $this->request->getPost('tgl_bln_thn');
        $no_hp = $this->request->getPost('no_hp');
        $alamat = $this->request->getPost('alamat');

        try {
            $query = "EXEC updateData @Nama = ?, @TglBlnThn = ?, @NoHp = ?, @Alamat = ?";
            $this->db->query($query, [$nama, $tgl_bln_thn, $no_hp, $alamat]);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data successfully saved or updated.'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error saving data: ' . $e->getMessage()
            ]);
        }
    }
    
}
