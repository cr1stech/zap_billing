<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'affected_accounts',
        'amount',
        'payment_date'
    ];

    protected $casts = [
        'affected_accounts' => 'array'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($payment) {
            DB::transaction(function () use ($payment) {
                // Decodifique 'affected_accounts' para garantir que seja um array
                $affectedAccounts = is_array($payment->affected_accounts) ? $payment->affected_accounts : json_decode($payment->affected_accounts, true);

                foreach ($affectedAccounts as $accountId => $paidAmount) {
                    $account = ClientAccount::find($accountId);
                    if ($account) {
                        $account->amount_paid += $paidAmount;
                        $account->updateStatus();
                    }
                }
            });
        });
    }
}
