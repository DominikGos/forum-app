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
    public function up()
    {
        Schema::create('thread_tag', function (Blueprint $table) {
            $table->foreignId('thread_id')->constrained('threads')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('tag_id')->constrained('tags')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('thread_tag');
    }
};
