<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Portal') &bull; Amber’s Roots Operations</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Dashboard Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/dashboard-theme.css') }}?v=1.1">
    <!-- Amber Custom Alerts & Modals Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/amber-alerts.css') }}?v=1.1">
    @stack('styles')
</head>
<body class="dashboard-body">

    @php
        $isImpersonating = session()->has('admin_impersonator_id');
        $currentUser = Auth::user();
        $isAdmin = $currentUser && $currentUser->role === 'admin';
    @endphp

    <!-- Top Stealth Impersonation Banner (Visible ONLY when Admin is viewing employee's dashboard) -->
    @if($isImpersonating)
    <div class="rm-impersonation-bar">
        <div class="rm-impersonation-content">
            <span class="rm-radar-dot"></span>
            <span>
                <i class="fa-solid fa-user-secret" style="margin-right: 6px;"></i>
                <strong>ADMIN SHADOW MODE ACTIVE:</strong> You are viewing this workspace as employee 
                <strong style="color: #dfc285; text-decoration: underline;">{{ $currentUser->name }}</strong> 
                ({{ $currentUser->designation ?? 'Staff Member' }}). The employee is completely unaware of this session.
            </span>
        </div>
        <form action="{{ route('impersonate.leave') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" class="btn-leave-impersonation" title="Exit Shadow Mode and return to Admin Portal">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Return to Admin Dashboard</span>
            </button>
        </form>
    </div>
    @endif

    <div class="dashboard-wrapper">
        <!-- Sidebar Navigation -->
        <aside class="dashboard-sidebar" id="dashboardSidebar">
            <!-- Sidebar Brand -->
            <div class="sidebar-brand">
                <div class="brand-crest" style="background: transparent; border: none; box-shadow: none; width: auto; height: auto;">
                    <img src="{{ asset('assets/Logos/logo-emblem-light.png') }}" 
                         alt="Amber's Roots" 
                         style="width: 38px; height: 38px; object-fit: contain; filter: drop-shadow(0 2px 8px rgba(201, 147, 27, 0.45));"
                         onerror="this.onerror=null; this.src='{{ asset('assets/Logos/logo-emblem-trimmed.png') }}';" />
                </div>
                <div class="brand-info">
                    <h4>Amber’s<span>Roots</span></h4>
                    <span class="brand-role-pill role-admin"><i class="fa-solid fa-sliders"></i> Operations Portal</span>
                </div>
            </div>

            <!-- Sidebar Menu Links -->
            <nav class="sidebar-menu">
                <!-- CORE OPERATIONS (Available for both Admin and Basic Employer) -->
                <div class="menu-category-label">Core Operations</div>
                <a href="{{ route('admin.dashboard') }}" class="sidebar-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-pie"></i>
                    <span>Overview</span>
                </a>
                <a href="{{ route('admin.inventory') }}" class="sidebar-nav-link {{ request()->routeIs('admin.inventory*') || request()->routeIs('admin.products*') ? 'active' : '' }}">
                    <i class="fa-solid fa-boxes-stacked"></i>
                    <span>Products Management</span>
                </a>
                <a href="{{ route('admin.discounts') }}" class="sidebar-nav-link {{ request()->routeIs('admin.discounts*') ? 'active' : '' }}">
                    <i class="fa-solid fa-percent"></i>
                    <span>Discount Management</span>
                </a>
                <a href="{{ route('admin.orders') }}" class="sidebar-nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                    <i class="fa-solid fa-boxes-packing"></i>
                    <span>Orders Management</span>
                </a>
                <a href="{{ route('admin.customers') }}" class="sidebar-nav-link {{ request()->routeIs('admin.customers*') ? 'active' : '' }}">
                    <i class="fa-solid fa-users"></i>
                    <span>Customers</span>
                </a>
                <a href="{{ route('admin.reviews') }}" class="sidebar-nav-link {{ request()->routeIs('admin.reviews*') ? 'active' : '' }}">
                    <i class="fa-solid fa-star-half-stroke"></i>
                    <span>Reviews Management</span>
                </a>
                <a href="{{ route('admin.tickets') }}" class="sidebar-nav-link {{ request()->routeIs('admin.tickets*') || request()->routeIs('employee.tickets*') ? 'active' : '' }}">
                    <i class="fa-solid fa-headset"></i>
                    <span>Customer Inquiries</span>
                    @php
                        $navOpenTickets = \App\Models\SupportTicket::where('status', 'open')->count();
                    @endphp
                    @if($navOpenTickets > 0)
                        <span style="margin-left: auto; background: #ef4444; color: #fff; font-size: 0.68rem; font-weight: 800; padding: 2px 8px; border-radius: 9999px; box-shadow: 0 0 10px rgba(239, 68, 68, 0.5);">
                            {{ $navOpenTickets }}
                        </span>
                    @endif
                </a>

                <div class="menu-category-label">Settings & Configuration</div>
                <a href="{{ route('admin.settings.whatsapp') }}" class="sidebar-nav-link {{ request()->routeIs('admin.settings.whatsapp*') ? 'active' : '' }}">
                    <i class="fa-brands fa-whatsapp" style="color: #25d366;"></i>
                    <span>WhatsApp Settings</span>
                </a>
                <a href="{{ route('admin.settings.website') }}" class="sidebar-nav-link {{ request()->routeIs('admin.settings.website*') ? 'active' : '' }}">
                    <i class="fa-solid fa-sliders"></i>
                    <span>Website Settings</span>
                </a>

                @if($isAdmin && !$isImpersonating)
                    <!-- SUPER ADMIN ONLY: Employee Management & Audit Logs (Hidden from Basic Employer) -->
                    <div class="menu-category-label">Administration</div>
                    <a href="{{ route('admin.employees') }}" class="sidebar-nav-link {{ request()->routeIs('admin.employees*') ? 'active' : '' }}">
                        <i class="fa-solid fa-users-gear"></i>
                        <span>Manage Employees</span>
                    </a>
                    <a href="{{ route('admin.logs') }}" class="sidebar-nav-link {{ request()->routeIs('admin.logs*') ? 'active' : '' }}">
                        <i class="fa-solid fa-fingerprint"></i>
                        <span>Audit & Activity Logs</span>
                    </a>
                @endif

                <div class="menu-category-label">External</div>
                <a href="{{ route('home') }}" target="_blank" class="sidebar-nav-link">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    <span>Live Amber's Roots Store</span>
                </a>
            </nav>

            <!-- Sidebar User Profile Footer (Anonymous - No Personal Names) -->
            <div class="sidebar-footer">
                <div class="user-mini-card">
                    <div style="width: 36px; height: 36px; border-radius: 50%; background: rgba(201, 147, 27, 0.15); border: 1.5px solid var(--db-gold); display: flex; align-items: center; justify-content: center; color: var(--db-gold); font-size: 0.95rem; flex-shrink: 0;">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    <div class="user-mini-info">
                        <div class="user-mini-name" style="font-weight: 700; color: #fff;">Operations Workspace</div>
                        <div class="user-mini-role" style="font-size: 0.72rem; color: #34d399;"><i class="fa-solid fa-circle" style="font-size: 0.5rem;"></i> Active Session</div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Workspace -->
        <div class="dashboard-main">
            <!-- Header Bar -->
            <header class="dashboard-header">
                <div class="header-left">
                    <button type="button" class="btn-db btn-db-outline" id="toggleMobileSidebar" style="padding: 8px 12px; display: none;">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <div class="header-title-group">
                        <h2>@yield('header_title', 'Dashboard')</h2>
                        <p>@yield('header_subtitle', "Amber's Roots Operations Platform")</p>
                    </div>
                </div>

                <div class="header-right">
                    <!-- Status indicator -->
                    @if($currentUser->status === 'active')
                        <span class="status-badge badge-active">
                            <span style="width: 6px; height: 6px; border-radius: 50%; background: #34d399;"></span> Active
                        </span>
                    @else
                        <span class="status-badge badge-kicked">
                            <i class="fa-solid fa-ban"></i> Suspended
                        </span>
                    @endif

                    <!-- Logout Form -->
                    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn-db btn-db-outline" title="Log out of session">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span>Sign Out</span>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Content Container -->
            <main class="dashboard-content">
                <!-- Flash Alerts -->
                @if(session('success'))
                    <div class="db-alert alert-success">
                        <i class="fa-solid fa-circle-check" style="font-size: 1.1rem;"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="db-alert alert-error">
                        <i class="fa-solid fa-circle-exclamation" style="font-size: 1.1rem;"></i>
                        <div>{{ session('error') }}</div>
                    </div>
                @endif

                @if(session('impersonation_notice'))
                    <div class="db-alert" style="background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.4); color: #fbbf24;">
                        <i class="fa-solid fa-eye" style="font-size: 1.1rem;"></i>
                        <div>{{ session('impersonation_notice') }} You can return to your Admin Dashboard anytime using the top amber bar.</div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Amber Custom Luxury Alerts Engine -->
    <script src="{{ asset('js/amber-alerts.js') }}?v=1.0"></script>

    <!-- Session Flash Alerts Trigger -->
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                AmberToast.success("{{ addslashes(session('success')) }}");
            });
        </script>
    @endif
    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                AmberToast.error("{{ addslashes(session('error')) }}");
            });
        </script>
    @endif

    <!-- Scripts -->
    <script>
        // Mobile sidebar toggle
        const toggleBtn = document.getElementById('toggleMobileSidebar');
        const sidebar = document.getElementById('dashboardSidebar');
        if (toggleBtn && sidebar) {
            if (window.innerWidth <= 900) {
                toggleBtn.style.display = 'inline-flex';
            }
            window.addEventListener('resize', () => {
                toggleBtn.style.display = window.innerWidth <= 900 ? 'inline-flex' : 'none';
            });
            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('mobile-open');
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
