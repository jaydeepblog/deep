<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\DeepWorkModel;

class DashboardController extends BaseController
{
    public function dashboard()
    {
        if(!$this->session->get('logged_in')) {
            return redirect()->to('/login');
        }

        return view('dashboard\dashboard');
    }

    public function getDeepWorkList()
    {
        $model = new DeepWorkModel();
        $data = $model->findAll();
        $data = json_encode($data);
        return $data;
    }
}
