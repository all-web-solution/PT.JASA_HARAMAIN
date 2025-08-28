<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plane;
use App\Models\Transportation;
use App\Models\TransportationItem;

class TransportationController extends Controller
{
    public function index(){
        $planes = Plane::all();
        return view('transportasi.pesawat.index',  compact('planes'));
    }
    public function indexCar(){
        $Transportations = Transportation::all();
        return view('transportasi.mobil.index', ['Transportations' => $Transportations]);
    }
    public function createCar(){
        return view('transportasi.mobil.create');
    }

    public function storeCar(Request $request){
       $status =  Transportation::create([
            'nama'=> $request->nama,
            'kapasitas' => $request->kapasitas,
            'fasilitas' => $request->fasilitas,
            'harga' => $request->harga
        ]);

        if($status){
            return redirect()->route('transportation.car.index')->with('success', 'Data kendaraan berhasil di tambahkan');
        }else{
            return redirect()->back()->with('failed', 'Data mobil gagal di tambahkan');
        }
    }

    public function editCar($id){
        $Transportation = Transportation::findOrFail($id);
        return view('transportasi.mobil.edit', compact("Transportation"));
    }
    public function updateCar($id, Request $request){
        $Transportation = Transportation::findOrFail($id);
        $status = $Transportation->update([
             'nama'=> $request->nama,
            'kapasitas' => $request->kapasitas,
            'fasilitas' => $request->fasilitas,
            'harga' => $request->harga
        ]);

        if($status){
             return redirect()->route('transportation.car.index')->with('success', 'Mobil berhasil di ubah');
        }
    }
        public function deleteCar($id){
         $Transportation = Transportation::findOrFail($id);
         $Transportation->delete();
         return redirect()->route('transportation.car.index')->with('success', 'Mobil berhasil di ubah');
    }

    public function TransportationCustomer(){
        $customers = TransportationItem::all();
        return view('transportasi.mobil.customer', compact('customers'));
    }


}

