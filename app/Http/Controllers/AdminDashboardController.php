<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    /**
     * Admin Overview Dashboard.
     */
    public function index(): View
    {
        $totalRevenue = Order::where('status', '!=', 'Cancelled')->sum('total');
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'Pending')->count();
        $confirmedOrders = Order::where('status', 'Confirmed')->count();
        $processingOrders = Order::where('status', 'Processing')->count();
        $deliveredOrders = Order::where('status', 'Delivered')->count();

        $employeesCount = User::where('role', 'employee')->count();
        $activeEmployeesCount = User::where('role', 'employee')->where('status', 'active')->count();
        $kickedEmployeesCount = User::where('role', 'employee')->where('status', 'kicked')->count();

        $recentOrders = Order::with('assignedEmployee')->latest()->take(6)->get();
        $recentLogs = ActivityLog::latest()->take(8)->get();
        $employees = User::where('role', 'employee')->get();

        // Product & Review summary
        $totalProducts = Product::count();
        $activeProducts = Product::where('is_active', true)->count();
        $lowStockCount = Product::where('stock', '<=', 15)->count();

        $totalReviews = Review::count();
        $pendingReviewsCount = Review::where('status', 'pending')->count();
        $averageRating = round((float)(Review::where('status', 'approved')->avg('rating') ?: 4.9), 1);

        // Inquiries & Support Tickets summary
        $totalTickets = SupportTicket::count();
        $openTicketsCount = SupportTicket::where('status', 'open')->count();
        $recentTickets = SupportTicket::with('assignedEmployee')->latest()->take(6)->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalOrders',
            'pendingOrders',
            'confirmedOrders',
            'processingOrders',
            'deliveredOrders',
            'employeesCount',
            'activeEmployeesCount',
            'kickedEmployeesCount',
            'recentOrders',
            'recentLogs',
            'employees',
            'totalProducts',
            'activeProducts',
            'lowStockCount',
            'totalReviews',
            'pendingReviewsCount',
            'averageRating',
            'totalTickets',
            'openTicketsCount',
            'recentTickets'
        ));
    }

    /**
     * Ensure only super admin can access staff management features.
     */
    protected function requireAdminRole(): void
    {
        if (Auth::user()?->role !== 'admin') {
            abort(403, 'Access denied. Employee management is restricted to Super Admin only.');
        }
    }

    /**
     * Manage Employees Sub-page.
     */
    public function employees(): View
    {
        $this->requireAdminRole();
        $employees = User::where('role', 'employee')->latest()->get();
        $activeCount = $employees->where('status', 'active')->count();
        $kickedCount = $employees->where('status', 'kicked')->count();

        return view('admin.employees', compact('employees', 'activeCount', 'kickedCount'));
    }

    /**
     * Store new Employee.
     */
    public function storeEmployee(Request $request): RedirectResponse
    {
        $this->requireAdminRole();
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
            'department' => ['required', 'string', 'max:100'],
            'designation' => ['required', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $employee = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'employee',
            'status' => 'active',
            'department' => $validated['department'],
            'designation' => $validated['designation'],
            'phone' => $validated['phone'],
            'avatar' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=200&q=80',
            'last_active_at' => now(),
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'employee_created',
            'details' => "Added new employee {$employee->name} ({$employee->email}) in {$employee->department}.",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('admin.employees')->with('success', "Employee {$employee->name} successfully added!");
    }

    /**
     * Kick (suspend) or unkick an employee.
     */
    public function kickEmployee(Request $request, int|string $id): RedirectResponse
    {
        $this->requireAdminRole();
        $employee = User::where('role', 'employee')->findOrFail($id);

        if ($employee->status === 'active') {
            $reason = $request->input('kick_reason', 'Kicked by administrator for review or policy violation.');
            $employee->status = 'kicked';
            $employee->kick_reason = $reason;
            $employee->save();

            try {
                DB::table('sessions')->where('user_id', $employee->id)->delete();
            } catch (\Throwable $e) {
                // Ignore if sessions table not in use
            }

            ActivityLog::create([
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name,
                'action' => 'kick_employee',
                'details' => "Admin KICKED employee {$employee->name} ({$employee->email}). Reason: {$reason}",
                'ip_address' => $request->ip(),
            ]);

            return redirect()->route('admin.employees')->with('success', "Employee {$employee->name} has been KICKED & suspended immediately.");
        } else {
            $employee->status = 'active';
            $employee->kick_reason = null;
            $employee->save();

            ActivityLog::create([
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name,
                'action' => 'unkick_employee',
                'details' => "Admin reactivated employee {$employee->name} ({$employee->email}).",
                'ip_address' => $request->ip(),
            ]);

            return redirect()->route('admin.employees')->with('success', "Employee {$employee->name} has been reinstated and is now ACTIVE.");
        }
    }

    /**
     * Delete an employee.
     */
    public function deleteEmployee(Request $request, int|string $id): RedirectResponse
    {
        $this->requireAdminRole();
        $employee = User::where('role', 'employee')->findOrFail($id);
        $name = $employee->name;

        Order::where('assigned_employee_id', $employee->id)->update(['assigned_employee_id' => null]);
        SupportTicket::where('assigned_employee_id', $employee->id)->update(['assigned_employee_id' => null]);

        $employee->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'employee_deleted',
            'details' => "Deleted employee record: {$name}.",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('admin.employees')->with('success', "Employee {$name} deleted successfully.");
    }

    /**
     * Manage Orders Sub-page with status tabs & search filter.
     */
    public function orders(Request $request): View
    {
        $status = $request->query('status');
        $search = trim((string)$request->query('q', ''));

        $query = Order::with('assignedEmployee')->latest();

        if ($status && in_array($status, ['Pending', 'Confirmed', 'Processing', 'Shipped', 'Dispatched', 'Delivered', 'Cancelled'])) {
            if ($status === 'Shipped') {
                $query->whereIn('status', ['Shipped', 'Dispatched']);
            } else {
                $query->where('status', $status);
            }
        }

        if ($search !== '') {
            $cleanSearch = str_replace('#', '', $search);
            $query->where(function ($q) use ($cleanSearch) {
                $q->where('order_number', 'LIKE', "%{$cleanSearch}%")
                    ->orWhere('customer_name', 'LIKE', "%{$cleanSearch}%")
                    ->orWhere('customer_phone', 'LIKE', "%{$cleanSearch}%")
                    ->orWhere('city', 'LIKE', "%{$cleanSearch}%");
            });
        }

        $orders = $query->paginate(15)->appends($request->query());
        $employees = User::where('role', 'employee')->where('status', 'active')->get();

        $counts = [
            'all' => Order::count(),
            'pending' => Order::where('status', 'Pending')->count(),
            'confirmed' => Order::where('status', 'Confirmed')->count(),
            'processing' => Order::where('status', 'Processing')->count(),
            'shipped' => Order::whereIn('status', ['Shipped', 'Dispatched'])->count(),
            'delivered' => Order::where('status', 'Delivered')->count(),
            'cancelled' => Order::where('status', 'Cancelled')->count(),
        ];

        $totalSales = Order::where('status', '!=', 'Cancelled')->sum('total');

        return view('admin.orders', compact('orders', 'employees', 'counts', 'status', 'search', 'totalSales'));
    }

    /**
     * Update Order Status & Courier details.
     */
    public function updateOrderStatus(Request $request, int|string $id): RedirectResponse
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:Pending,Confirmed,Processing,Shipped,Dispatched,Delivered,Cancelled'],
            'courier_service' => ['nullable', 'string', 'max:50'],
            'tracking_number' => ['nullable', 'string', 'max:100'],
            'assigned_employee_id' => ['nullable', 'exists:users,id'],
            'notes' => ['nullable', 'string'],
        ]);

        $oldStatus = $order->status;
        $order->update($validated);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'order_updated',
            'details' => "Updated order #{$order->order_number} status from '{$oldStatus}' to '{$order->status}'.",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', "Order #{$order->order_number} status updated to '{$order->status}' successfully!");
    }

    /**
     * Inventory & Products Sub-page.
     */
    public function inventory(): View
    {
        $products = Product::orderBy('display_order', 'asc')->orderBy('id', 'asc')->get();
        $activeCount = Product::where('is_active', true)->count();
        $inactiveCount = Product::where('is_active', false)->count();
        $lowStockCount = Product::where('stock', '<=', 15)->count();

        return view('admin.inventory', compact('products', 'activeCount', 'inactiveCount', 'lowStockCount'));
    }

    /**
     * Store new product in catalog.
     */
    public function storeProduct(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:50'],
            'volume' => ['nullable', 'string', 'max:50'],
            'price' => ['required', 'numeric', 'min:1'],
            'original_price' => ['nullable', 'numeric'],
            'discount_percent' => ['nullable', 'integer', 'min:0', 'max:90'],
            'discount_active' => ['nullable'],
            'discount_expires_at' => ['nullable', 'date'],
            'stock' => ['required', 'integer', 'min:0'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable'],
            'is_featured' => ['nullable'],
            'badge' => ['nullable', 'string', 'max:50'],
            'short_desc' => ['nullable', 'string'],
            'ingredients' => ['nullable', 'string'],
            'how_to_use' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'image_url' => ['nullable', 'string', 'max:500'],
            'gallery_image_1' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'gallery_image_2' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'gallery_image_3' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'gallery_image_4' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'gallery_files.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'gallery_url_1' => ['nullable', 'string', 'max:500'],
            'gallery_url_2' => ['nullable', 'string', 'max:500'],
            'gallery_url_3' => ['nullable', 'string', 'max:500'],
            'gallery_url_4' => ['nullable', 'string', 'max:500'],
        ]);

        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $counter = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-" . $counter++;
        }

        $price = (float)$validated['price'];
        $originalPrice = !empty($validated['original_price']) ? (float)$validated['original_price'] : ($price * 1.25);
        $discountPercent = isset($validated['discount_percent']) ? (int)$validated['discount_percent'] : null;

        if ($discountPercent === null && $originalPrice > $price) {
            $discountPercent = round((($originalPrice - $price) / $originalPrice) * 100);
        }

        $discountBadge = $discountPercent ? "{$discountPercent}% OFF" : null;

        // Image handling
        $imagePath = 'assets/product/1000082361.jpg';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/products'), $fileName);
            $imagePath = 'images/products/' . $fileName;
        } elseif (!empty($validated['image_url'])) {
            $imagePath = trim($validated['image_url']);
        }

        // 4 Gallery Images Handling
        $gallery = [];
        for ($i = 1; $i <= 4; $i++) {
            $key = "gallery_image_{$i}";
            if ($request->hasFile($key)) {
                $gFile = $request->file($key);
                $gFileName = time() . "_{$i}_" . Str::slug(pathinfo($gFile->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $gFile->getClientOriginalExtension();
                $gFile->move(public_path('images/products'), $gFileName);
                $gallery[] = 'images/products/' . $gFileName;
            } elseif (!empty($request->input("gallery_url_{$i}"))) {
                $gallery[] = trim($request->input("gallery_url_{$i}"));
            }
        }

        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $idx => $gFile) {
                if (count($gallery) >= 4) break;
                $gFileName = time() . "_g{$idx}_" . Str::slug(pathinfo($gFile->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $gFile->getClientOriginalExtension();
                $gFile->move(public_path('images/products'), $gFileName);
                $gallery[] = 'images/products/' . $gFileName;
            }
        }

        if (empty($gallery)) {
            $gallery = [
                'assets/product/1000082361.jpg',
                'assets/product/1000082362.jpg',
                'assets/product/1000082363.jpg',
                'assets/product/1000082365.jpg',
            ];
        }

        while (count($gallery) < 4) {
            $defaults = [
                'assets/product/1000082361.jpg',
                'assets/product/1000082362.jpg',
                'assets/product/1000082363.jpg',
                'assets/product/1000082365.jpg',
            ];
            $gallery[] = $defaults[count($gallery)] ?? $gallery[0];
        }
        $gallery = array_slice($gallery, 0, 4);

        $categoryNames = [
            'hair-oil' => 'Hair Oil',
            'shampoo' => 'Botanical Shampoo',
            'serum' => 'Scalp Serum',
            'skincare' => 'Herbal Skincare',
            'bundle' => 'Value Bundle',
        ];

        $category = $validated['category'];
        $categoryName = $categoryNames[$category] ?? ucfirst($category);

        $product = Product::create([
            'slug' => $slug,
            'title' => $validated['title'],
            'category' => $category,
            'category_name' => $categoryName,
            'volume' => !empty($validated['volume']) ? $validated['volume'] : '200ml',
            'price' => $price,
            'original_price' => $originalPrice,
            'discount' => $discountBadge ?: '15% OFF',
            'discount_percent' => $discountPercent,
            'discount_active' => $request->has('discount_active') ? true : ($discountPercent > 0),
            'discount_expires_at' => $validated['discount_expires_at'] ?? null,
            'rating' => 5.0,
            'reviews_count' => 0,
            'badge' => !empty($validated['badge']) ? $validated['badge'] : 'NEW LAUNCH',
            'icon' => $category === 'shampoo' ? 'fa-pump-soap' : ($category === 'serum' ? 'fa-wand-magic-sparkles' : 'fa-bottle-droplet'),
            'image' => $imagePath,
            'gallery' => $gallery,
            'short_desc' => !empty($validated['short_desc']) ? $validated['short_desc'] : 'Pure herbal formulation crafted with certified botanicals for visible results.',
            'ingredients' => !empty($validated['ingredients']) ? $validated['ingredients'] : '100% natural Ayurvedic botanicals, essential plant extracts, and vitamin compounds.',
            'how_to_use' => !empty($validated['how_to_use']) ? $validated['how_to_use'] : 'Apply as directed on packaging. For maximum results, use routinely 3 times a week.',
            'benefits' => [
                '100% Herbal & Organic Ingredients',
                'Clinically formulated for healthy results',
                'Free from parabens, mineral oils, and synthetic silicones'
            ],
            'stock' => (int)$validated['stock'],
            'is_active' => $request->has('is_active') ? true : false,
            'is_featured' => $request->has('is_featured') ? true : false,
            'display_order' => (int)($validated['display_order'] ?? 0),
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'product_created',
            'details' => "Added new product '{$product->title}' (Rs. {$product->price}) with stock {$product->stock}.",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', "Product '{$product->title}' created successfully! Status: " . ($product->is_active ? 'Active (ON)' : 'Inactive (OFF)'));
    }

    /**
     * Update an existing product.
     */
    public function updateProduct(Request $request, int|string $id): RedirectResponse
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:50'],
            'volume' => ['nullable', 'string', 'max:50'],
            'price' => ['required', 'numeric', 'min:1'],
            'original_price' => ['nullable', 'numeric'],
            'discount_percent' => ['nullable', 'integer', 'min:0', 'max:90'],
            'discount_expires_at' => ['nullable', 'date'],
            'stock' => ['required', 'integer', 'min:0'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'badge' => ['nullable', 'string', 'max:50'],
            'short_desc' => ['nullable', 'string'],
            'ingredients' => ['nullable', 'string'],
            'how_to_use' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'image_url' => ['nullable', 'string', 'max:500'],
            'gallery_image_1' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'gallery_image_2' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'gallery_image_3' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'gallery_image_4' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'gallery_files.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'gallery_url_1' => ['nullable', 'string', 'max:500'],
            'gallery_url_2' => ['nullable', 'string', 'max:500'],
            'gallery_url_3' => ['nullable', 'string', 'max:500'],
            'gallery_url_4' => ['nullable', 'string', 'max:500'],
        ]);

        $price = (float)$validated['price'];
        $originalPrice = !empty($validated['original_price']) ? (float)$validated['original_price'] : ($price * 1.25);
        $discountPercent = isset($validated['discount_percent']) ? (int)$validated['discount_percent'] : null;

        if ($discountPercent === null && $originalPrice > $price) {
            $discountPercent = round((($originalPrice - $price) / $originalPrice) * 100);
        }

        $discountBadge = $discountPercent ? "{$discountPercent}% OFF" : ($originalPrice > $price ? round((($originalPrice - $price) / $originalPrice) * 100) . '% OFF' : 'BEST VALUE');

        $categoryNames = [
            'hair-oil' => 'Hair Oil',
            'shampoo' => 'Botanical Shampoo',
            'serum' => 'Scalp Serum',
            'skincare' => 'Herbal Skincare',
            'bundle' => 'Value Bundle',
        ];

        $category = $validated['category'];
        $categoryName = $categoryNames[$category] ?? ucfirst($category);

        $product->title = $validated['title'];
        $product->category = $category;
        $product->category_name = $categoryName;
        $product->volume = !empty($validated['volume']) ? $validated['volume'] : $product->volume;
        $product->price = $price;
        $product->original_price = $originalPrice;
        $product->discount = $discountBadge;
        $product->discount_percent = $discountPercent;
        $product->discount_active = $request->has('discount_active');
        $product->discount_expires_at = $validated['discount_expires_at'] ?? null;
        $product->stock = (int)$validated['stock'];
        $product->is_active = $request->has('is_active');
        $product->is_featured = $request->has('is_featured');
        $product->display_order = (int)($validated['display_order'] ?? 0);
        $product->badge = !empty($validated['badge']) ? $validated['badge'] : $product->badge;
        $product->short_desc = !empty($validated['short_desc']) ? $validated['short_desc'] : $product->short_desc;
        $product->ingredients = !empty($validated['ingredients']) ? $validated['ingredients'] : $product->ingredients;
        $product->how_to_use = !empty($validated['how_to_use']) ? $validated['how_to_use'] : $product->how_to_use;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/products'), $fileName);
            $product->image = 'images/products/' . $fileName;
        } elseif (!empty($validated['image_url'])) {
            $product->image = trim($validated['image_url']);
        }

        // Gallery handling for edit
        $currentGallery = is_array($product->gallery) && count($product->gallery) > 0 ? $product->gallery : [
            'assets/product/1000082361.jpg',
            'assets/product/1000082362.jpg',
            'assets/product/1000082363.jpg',
            'assets/product/1000082365.jpg',
        ];

        for ($i = 1; $i <= 4; $i++) {
            $key = "gallery_image_{$i}";
            if ($request->hasFile($key)) {
                $gFile = $request->file($key);
                $gFileName = time() . "_{$i}_" . Str::slug(pathinfo($gFile->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $gFile->getClientOriginalExtension();
                $gFile->move(public_path('images/products'), $gFileName);
                $currentGallery[$i - 1] = 'images/products/' . $gFileName;
            } elseif ($request->filled("gallery_url_{$i}")) {
                $currentGallery[$i - 1] = trim($request->input("gallery_url_{$i}"));
            }
        }

        if ($request->hasFile('gallery_files')) {
            $newGallery = [];
            foreach ($request->file('gallery_files') as $idx => $gFile) {
                if (count($newGallery) >= 4) break;
                $gFileName = time() . "_g{$idx}_" . Str::slug(pathinfo($gFile->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $gFile->getClientOriginalExtension();
                $gFile->move(public_path('images/products'), $gFileName);
                $newGallery[] = 'images/products/' . $gFileName;
            }
            if (count($newGallery) > 0) {
                $currentGallery = $newGallery;
            }
        }

        while (count($currentGallery) < 4) {
            $defaults = [
                'assets/product/1000082361.jpg',
                'assets/product/1000082362.jpg',
                'assets/product/1000082363.jpg',
                'assets/product/1000082365.jpg',
            ];
            $currentGallery[] = $defaults[count($currentGallery)] ?? $currentGallery[0];
        }
        $product->gallery = array_slice($currentGallery, 0, 4);

        $product->save();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'product_updated',
            'details' => "Updated product '{$product->title}' (Rs. {$product->price}, Stock: {$product->stock}, Active: " . ($product->is_active ? 'Yes' : 'No') . ").",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', "Product '{$product->title}' updated successfully!");
    }

    /**
     * Fast toggle of product Active/Inactive (ON/OFF).
     */
    public function toggleProductStatus(Request $request, int|string $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $product->is_active = !$product->is_active;
        $product->save();

        $statusStr = $product->is_active ? 'ACTIVE (ON)' : 'INACTIVE (OFF)';

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'product_toggled',
            'details' => "Product '{$product->title}' set to {$statusStr}.",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', "Product '{$product->title}' is now {$statusStr}.");
    }

    /**
     * Fast toggle of product Discount (ON/OFF).
     */
    public function toggleDiscount(Request $request, int|string $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $product->discount_active = !$product->discount_active;
        $product->save();

        $statusStr = $product->discount_active ? 'ACTIVE (ON)' : 'PAUSED (OFF)';

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'discount_toggled',
            'details' => "Discount on '{$product->title}' set to {$statusStr}.",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', "Discount for '{$product->title}' is now {$statusStr}.");
    }

    /**
     * Delete product from catalog.
     */
    public function deleteProduct(Request $request, int|string $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $title = $product->title;
        $product->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'product_deleted',
            'details' => "Removed product '{$title}'.",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', "Product '{$title}' removed from store catalog.");
    }

    /**
     * Customer Reviews Moderation Sub-page.
     */
    public function reviews(Request $request): View
    {
        $status = $request->query('status');
        $search = trim((string)$request->query('q', ''));

        $query = Review::with('product')->latest();

        if ($status && in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $status);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'LIKE', "%{$search}%")
                    ->orWhere('review_text', 'LIKE', "%{$search}%")
                    ->orWhere('customer_phone', 'LIKE', "%{$search}%");
            });
        }

        $reviews = $query->paginate(15)->appends($request->query());

        $counts = [
            'all' => Review::count(),
            'pending' => Review::where('status', 'pending')->count(),
            'approved' => Review::where('status', 'approved')->count(),
            'rejected' => Review::where('status', 'rejected')->count(),
        ];

        $averageRating = round((float)(Review::where('status', 'approved')->avg('rating') ?: 5.0), 1);

        return view('admin.reviews', compact('reviews', 'counts', 'status', 'search', 'averageRating'));
    }

    /**
     * Approve or reject customer review.
     */
    public function updateReviewStatus(Request $request, int|string $id): RedirectResponse
    {
        $review = Review::findOrFail($id);

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:approved,rejected,pending'],
        ]);

        $review->status = $validated['status'];
        $review->save();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'review_status_updated',
            'details' => "Updated review #{$review->id} from {$review->customer_name} to '{$review->status}'.",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', "Review from {$review->customer_name} has been marked as " . strtoupper($review->status) . '.');
    }

    /**
     * Delete a review.
     */
    public function deleteReview(Request $request, int|string $id): RedirectResponse
    {
        $review = Review::findOrFail($id);
        $name = $review->customer_name;
        $review->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'review_deleted',
            'details' => "Deleted review #{$id} by {$name}.",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', "Review from {$name} deleted successfully.");
    }

    /**
     * Discount & Promotional Campaigns Management Sub-page.
     */
    public function discounts(): View
    {
        $products = Product::orderBy('display_order', 'asc')->get();
        $coupons = \App\Models\Coupon::latest()->get();

        $activeDiscountsCount = Product::where('discount_active', true)->where('discount_percent', '>', 0)->count();
        $activeCouponsCount = $coupons->where('is_active', true)->count();

        return view('admin.discounts', compact('products', 'coupons', 'activeDiscountsCount', 'activeCouponsCount'));
    }

    /**
     * Quick Update Product Discount percentage and ON/OFF state.
     */
    public function updateProductDiscount(Request $request, int|string $id): RedirectResponse
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'discount_percent' => ['required', 'integer', 'min:0', 'max:90'],
            'discount_active' => ['nullable'],
            'discount_expires_at' => ['nullable', 'date'],
        ]);

        $discountPercent = (int)$validated['discount_percent'];
        $product->discount_percent = $discountPercent;
        $product->discount = $discountPercent > 0 ? "{$discountPercent}% OFF" : null;
        $product->discount_active = $request->has('discount_active') || $discountPercent > 0;
        $product->discount_expires_at = $validated['discount_expires_at'] ?? null;
        $product->save();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'discount_updated',
            'details' => "Updated discount on '{$product->title}' to {$discountPercent}% OFF (Active: " . ($product->discount_active ? 'ON' : 'OFF') . ").",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', "Discount for '{$product->title}' set to {$discountPercent}% OFF successfully!");
    }

    /**
     * Store a new coupon code.
     */
    public function storeCoupon(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:30', 'unique:coupons,code'],
            'discount_type' => ['required', 'in:percentage,fixed'],
            'discount_value' => ['required', 'numeric', 'min:1'],
            'min_order_amount' => ['nullable', 'numeric', 'min:0'],
            'expires_at' => ['nullable', 'date'],
        ]);

        $coupon = \App\Models\Coupon::create([
            'code' => strtoupper(trim($validated['code'])),
            'discount_type' => $validated['discount_type'],
            'discount_value' => $validated['discount_value'],
            'min_order_amount' => $validated['min_order_amount'] ?? 0,
            'is_active' => true,
            'expires_at' => $validated['expires_at'] ?? null,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'coupon_created',
            'details' => "Created coupon code {$coupon->code} ({$coupon->discount_value}" . ($coupon->discount_type === 'percentage' ? '%' : ' PKR') . " OFF).",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', "Coupon code '{$coupon->code}' created successfully!");
    }

    /**
     * Delete a coupon code.
     */
    public function deleteCoupon(Request $request, int|string $id): RedirectResponse
    {
        $coupon = \App\Models\Coupon::findOrFail($id);
        $code = $coupon->code;
        $coupon->delete();

        return back()->with('success', "Coupon '{$code}' deleted successfully.");
    }

    /**
     * Customers Directory Sub-page (Aggregated from Orders).
     */
    public function customers(Request $request): View
    {
        $search = trim((string)$request->query('q', ''));

        $query = Order::select(
            'customer_name',
            'customer_phone',
            'city',
            'shipping_address',
            DB::raw('COUNT(*) as total_orders'),
            DB::raw('SUM(total) as total_spent'),
            DB::raw('MAX(created_at) as last_ordered_at')
        )->groupBy('customer_phone');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'LIKE', "%{$search}%")
                    ->orWhere('customer_phone', 'LIKE', "%{$search}%")
                    ->orWhere('city', 'LIKE', "%{$search}%");
            });
        }

        $customers = $query->orderByDesc('total_spent')->paginate(15)->appends($request->query());
        $totalCustomersCount = Order::distinct('customer_phone')->count('customer_phone');
        $repeatCustomersCount = Order::select('customer_phone')
            ->groupBy('customer_phone')
            ->havingRaw('COUNT(*) > 1')
            ->get()
            ->count();

        return view('admin.customers', compact('customers', 'totalCustomersCount', 'repeatCustomersCount', 'search'));
    }

    /**
     * WhatsApp Settings Sub-page.
     */
    public function whatsappSettings(): View
    {
        $whatsappNumber = \App\Models\Setting::get('whatsapp_number', '923272222180');
        $whatsappTemplate = \App\Models\Setting::get('whatsapp_template', '');
        $whatsappAutoOpen = \App\Models\Setting::get('whatsapp_auto_open', '1');

        return view('admin.settings.whatsapp', compact('whatsappNumber', 'whatsappTemplate', 'whatsappAutoOpen'));
    }

    /**
     * Update WhatsApp Settings.
     */
    public function updateWhatsappSettings(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'whatsapp_number' => ['required', 'string', 'max:30'],
            'whatsapp_template' => ['nullable', 'string', 'max:2000'],
            'whatsapp_auto_open' => ['nullable'],
        ]);

        $cleanWa = preg_replace('/[^0-9]/', '', $validated['whatsapp_number']);
        if (str_starts_with($cleanWa, '0')) {
            $cleanWa = '92' . substr($cleanWa, 1);
        }

        \App\Models\Setting::set('whatsapp_number', $cleanWa ?: '923272222180', 'whatsapp');
        \App\Models\Setting::set('whatsapp_template', $validated['whatsapp_template'] ?? '', 'whatsapp');
        \App\Models\Setting::set('whatsapp_auto_open', $request->has('whatsapp_auto_open') ? '1' : '0', 'whatsapp');

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'whatsapp_settings_updated',
            'details' => "Updated official store WhatsApp number to {$cleanWa}.",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', "WhatsApp settings updated successfully! New number: +{$cleanWa}");
    }

    /**
     * Website General Settings Sub-page.
     */
    public function websiteSettings(): View
    {
        $storeName = \App\Models\Setting::get('store_name', "Amber's Roots");
        $storeTagline = \App\Models\Setting::get('store_tagline', 'Pure Herbs, Pure Results');
        $storePhone = \App\Models\Setting::get('store_phone', '+92 327 2222180');
        $storeEmail = \App\Models\Setting::get('store_email', 'info@ambersroots.com');
        $storeAddress = \App\Models\Setting::get('store_address', 'Big City Plaza Laboratory');
        $announcementText = \App\Models\Setting::get('announcement_text', 'Trusted by 50,000+ happy customers across Pakistan • 4.9★ rating • Free Doorstep Express Delivery');
        $freeShippingMin = \App\Models\Setting::get('free_shipping_min', '0');

        return view('admin.settings.website', compact(
            'storeName',
            'storeTagline',
            'storePhone',
            'storeEmail',
            'storeAddress',
            'announcementText',
            'freeShippingMin'
        ));
    }

    /**
     * Update Website General Settings.
     */
    public function updateWebsiteSettings(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'store_name' => ['required', 'string', 'max:255'],
            'store_tagline' => ['nullable', 'string', 'max:255'],
            'store_phone' => ['nullable', 'string', 'max:50'],
            'store_email' => ['nullable', 'email', 'max:255'],
            'store_address' => ['nullable', 'string', 'max:500'],
            'announcement_text' => ['nullable', 'string', 'max:500'],
            'free_shipping_min' => ['nullable', 'numeric', 'min:0'],
        ]);

        \App\Models\Setting::set('store_name', $validated['store_name'], 'website');
        \App\Models\Setting::set('store_tagline', $validated['store_tagline'] ?? '', 'website');
        \App\Models\Setting::set('store_phone', $validated['store_phone'] ?? '', 'website');
        \App\Models\Setting::set('store_email', $validated['store_email'] ?? '', 'website');
        \App\Models\Setting::set('store_address', $validated['store_address'] ?? 'Big City Plaza Laboratory', 'website');
        \App\Models\Setting::set('announcement_text', $validated['announcement_text'] ?? '', 'website');
        \App\Models\Setting::set('free_shipping_min', $validated['free_shipping_min'] ?? '0', 'website');

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'website_settings_updated',
            'details' => "Updated website general settings & store address.",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', "Website settings updated successfully!");
    }

    /**
     * Activity & Audit Logs Sub-page.
     */
    public function activityLogs(): View
    {
        $this->requireAdminRole();
        $logs = ActivityLog::latest()->paginate(25);
        return view('admin.activity-logs', compact('logs'));
    }

    /**
     * Customer Inquiries & Support Tickets Sub-page.
     * Displays all contact submissions with real-time assignment & response controls.
     */
    public function tickets(Request $request): View
    {
        $query = SupportTicket::with('assignedEmployee')->latest();

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority') && $request->priority !== 'all') {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('ticket_id', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $tickets = $query->paginate(15)->withQueryString();
        $employees = User::where('role', 'employee')->where('status', 'active')->orderBy('name', 'asc')->get();

        $totalTickets = SupportTicket::count();
        $openTickets = SupportTicket::where('status', 'open')->count();
        $inProgressTickets = SupportTicket::where('status', 'in_progress')->count();
        $resolvedTickets = SupportTicket::where('status', 'resolved')->count();

        return view('admin.tickets', compact(
            'tickets',
            'employees',
            'totalTickets',
            'openTickets',
            'inProgressTickets',
            'resolvedTickets'
        ));
    }

    /**
     * Update Support Ticket Status, Priority, Assignment, or Notes.
     */
    public function updateTicket(Request $request, int|string $id): RedirectResponse
    {
        $ticket = SupportTicket::findOrFail($id);

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:open,in_progress,resolved'],
            'priority' => ['required', 'string', 'in:low,normal,urgent'],
            'resolution_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $ticket->update($validated);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'ticket_updated',
            'details' => "Updated inquiry #{$ticket->ticket_id} status to '{$ticket->status}'.",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', "Inquiry ticket #{$ticket->ticket_id} updated successfully!");
    }

    /**
     * Delete Support Ticket.
     */
    public function deleteTicket(Request $request, int|string $id): RedirectResponse
    {
        $ticket = SupportTicket::findOrFail($id);
        $ticketId = $ticket->ticket_id;
        $ticket->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'ticket_deleted',
            'details' => "Deleted inquiry ticket #{$ticketId}.",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', "Inquiry ticket #{$ticketId} deleted successfully.");
    }
}
