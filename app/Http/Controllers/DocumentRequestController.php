<?php

namespace App\Http\Controllers;

use App\Models\DocumentRequest;
use App\Models\DocumentType;
use Illuminate\Http\Request;

class DocumentRequestController extends Controller
{
    public function create()
    {
        $documentTypes = DocumentType::all();
        $dependents = auth()->user()->dependents()->get();
        return view('resident.request-document', compact('documentTypes', 'dependents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'document_type_id' => 'required|exists:document_types,id',
            'purpose' => 'required|string|max:1000',
            'attachments.*' => 'sometimes|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        // Create the document request
        // Observer will automatically create status history and notification
        $documentRequest = DocumentRequest::create([
            'user_id' => auth()->id(),
            'document_type_id' => $request->document_type_id,
            'purpose' => $request->purpose,
            'status' => 'pending',
            'reference_number' => 'REF' . str_pad(DocumentRequest::count() + 1, 4, '0', STR_PAD_LEFT),
            'dependent_id' => $request->dependent_id ?? null,
        ]);

        // Handle file uploads if any
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('document-requests');
                $documentRequest->uploadedDocuments()->create([
                    'file_path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }

        return redirect()->route('request.track')
            ->with('success', 'Document request submitted successfully. Your reference number is ' . $documentRequest->reference_number);
    }
}