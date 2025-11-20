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
            'price' => 'required|string'
        ]);

        $children = DocumentChildren::findOrFail($id);
        $document = DocumentModel::findOrFail($children->document_id);

        $children->update(['name' => $request->nama, 'price' => $request->price,]);

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
        $customers = CustomerDocument::query()

            ->with([
                'service.pelanggan',
                'document'
            ])

            ->latest()
            ->paginate(10);

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
            'document' => $document, // Nama variabel diubah jadi 'document'
            'services' => $services,
            'documents' => $documents,
            'documentChildrens' => $documentChildrens,
            'statuses' => $statuses
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

    /**
     * Menampilkan daftar supplier (transaksi) untuk Document CHILDREN.
     * Menggunakan DocumentChildren ID.
     */
    public function supplier($id) // Rute lama: visa.document.customer.detail.supplier
    {
        // 1. Ambil data master DocumentChildren untuk konteks
        $documentChildren = DocumentChildren::with('document')->findOrFail($id);

        // 2. Ambil SEMUA CustomerDocument (permintaan service) yang menggunakan DocumentChildren ini.
        $customerDocuments = CustomerDocument::where('document_children_id', $documentChildren->id)
            ->with(['service.pelanggan', 'document', 'documentChild'])
            ->latest()
            ->paginate(15);

        // Menggunakan nama variabel 'documentItem' untuk konsistensi di view
        $documentItem = $documentChildren;

        return view('content.supplier', compact('documentItem', 'customerDocuments'));
    }

    /**
     * Menampilkan daftar supplier (transaksi) untuk Document INDUK tanpa CHILDREN.
     * Menggunakan Document ID.
     */
    public function supplierParent($id)
    {
        // 1. Ambil Document (Induk)
        $documentParent = DocumentModel::findOrFail($id);

        // 2. Query CustomerDocument yang menggunakan Document ID ini, tetapi TIDAK memiliki Document Children ID.
        // Ini menangani kasus dokumen yang tidak memiliki child item
        $customerDocuments = CustomerDocument::where('document_id', $documentParent->id)
            ->whereNull('document_children_id') // Penting: Hanya transaksi tanpa child ID
            ->with(['service.pelanggan', 'document', 'documentChild'])
            ->latest()
            ->paginate(15);

        // Buat objek sementara agar konsisten di view
        $documentItem = (object) [
            'id' => $documentParent->id,
            'name' => $documentParent->name,
            'document' => $documentParent,
            'is_parent_only' => true // Penanda di view
        ];

        return view('content.supplier', compact('documentItem', 'customerDocuments'));
    }
}
