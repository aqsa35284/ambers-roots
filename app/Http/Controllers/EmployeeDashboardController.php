<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\SupportTicket;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeDashboardController extends Controller
{
    /**
     * Employee Main Overview & Shift Hub - Redirects to full Store Operations Dashboard.
     */
    public function index()
    {
        return redirect()->route('admin.dashboard');
    }

    /**
     * Orders Fulfillment Sub-page.
     */
    public function orders(Request $request)
    {
        return redirect()->route('admin.orders');
    }

    /**
     * Update Order Fulfillment Status by Employee.
     */
    public function updateOrderStatus(Request $request, $id)
    {
        $employee = Auth::user();
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:Pending,Confirmed,Processing,Shipped,Dispatched,Delivered'],
            'courier_service' => ['nullable', 'string', 'max:50'],
            'tracking_number' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string'],
        ]);

        // Auto-assign to this employee if not assigned yet
        if (!$order->assigned_employee_id) {
            $validated['assigned_employee_id'] = $employee->id;
        }

        $order->update($validated);

        ActivityLog::create([
            'user_id' => $employee->id,
            'user_name' => $employee->name,
            'action' => 'employee_order_fulfill',
            'details' => "Employee {$employee->name} updated order #{$order->order_number} to status '{$order->status}'.",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', "Order #{$order->order_number} updated to {$order->status} successfully!");
    }

    /**
     * Customer Inquiries & Support Tickets Sub-page.
     */
    public function tickets()
    {
        $employee = Auth::user();
        $tickets = SupportTicket::latest()->paginate(15);

        return view('employee.tickets', compact('employee', 'tickets'));
    }

    /**
     * Update Support Ticket by Employee.
     */
    public function updateTicket(Request $request, $id)
    {
        $employee = Auth::user();
        $ticket = SupportTicket::findOrFail($id);

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:open,in_progress,resolved'],
            'resolution_notes' => ['nullable', 'string'],
        ]);

        if (!$ticket->assigned_employee_id) {
            $validated['assigned_employee_id'] = $employee->id;
        }

        $ticket->update($validated);

        ActivityLog::create([
            'user_id' => $employee->id,
            'user_name' => $employee->name,
            'action' => 'ticket_updated',
            'details' => "Employee {$employee->name} updated ticket #{$ticket->ticket_id} to '{$ticket->status}'.",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', "Ticket #{$ticket->ticket_id} updated successfully!");
    }

    /**
     * Inventory & Products for Employee.
     */
    public function inventory()
    {
        return redirect()->route('admin.inventory');
    }

    /**
     * Store Product added by Employee.
     */
    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:50'],
            'price' => ['required', 'numeric', 'min:1'],
            'original_price' => ['nullable', 'numeric'],
            'volume' => ['nullable', 'string', 'max:50'],
            'stock' => ['required', 'integer', 'min:0'],
            'badge' => ['nullable', 'string', 'max:50'],
            'short_desc' => ['nullable', 'string'],
        ]);

        $slug = \Illuminate\Support\Str::slug($validated['title']);
        $originalSlug = $slug;
        $counter = 1;
        while (\App\Models\Product::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-" . $counter++;
        }

        $title = $validated['title'];
        $category = $validated['category'];
        $price = $validated['price'];
        $originalPrice = $request->input('original_price') ?: ($price * 1.25);
        $volume = $request->input('volume') ?: '200ml';
        $stock = $request->input('stock', 100);
        $badge = $request->input('badge') ?: 'NEW LAUNCH';
        $shortDesc = $request->input('short_desc') ?: 'Pure herbal formulation crafted with certified botanicals for visible results.';

        $categoryNames = [
            'hair-oil' => 'Hair Oil',
            'shampoo' => 'Botanical Shampoo',
            'serum' => 'Scalp Serum',
            'skincare' => 'Herbal Skincare',
            'bundle' => 'Value Bundle',
        ];

        $categoryName = $categoryNames[$category] ?? ucfirst($category);
        
        $discount = null;
        if ($originalPrice > $price) {
            $pct = round((($originalPrice - $price) / $originalPrice) * 100);
            $discount = "{$pct}% OFF";
        }

        $product = \App\Models\Product::create([
            'slug' => $slug,
            'title' => $title,
            'category' => $category,
            'category_name' => $categoryName,
            'volume' => $volume,
            'price' => $price,
            'original_price' => $originalPrice,
            'discount' => $discount ?: '15% OFF',
            'rating' => 5.0,
            'reviews_count' => 1,
            'badge' => $badge,
            'icon' => $category === 'shampoo' ? 'fa-pump-soap' : ($category === 'serum' ? 'fa-wand-magic-sparkles' : 'fa-bottle-droplet'),
            'short_desc' => $shortDesc,
            'ingredients' => '100% natural Ayurvedic botanicals, essential plant extracts, and vitamin compounds.',
            'how_to_use' => 'Apply as directed on packaging. For maximum results, use routinely 3 times a week.',
            'benefits' => [
                '100% Herbal & Organic Ingredients',
                'Clinically formulated for healthy results',
                'Free from parabens, mineral oils, and synthetic silicones'
            ],
            'stock' => $stock,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'employee_product_created',
            'details' => "Staff member {$product->title} created product.",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', "New Product '{$product->title}' added successfully! It is now live on the store.");
    }
}
