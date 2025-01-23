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
        Schema::create('devices', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('name'); // Name of the device (e.g., "Router 1")
            $table->string('icon')->nullable(); // Icon name (e.g., "router-icon.png")
            $table->string('type'); // Type of device (e.g., "router", "switch", "port")
            $table->text('description')->nullable(); // Additional details about the device
            $table->string('status')->default('active'); // Status of the device (e.g., "active", "inactive")
            $table->string('ip_address')->nullable(); // IP address of the device
            $table->string('model')->nullable(); // Model of the device
            $table->string('serial_number')->nullable(); // Serial number of the device
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
