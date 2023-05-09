<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['first_name',
        'last_name',
        'address',
        'payment_method',
        'installation_date',
        'amount',
        'barangay_id',
        'contact_number',
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function barangay()
    {
       return $this->belongsTo(Barangay::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
