@extends('layouts.dashboard')

@section('title', 'Products & Stock')
@section('header_title', 'Product Catalog & Inventory')
@section('header_subtitle', 'View current stock levels and register new herbal products to the store catalog')

@section('content')

<div class="db-panel">
    <div class="db-panel-header">
        <div>
            <div class="panel-title">
                <i class="fa-solid fa-boxes-stacked"></i> Store Products & Stock ({{ count($products) }} SKUs)
            </div>
            <div style="font-size: 0.8rem; color: #34d399; margin-top: 4px;">
                <i class="fa-solid fa-check-double"></i> Live store catalog
            </div>
        </div>
        <button type="button" class="btn-db btn-db-gold" onclick="openAddProductModal()">
            <i class="fa-solid fa-plus"></i> Add New Product
        </button>
    </div>

    <div class="db-table-responsive">
        <table class="db-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Volume / Size</th>
                    <th>Price (PKR)</th>
                    <th>Original</th>
                    <th>Stock Level</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $slug => $prod)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 38px; height: 38px; border-radius: 8px; background: rgba(223, 194, 133, 0.12); border: 1px solid rgba(223, 194, 133, 0.3); display: flex; align-items: center; justify-content: center; color: var(--db-gold);">
                                    <i class="fa-solid {{ $prod['icon'] ?? 'fa-bottle-droplet' }}"></i>
                                </div>
                                <div>
                                    <div style="font-weight: 700; color: #fff;">{{ $prod['title'] }}</div>
                                    <div style="font-size: 0.72rem; color: var(--db-gold); font-weight: 600;">{{ $prod['badge'] ?? 'AUTHENTIC' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span style="font-size: 0.82rem; color: #cbd5e1;">{{ $prod['category_name'] ?? 'Herbal Care' }}</span>
                        </td>
                        <td>
                            <span style="font-size: 0.82rem; color: #94a3b8;">{{ $prod['volume'] ?? 'Standard' }}</span>
                        </td>
                        <td>
                            <strong style="color: #fff; font-family: 'Cinzel', serif; font-size: 0.95rem;">Rs. {{ number_format($prod['price']) }}</strong>
                        </td>
                        <td>
                            <span style="text-decoration: line-through; color: #64748b; font-size: 0.85rem;">
                                Rs. {{ number_format($prod['original_price'] ?? ($prod['price'] * 1.25)) }}
                            </span>
                        </td>
                        <td>
                            @php $stock = $prod['stock'] ?? 100; @endphp
                            @if($stock > 20)
                                <span class="status-badge badge-active">
                                    <i class="fa-solid fa-circle-check"></i> {{ $stock }} in Stock
                                </span>
                            @elseif($stock > 0)
                                <span class="status-badge badge-pending">
                                    <i class="fa-solid fa-triangle-exclamation"></i> Low Stock ({{ $stock }})
                                </span>
                            @else
                                <span class="status-badge badge-kicked">
                                    <i class="fa-solid fa-ban"></i> Out of Stock
                                </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Add New Product -->
<div class="db-modal-backdrop" id="addProductModal">
    <div class="db-modal-dialog" style="max-width: 600px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
            <h3 style="color: var(--db-gold); font-size: 1.25rem; font-family: 'Cinzel', serif;">
                <i class="fa-solid fa-plus-circle"></i> Add New Product to Store
            </h3>
            <button type="button" class="btn-db btn-db-outline" onclick="closeAddProductModal()" style="padding: 4px 8px;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="{{ route('employee.products.store') }}" method="POST">
            @csrf

            <div class="db-form-group">
                <label class="db-form-label" for="ep_title">Product Title *</label>
                <input type="text" name="title" id="ep_title" class="db-form-input" placeholder="e.g. Herbal Anti-Dandruff Scalp Tonic" required>
            </div>

            <div class="db-form-row-2">
                <div class="db-form-group">
                    <label class="db-form-label" for="ep_category">Category *</label>
                    <select name="category" id="ep_category" class="db-form-select" required>
                        <option value="hair-oil">Hair Oil</option>
                        <option value="shampoo">Botanical Shampoo</option>
                        <option value="serum">Scalp Serum</option>
                        <option value="skincare">Herbal Skincare</option>
                        <option value="bundle">Value Bundle</option>
                    </select>
                </div>

                <div class="db-form-group">
                    <label class="db-form-label" for="ep_volume">Volume / Size *</label>
                    <input type="text" name="volume" id="ep_volume" class="db-form-input" placeholder="e.g. 200ml, 100ml" required>
                </div>
            </div>

            <div class="db-form-row-3">
                <div class="db-form-group">
                    <label class="db-form-label" for="ep_price">Selling Price (PKR) *</label>
                    <input type="number" name="price" id="ep_price" class="db-form-input" placeholder="2450" min="1" required>
                </div>

                <div class="db-form-group">
                    <label class="db-form-label" for="ep_original">Original Price</label>
                    <input type="number" name="original_price" id="ep_original" class="db-form-input" placeholder="3200">
                </div>

                <div class="db-form-group">
                    <label class="db-form-label" for="ep_stock">Stock Quantity *</label>
                    <input type="number" name="stock" id="ep_stock" class="db-form-input" value="100" min="0" required>
                </div>
            </div>

            <div class="db-form-group">
                <label class="db-form-label" for="ep_desc">Short Description</label>
                <textarea name="short_desc" id="ep_desc" rows="2" class="db-form-textarea" placeholder="Key herbal benefits and product details..."></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button type="button" class="btn-db btn-db-outline" onclick="closeAddProductModal()">Cancel</button>
                <button type="submit" class="btn-db btn-db-gold" style="padding: 9px 22px;">
                    <i class="fa-solid fa-check"></i> Publish Product
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openAddProductModal() {
        document.getElementById('addProductModal').classList.add('is-open');
    }
    function closeAddProductModal() {
        document.getElementById('addProductModal').classList.remove('is-open');
    }
</script>
@endpush

@endsection
