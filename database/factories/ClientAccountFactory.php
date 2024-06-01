<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\ClientAccount;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientAccountFactory extends Factory
{
    protected $model = ClientAccount::class;

    public function definition()
    {
        $totalAmount = $this->faker->numberBetween(10000, 1000000);
        $amountPaid = $this->faker->numberBetween(0, $totalAmount);
        $status = $this->getStatus($totalAmount, $amountPaid);

        return [
            'client_id' => Client::factory(),
            'total_amount' => $totalAmount,
            'amount_paid' => 0,
            'due_date' => Carbon::parse($this->faker->dateTimeBetween('-1 years', '+1 years')),
//            'status' => $status,
        ];
    }

    private function getStatus($totalAmount, $amountPaid)
    {
        if ($amountPaid >= $totalAmount) {
            return 'paid';
        } elseif ($amountPaid > 0) {
            return 'partially_paid';
        } elseif (now()->greaterThan(Carbon::parse($this->faker->dateTimeBetween('-1 years', '+1 years')))) {
            return 'overdue';
        } else {
            return 'pending';
        }
    }
}
