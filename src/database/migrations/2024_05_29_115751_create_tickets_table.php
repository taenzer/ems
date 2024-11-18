<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Event;
use App\Models\TicketProduct;
use App\Models\TicketDesign;
use App\Models\TicketPrice;
use App\Models\TicketOrder;
use App\Models\User;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ticket_designs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('html');
        });
        Schema::create('ticket_products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('Online Ticket');
            $table->integer('tixAvailable')->nullable();
            $table->timestamps();
        });
        Schema::create('ticket_permits', function (Blueprint $table) {
            $table->id();
            $table
                ->foreignIdFor(TicketProduct::class)
                ->constrained()
                ->cascade();
            $table
                ->foreignIdFor(Event::class)
                ->constrained()
                ->restrict();
        });
        Schema::create('ticket_prices', function (Blueprint $table) {
            $table->id();
            $table
                ->foreignIdFor(TicketProduct::class)
                ->constrained()
                ->cascade();
            $table->string('category');
            $table->double('price');
        });

        Schema::create('ticket_orders', function (Blueprint $table) {
            $table->id();
            $table->string('gateway');
            $table->double('total');
            $table->string('meta')->nullable();
            $table
                ->foreignIdFor(User::class)
                ->nullable()
                ->constrained()
                ->noAction();
            $table->timestamps();
        });

        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table
                ->foreignIdFor(TicketOrder::class)
                ->constrained()
                ->cascade();
            $table
                ->foreignIdFor(TicketProduct::class)
                ->constrained()
                ->cascade();
            $table
                ->foreignIdFor(TicketPrice::class)
                ->constrained()
                ->restrict();
            $table->string('secret');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};