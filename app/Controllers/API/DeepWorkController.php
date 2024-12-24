<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;

class DeepWorkController extends ResourceController
{
    protected $modelName = 'App\Models\DeepWorkModel';
    protected $format = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }
}