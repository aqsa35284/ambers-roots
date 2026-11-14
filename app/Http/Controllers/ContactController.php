<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Setting;
use App\Models\SupportTicket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Show the Contact Page.
     */
    public function index(): View
    {
        $whatsappNumber = Setting::get('whatsapp_number', '923272222180');
        $storePhone = Setting::get('store_phone', '+92 327 2222180');
        $storeEmail = Setting::get('store_email', 'info@ambersroots.com');
        $storeAddress = Setting::get('store_address', 'Big City Plaza Laboratory');

        return view('contact', compact('whatsappNumber', 'storePhone', 'storeEmail', 'storeAddress'));
    }

    /**
     * Handle Contact Form Submission.
     * Submissions are stored as Support Tickets visible to both Admin and Employees.
     */
    public function submit(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:150'],
            'subject' => ['required', 'string', 'max:200'],
            'message' => ['required', 'string', 'min:5', 'max:2500'],
            'product_related' => ['nullable', 'string', 'max:150'],
        ]);

        // Generate unique ticket number
        $ticketId = 'TCK-' . strtoupper(Str::random(3)) . rand(1000, 9999);

        // Determine priority based on subject
        $subjectLower = strtolower($validated['subject']);
        $priority = 'normal';
        if (str_contains($subjectLower, 'urgent') || str_contains($subjectLower, 'complaint') || str_contains($subjectLower, 'damage')) {
            $priority = 'urgent';
        }

        $ticket = SupportTicket::create([
            'ticket_id' => $ticketId,
            'customer_name' => $validated['name'],
            'customer_phone' => $validated['phone'],
            'customer_email' => $validated['email'] ?? null,
            'subject' => $validated['subject'],
            'product_related' => $validated['product_related'] ?? 'Amber\'s Roots Herbal Care',
            'message' => $validated['message'],
            'priority' => $priority,
            'status' => 'open',
            'assigned_employee_id' => null, // Visible to all employees and admin
        ]);

        // Log the activity
        ActivityLog::create([
            'user_id' => null,
            'user_name' => 'Client: ' . $validated['name'],
            'action' => 'contact_form_submitted',
            'details' => "New client inquiry #{$ticket->ticket_id} received from {$validated['name']} ({$validated['phone']}). Subject: {$validated['subject']}",
            'ip_address' => $request->ip(),
        ]);

        $message = "Thank you {$validated['name']}! Your message has been received (Ticket #{$ticket->ticket_id}). Our team will contact you shortly.";

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'ticket_id' => $ticket->ticket_id,
            ]);
        }

        return back()->with('success', $message);
    }
}
