<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('supports', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->text('message');
            $table->boolean('is_active')->default(false);
            $table->foreignId('user_id')->index();
            $table->foreignId('company_id')->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('supports');
    }
};
