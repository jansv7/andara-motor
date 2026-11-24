<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table): void {
            $table->id();
            $table->string('invoice_number', 30)->unique();
            $table->foreignId('motorcycle_id')->constrained('motorcycles')->restrictOnDelete();
            $table->date('sale_date')->index();
            $table->string('buyer_name', 100);
            $table->string('buyer_phone', 20);
            $table->text('buyer_address')->nullable();
            $table->enum('payment_method', ['tunai', 'transfer', 'kredit']);
            $table->decimal('sale_price', 12, 0);
            $table->decimal('purchase_price_snapshot', 12, 0);
            $table->decimal('reconditioning_cost_snapshot', 12, 0)->default(0);
            $table->decimal('profit', 12, 0);
            $table->text('notes')->nullable();
            $table->text('cancel_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
