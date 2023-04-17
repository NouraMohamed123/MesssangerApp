<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants', function (Blueprint $table) {
            $table
                ->foreignId('conversation_id')

                ->constrained('conversations')
                ->cascadeOnDelete();
            $table
                ->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->enum('role', ['admin', 'memmber'])->default('memmber');
            $table->timestamp('joined_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participants');
    }
}
