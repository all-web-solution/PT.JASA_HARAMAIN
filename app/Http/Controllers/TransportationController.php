<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plane;
use App\Models\Car;


class TransportationController extends Controller
{
    public function index(){
        $planes = Plane::all();
        return view('transportasi.pesawat.index', ['planes' => $planes]);
    }
    public function create(){
        return view('transportasi.pesawat.create');
    }

    public function store(Request $request){
       $plane =  Plane::create([
            'bandara_asal' => $request->asal,
            'bandara_tujuan' => $request->tujuan,
            'tanggal_berangkat' => $request->tanggal,
            'maskapai' => $request->maskapai,
            'transit' => $request->transit,
            'pax' => $request->pax,
            'description' => $request->deskripsi
        ]);

        if($plane){
            return redirect()->route('transportation.plane.index')->with('success', 'Bandara berhasil di tambahkan');
        }else{
            return redirect()->back()->with('success', 'Bandara berhasil di tambahkan');
        }
    dd($request->all());
    }

    public function edit($id){
        $plane = Plane::findOrFail($id);
        return view('transportasi.pesawat.edit', compact("plane"));
    }
    public function update($id, Request $request){
        $plane = Plane::findOrFail($id);
        $status = $plane->update([
            'bandara_asal' => $request->asal,
            'bandara_tujuan' => $request->tujuan,
            'tanggal_berangkat' => $request->tanggal,
            'maskapai' => $request->maskapai,
            'transit' => $request->transit,
            'pax' => $request->pax,
            'description' => $request->deskripsi
        ]);

        if($status){
             return redirect()->route('transportation.plane.index')->with('success', 'Bandara berhasil di ubah');
        }
    }

    public function delete($id){
         $plane = Plane::findOrFail($id);
         $plane->delete();
         return redirect()->route('transportation.plane.index')->with('success', 'Bandara berhasil di ubah');
    }



    public function indexCar(){
        $cars = Car::all();
        return view('transportasi.mobil.index', ['cars' => $cars]);
    }
    public function createCar(){
        return view('transportasi.mobil.create');
    }

    public function storeCar(Request $request){
       $status =  Car::create([
            'nama'=> $request->nama, 'tujuan' => $request->tujuan, 'harga' => $request->harga
        ]);

        if($status){
            return redirect()->route('transportation.car.index')->with('success', 'Data mobil berhasil di tambahkan');
        }else{
            return redirect()->back()->with('failed', 'Data mobil gagal di tambahkan');
        }
    }

    public function editCar($id){
        $car = Car::findOrFail($id);
        return view('transportasi.mobil.edit', compact("car"));
    }
    public function updateCar($id, Request $request){
        $car = Car::findOrFail($id);
        $status = $car->update([
            'nama'=> $request->nama, 'tujuan' => $request->tujuan, 'harga' => $request->harga
        ]);

        if($status){
             return redirect()->route('transportation.car.index')->with('success', 'Mobil berhasil di ubah');
        }
    }
        public function deleteCar($id){
         $car = Car::findOrFail($id);
         $car->delete();
         return redirect()->route('transportation.car.index')->with('success', 'Mobil berhasil di ubah');
    }

}
