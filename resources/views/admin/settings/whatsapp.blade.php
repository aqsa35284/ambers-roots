@extends('layouts.dashboard')

@section('title', 'WhatsApp Settings')
@section('header_title', 'WhatsApp Integration & Number Settings')
@section('header_subtitle', 'Update official WhatsApp number, automated order messages, and customer checkout redirect')

@section('content')

<div style="max-width: 840px;">
    
    <!-- Active Status Card -->
    <div class="db-panel" style="margin-bottom: 24px; border-left: 4px solid #25d366;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="width: 52px; height: 52px; border-radius: 12px; background: rgba(37, 211, 102, 0.15); border: 1px solid rgba(37, 211, 102, 0.3); display: flex; align-items: center; justify-content: center; color: #25d366; font-size: 1.8rem;">
                    <i class="fa-brands fa-whatsapp"></i>
                </div>
                <div>
                    <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--db-text-muted);">Current Active WhatsApp Number</div>
                    <div style="font-size: 1.5rem; font-weight: 800; color: #fff; font-family: monospace;">
                        +{{ $whatsappNumber }}
                    </div>
                </div>
            </div>

            <div>
                <a href="https://wa.me/{{ $whatsappNumber }}?text={{ rawurlencode("Test message from Amber's Roots admin dashboard.") }}" target="_blank" class="btn-db" style="background: #25d366; color: #ffffff; padding: 10px 20px; font-weight: 700;">
                    <i class="fa-brands fa-whatsapp"></i> Test WhatsApp Link
                </a>
            </div>
        </div>
    </div>

    <!-- Settings Form -->
    <div class="db-panel">
        <div class="db-panel-header">
            <div class="panel-title">
                <i class="fa-solid fa-sliders"></i> Configure WhatsApp Parameters
            </div>
        </div>

        <form action="{{ route('admin.settings.whatsapp.update') }}" method="POST" style="padding: 20px 24px;">
            @csrf

            <!-- WhatsApp Number Input -->
            <div class="db-form-group">
                <label class="db-form-label" for="wa_number">
                    Official WhatsApp Phone Number *
                </label>
                <div style="position: relative;">
                    <i class="fa-brands fa-whatsapp" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #25d366; font-size: 1.2rem;"></i>
                    <input type="text" name="whatsapp_number" id="wa_number" value="{{ $whatsappNumber }}" class="db-form-input" style="padding-left: 44px; font-size: 1.05rem; font-family: monospace; font-weight: 700; color: #fff;" placeholder="e.g. 923272222180 or 03272222180" required>
                </div>
                <div style="font-size: 0.75rem; color: var(--db-text-dim); margin-top: 6px;">
                    Enter Pakistan mobile number (e.g. <code>923272222180</code> or <code>03272222180</code>). System automatically formats international prefix.
                </div>
            </div>

            <!-- WhatsApp Message Template -->
            <div class="db-form-group">
                <label class="db-form-label" for="wa_template">
                    Order Confirmation WhatsApp Message Template
                </label>
                <textarea name="whatsapp_template" id="wa_template" rows="7" class="db-form-textarea" style="font-family: monospace; font-size: 0.88rem; line-height: 1.6;">{{ $whatsappTemplate }}</textarea>
                
                <div style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px; padding: 12px; margin-top: 10px;">
                    <div style="font-size: 0.78rem; font-weight: 700; color: var(--db-gold); margin-bottom: 6px;">Available Template Variables:</div>
                    <div style="display: flex; gap: 8px; flex-wrap: wrap; font-size: 0.75rem; color: #cbd5e1; font-family: monospace;">
                        <span style="background: rgba(0,0,0,0.3); padding: 2px 6px; border-radius: 4px;">{order_number}</span>
                        <span style="background: rgba(0,0,0,0.3); padding: 2px 6px; border-radius: 4px;">{customer_name}</span>
                        <span style="background: rgba(0,0,0,0.3); padding: 2px 6px; border-radius: 4px;">{customer_phone}</span>
                        <span style="background: rgba(0,0,0,0.3); padding: 2px 6px; border-radius: 4px;">{shipping_address}</span>
                        <span style="background: rgba(0,0,0,0.3); padding: 2px 6px; border-radius: 4px;">{city}</span>
                        <span style="background: rgba(0,0,0,0.3); padding: 2px 6px; border-radius: 4px;">{items}</span>
                        <span style="background: rgba(0,0,0,0.3); padding: 2px 6px; border-radius: 4px;">{total}</span>
                    </div>
                </div>
            </div>

            <!-- Auto-open Checkbox -->
            <div style="background: rgba(0, 0, 0, 0.2); border-radius: 8px; padding: 14px 16px; margin-bottom: 24px;">
                <label style="display: flex; align-items: flex-start; gap: 12px; cursor: pointer; color: #fff; font-size: 0.88rem;">
                    <input type="checkbox" name="whatsapp_auto_open" value="1" {{ $whatsappAutoOpen ? 'checked' : '' }} style="accent-color: #25d366; width: 18px; height: 18px; margin-top: 2px;">
                    <div>
                        <strong>Automatically Open WhatsApp After Saving Order</strong>
                        <div style="font-size: 0.75rem; color: var(--db-text-muted); margin-top: 2px;">
                            When checked, the customer's order is saved into the database, and WhatsApp will immediately launch in a new tab with the pre-filled order text.
                        </div>
                    </div>
                </label>
            </div>

            <div style="display: flex; justify-content: flex-end;">
                <button type="submit" class="btn-db btn-db-gold" style="padding: 12px 28px; font-size: 0.95rem;">
                    <i class="fa-solid fa-save"></i> Save WhatsApp Settings
                </button>
            </div>
        </form>
    </div>

</div>

@endsection

