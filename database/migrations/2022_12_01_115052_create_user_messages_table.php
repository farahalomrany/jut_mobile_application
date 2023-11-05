<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_messages', function (Blueprint $table) {
            $table->id();
            $table->date('date')->useCurrent();
            $table->string('sender_name')->nullable();
            $table->string('sender_id')->nullable();
            $table->enum('destination', ['dist', 'company', 'both'])->default('company');
            $table->json('receivers')->nullable();
            $table->enum('stype', ['visitor', 'member', 'distributor'])->default('visitor');
            $table->enum('mtype', ['query', 'objection'])->default('query');
            $table->string('text');
            $table->enum('status', ['new', 'read','answered','ignored'])->default('new');
            $table->string('phone_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_messages');
    }
}
