@extends('layouts.resident')

@section('title', 'Submit Document Request')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Submit Document Request</h1>

            <!-- Registered Dependents Section -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 style="color: #ff6b35; margin-bottom: 20px;">Registered Dependents ({{ isset($dependents) ? count($dependents) : 0 }})</h5>
                    
                    @if(isset($dependents) && count($dependents) > 0)
                        <div class="row mb-4">
                            @foreach($dependents as $dependent)
                                <div class="col-md-6 mb-3">
                                    <div class="card border" style="border-color: #e2e8f0;">
                                        <div class="card-body p-3">
                                            <div style="display: flex; justify-content: space-between; align-items: start;">
                                                <div>
                                                    <h6 style="color: #2d3748; font-weight: 600; margin-bottom: 4px;">
                                                        {{ $dependent->first_name }} {{ $dependent->last_name }}
                                                    </h6>
                                                    <small style="color: #718096;">
                                                        <strong>Relationship:</strong> {{ ucfirst($dependent->relationship ?? 'N/A') }}
                                                    </small>
                                                    <br>
                                                    <small style="color: #718096;">
                                                        <strong>Age:</strong> {{ \Carbon\Carbon::parse($dependent->date_of_birth)->age ?? 'N/A' }} years old
                                                    </small>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeDependent({{ $dependent->id }})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p style="color: #718096; margin-bottom: 20px;">No registered dependents.</p>
                    @endif

                    <!-- Add New Dependents Button -->
                    <button type="button" class="btn btn-lg w-100" style="background-color: #ff6b35; color: white; border: none; font-weight: 600; padding: 12px 24px;" data-bs-toggle="modal" data-bs-target="#addDependentModal">
                        <i class="fas fa-plus"></i> Add New Dependents
                    </button>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('document.request.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Document Type -->
                        <div class="mb-4">
                            <label for="document_type" class="form-label">
                                Document Type
                                <span style="color: #ff6b35;">*</span>
                            </label>
                            <select class="form-select @error('document_type_id') is-invalid @enderror" id="document_type" name="document_type_id" required>
                                <option value="">Select a document type</option>
                                @if(isset($documentTypes) && count($documentTypes) > 0)
                                    @foreach($documentTypes as $type)
                                        <option value="{{ $type->id }}" {{ old('document_type_id') == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="1">Barangay Clearance</option>
                                    <option value="2">Certificate of Residency</option>
                                    <option value="3">Indigency Certificate</option>
                                @endif
                            </select>
                            @error('document_type_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Purpose -->
                        <div class="mb-4">
                            <label for="purpose" class="form-label">
                                Purpose
                                <span style="color: #ff6b35;">*</span>
                            </label>
                            <textarea class="form-control @error('purpose') is-invalid @enderror" id="purpose" name="purpose" rows="4" placeholder="Please specify the purpose of your request..." required>{{ old('purpose') }}</textarea>
                            @error('purpose')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Request for Dependent -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="for_dependent" name="for_dependent" value="1" {{ old('for_dependent') ? 'checked' : '' }} onchange="toggleDependentSelect()">
                                <label class="form-check-label" for="for_dependent">
                                    Request this document for a registered dependent?
                                </label>
                            </div>
                        </div>

                        <!-- Dependent Select (hidden by default) -->
                        <div class="mb-4" id="dependent-section" style="display: {{ old('for_dependent') ? 'block' : 'none' }};">
                            <label for="dependent_id" class="form-label">Select Dependent</label>
                            <select class="form-select" id="dependent_id" name="dependent_id">
                                <option value="">--Select Dependent--</option>
                                @if(isset($dependents) && count($dependents) > 0)
                                    @foreach($dependents as $dependent)
                                        <option value="{{ $dependent->id }}" {{ old('dependent_id') == $dependent->id ? 'selected' : '' }}>
                                            {{ $dependent->first_name }} {{ $dependent->last_name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <!-- Important Notice -->
                        <div class="alert alert-light border-start border-5" style="border-color: #ff6b35 !important; padding: 16px 20px;">
                            <strong style="color: #ff6b35;">Important:</strong>
                            <p class="mb-0" style="color: #4a5568; margin-top: 8px;">
                                There is <strong>*no file upload*</strong> required at this stage. Please bring all necessary verification documents (IDs, proof of address) when you claim the completed document at the Barangay Office.
                            </p>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-lg" style="background-color: #ff6b35; color: white; border: none; font-weight: 600; padding: 12px 24px;">
                                Submit Request
                            </button>
                        </div>

                        @if($errors->any())
                            <div class="alert alert-danger mt-3">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleDependentSelect() {
    const checkbox = document.getElementById('for_dependent');
    const section = document.getElementById('dependent-section');
    section.style.display = checkbox.checked ? 'block' : 'none';
}

function removeDependent(dependentId) {
    if (confirm('Are you sure you want to remove this dependent?')) {
        // TODO: Implement dependent removal via AJAX
        console.log('Remove dependent:', dependentId);
    }
}
</script>

<!-- Add Dependent Modal -->
<div class="modal fade" id="addDependentModal" tabindex="-1" aria-labelledby="addDependentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #f8f9fa; border-bottom: 2px solid #e2e8f0;">
                <h5 class="modal-title" id="addDependentModalLabel" style="color: #2d3748; font-weight: 600;">
                    <i class="fas fa-user-plus"></i> Add New Dependent
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addDependentForm" method="POST" action="{{ route('dependent.store') }}">
                @csrf
                <div class="modal-body">
                    @if($errors->any())
                        <div class="alert alert-danger mb-3">
                            <strong>Please fix the following errors:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success mb-3">
                            {{ session('success') }}
                        </div>
                    @endif
                    <!-- Name -->
                    <div class="mb-3">
                        <label for="dependent_first_name" class="form-label">
                            First Name
                            <span style="color: #ff6b35;">*</span>
                        </label>
                        <input type="text" class="form-control" id="dependent_first_name" name="first_name" required>
                    </div>

                    <!-- Last Name -->
                    <div class="mb-3">
                        <label for="dependent_last_name" class="form-label">
                            Last Name
                            <span style="color: #ff6b35;">*</span>
                        </label>
                        <input type="text" class="form-control" id="dependent_last_name" name="last_name" required>
                    </div>

                    <!-- Relationship -->
                    <div class="mb-3">
                        <label for="dependent_relationship" class="form-label">
                            Relationship
                            <span style="color: #ff6b35;">*</span>
                        </label>
                        <select class="form-select" id="dependent_relationship" name="relationship" required>
                            <option value="">Select relationship</option>
                            <option value="child">Child</option>
                            <option value="spouse">Spouse</option>
                            <option value="parent">Parent</option>
                            <option value="sibling">Sibling</option>
                            <option value="grandchild">Grandchild</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <!-- Date of Birth -->
                    <div class="mb-3">
                        <label for="dependent_dob" class="form-label">
                            Date of Birth
                            <span style="color: #ff6b35;">*</span>
                        </label>
                        <input type="date" class="form-control" id="dependent_dob" name="date_of_birth" required>
                    </div>

                    <!-- Gender -->
                    <div class="mb-3">
                        <label for="dependent_gender" class="form-label">
                            Gender
                            <span style="color: #ff6b35;">*</span>
                        </label>
                        <select class="form-select" id="dependent_gender" name="gender" required>
                            <option value="">Select gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>

                    <!-- Civil Status -->
                    <div class="mb-3">
                        <label for="dependent_civil_status" class="form-label">
                            Civil Status
                            <span style="color: #ff6b35;">*</span>
                        </label>
                        <select class="form-select" id="dependent_civil_status" name="civil_status" required>
                            <option value="">Select civil status</option>
                            <option value="single">Single</option>
                            <option value="married">Married</option>
                            <option value="widowed">Widowed</option>
                            <option value="separated">Separated</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 2px solid #e2e8f0;">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn" style="background-color: #ff6b35; color: white; font-weight: 600;">
                        <i class="fas fa-save"></i> Save Dependent
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
