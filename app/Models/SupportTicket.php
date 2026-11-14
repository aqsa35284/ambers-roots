<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupportTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'subject',
        'product_related',
        'message',
        'priority',
        'status',
        'assigned_employee_id',
        'resolution_notes',
    ];

    public function assignedEmployee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_employee_id');
    }
}
