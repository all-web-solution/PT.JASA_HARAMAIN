<?php

namespace App\Helper;

use App\Models\Service;

class ServiceHelper
{
    public static function countByStatus($status)
    {
        return Service::where('status', $status)->count();
    }

    public static function allStatusCount()
    {
        $statuses = ['nego', 'deal', 'batal', 'tahap persiapan', 'tahap produksi', 'done'];
        $data = [];

        foreach ($statuses as $status) {
            $data[$status] = Service::where('status', $status)->count();
        }

        return $data;
    }
}
