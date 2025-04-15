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
        Schema::table('attendance_settings', function (Blueprint $table) {
            $table->time('start_time')->default('08:00:00')->after('id');
            $table->time('end_time')->default('17:00:00')->after('start_time');
            $table->float('radius')->default(100)->after('end_time');
            $table->boolean('allow_late_checkin')->default(true)->after('radius');
            $table->boolean('use_geofence')->default(true)->after('allow_late_checkin');
        });
    }
    
    public function down(): void
    {
        Schema::table('attendance_settings', function (Blueprint $table) {
            $table->dropColumn([
                'start_time',
                'end_time',
                'radius',
                'allow_late_checkin',
                'use_geofence',
            ]);
        });
    }
    
};
