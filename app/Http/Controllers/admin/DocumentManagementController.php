<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentType;
use App\Services\AuditService;
use App\Models\DocumentRequest;
use App\Services\SmsService; 
use Illuminate\Http\Request;

class DocumentManagementController extends Controller
{
    protected $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,processing,ready,completed,rejected',
            'send_sms' => 'boolean' // Add checkbox validation
        ]);

        $documentRequest = DocumentRequest::with('user')->findOrFail($id);
        $documentRequest->status = $request->status;
        $documentRequest->save();

        // Send SMS if checkbox is checked
        if ($request->send_sms && $documentRequest->user->phone) {
            $smsSent = $this->smsService->sendDocumentStatusUpdate(
                $documentRequest->user,
                $documentRequest,
                $request->status
            );

            if ($smsSent) {
                return redirect()->back()->with('success', 'Status updated and SMS notification sent!');
            } else {
                return redirect()->back()->with('warning', 'Status updated but SMS sending failed. Please check SMS service.');
            }
        }

        return redirect()->back()->with('success', 'Status updated successfully!');
    }
    
    public function index()
    {
        $documents = DocumentType::all();
        return view('admin.manage-documents', compact('documents'));
    }

    public function create()
    {
        return view('admin.documents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:document_types,code',
            'processing_fee' => 'required|numeric|min:0',
            'required_time' => 'required|string|max:100',
            'is_active' => 'boolean',
        ]);

        $document = DocumentType::create([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'fee' => $request->processing_fee,
            'processing_days' => $request->required_time,
            'is_active' => $request->is_active ?? true,
        ]);

        // Log the action
        AuditService::logDocumentCreated($document);

        return redirect()->route('admin.documents.index')->with('success', 'Document type added successfully');
    }

    public function edit($id)
    {
        $document = DocumentType::findOrFail($id);
        return view('admin.documents.edit', compact('document'));
    }

    public function update(Request $request, $id)
    {
        $document = DocumentType::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:document_types,code,' . $id,
            'processing_fee' => 'required|numeric|min:0',
            'required_time' => 'required|string|max:100',
            'is_active' => 'boolean',
        ]);

        // Store old data for audit log
        $oldData = $document->only('name', 'code', 'fee', 'processing_days', 'is_active');

        $document->update([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'fee' => $request->processing_fee,
            'processing_days' => $request->required_time,
            'is_active' => $request->is_active,
        ]);

        // Log the action
        AuditService::logDocumentUpdated($document, $oldData);

        return redirect()->route('admin.documents.index')->with('success', 'Document type updated successfully');
    }

    public function destroy($id)
    {
        $document = DocumentType::findOrFail($id);
        $documentName = $document->name;
        $documentId = $document->id;

        $document->delete();

        // Log the action
        AuditService::logDocumentDeleted($documentName, $documentId);

        return redirect()->route('admin.documents.index')->with('success', 'Document type deleted successfully');
    }

    
}

