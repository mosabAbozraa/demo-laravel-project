<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();

            //  Location 
            $table->string('governorate');
            $table->string('city');

            //  Price 
            $table->decimal('price_per_night');

            //  Info
            $table->text('description');
            $table->decimal('area');
            $table->integer('rooms');
            $table->integer('bath_rooms');

            //  status
            $table->enum('current_status', ['rented', 'unrented'])->default('unrented');

            //  rating 


            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
