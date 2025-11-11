<?php

namespace App\Http\Controllers;

use App\Models\CustomerDocument;
use Illuminate\Http\Request;
use App\Models\Document as DocumentModel;
use App\Models\DocumentChildren;
use App\Models\Service;
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
       // 1. Query model CustomerDocument, BUKAN ContentCustomer
        $customers = CustomerDocument::query()

            // 2. Load relasi yang dibutuhkan
            ->with([
                'service.pelanggan', // Untuk mengambil Nama Travel
                'document'           // Untuk mengambil Nama Dokumen
            ])

            // 3. Urutkan dan paginasi
            ->latest()
            ->paginate(10);

        // 4. Kirim ke view
        // Pastikan path view-nya benar (misal: 'dokumentasi.document.index')
        return view('content.customer', compact('customers'));
    }
    public function detail($id)
    {
        $customerDocument = CustomerDocument::with('service.pelanggan', 'document', 'documentChild')->findOrFail($id);
        return view('content.customer_detail', compact('customerDocument'));
    }

    public function editDocumentCustomer(CustomerDocument $document)
    {
        // Ambil data untuk dropdowns
        $services = Service::with('pelanggan')->get();
        $documents = DocumentModel::all();
        $documentChildrens = DocumentChildren::all();

        // Ambil status enum dari migrasi
        $statuses = ['nego', 'deal', 'batal', 'tahap persiapan', 'tahap produksi', 'done'];

        return view('content.customer_edit', [
            'document'          => $document, // Nama variabel diubah jadi 'document'
            'services'          => $services,
            'documents'         => $documents,
            'documentChildrens' => $documentChildrens,
            'statuses'          => $statuses
        ]);
    }

    /**
     * Memproses update untuk CustomerDocument.
     */
    public function updateDocumentCustomer(Request $request, CustomerDocument $document)
    {
        // Validasi data (sesuai migrasi)
        // (Saya asumsikan kolom harga & jumlah seharusnya numeric)
        $validatedData = $request->validate([
            'status' => 'required|in:nego,deal,batal,tahap persiapan,tahap produksi,done',
            'supplier' => 'nullable|string|max:255',
            'harga_dasar' => 'nullable|numeric|min:0',
            'harga_jual' => 'nullable|numeric|min:0|gte:harga_dasar',
        ]);

        // Update data
        $document->update($validatedData);

        // Redirect kembali ke halaman index dokumen
        // (Asumsi 'content.customer' adalah route index dokumen Anda)
        return redirect()->route('visa.document.customer')
                         ->with('success', 'Order Dokumen berhasil diperbarui!');
    }

    public function supplier($id)
    {
        $documentChildren = DocumentChildren::findOrFail($id);
        return view('content.supplier', compact('documentChildren'));
    }
    public function supplier_create($id)
    {
        $documentChildren = DocumentChildren::findOrFail($id);
        return view('content.supplier_create', compact('documentChildren'));
    }
    public function supplier_store($id)
    {
        $children = DocumentChildren::findOrFail($id);
        $children->update([
            'supplier' => request()->input('name'),
            'harga_dasar' => request()->input('price'),
        ]);
        return redirect()->route('visa.document.customer.detail.supplier', $children->id);

    }
}
