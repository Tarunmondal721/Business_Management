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
        Schema::create('departureproducts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_id')->nullable();
            $table->foreign('seller_id')->references('id')->on('seller_users')->nullOnDelete()->nullOnUpdate();
            $table->string('bag_name')->nullable();
            $table->string('total_quantity')->nullable();
            $table->string('weight_per_bag')->nullable();
            $table->string('unit')->nullable();
            $table->string('total_weight')->nullable();
            $table->string('departure_date')->nullable();
            $table->string('arrival_date')->nullable();
            $table->timestamps();
        });
        Schema::create('arrivalproducts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('departure_id')->nullable();
            $table->foreign('departure_id')->references('id')->on('departureproducts')->nullOnDelete()->nullOnUpdate();
            $table->string('arrival_date')->nullable();
            $table->string('attachment')->nullable();
            $table->timestamps();
        });

        Schema::create('departure_arrival_fishs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('departure_id')->nullable();
            $table->foreign('departure_id')->references('id')->on('departureproducts')->nullOnDelete()->nullOnUpdate();
            $table->unsignedBigInteger('arrival_id')->nullable();
            $table->foreign('arrival_id')->references('id')->on('arrivalproducts')->nullOnDelete()->nullOnUpdate();
            $table->unsignedBigInteger('fish_id')->nullable();
            $table->foreign('fish_id')->references('id')->on('fishs')->nullOnDelete()->nullOnUpdate();
            $table->string('quantity')->nullable();
            $table->string('weight')->nullable();
            $table->string('unit')->nullable();
            $table->decimal('total_weight', 10, 2)->default(00.00);
            $table->string('total_quantity')->nullable();
            $table->decimal('price', 10, 2)->default(00.00);
            $table->decimal('total_price', 10, 2)->default(00.00);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departureproducts');
        Schema::dropIfExists('arrivalproducts');
        Schema::dropIfExists('departure_arrival_fishs');
    }
};
