<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    // Define fillable fields for mass assignment
    protected $fillable = [
        'date',
        'time',
        'note',
        'client_id',
        'auth_user_id',
    ];

    // Define relationship with the User model (auth user as owner)
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'auth_user_id');
    }

    // Define relationship with the Client model
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
