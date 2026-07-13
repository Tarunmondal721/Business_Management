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
            $table->decimal('booking_cost_per_bag', 10, 2)->default(00.00);
            $table->decimal('total_booking_cost', 10, 2)->default(00.00);
            $table->string('weight_per_bag')->nullable();
            $table->string('unit')->nullable();
            $table->string('total_weight')->nullable();
            $table->string('departure_date')->nullable();
            $table->string('expected_arrival_date')->nullable();
            $table->timestamps();
        });
        Schema::create('arrivalproducts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('departure_id')->nullable();
            $table->foreign('departure_id')->references('id')->on('departureproducts')->nullOnDelete()->nullOnUpdate();
            $table->string('arrival_date')->nullable();
            $table->string('billing_date')->nullable();
            $table->string('attachment')->nullable();
            $table->timestamps();
        });

        Schema::create('departure_arrival_fishs', function (Blueprint $table) {
            $table->id();

            // Relations
            $table->foreignId('departure_id')
                ->nullable()
                ->constrained('departureproducts')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('arrival_id')
                ->nullable()
                ->constrained('arrivalproducts')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            // Fish
            $table->foreignId('departure_fish_id')
                ->nullable()
                ->constrained('fishs')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('arrival_fish_id')
                ->nullable()
                ->constrained('fishs')
                ->nullOnDelete()
                ->cascadeOnUpdate();


            $table->integer('departure_quantity')->default(0);
            $table->decimal('departure_weight', 10, 2)->default(0);
            $table->string('departure_unit')->default('KG');
            $table->decimal('departure_total_weight', 10, 2)->default(0);
            $table->decimal('departure_total_fish', 10, 2)->default(0);
            $table->decimal('departure_total_quantity', 10, 2)->default(0);
            $table->decimal('departure_grand_total_weight', 10, 2)->default(0);



            $table->integer('bill_quantity')->default(0);
            $table->decimal('bill_weight', 10, 2)->default(0);
            $table->string('bill_unit')->default('KG');
            $table->decimal('bill_price', 10, 2)->default(0);
            $table->decimal('bill_total_weight', 10, 2)->default(0);
            $table->decimal('bill_total_price', 12, 2)->default(0);

            $table->decimal('bill_total_quantity', 10, 2)->default(0);
            $table->decimal('bill_total_fish', 10, 2)->default(0);
            $table->decimal('bill_grand_total_weight', 12, 2)->default(0);
            $table->decimal('grand_total', 12, 2)->default(0);


            $table->text('remarks')->nullable();

            $table->timestamps();
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
