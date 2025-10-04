<?php

namespace App\Http\Controllers;

use App\Models\ContentCustomer;
use App\Models\ContentItem;
use Illuminate\Http\Request;

class ContentController extends Controller
{

    public function index(){
        $contents = ContentItem::all();
        return view('dokumentasi.index', compact('contents'));
    }
    public function create(){
        return view('dokumentasi.create');
    }
    public function store(Request $request){
        ContentItem::create([
            'name' => $request->nama,
            'price' => $request->harg
        ]);
        return redirect()->route('content.index');

     
    }
    public function edit($id){
        $content = ContentItem::find($id);
        return view('dokumentasi.edit', compact('content'));
    }
    public function update($id, Request $request){
        $content = ContentItem::find($id);
        $content->update([
            'name' => $request->nama,
            'price' => $request->harga
        ]);
         return redirect()->route('content.index');
    }
    public function destroy($id){
        $content = ContentItem::find($id);
        $content->delete();
         return redirect()->route('content.index');
    }
    public function customer(){
        $customer = ContentCustomer::all();
        return view('dokumentasi.customer', compact('customer'));
    }
}
