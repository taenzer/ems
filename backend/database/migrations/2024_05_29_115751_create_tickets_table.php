<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Event;
use App\Models\Ticket;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string("title")->default("Online Ticket");
            $table->string("secret");
            $table->timestamps();
        });
        Schema::create('ticket_permits', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Ticket::class)->constrained()->cascade();
            $table->foreignIdFor(Event::class)->constrained()->restrict();
            $table->datetime("checkedIn")->nullable()->default(null);
            $table->timestamps();
        });
        Schema::create('ticket_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Ticket::class)->constrained()->cascade();
            $table->string("category");
            $table->double("price");
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