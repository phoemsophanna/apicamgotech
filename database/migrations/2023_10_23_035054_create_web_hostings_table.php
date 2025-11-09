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
        Schema::create('web_hostings', function (Blueprint $table) {
            $table->id();
            $table->string("type")->nullable();
            $table->string("pricePerYear")->nullable();
            $table->string("dataStorage")->nullable();
            $table->string("bandwidth")->nullable();
            $table->string("emailAccounts")->nullable();
            $table->string("database")->nullable();
            $table->string("domainAddOn")->nullable();
            $table->string("maxHourlyEmailSend")->nullable();
            $table->boolean("isFreeDomain")->default(false);
            $table->boolean("isMostPopular")->default(false);
            $table->boolean("isGoodSpeed")->default(false);
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
        Schema::dropIfExists('web_hostings');
    }
};
