@extends('layouts.dashboard')

@section('title', 'Activity & Audit Logs')
@section('header_title', 'System Audit Trail')
@section('header_subtitle', 'Immutable logging of admin sessions, employee kicks, and shadow entries')

@section('content')

<div class="db-panel">
    <div class="db-panel-header">
        <div class="panel-title">
            <i class="fa-solid fa-fingerprint"></i> Activity & Security Audit Trail
        </div>
        <div style="font-size: 0.8rem; color: var(--db-text-muted);">
            Chronological records of administrator & employee operations
        </div>
    </div>

    <div class="db-table-responsive">
        <table class="db-table">
            <thead>
                <tr>
                    <th>Timestamp</th>
                    <th>User</th>
                    <th>Action</th>
                    <th>Details</th>
                    <th>IP Address</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td style="font-size: 0.78rem; color: var(--db-text-dim); white-space: nowrap;">
                            {{ $log->created_at->format('d M Y, h:i:s A') }}
                            <div style="font-size: 0.7rem; color: var(--db-gold);">{{ $log->created_at->diffForHumans() }}</div>
                        </td>
                        <td>
                            <strong style="color: #fff;">{{ $log->user_name }}</strong>
                        </td>
                        <td>
                            @if($log->action === 'kick_employee')
                                <span class="status-badge badge-kicked"><i class="fa-solid fa-ban"></i> Kick Employee</span>
                            @elseif($log->action === 'impersonate_start')
                                <span class="status-badge badge-pending"><i class="fa-solid fa-user-secret"></i> Shadow Mode Start</span>
                            @elseif($log->action === 'impersonate_end')
                                <span class="status-badge badge-processing"><i class="fa-solid fa-arrow-left"></i> Shadow Mode Return</span>
                            @elseif($log->action === 'unkick_employee')
                                <span class="status-badge badge-active"><i class="fa-solid fa-rotate-left"></i> Reactivate Employee</span>
                            @elseif($log->action === 'employee_created')
                                <span class="status-badge badge-processing"><i class="fa-solid fa-user-plus"></i> Staff Created</span>
                            @else
                                <span class="status-badge badge-active">{{ ucfirst(str_replace('_', ' ', $log->action)) }}</span>
                            @endif
                        </td>
                        <td style="color: #cbd5e1; font-size: 0.85rem;">
                            {{ $log->details }}
                        </td>
                        <td style="font-family: monospace; font-size: 0.78rem; color: #64748b;">
                            {{ $log->ip_address ?? '127.0.0.1' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: var(--db-text-dim); padding: 40px;">
                            No activity logs found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($logs->hasPages())
        <div style="padding: 16px 20px; border-top: 1px solid rgba(255, 255, 255, 0.05);">
            {{ $logs->links() }}
        </div>
    @endif
</div>

@endsection
