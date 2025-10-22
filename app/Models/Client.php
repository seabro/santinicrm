<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Client extends Model
{
    use HasFactory;

    // Define fillable fields for mass assignment
    protected $fillable = [
        'first_name',
        'last_name',
        'date_of_birth',
        'phone',
        'email',
        'gender',
        'supervisor',
        'association',
        'auth_user_id',
    ];

    // Define relationship with the User model (auth user as owner)
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'auth_user_id');
    }
}
