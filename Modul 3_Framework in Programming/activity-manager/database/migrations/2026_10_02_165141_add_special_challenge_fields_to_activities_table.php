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
        Schema::table('activities', function (Blueprint $table) {
            $table->string('code', 30)->nullable()->unique()->after('category_id');
            $table->dateTime('start_at')->nullable()->after('description');
            $table->dateTime('end_at')->nullable()->after('start_at');
            $table->string('location')->nullable()->after('end_at');
            $table->unsignedInteger('capacity')->nullable()->after('location');
            $table->string('status', 20)->default('draft')->change();
            $table->string('poster_path')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropUnique(['code']);
            $table->dropColumn([
                'code',
                'start_at',
                'end_at',
                'location',
                'capacity',
                'poster_path',
            ]);
            $table->string('status', 20)->default('Planned')->change();
        });
    }
};
