<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('motorcycles', function (Blueprint $table): void {
            $table->id();
            $table->string('code', 20)->unique();
            $table->foreignId('brand_id')->constrained('brands')->restrictOnDelete();
            $table->string('model', 100);
            $table->string('slug', 150)->unique();
            $table->enum('category', ['matic', 'bebek', 'sport', 'trail', 'lainnya'])->index();
            $table->unsignedSmallInteger('year')->index();
            $table->string('color', 30);
            $table->unsignedSmallInteger('engine_cc');
            $table->enum('transmission', ['matic', 'manual', 'kopling']);
            $table->unsignedInteger('mileage');
            $table->string('plate_region', 5)->nullable();
            $table->enum('setting_condition', ['standar', 'modifikasi_ringan', 'modifikasi_berat'])->default('standar');
            $table->text('modification_notes')->nullable();
            $table->boolean('engine_ever_opened')->default(false);
            $table->text('engine_notes')->nullable();
            $table->boolean('has_bpkb')->default(true);
            $table->boolean('has_stnk')->default(true);
            $table->boolean('has_faktur')->default(false);
            $table->date('tax_expired_at')->nullable();
            $table->string('warranty', 100)->nullable();
            $table->text('description')->nullable();
            $table->decimal('purchase_price', 12, 0);
            $table->date('purchase_date');
            $table->string('purchase_source', 100)->nullable();
            $table->decimal('selling_price', 12, 0)->index();
            $table->boolean('is_negotiable')->default(true);
            $table->enum('status', ['available', 'booked', 'sold'])->default('available')->index();
            $table->boolean('is_featured')->default(false)->index();
            $table->unsignedInteger('views')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('motorcycles');
    }
};
