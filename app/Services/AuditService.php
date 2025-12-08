<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditService
{
    /**
     * Log an action to the audit trail
     */
    public static function log(
        $action,
        $category = 'general',
        $description = null,
        $modelType = null,
        $modelId = null,
        $oldValues = null,
        $newValues = null
    ) {
        try {
            AuditLog::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'category' => $category,
                'description' => $description ?? $action,
                'model_type' => $modelType,
                'model_id' => $modelId,
                'old_values' => $oldValues,
                'new_values' => $newValues,
                'ip_address' => Request::ip(),
            ]);
        } catch (\Exception $e) {
            // Silently fail to not interrupt application flow
            \Log::error('Audit logging failed: ' . $e->getMessage());
        }
    }

    /**
     * Log staff creation
     */
    public static function logStaffCreated($staff)
    {
        self::log(
            'CREATED',
            'staff',
            "Created staff member: {$staff->first_name} {$staff->last_name}",
            'User',
            $staff->id,
            null,
            $staff->toArray()
        );
    }

    /**
     * Log staff update
     */
    public static function logStaffUpdated($staff, $oldData)
    {
        self::log(
            'UPDATED',
            'staff',
            "Updated staff member: {$staff->first_name} {$staff->last_name}",
            'User',
            $staff->id,
            $oldData,
            $staff->toArray()
        );
    }

    /**
     * Log staff deletion
     */
    public static function logStaffDeleted($staffName, $staffId)
    {
        self::log(
            'DELETED',
            'staff',
            "Deleted staff member: {$staffName}",
            'User',
            $staffId
        );
    }

    /**
     * Log document creation
     */
    public static function logDocumentCreated($document)
    {
        self::log(
            'CREATED',
            'document',
            "Created document type: {$document->name}",
            'DocumentType',
            $document->id,
            null,
            $document->toArray()
        );
    }

    /**
     * Log document update
     */
    public static function logDocumentUpdated($document, $oldData)
    {
        self::log(
            'UPDATED',
            'document',
            "Updated document type: {$document->name}",
            'DocumentType',
            $document->id,
            $oldData,
            $document->toArray()
        );
    }

    /**
     * Log document deletion
     */
    public static function logDocumentDeleted($documentName, $documentId)
    {
        self::log(
            'DELETED',
            'document',
            "Deleted document type: {$documentName}",
            'DocumentType',
            $documentId
        );
    }

    /**
     * Log request status change
     */
    public static function logRequestStatusChanged($requestId, $oldStatus, $newStatus, $userId = null)
    {
        self::log(
            'STATUS_CHANGED',
            'request',
            "Request #{$requestId} status changed from {$oldStatus} to {$newStatus}",
            'DocumentRequest',
            $requestId,
            ['status' => $oldStatus],
            ['status' => $newStatus]
        );
    }

    /**
     * Log login
     */
    public static function logLogin($user)
    {
        self::log(
            'LOGIN',
            'auth',
            "User logged in: {$user->first_name} {$user->last_name}",
            'User',
            $user->id
        );
    }

    /**
     * Log logout
     */
    public static function logLogout($user)
    {
        self::log(
            'LOGOUT',
            'auth',
            "User logged out: {$user->first_name} {$user->last_name}",
            'User',
            $user->id
        );
    }
}
