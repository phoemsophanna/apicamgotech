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
        // Testimonial(id, reviewerName, reviewerPosition, comment, reviewerProfile, isDisplayHomepage, ordering, isActive)
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string("reviewerName")->nullable();
            $table->string("reviewerPosition")->nullable();
            $table->text("comment")->nullable();
            $table->string("reviewerProfile")->nullable();
            $table->boolean("isDisplayHomepage")->default(false);
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
        Schema::dropIfExists('testimonials');
    }
};
