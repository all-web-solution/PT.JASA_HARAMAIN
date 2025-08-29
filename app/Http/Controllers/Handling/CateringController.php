<?php

namespace App\Http\Controllers\Handling;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catering;
use App\Models\cateringItem;
use App\Models\Meal;

class CateringController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $meals = Meal::all();
        return view('handling.catering.index', compact('meals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    
}
