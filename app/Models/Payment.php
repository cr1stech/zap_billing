<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_account_id',
        'amount',
        'payment_date'
    ];

    public function account()
    {
        return $this->belongsTo(ClientAccount::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($payment) {
            $account = $payment->account;
            $account->amount_paid += $payment->amount;
            $account->updateStatus();
        });
    }
}
