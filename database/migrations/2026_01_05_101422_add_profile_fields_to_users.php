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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('address')->nullable();
            $table->string('company')->nullable();
            $table->string('job')->nullable();
            $table->string('country')->nullable();
            $table->text('about')->nullable();
            $table->string('profile_image')->nullable()->before('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            Schema::table('users', function (Blueprint $table) {
                if (Schema::hasColumn('users', 'phone')) {
                    $table->dropColumn('phone');
                }
                if (Schema::hasColumn('users', 'address')) {
                    $table->dropColumn('address');
                }
                if (Schema::hasColumn('users', 'company')) {
                    $table->dropColumn('company');
                }
                if (Schema::hasColumn('users', 'job')) {
                    $table->dropColumn('job');
                }
                if (Schema::hasColumn('users', 'country')) {
                    $table->dropColumn('country');
                }
                if (Schema::hasColumn('users', 'about')) {
                    $table->dropColumn('about');
                }
                if (Schema::hasColumn('users', 'profile_image')) {
                    $table->dropColumn('profile_image');
                }
            });
        });
    }
};
