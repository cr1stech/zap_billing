<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('client_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->decimal('total_amount', 10, 0);
            $table->decimal('amount_paid', 10, 0)->default(0);
            $table->date('due_date');
            $table->enum('status', ['pending', 'partially_paid', 'paid', 'overdue']);
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_accounts');
    }
};
