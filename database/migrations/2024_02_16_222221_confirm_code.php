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
        Schema::create('two_factors', function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->integer('code')->nullable();
            $table->integer('failed_attempts')->default(0);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('two_factors', function (Blueprint $table){
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('two_factors');
    }
};
