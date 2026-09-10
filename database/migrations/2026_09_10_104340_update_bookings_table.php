<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['pet_id']);
            $table->dropColumn([
                'pet_id',
                'start_date',
                'end_date',
                'total_price',
            ]);

            $table->string('pet_name');
            $table->date('booking_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->text('message')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('pet_id')->constrained('pets')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('total_price', 8, 2)->nullable();

            $table->dropColumn([
                'pet_name',
                'booking_date',
                'start_time',
                'end_time',
                'message',
            ]);
        });
    }
};
