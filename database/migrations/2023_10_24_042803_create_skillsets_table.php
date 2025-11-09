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
        Schema::create('skillsets', function (Blueprint $table) {
            // Skillset(id, title, percentage, barColor, isActive, ordering)
            $table->id();
            $table->string("title")->nullable();
            $table->integer("percentage")->default(0);
            $table->string("barColor")->nullable();
            $table->integer("ordering")->default(0);
            $table->boolean("isActive")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skillsets');
    }
};
