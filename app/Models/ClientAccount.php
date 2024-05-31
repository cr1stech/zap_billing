<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientAccount extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'total_amount',
        'amount_paid',
        'due_date',
        'status'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function updateStatus()
    {
        if ($this->amount_paid >= $this->total_amount) {
            $this->status = 'paid';
        } elseif ($this->amount_paid > 0) {
            $this->status = 'partially_paid';
        } elseif (now()->greaterThan($this->due_date)) {
            $this->status = 'overdue';
        } else {
            $this->status = 'pending';
        }
        $this->save();
    }
}
