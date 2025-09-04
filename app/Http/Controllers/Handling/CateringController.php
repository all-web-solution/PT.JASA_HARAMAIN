<?php

namespace App\Http\Controllers\Handling;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catering;
use App\Models\cateringItem;
use App\Models\Meal;
use App\Models\MealItem;

class CateringController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $meals = MealItem::all();
        return view('handling.catering.index', compact('meals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(){
        return view('handling.catering.create');
    }

    public function store(Request $request){
        MealItem::create([
            'name' => $request->name,
            'price' => $request->price
        ]);

        return redirect()->route('catering.index');
    }

    public function edit($id){
        $meal = MealItem::find($id);

        return view('handling.catering.edit', compact('meal'));
    }
    public function update(Request $request, $id){
          $meal = MealItem::find($id);
          $meal->update([
             'name' => $request->name,
            'price' => $request->price
          ]);

            return redirect()->route('catering.index');
    }

    public function destroy($id){
         $meal = MealItem::find($id);
         $meal->delete();
         return redirect()->route('catering.index');
    }

    public function show(){
        $customerMeal = Meal::all();
        return view('handling.catering.customer', compact('customerMeal'));
    }
}
