<?php

namespace App\Http\Controllers;

use App\Models\CustomerDocument;
use Illuminate\Http\Request;
use App\Models\Document as DocumentModel;
use App\Models\DocumentChildren;
use Illuminate\Support\Facades\Session;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = DocumentModel::all();
        return view('content.index', compact('documents'));
    }

    public function create()
    {
        return view('content.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        DocumentModel::create(['name' => $request->nama]);

        Session::flash('success', 'Document created successfully!');
        return redirect()->route('visa.document.index');
    }

    public function show(string $id)
    {
        $document = DocumentModel::findOrFail($id);
        $childrens = DocumentChildren::where('document_id', $document->id)->get();
        return view('content.detail', compact('document', 'childrens'));
    }

    public function edit(string $id)
    {
        $document = DocumentModel::findOrFail($id);
        return view('content.edit', compact('document'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $document = DocumentModel::findOrFail($id);
        $document->update(['name' => $request->nama]);

        Session::flash('success', 'Document updated successfully!');
        return redirect()->route('visa.document.index');
    }

    public function destroy(string $id)
    {
        $document = DocumentModel::findOrFail($id);
        $document->delete();

        Session::flash('success', 'Document deleted successfully!');
        return redirect()->route('visa.document.index');
    }

    public function createDocument($id)
    {
        $document = DocumentModel::findOrFail($id);
        return view('content.create_detail', compact('document'));
    }

    public function createDocumentStore(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'price' => 'required|string'
        ]);

        $document = DocumentModel::findOrFail($id);
        $document->childrens()->create([
            'document_id' => $document->id,
            'name' => $request->nama,
            'price' => $request->price
        ]);

        Session::flash('success', 'Document child created successfully!');
        return redirect()->route('visa.document.show', $document->id);
    }

    public function createDocumentEdit($id)
    {
        $children = DocumentChildren::findOrFail($id);
        return view('content.edit_detail', compact('children'));
    }

    public function createDocumentUpdate($id, Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $children = DocumentChildren::findOrFail($id);
        $document = DocumentModel::findOrFail($children->document_id);

        $children->update(['name' => $request->nama]);

        Session::flash('success', 'Document child updated successfully!');
        return redirect()->route('visa.document.show', $document->id);
    }

    public function createDocumentDelete($id)
    {
        $children = DocumentChildren::findOrFail($id);
        $document = DocumentModel::findOrFail($children->document_id);

        $children->delete();

        Session::flash('success', 'Document child deleted successfully!');
        return redirect()->route('visa.document.show', $document->id);
    }

    public function customer()
    {
        $customers = CustomerDocument::all();
        return view('content.customer', compact('customers'));
    }
}
