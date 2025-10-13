<?php

namespace App\Http\Controllers\Admin;

use App\Helper\ServiceHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    public function index()
    {
        $serviceStatus = ServiceHelper::allStatusCount();

        return view('admin.dashboard', compact('serviceStatus'));
    }
}
