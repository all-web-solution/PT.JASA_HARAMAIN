<?php

namespace App\Http\Controllers;


use App\Models\CustomerDocument;
use Illuminate\Http\Request;
use App\Models\Document as DocumentModel;
use App\Models\DocumentChildren;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = DocumentModel::all();
        return view('content.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('content.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DocumentModel::create(['name' => $request->nama]);
        return redirect()->route('visa.document.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $document = DocumentModel::findOrFail($id);
        $childrens = DocumentChildren::where('document_id', $document->id)->get();
        return view('content.detail', compact('document', 'childrens'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
         $document = DocumentModel::findOrFail($id);
         return view('content.edit', compact('document'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $document = DocumentModel::findOrFail($id);
         $document->update(['name' => $request->nama]);
         return redirect()->route('visa.document.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $document = DocumentModel::findOrFail($id);
        $document->delete();
         return redirect()->route('visa.document.index');
    }

    public function createDocument($id)
    {
        $document = DocumentModel::findOrFail($id);
        return view('content.create_detail', compact('document'));
    }
    public function createDocumentStore(Request $request, $id)
    {
        $document = DocumentModel::findOrFail($id);
        $document->childrens()->create([
            'document_id' => $document->id,
            'name' => $request->nama
        ]);
        return redirect()->route('visa.document.show', $document->id);
    }

    public function createDocumentEdit($id)
    {
        $children = DocumentChildren::findOrFail($id);
        return view('content.edit_detail', compact('children'));
    }
    public function createDocumentUpdate($id, Request $request)
    {
        $children = DocumentChildren::findOrFail($id);
        $document = DocumentModel::findOrFail($id);
        $children->update([
            'name' => $request->nama
        ]);
        return redirect()->route('visa.document.show', $document->id);
    }
    public function createDocumentDelete($id)
    {
        $children = DocumentChildren::findOrFail($id);
        $document = DocumentModel::findOrFail($id);
        $children->delete();
        return redirect()->route('visa.document.show', $document->id);
    }
    public function customer(){
        $customers = CustomerDocument::all();
        return view('content.customer', compact('customers'));
    }
}
