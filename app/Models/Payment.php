<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['client_id',
        'date',
        'amount',
        'status',
        'received_by',
        'payment_method',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
