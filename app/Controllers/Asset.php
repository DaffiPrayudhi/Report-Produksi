<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AssetModel;
use CodeIgniter\HTTP\ResponseInterface;

class Asset extends BaseController
{
    public function index()
    {
      $model = new AssetModel();
      $data['item'] = $model->findAll();
      return view('admnscrap/asset', $data);  
    }

    public function create()
    {
        return view('admnscrap/create');
    }

    public function store()
    {
    }
}
