<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Your Hair, Your Confidence. Mazboot, chamakdaar aur sehatmand baal - sirf Amber's Roots Herbal Hair Oil ke saath! Free Delivery across Pakistan.">
    <meta property="og:title" content="Amber's Roots – Pure Herbs, Pure Results">
    <meta property="og:site_name" content="Amber's Roots">
    <meta property="og:description" content="100% Herbal & Organic Hair Oil and Ayurvedic formulations.">
    
    <title>@yield('title', "Amber's Roots – Pure Herbs, Pure Results | Herbal Hair Oil")</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/Logos/logo-emblem-trimmed.png') }}">

    <!-- Google Fonts: Cinzel (Luxury Display) & Plus Jakarta Sans (Modern Clean) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Amber's Roots Theme Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/rivaaj-theme.css') }}?v=2.5">
    <!-- Amber Custom Alerts & Modals Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/amber-alerts.css') }}?v=1.1">
    
    @stack('styles')
</head>
<body>

    <!-- Header & Navigation -->
    @include('components.navbar')

    <!-- Main Content Page -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('components.footer')

    <!-- Search Modal -->
    @include('components.search-modal')

    <!-- Cart Drawer -->
    @include('components.cart-drawer')

    <!-- Login Modal -->
    @include('components.login-modal')

    <!-- Global Floating WhatsApp Button (Dynamically updated from Admin WhatsApp Settings) -->
    <a href="https://wa.me/{{ $whatsappNumber ?? '923272222180' }}?text={{ urlencode('Hello Amber\'s Roots! I would like to inquire about your herbal hair care products.') }}" 
       target="_blank" 
       rel="noopener noreferrer"
       class="rm-floating-wa" 
       aria-label="Chat with us on WhatsApp"
       title="Chat with us on WhatsApp">
        <i class="fa-brands fa-whatsapp"></i>
        <span class="rm-wa-tooltip">Chat with us on WhatsApp</span>
        <span class="rm-wa-pulse"></span>
    </a>

    <!-- Toast Notification Container -->
    <div class="rm-toast"></div>

    <!-- Amber Custom Luxury Alerts Engine -->
    <script src="{{ asset('js/amber-alerts.js') }}?v=1.0"></script>
    
    <!-- Interactive Script -->
    <script src="{{ asset('js/rivaaj-main.js') }}"></script>

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
    
    @stack('scripts')
</body>
</html>
