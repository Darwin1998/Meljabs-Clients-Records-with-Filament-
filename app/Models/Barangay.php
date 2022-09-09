<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'client_id'];

    public function clients()
    {
        return $this->hasMany(Client::class);
    }
}
