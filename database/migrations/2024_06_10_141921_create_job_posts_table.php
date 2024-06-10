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
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employer_id')->unsigned()->index()->nullable();
            $table->foreign('employer_id')->references('id')->on('employers')->onDelete('cascade');
            $table->string('job_title');
            $table->string('company_name');
            $table->string('location');
            $table->string('skills');
            $table->string('experience');
            $table->string('salary');
            $table->text('description');
            $table->tinyInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_posts');
    }
};
