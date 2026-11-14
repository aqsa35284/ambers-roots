<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Store new customer order in database and generate WhatsApp URL.
     * Orders are saved first with status 'Pending' before redirecting to WhatsApp.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:30'],
            'shipping_address' => ['required', 'string', 'max:500'],
            'city' => ['required', 'string', 'max:100'],
            'customer_email' => ['nullable', 'email', 'max:255'],
            'notes' => ['nullable', 'string', 'max:500'],
            'coupon_code' => ['nullable', 'string', 'max:50'],
            'items' => ['nullable', 'array'],
            'product_id' => ['nullable', 'integer'],
            'product_slug' => ['nullable', 'string'],
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $items = [];
        $subtotal = 0.0;

        // Multi-item cart submission
        if (!empty($validated['items']) && is_array($validated['items'])) {
            foreach ($validated['items'] as $item) {
                $qty = max(1, (int)($item['qty'] ?? $item['quantity'] ?? 1));
                $slug = $item['slug'] ?? null;
                $prodId = $item['product_id'] ?? $item['id'] ?? null;

                $product = null;
                if ($prodId) {
                    $product = Product::find($prodId);
                } elseif ($slug) {
                    $product = Product::where('slug', $slug)->first();
                }

                if ($product) {
                    $unitPrice = (float)$product->effective_price;
                    $title = $product->title;
                    $icon = $product->icon ?? 'fa-bottle-droplet';

                    // Decrement stock if available
                    if ($product->stock > 0) {
                        $product->decrement('stock', min($product->stock, $qty));
                    }
                } else {
                    $cleanPrice = preg_replace('/[^0-9.]/', '', (string)($item['price'] ?? 0));
                    $unitPrice = (float)($cleanPrice ?: 2450);
                    $title = $item['title'] ?? "Amber's Roots Herbal Hair Oil";
                    $icon = $item['icon'] ?? 'fa-bottle-droplet';
                }

                $lineTotal = $unitPrice * $qty;
                $subtotal += $lineTotal;

                $items[] = [
                    'product_id' => $product?->id,
                    'slug' => $product?->slug ?? ($slug ?? 'ambers-roots-hair-oil'),
                    'title' => $title,
                    'price' => $unitPrice,
                    'qty' => $qty,
                    'total' => $lineTotal,
                    'icon' => $icon,
                ];
            }
        } else {
            // Single product direct checkout
            $qty = max(1, (int)($validated['quantity'] ?? 1));
            $product = null;

            if (!empty($validated['product_id'])) {
                $product = Product::find($validated['product_id']);
            } elseif (!empty($validated['product_slug'])) {
                $product = Product::where('slug', $validated['product_slug'])->first();
            }

            if (!$product) {
                // Default to active Hair Oil
                $product = Product::active()->first() ?? Product::first();
            }

            if ($product) {
                $unitPrice = (float)$product->effective_price;
                $title = $product->title;
                $icon = $product->icon ?? 'fa-bottle-droplet';

                if ($product->stock > 0) {
                    $product->decrement('stock', min($product->stock, $qty));
                }
            } else {
                $unitPrice = 2450.0;
                $title = "Amber's Roots 100% Herbal Hair Growth Oil";
                $icon = 'fa-bottle-droplet';
            }

            $lineTotal = $unitPrice * $qty;
            $subtotal += $lineTotal;

            $items[] = [
                'product_id' => $product?->id,
                'slug' => $product?->slug ?? 'rivaaj-mahal-hair-oil',
                'title' => $title,
                'price' => $unitPrice,
                'qty' => $qty,
                'total' => $lineTotal,
                'icon' => $icon,
            ];
        }

        // Coupon calculation
        $discountAmount = 0.0;
        $appliedCoupon = null;
        if (!empty($validated['coupon_code'])) {
            $coupon = Coupon::where('code', strtoupper(trim($validated['coupon_code'])))->first();
            if ($coupon && $coupon->isValidForAmount($subtotal)) {
                $discountAmount = $coupon->calculateDiscount($subtotal);
                $appliedCoupon = $coupon->code;
            }
        }

        $shippingFee = 0.0; // Free express delivery across Pakistan
        $total = max(0.0, $subtotal - $discountAmount + $shippingFee);

        // Generate distinctive Order Number
        $orderNumber = 'AR-' . date('ymd') . '-' . str_pad((string)random_int(100, 9999), 4, '0', STR_PAD_LEFT);

        $notes = $validated['notes'] ?? '';
        if ($appliedCoupon) {
            $notes = trim($notes . " [Coupon applied: {$appliedCoupon} - Rs. {$discountAmount} OFF]");
        }

        // Save order to database first
        $order = Order::create([
            'order_number' => $orderNumber,
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'customer_email' => $validated['customer_email'] ?? null,
            'city' => $validated['city'],
            'shipping_address' => $validated['shipping_address'],
            'payment_method' => 'COD',
            'subtotal' => $subtotal,
            'shipping_fee' => $shippingFee,
            'total' => $total,
            'status' => 'Pending',
            'items' => $items,
            'notes' => $notes ?: null,
        ]);

        // Construct formatted WhatsApp message
        $itemsText = '';
        foreach ($items as $it) {
            $itemsText .= "• {$it['title']} (Qty: {$it['qty']}) - Rs. " . number_format($it['total']) . "\n";
        }

        $waMessage = "🌿 *New Order - Amber's Roots Herbal Care*\n"
            . "──────────────────────\n"
            . "📦 *Order Number:* #{$order->order_number}\n"
            . "👤 *Customer:* {$order->customer_name}\n"
            . "📞 *Phone:* {$order->customer_phone}\n"
            . "📍 *Address:* {$order->shipping_address}\n"
            . "🏙️ *City:* {$order->city}\n"
            . "──────────────────────\n"
            . "🛒 *Ordered Items:*\n"
            . $itemsText
            . "──────────────────────\n"
            . "💰 *Total Amount:* Rs. " . number_format($order->total) . "\n"
            . "🚚 *Delivery:* Free Express Shipping (COD)\n"
            . "💳 *Payment Method:* Cash on Delivery\n";

        if ($notes) {
            $waMessage .= "📝 *Notes:* {$notes}\n";
        }

        $waMessage .= "\nPlease confirm my order and share dispatch details. Thank you!";

        $rawWa = \App\Models\Setting::get('whatsapp_number', '923272222180');
        $whatsappPhone = preg_replace('/[^0-9]/', '', (string)$rawWa);
        if (str_starts_with($whatsappPhone, '0')) {
            $whatsappPhone = '92' . substr($whatsappPhone, 1);
        }
        $whatsappPhone = $whatsappPhone ?: '923272222180';
        $whatsappUrl = 'https://wa.me/' . $whatsappPhone . '?text=' . rawurlencode($waMessage);

        return response()->json([
            'success' => true,
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'total' => $order->total,
            'total_formatted' => 'Rs. ' . number_format($order->total),
            'customer_name' => $order->customer_name,
            'customer_phone' => $order->customer_phone,
            'shipping_address' => $order->shipping_address,
            'city' => $order->city,
            'items' => $items,
            'whatsapp_url' => $whatsappUrl,
            'message' => 'Your order has been recorded successfully! Tap to open WhatsApp for fast confirmation.',
        ]);
    }

    /**
     * Track Order page & search lookup.
     */
    public function track(Request $request): View|JsonResponse
    {
        $search = trim((string)$request->input('search', ''));
        $orders = collect();

        if ($search !== '') {
            $cleanSearch = str_replace('#', '', $search);
            $orders = Order::where('order_number', 'LIKE', "%{$cleanSearch}%")
                ->orWhere('customer_phone', 'LIKE', "%{$cleanSearch}%")
                ->latest()
                ->take(10)
                ->get();
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'count' => $orders->count(),
                'orders' => $orders,
            ]);
        }

        return view('track-order', compact('orders', 'search'));
    }

    /**
     * Apply & validate coupon code endpoint.
     */
    public function validateCoupon(Request $request): JsonResponse
    {
        $code = strtoupper(trim((string)$request->input('code', '')));
        $subtotal = (float)$request->input('subtotal', 0);

        if (!$code) {
            return response()->json(['valid' => false, 'message' => 'Please enter a coupon code.'], 422);
        }

        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon || !$coupon->is_active) {
            return response()->json(['valid' => false, 'message' => 'Invalid or inactive coupon code.'], 404);
        }

        if ($coupon->expires_at && $coupon->expires_at->isPast()) {
            return response()->json(['valid' => false, 'message' => 'This coupon has expired.'], 422);
        }

        if ($coupon->min_order_amount > 0 && $subtotal < $coupon->min_order_amount) {
            return response()->json([
                'valid' => false,
                'message' => 'Minimum order amount for this coupon is Rs. ' . number_format($coupon->min_order_amount) . '.',
            ], 422);
        }

        $discount = $coupon->calculateDiscount($subtotal);

        return response()->json([
            'valid' => true,
            'code' => $coupon->code,
            'discount' => $discount,
            'discount_formatted' => 'Rs. ' . number_format($discount),
            'message' => "Coupon {$coupon->code} applied successfully! You saved Rs. " . number_format($discount) . '.',
        ]);
    }
}
