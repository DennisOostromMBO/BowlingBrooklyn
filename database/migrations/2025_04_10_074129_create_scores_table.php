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
        Schema::create('scores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reservation_id');
            $table->integer('points');
            $table->integer('round');
            $table->enum('status', ['In progress', 'Confirmed'])->default('In progress');
            $table->boolean('isactive')->default(true);
            $table->text('note')->nullable();
            $table->string('team_name')->nullable();
            $table->string('teammate1')->nullable();
            $table->integer('teammate1_score')->nullable();
            $table->string('teammate2')->nullable();
            $table->integer('teammate2_score')->nullable();
            $table->string('teammate3')->nullable();
            $table->integer('teammate3_score')->nullable();
            $table->string('teammate4')->nullable();
            $table->integer('teammate4_score')->nullable();
            $table->string('teammate5')->nullable();
            $table->integer('teammate5_score')->nullable();
            $table->string('teammate6')->nullable();
            $table->integer('teammate6_score')->nullable();
            $table->string('teammate7')->nullable();
            $table->integer('teammate7_score')->nullable();
            $table->string('teammate8')->nullable();
            $table->integer('teammate8_score')->nullable();
            $table->timestamps();
            $table->foreign('reservation_id')->references('id')->on('reservations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scores');
    }
};
