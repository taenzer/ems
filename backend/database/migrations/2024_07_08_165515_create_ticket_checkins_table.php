<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ticket_checkins', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Ticket::class)->constrained()->cascade();
            $table->foreignIdFor(Event::class)->constrained()->cascade();
            $table->foreignIdFor(User::class)->constrained()->noAction();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_checkins');
    }
};
