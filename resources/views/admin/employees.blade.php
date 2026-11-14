@extends('layouts.dashboard')

@section('title', 'Manage Employees')
@section('header_title', 'Staff Management & Supervision')
@section('header_subtitle', 'Monitor staff, enforce account access, or enter dashboards in shadow mode')

@section('content')

<!-- Summary metrics -->
<div class="metrics-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); margin-bottom: 24px;">
    <div class="metric-card">
        <div class="metric-info">
            <h5>Total Registered Staff</h5>
            <div class="metric-value">{{ $employees->count() }}</div>
        </div>
        <div class="metric-icon-box icon-blue"><i class="fa-solid fa-users"></i></div>
    </div>
    <div class="metric-card">
        <div class="metric-info">
            <h5>Active on Duty</h5>
            <div class="metric-value" style="color: #34d399;">{{ $activeCount }}</div>
        </div>
        <div class="metric-icon-box icon-green"><i class="fa-solid fa-user-check"></i></div>
    </div>
    <div class="metric-card">
        <div class="metric-info">
            <h5>Kicked / Suspended</h5>
            <div class="metric-value" style="color: #f87171;">{{ $kickedCount }}</div>
        </div>
        <div class="metric-icon-box icon-red"><i class="fa-solid fa-user-xmark"></i></div>
    </div>
</div>

<!-- Main Employee Management Table Panel -->
<div class="db-panel">
    <div class="db-panel-header">
        <div>
            <div class="panel-title">
                <i class="fa-solid fa-users-gear"></i> Employee Roster & Privileges
            </div>
            <p style="font-size: 0.78rem; color: var(--db-text-muted); margin-top: 4px;">
                Direct access controls: Terminate/kick access instantly or inspect workspaces via covert shadow mode.
            </p>
        </div>
        <button type="button" class="btn-db btn-db-gold" onclick="openAddEmployeeModal()">
            <i class="fa-solid fa-user-plus"></i> Add New Employee
        </button>
    </div>

    <div class="db-table-responsive">
        <table class="db-table">
            <thead>
                <tr>
                    <th>Employee Details</th>
                    <th>Department & Role</th>
                    <th>Contact Phone</th>
                    <th>Status</th>
                    <th>Last Active</th>
                    <th style="text-align: right;">Admin Powers</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $emp)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <img src="{{ $emp->avatar ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=200&q=80' }}" alt="{{ $emp->name }}" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(223, 194, 133, 0.3);">
                                <div>
                                    <div style="font-weight: 700; color: #fff; font-size: 0.95rem;">{{ $emp->name }}</div>
                                    <div style="font-size: 0.75rem; color: var(--db-text-muted);">{{ $emp->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: #e2e8f0;">{{ $emp->designation ?? 'Operations Specialist' }}</div>
                            <div style="font-size: 0.72rem; color: var(--db-gold); font-weight: 600; text-transform: uppercase;">{{ $emp->department ?? 'General' }}</div>
                        </td>
                        <td>
                            <div style="font-size: 0.82rem; color: #cbd5e1;">
                                <i class="fa-solid fa-phone" style="color: var(--db-gold-dark); margin-right: 4px;"></i>
                                {{ $emp->phone ?? 'N/A' }}
                            </div>
                        </td>
                        <td>
                            @if($emp->status === 'active')
                                <span class="status-badge badge-active">
                                    <i class="fa-solid fa-circle-check"></i> Active
                                </span>
                            @else
                                <span class="status-badge badge-kicked" title="Reason: {{ $emp->kick_reason }}">
                                    <i class="fa-solid fa-ban"></i> Kicked / Suspended
                                </span>
                                @if($emp->kick_reason)
                                    <div style="font-size: 0.68rem; color: #f87171; margin-top: 3px; max-width: 140px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        "{{ $emp->kick_reason }}"
                                    </div>
                                @endif
                            @endif
                        </td>
                        <td>
                            <div style="font-size: 0.8rem; color: var(--db-text-dim);">
                                {{ $emp->last_active_at ? $emp->last_active_at->diffForHumans() : 'Never logged in' }}
                            </div>
                        </td>
                        <td>
                            <div class="btn-action-group" style="justify-content: flex-end;">
                                <!-- 1. Shadow Mode: Login As Employee without notifying them -->
                                @if($emp->status === 'active')
                                    <form action="{{ route('admin.impersonate.enter', $emp->id) }}" method="POST" style="margin: 0;">
                                        @csrf
                                        <button type="submit" class="btn-db btn-db-impersonate" title="Enter {{ $emp->name }}'s workspace covertly without alerting them">
                                            <i class="fa-solid fa-user-secret"></i>
                                            <span>Shadow Mode</span>
                                        </button>
                                    </form>
                                @endif

                                <!-- 2. Kick or Reactivate Employee -->
                                @if($emp->status === 'active')
                                    <button type="button" class="btn-db btn-db-kick" onclick="openKickModal('{{ $emp->id }}', '{{ addslashes($emp->name) }}')">
                                        <i class="fa-solid fa-gavel"></i>
                                        <span>Kick</span>
                                    </button>
                                @else
                                    <form action="{{ route('admin.employees.kick', $emp->id) }}" method="POST" style="margin: 0;">
                                        @csrf
                                        <button type="submit" class="btn-db btn-db-unkick" title="Reactivate employee access">
                                            <i class="fa-solid fa-rotate-left"></i>
                                            <span>Reactivate</span>
                                        </button>
                                    </form>
                                @endif

                                <!-- 3. Delete Employee -->
                                <form action="{{ route('admin.employees.delete', $emp->id) }}" method="POST" style="margin: 0;" data-confirm="Are you sure you want to permanently delete employee {{ addslashes($emp->name) }}?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-db btn-db-outline" style="color: #ef4444; border-color: rgba(239, 68, 68, 0.3);" title="Delete Employee Record">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--db-text-dim); padding: 40px;">
                            No employee accounts currently registered. Click "Add New Employee" to onboard staff.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Kick Confirmation -->
<div class="db-modal-backdrop" id="kickEmployeeModal">
    <div class="db-modal-dialog">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h3 style="color: #f87171; font-size: 1.15rem; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-triangle-exclamation"></i> Kick & Suspend Employee
            </h3>
            <button type="button" class="btn-db btn-db-outline" onclick="closeKickModal()" style="padding: 4px 8px;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <p style="font-size: 0.85rem; color: #cbd5e1; margin-bottom: 16px;">
            You are about to kick <strong id="kickEmployeeTargetName" style="color: #fff;"></strong>. 
            Their active session will be invalidated immediately, logging them out of all browser terminals in real time.
        </p>

        <form id="kickEmployeeForm" method="POST" action="">
            @csrf
            <div class="db-form-group">
                <label class="db-form-label" for="kick_reason">Reason for Suspension / Kick (Optional)</label>
                <textarea name="kick_reason" id="kick_reason" rows="3" class="db-form-textarea" placeholder="e.g. Disciplinary suspension, breach of store policy, or administrative review..."></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button type="button" class="btn-db btn-db-outline" onclick="closeKickModal()">Cancel</button>
                <button type="submit" class="btn-db btn-db-kick" style="padding: 9px 18px;">
                    <i class="fa-solid fa-ban"></i> Confirm Kick & Revoke Access
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Add New Employee -->
<div class="db-modal-backdrop" id="addEmployeeModal">
    <div class="db-modal-dialog" style="max-width: 580px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
            <h3 style="color: var(--db-gold); font-size: 1.2rem; font-family: 'Cinzel', serif;">
                <i class="fa-solid fa-user-plus"></i> Onboard New Staff Member
            </h3>
            <button type="button" class="btn-db btn-db-outline" onclick="closeAddEmployeeModal()" style="padding: 4px 8px;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="{{ route('admin.employees.store') }}" method="POST">
            @csrf

            <div class="db-form-row-2">
                <div class="db-form-group">
                    <label class="db-form-label" for="new_name">Full Name *</label>
                    <input type="text" name="name" id="new_name" class="db-form-input" placeholder="e.g. Daniyal Qureshi" required>
                </div>

                <div class="db-form-group">
                    <label class="db-form-label" for="new_email">Work Email *</label>
                    <input type="email" name="email" id="new_email" class="db-form-input" placeholder="daniyal@rivaaj.com" required>
                </div>
            </div>

            <div class="db-form-row-2">
                <div class="db-form-group">
                    <label class="db-form-label" for="new_dept">Department *</label>
                    <select name="department" id="new_dept" class="db-form-select" required>
                        <option value="Logistics & Dispatch">Logistics & Dispatch</option>
                        <option value="Customer Support">Customer Support</option>
                        <option value="Stock & Warehouse">Stock & Warehouse</option>
                        <option value="Operations & Quality">Operations & Quality</option>
                    </select>
                </div>

                <div class="db-form-group">
                    <label class="db-form-label" for="new_designation">Designation / Role Title *</label>
                    <input type="text" name="designation" id="new_designation" class="db-form-input" placeholder="e.g. Order Dispatch Lead" required>
                </div>
            </div>

            <div class="db-form-row-2">
                <div class="db-form-group">
                    <label class="db-form-label" for="new_phone">Contact Phone</label>
                    <input type="text" name="phone" id="new_phone" class="db-form-input" placeholder="0300-XXXXXXX">
                </div>

                <div class="db-form-group">
                    <label class="db-form-label" for="new_password">Initial Password *</label>
                    <input type="password" name="password" id="new_password" class="db-form-input" placeholder="Minimum 6 characters" required>
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button type="button" class="btn-db btn-db-outline" onclick="closeAddEmployeeModal()">Cancel</button>
                <button type="submit" class="btn-db btn-db-gold" style="padding: 9px 20px;">
                    <i class="fa-solid fa-check"></i> Register Employee
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openKickModal(employeeId, employeeName) {
        const form = document.getElementById('kickEmployeeForm');
        form.action = `/admin/employees/${employeeId}/kick`;
        document.getElementById('kickEmployeeTargetName').innerText = employeeName;
        document.getElementById('kickEmployeeModal').classList.add('is-open');
    }

    function closeKickModal() {
        document.getElementById('kickEmployeeModal').classList.remove('is-open');
    }

    function openAddEmployeeModal() {
        document.getElementById('addEmployeeModal').classList.add('is-open');
    }

    function closeAddEmployeeModal() {
        document.getElementById('addEmployeeModal').classList.remove('is-open');
    }
</script>
@endpush

@endsection
