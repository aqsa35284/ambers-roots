@extends('layouts.dashboard')

@section('title', 'Customer Reviews Moderation')
@section('header_title', 'Customer Reviews Moderation')
@section('header_subtitle', 'Approve, reject, and manage authentic customer testimonials for store display')

@section('content')

<!-- Reviews Summary Metrics Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 16px; margin-bottom: 24px;">
    <div class="db-panel" style="padding: 18px 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(223, 194, 133, 0.15); border: 1px solid rgba(223, 194, 133, 0.3); display: flex; align-items: center; justify-content: center; color: var(--db-gold); font-size: 1.3rem;">
            <i class="fa-solid fa-comments"></i>
        </div>
        <div>
            <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--db-text-muted);">Total Reviews</div>
            <div style="font-size: 1.5rem; font-weight: 800; color: #fff; font-family: 'Cinzel', serif;">{{ $counts['all'] }}</div>
        </div>
    </div>

    <div class="db-panel" style="padding: 18px 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(234, 179, 8, 0.15); border: 1px solid rgba(234, 179, 8, 0.3); display: flex; align-items: center; justify-content: center; color: #eab308; font-size: 1.3rem;">
            <i class="fa-solid fa-clock"></i>
        </div>
        <div>
            <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--db-text-muted);">Pending Approvals</div>
            <div style="font-size: 1.5rem; font-weight: 800; color: #facc15; font-family: 'Cinzel', serif;">{{ $counts['pending'] }}</div>
        </div>
    </div>

    <div class="db-panel" style="padding: 18px 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(52, 211, 153, 0.15); border: 1px solid rgba(52, 211, 153, 0.3); display: flex; align-items: center; justify-content: center; color: #34d399; font-size: 1.3rem;">
            <i class="fa-solid fa-circle-check"></i>
        </div>
        <div>
            <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--db-text-muted);">Approved Live</div>
            <div style="font-size: 1.5rem; font-weight: 800; color: #34d399; font-family: 'Cinzel', serif;">{{ $counts['approved'] }}</div>
        </div>
    </div>

    <div class="db-panel" style="padding: 18px 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(223, 194, 133, 0.15); border: 1px solid rgba(223, 194, 133, 0.3); display: flex; align-items: center; justify-content: center; color: #facc15; font-size: 1.3rem;">
            <i class="fa-solid fa-star"></i>
        </div>
        <div>
            <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--db-text-muted);">Average Rating</div>
            <div style="font-size: 1.5rem; font-weight: 800; color: #fff; font-family: 'Cinzel', serif;">
                {{ $averageRating }} <span style="font-size: 0.9rem; color: #94a3b8; font-family: sans-serif;">/ 5.0</span>
            </div>
        </div>
    </div>
</div>

<!-- Filter Tabs & Search Bar -->
<div style="display: flex; justify-content: space-between; align-items: center; gap: 14px; flex-wrap: wrap; margin-bottom: 20px;">
    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
        <a href="{{ route('admin.reviews') }}" class="btn-db {{ !$status ? 'btn-db-gold' : 'btn-db-outline' }}">
            All Reviews ({{ $counts['all'] }})
        </a>
        <a href="{{ route('admin.reviews', ['status' => 'pending']) }}" class="btn-db {{ $status === 'pending' ? 'btn-db-gold' : 'btn-db-outline' }}">
            <i class="fa-solid fa-clock"></i> Pending ({{ $counts['pending'] }})
        </a>
        <a href="{{ route('admin.reviews', ['status' => 'approved']) }}" class="btn-db {{ $status === 'approved' ? 'btn-db-gold' : 'btn-db-outline' }}">
            <i class="fa-solid fa-circle-check"></i> Approved Live ({{ $counts['approved'] }})
        </a>
        <a href="{{ route('admin.reviews', ['status' => 'rejected']) }}" class="btn-db {{ $status === 'rejected' ? 'btn-db-gold' : 'btn-db-outline' }}">
            <i class="fa-solid fa-ban"></i> Rejected ({{ $counts['rejected'] }})
        </a>
    </div>

    <!-- Search input -->
    <form action="{{ route('admin.reviews') }}" method="GET" style="display: flex; gap: 8px; margin: 0;">
        @if($status)
            <input type="hidden" name="status" value="{{ $status }}">
        @endif
        <input type="text" name="q" value="{{ $search }}" placeholder="Search customer or review..." class="db-form-input" style="width: 240px; padding: 7px 12px; font-size: 0.85rem;">
        <button type="submit" class="btn-db btn-db-outline" style="padding: 7px 14px;">
            <i class="fa-solid fa-search"></i>
        </button>
        @if($search)
            <a href="{{ route('admin.reviews', $status ? ['status' => $status] : []) }}" class="btn-db btn-db-outline" style="padding: 7px 12px;" title="Clear Search">
                <i class="fa-solid fa-xmark"></i>
            </a>
        @endif
    </form>
</div>

<!-- Reviews Table Panel -->
<div class="db-panel">
    <div class="db-panel-header">
        <div class="panel-title">
            <i class="fa-solid fa-star-half-stroke"></i> Customer Reviews & Testimonials
        </div>
        <div style="font-size: 0.8rem; color: var(--db-text-muted);">
            Showing {{ $reviews->count() }} of {{ $reviews->total() }} records
        </div>
    </div>

    <div class="db-table-responsive">
        <table class="db-table">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Product</th>
                    <th>Rating</th>
                    <th>Review Content</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th style="text-align: right;">Moderation</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $rev)
                    <tr>
                        <td>
                            <div style="font-weight: 700; color: #fff;">{{ $rev->customer_name }}</div>
                            @if($rev->customer_phone)
                                <div style="font-size: 0.75rem; color: #94a3b8;">
                                    <i class="fa-solid fa-phone" style="color: var(--db-gold);"></i> {{ $rev->customer_phone }}
                                </div>
                            @endif
                        </td>
                        <td>
                            <div style="font-size: 0.82rem; color: #e2e8f0; font-weight: 600;">
                                {{ $rev->product->title ?? "Amber's Roots Herbal Oil" }}
                            </div>
                        </td>
                        <td>
                            <div style="color: #eab308; font-size: 0.85rem; white-space: nowrap;">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $rev->rating)
                                        <i class="fa-solid fa-star"></i>
                                    @else
                                        <i class="fa-regular fa-star" style="color: #475569;"></i>
                                    @endif
                                @endfor
                                <span style="color: #fff; font-weight: 700; margin-left: 4px;">{{ $rev->rating }}.0</span>
                            </div>
                        </td>
                        <td style="max-width: 320px;">
                            <div style="font-size: 0.83rem; color: #cbd5e1; line-height: 1.5;">
                                "{{ $rev->review_text }}"
                            </div>
                        </td>
                        <td>
                            <span style="font-size: 0.75rem; color: var(--db-text-dim);">
                                {{ $rev->created_at->format('d M Y') }}
                            </span>
                        </td>
                        <td>
                            @if($rev->status === 'approved')
                                <span class="status-badge badge-active" style="display: inline-flex; align-items: center; gap: 4px;">
                                    <i class="fa-solid fa-check"></i> Approved Live
                                </span>
                            @elseif($rev->status === 'pending')
                                <span class="status-badge badge-pending" style="display: inline-flex; align-items: center; gap: 4px;">
                                    <i class="fa-solid fa-clock"></i> Pending Review
                                </span>
                            @else
                                <span class="status-badge badge-kicked" style="display: inline-flex; align-items: center; gap: 4px;">
                                    <i class="fa-solid fa-ban"></i> Rejected
                                </span>
                            @endif
                        </td>
                        <td style="text-align: right; white-space: nowrap;">
                            <div style="display: inline-flex; gap: 6px;">
                                @if($rev->status !== 'approved')
                                    <form action="{{ route('admin.reviews.update', $rev->id) }}" method="POST" style="margin: 0;">
                                        @csrf
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="btn-db btn-db-outline" style="color: #34d399; border-color: rgba(52, 211, 153, 0.4); padding: 5px 10px;" title="Approve Review for Website Display">
                                            <i class="fa-solid fa-check"></i> Approve
                                        </button>
                                    </form>
                                @endif

                                @if($rev->status !== 'rejected')
                                    <form action="{{ route('admin.reviews.update', $rev->id) }}" method="POST" style="margin: 0;">
                                        @csrf
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="btn-db btn-db-outline" style="color: #f59e0b; border-color: rgba(245, 158, 11, 0.4); padding: 5px 10px;" title="Reject Review">
                                            <i class="fa-solid fa-ban"></i> Reject
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('admin.reviews.delete', $rev->id) }}" method="POST" style="margin: 0;" data-confirm="Permanently delete review by '{{ addslashes($rev->customer_name) }}'?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-db btn-db-outline" style="color: #f87171; border-color: rgba(239, 68, 68, 0.4); padding: 5px 10px;" title="Delete Review">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--db-text-dim); padding: 40px;">
                            No reviews found matching the criteria.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($reviews->hasPages())
        <div style="padding: 16px 20px; border-top: 1px solid rgba(255, 255, 255, 0.05);">
            {{ $reviews->links() }}
        </div>
    @endif
</div>

@endsection

