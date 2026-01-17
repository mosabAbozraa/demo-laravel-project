<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("
            ALTER TABLE bookings
            MODIFY bookings_status_check ENUM(
                'pending',
                'completed',
                'canceled',
                'finished')
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE bookings
            MODIFY bookings_status_check ENUM('pending',
                'completed',
                'canceled')
        ");
    }
};
