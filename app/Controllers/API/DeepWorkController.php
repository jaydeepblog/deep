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

    public function show($id = null)
    {
        $task = $this->model->find($id);

        if($task) {
            return $this->respond($task);
        }
        
        return $this->failNotFound('Task Not Found!');
    }

    public function update($id = null)
    {
        $existingTask = $this->model->find($id);

        if(!$existingTask) return $this->failNotFound('Task not found!');

        $json = $this->request->getBody();
        $input = json_decode($json, true);

        if(!$this->validate([
            'title' => 'permit_empty|string|max_length[255]',
            'picture' => 'permit_empty|valid_url',
            'videos' => 'permit_empty',
            'description' => 'permit_empty|string',
            'ppm' => 'permit_empty|numeric',
        ])) return $this->failValidationErrors($this->validator->getErrors());

        $updatedTask = $this->model->update($id, $input);

        if($updatedTask) {
            return $this->respond([
                'message' => 'Task updated successfully!',
                'data' => $this->model->find($id)
            ]);
        }

        return $this->fail('Failed to update task!');
    }

    public function delete($id = null)
    {
        //check if task exists
        $existingTask = $this->model->find($id);

        if(!$existingTask) return $this->failNotFound('Task not found!');

        //delete task
        if($this->model->delete($id)) {
            return $this->respondDeleted(['message' => 'Task deleted successfully']);
        }

        return $this->fail('Failed to delete task!');
    }
}