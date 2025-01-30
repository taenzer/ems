<?php

use App\Models\Order;
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
        Schema::table('orders', function (Blueprint $table) {
            $table->string("unique_order_id")->nullable();
        });
        foreach (Order::all() as $order) {
            $order->unique_order_id = uniqid();
            $order->save();
        }
        Schema::table('orders', function (Blueprint $table) {
            $table->string("unique_order_id")->unique()->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropUnique("unique_order_id");
            $table->dropColumn("unique_order_id");
        });
    }
};
