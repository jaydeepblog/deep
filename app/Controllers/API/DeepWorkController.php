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

    public function create()
    {
        $json = $this->request->getBody();
        $data = json_decode($json, true);

        $validation = \Config\Services::validation();
        $validation->setRules([
            'title' => 'required|string|max_length[255]',
            'picture' => 'permit_empty|valid_url',
            'videos' => 'permit_empty',
            'description' => 'required|string',
            'ppm' => 'required|numeric',
        ]);

        if(!$validation->run($data)) {
            return $this->fail($validation->getErrors(), 400);
        }

        if($this->model->insert($data)) {
            return $this->respondCreated([
                'status' => 201,
                'message' => 'Task created successfully',
                'data' => $data,
            ]);
        }

        return $this->fail('Failed to create task', 500);
    }
}