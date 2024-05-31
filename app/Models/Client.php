<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone_number'
    ];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function accounts()
    {
        return $this->hasMany(ClientAccount::class);
    }
}